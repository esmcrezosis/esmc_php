<?php

class AdministrationController extends Zend_Controller_Action
{

    public function init()
    {
	$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        /* Initialize action controller here */	
		
//include("Url.php");   
 
        $smsnbre = new Application_Model_EuSmsNbre();
        $smsnbreM = new Application_Model_EuSmsNbreMapper();
        $smsnbreM->find(1, $smsnbre);
if($smsnbre->sms_nbre_nbre <= 50 && $smsnbre->sms_nbre_alerte == 0){

        $smsnbre->setSms_nbre_alerte(1);
		$smsnbreM->update($smsnbre);
	
$mobilemcnp = Util_Utils::getParametre('mobile', 'sms');

$mobilemcnp1 = "92046435";
$mobilemcnp2 = "93030332";
$mobilemcnp3 = "99685657";

$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilemcnp1, "Le compte SMS est bientôt épuisé. Il ne reste plus que ".$smsnbre->sms_nbre_nbre." SMS. Veuillez recharger, Merci. ESMC");  
      
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilemcnp2, "Le compte SMS est bientôt épuisé. Il ne reste plus que ".$smsnbre->sms_nbre_nbre." SMS. Veuillez recharger, Merci. ESMC");
        
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilemcnp3, "Le compte SMS est bientôt épuisé. Il ne reste plus que ".$smsnbre->sms_nbre_nbre." SMS. Veuillez recharger, Merci. ESMC");        
	
	}

    }

    public function loginAction()
    {
        /* page administration/login - Authentification Espace Administration */

	$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!=""){

	$euutilisateur = new Application_Model_DbTable_EuUtilisateur();
	$select = $euutilisateur->select()->where('login = ?', $_POST['login'])
						  	  ->where('pwd = ?', md5($_POST['pwd']));
							  //->where("code_groupe = 'admin' OR code_groupe = 'acnev'");
	$rowseuutilisateur = $euutilisateur->fetchRow($select);
if (count($rowseuutilisateur)>0){
				 $sessionutilisateur->id_utilisateur = $rowseuutilisateur->id_utilisateur;
				 $sessionutilisateur->login = $rowseuutilisateur->login;
				 $sessionutilisateur->code_groupe = $rowseuutilisateur->code_groupe;
				 $sessionutilisateur->nom_utilisateur = $rowseuutilisateur->nom_utilisateur;
				 $sessionutilisateur->prenom_utilisateur = $rowseuutilisateur->prenom_utilisateur;
				 $sessionutilisateur->pays = $rowseuutilisateur->id_pays;
				 $sessionutilisateur->code_membre = $rowseuutilisateur->code_membre;
				 $sessionutilisateur->id_filiere = $rowseuutilisateur->id_filiere;
				 $sessionutilisateur->code_acteur = $rowseuutilisateur->code_acteur;
				 $sessionutilisateur->code_groupe_create = $rowseuutilisateur->code_groupe_create;
				 $sessionutilisateur->code_agence = $rowseuutilisateur->code_agence;
				 
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($rowseuutilisateur->code_acteur);
				 $sessionutilisateur->code_source_create = $acteurRow->code_source_create;
				 $sessionutilisateur->code_monde_create = $acteurRow->code_monde_create;
				 $sessionutilisateur->code_zone_create = $acteurRow->code_zone_create;
				 $sessionutilisateur->id_pays = $acteurRow->id_pays;
				 $sessionutilisateur->id_region = $acteurRow->id_region;
				 $sessionutilisateur->code_secteur_create = $acteurRow->code_secteur_create;
				 $sessionutilisateur->code_agence_create = $acteurRow->code_agence_create;


        $filiere = new Application_Model_EuFiliere();
        $filiereM = new Application_Model_EuFiliereMapper();
        $filiereM->find($rowseuutilisateur->id_filiere, $filiere);
				 $sessionutilisateur->code_division = $filiere->code_division;
				 $sessionutilisateur->nom_filiere = $filiere->nom_filiere;

        $membremorale = new Application_Model_EuMembreMorale();
        $membremoraleM = new Application_Model_EuMembreMoraleMapper();
        $membremoraleM->find($rowseuutilisateur->code_membre, $membremorale);
$sessionutilisateur->raison_sociale = $membremorale->raison_sociale;

				 $sessionutilisateur->errorlogin = "";
if($sessionutilisateur->code_membre != ""){				 
				 $sessionutilisateur->confirmation = strtoupper(Util_Utils::genererCodeSMS(5));
				 
					if (substr($sessionutilisateur->code_membre, -1) == "P") {
					$m_membre = new Application_Model_EuMembreMapper();
					$membre = new Application_Model_EuMembre();
					$retour = $m_membre->find($sessionutilisateur->code_membre, $membre);
					}else if (substr($sessionutilisateur->code_membre, -1) == "M") {
					$m_membre = new Application_Model_EuMembreMoraleMapper();
					$membre = new Application_Model_EuMembreMorale();
					$retour = $m_membre->find($sessionutilisateur->code_membre, $membre);
					}

				 $compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, $membre->portable_membre, "Voici votre code de confirmation: ".$sessionutilisateur->confirmation.". Veuillez le saisir dans le champ correspondant. Merci");        

				 
    $this->_redirect('/administration/confirmation');
}else{
    $this->_redirect('/administration');
	}
	} else { $sessionutilisateur->errorlogin = "Login ou Mot de Passe Erroné"; }
    $this->_redirect('/administration/login');
	} else { $sessionutilisateur->errorlogin = "Saisir Login et Mot de Passe"; } 
    $this->_redirect('/administration/login');
	}



    }

	public function passwordAction() 
	{
		/* page administration/password - Modification de mot de passe */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['ancien']) && $_POST['ancien'] != "" && isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

					$euutilisateur = new Application_Model_DbTable_EuUtilisateur();
					$select = $euutilisateur->select()->where('login = ?', $sessionutilisateur->login);
					$select->where('pwd = ?', md5($_POST['ancien']));
					if ($rowseuutilisateur = $euutilisateur->fetchRow($select)) {
						$utilisateur = new Application_Model_EuUtilisateur();
						$mapper = new Application_Model_EuUtilisateurMapper();
						$mapper->find($sessionutilisateur->id_utilisateur, $utilisateur);
						
						$utilisateur->setPwd(md5($_POST['nouveau']));
						$mapper->update($utilisateur);
						$this->view->error = "Modification effectuée";
					}
			} else {
				$this->view->error = "Saisir tous les champs";
			}
			//$this->_redirect('/administration');
		}
	}

    function nocompteAction()
    {
	Zend_Session::destroy(true);
    $this->_redirect('/administration/login');
    }


	public function confirmationAction() 
	{
		/* page administration/confirmation - Confirmation d'accès a cet espace d'administration */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['confirme']) && $_POST['confirme'] != "" && $_POST['confirme'] == $sessionutilisateur->confirmation) {

				 $sessionutilisateur->confirmation = "";
			$this->_redirect('/administration');

			} else {
				$this->view->error = "Erreur de Code de confirmation";
			$this->_redirect('/administration/nocompte');
			}
			//$this->_redirect('/administration');
		}
	}




    public function indexAction()
    {
        /* page administration/index - Tableau de bord Espace Administration */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    }


    public function detailsdemandeAction() 
    {
        /* page administration/detailsdemande - Détail demande BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $demande = new Application_Model_EuDemande();
        $demandeM = new Application_Model_EuDemandeMapper();
        $demandeM->find($id, $demande);
		$this->view->demande = $demande;

            }

	}


    public function listdemandeAction() 
    {
        /* page administration/listdemande - Liste demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $demande = new Application_Model_EuDemandeMapper();
        $this->view->entries = $demande->fetchAll4($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);

        $this->view->tabletri = 1;
    }


    public function listdemandefraisAction() 
    {
	        /* page administration/listdemandefrais - Liste demande de BPS avec frais */

	$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');

	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $frais = new Application_Model_EuFraisMapper();
        $this->view->entries = $frais->fetchAll4($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);

        $this->view->tabletri = 1;
    }




    public function pdfdemandefraisAction() 
    {
        /* page administration/pdfdemandefrais - Livrer demande */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


        $id = (int) $this->_request->getParam('id');
        $idfrais = (int) $this->_request->getParam('idfrais');
        if ($id > 0 && $idfrais > 0) {
			
            $frais = new Application_Model_EuFrais();
            $m_frais = new Application_Model_EuFraisMapper();
            $m_frais->find($idfrais, $frais);
			
            $m_appeloffre = new Application_Model_EuAppelOffreMapper();
            $appeloffre = $m_appeloffre->findByDemande($id);
						
			$date = new Zend_Date(Zend_Date::ISO_8601);

            $demande = new Application_Model_EuDemande();
            $m_demande = new Application_Model_EuDemandeMapper();
            $m_demande->find($id, $demande);





        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuLivraison();
        $ma = new Application_Model_EuLivraisonMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setLivraison_id($compteur);
            $a->setLivraison_code_produit("I");
            $a->setLivraison_libelle($demande->objet_demande);
            $a->setLivraison_montant($frais->mont_projet);
            $a->setLivraison_description($demande->description_demande);
            $a->setLivraison_code_membre($demande->code_membre_morale);
            $a->setLivraison_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $a->setLivraison_utilisateur($sessionutilisateur->id_utilisateur);
            $a->setPublier(1);
            $ma->save($a);


$date_id = new Zend_Date(Zend_Date::ISO_8601);


        $validation_quittance = new Application_Model_EuValidationQuittance();
        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
			
            $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
            $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
            $validation_quittance->setValidation_quittance_utilisateur($sessionutilisateur->id_utilisateur);
            $validation_quittance->setValidation_quittance_livraison($compteur);
            $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $validation_quittance->setPublier(1);
            $validation_quittance_mapper->save($validation_quittance);

		include("Transfert.php");







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
	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Bon d\'Achat : BA'.ajoutezero($frais->id_frais).'</u></em></strong></td>
  </tr>';
		
  
/*$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>QUITTANCE CMFH/CAPS/GAC TOGO N° '.$livraison->livraison_id.'</u></em></strong></td>
  </tr>';*/
  
        $membre_morale = new Application_Model_EuMembreMorale();
        $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
        $membre_moraleM->find($demande->code_membre_morale, $membre_morale);
		
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Raison sociale </u>: </em><strong><em>'.$membre_morale->raison_sociale.'</em></strong></p></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="center"><strong><em>Montant Bon d\'Achat : '.number_format(($frais->mont_projet), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="center"><strong><em>Proposition</em></strong></td>
    <td align="center"><strong><em>Salaire</em></strong></td>
    <td align="center"><em><strong>Montant</strong></em></td>
  </tr>';
  
$htmlpdf .= '
  <tr style="background-color:#999;">
    <td align="left"><em><strong>'.$demande->objet_demande.'</strong></em></td>
    <td align="center"><em>'.number_format(($frais->montant_proposition), 0, ',', ' ').'</em></td>
    <td align="center"><em>'.number_format(($frais->montant_salaire), 0, ',', ' ').'</em></td>
    <td align="center"><em>'.number_format(($frais->mont_projet), 0, ',', ' ').'</em></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="2" align="left"><em><u>Montant en  lettres </u>: '.lettre(($frais->mont_projet), 50).' CFA</em></td>
    <td colspan="2" align="left">Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
  </tr>';	  
  
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
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
$filename = ''.Util_Utils::getParamEsmc(1).'/achats.html';
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
if (!is_dir("pdf_achat/")) {
mkdir("pdf_achat/", 0777);
}
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "pdf_achat/BONACHAT_".str_replace("/", "_", mettreaccents($frais->id_frais))."_.html";
$newnom = "BONACHAT_".str_replace("/", "_", mettreaccents($frais->id_frais)."_");
$newchemin = "pdf_achat/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
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
$filena	= $newnom.'.pdf';

unlink($newfile);

	
		//$this->_redirect($file);




if($membre_morale->email_membre != ""){

$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml("Bon d'Achat : BA".ajoutezero($frais->id_frais)." le ".$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membre_morale->email_membre, $membre_morale->raison_sociale);
$mail->setSubject("Bon d'Achat : BA".ajoutezero($frais->id_frais)." le ".$date_id->toString('dd-MM-yyyy HH:mm')); 

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










			
//$sessionmembre->errorlogin = "Validation de la livraison réussie ...";			
			
			/*}else {
$sessionmembre->errorlogin = "Validation de la livraison échouée ...";			
				}*/
			
        }

        $this->_redirect('/administration/listdemandefrais');
    }









    public function addappeloffreAction()
    {
        /* page administration/addappeloffre - Création de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

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
            $a->setMembre_morale_executante($sessionutilisateur->code_membre);
            $a->setDate_creation($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listappeloffre');
					}
}
		} else {  $this->view->error = "Choisir l'appel d'offre";  } 
		}
		
    }




    public function listappeloffreAction()
    {
        /* page administration/listappeloffre - Liste des appels d'offres suite aux demandes de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $appeloffre = new Application_Model_EuAppelOffreMapper();
		if($sessionutilisateur->code_groupe == "executante" || $sessionutilisateur->code_groupe == "executante_pays" || $sessionutilisateur->code_groupe == "executante_region" || $sessionutilisateur->code_groupe == "executante_secteur" || $sessionutilisateur->code_groupe == "executante_agence"){
        $this->view->entries = $appeloffre->fetchAll7($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
		}else{
        $this->view->entries = $appeloffre->fetchAll8($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create, $sessionutilisateur->id_filiere);
		}
        $this->view->tabletri = 1;

    }


    public function suppappeloffreAction()
    {
        /* page administration/suppappeloffre - Suppression de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffre = new Application_Model_EuAppelOffre();
        $appeloffreM = new Application_Model_EuAppelOffreMapper();
        $appeloffreM->find($id, $appeloffre);
		
        $appeloffreM->delete($appeloffre->id_appel_offre);
		//unlink($appeloffre->descrip_appel_offre);	

        }

		$this->_redirect('/administration/listappeloffre');
    }


    public function publierappeloffreAction()
    {
        /* page administration/publierappeloffre - Publier l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffre = new Application_Model_EuAppelOffre();
        $appeloffreM = new Application_Model_EuAppelOffreMapper();
        $appeloffreM->find($id, $appeloffre);
		
        $appeloffre->setPublier($this->_request->getParam('publier'));
		$appeloffreM->update($appeloffre);
        }

		$this->_redirect('/administration/listappeloffre');
    }


    public function listpropositionAction()
    {
        /* page administration/listproposition - Liste des propositions de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

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

    public function listpropositionpreselectionAction()
    {
        /* page administration/listproposition - Liste des propositions pre-selectionnées de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffre = new Application_Model_EuAppelOffre();
        $appeloffreM = new Application_Model_EuAppelOffreMapper();
        $appeloffreM->find($id, $appeloffre);
		$this->view->appeloffre = $appeloffre;

        $proposition = new Application_Model_EuPropositionMapper();
        $this->view->entries = $proposition->fetchAll5($id);
    }

        $this->view->tabletri = 1;

    }

    public function listpropositionfinaleAction()
    {
        /* page administration/listpropositionfinale - Liste des propositions finales de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffre = new Application_Model_EuAppelOffre();
        $appeloffreM = new Application_Model_EuAppelOffreMapper();
        $appeloffreM->find($id, $appeloffre);
		$this->view->appeloffre = $appeloffre;

        $proposition = new Application_Model_EuPropositionMapper();
        $this->view->entries = $proposition->fetchAll8($id);
    }

        $this->view->tabletri = 1;

    }
	
    public function detailpropositionAction()
    {
        /* page administration/detailproposition - Détail d'une proposition de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

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
		
		$this->view->id = $id;
		
		
		
		
        $this->view->tabletri = 1;

        }else{
		$this->_redirect('/administration/listproposition/id/'.$proposition->id_appel_offre);			
			}

    }


    public function choixpropositionAction()
    {
        /* page administration/choixproposition - Choix final des propositions de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

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
		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["portable_membre"], "Bienvenue dans le réseau MCNP! Votre numéro de membre est: " . $code);        
		
		}

		$this->_redirect('/administration/listpropositionpreselection/id/'.$proposition->id_appel_offre);
    }



    public function preselectionpropositionAction()
    {
        /* page administration/preselectionproposition - Pré-selection des propositions de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $proposition = new Application_Model_EuProposition();
        $propositionM = new Application_Model_EuPropositionMapper();
        $propositionM->find($id, $proposition);
		
        $proposition->setPreselection($this->_request->getParam('preselection'));
		$propositionM->update($proposition);
        }

		$this->_redirect('/administration/listproposition/id/'.$proposition->id_appel_offre);
    }


    public function disponiblepropositionAction()
    {
        /* page administration/disponibleproposition - Rendre disponible une proposition de l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $proposition = new Application_Model_EuProposition();
        $propositionM = new Application_Model_EuPropositionMapper();
        $propositionM->find($id, $proposition);
		
        $proposition->setDisponible($this->_request->getParam('disponible'));
		$propositionM->update($proposition);
        }

		$this->_redirect('/administration/listpropositionfinale/id/'.$proposition->id_appel_offre);
    }



    public function addpageAction()
    {
        /* page administration/addpage - Création de page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['titre']) && $_POST['titre']!="" && isset($_POST['resume']) && $_POST['resume']!="") {
		
		include("Transfert.php");
		if (isset($_FILES['vignette']['name']) && $_FILES['vignette']['name']!="") {
		$chemin	= "pages";
		$file = $_FILES['vignette']['name'];
		$file1='vignette';
		$page = $chemin."/".transfert($chemin,$file1);
		} else {$page = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuPage();
        $ma = new Application_Model_EuPageMapper();
		
		$ordre_last = $ma->findOrdre($_POST['menu']) + 1;
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_page($compteur);
            $a->setTitre($_POST['titre']);
            $a->setResume($_POST['resume']);
            $a->setVignette($page);
            $a->setDescription($_POST['description']);
            $a->setMenu($_POST['menu']);
            $a->setMenusous($_POST['menusous']);
            $a->setPublier($_POST['publier']);
            $a->setOrdre($ordre_last);
            $a->setSpotlight(0);
            $a->setDeroulant(0);
            $a->setTitre_autre($_POST['titre_autre']);
            $a->setTitre_deroulant($_POST['titre_deroulant']);
            $ma->save($a);
			
		$this->_redirect('/administration/listpage');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editpageAction()
    {
        /* page administration/editpage - Modification de page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['titre']) && $_POST['titre']!="" && isset($_POST['resume']) && $_POST['resume']!="") {
		
		include("Transfert.php");
		if (isset($_FILES['vignette']['name']) && $_FILES['vignette']['name']!="") {
		$chemin	= "pages";
		$file = $_FILES['vignette']['name'];
		$file1='vignette';
		$page = $chemin."/".transfert($chemin,$file1);
		} else {$page = $_POST['vignetteold'];}

			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuPage();
        $ma = new Application_Model_EuPageMapper();
		$ma->find($_POST['id_page'], $a);
			
            $a->setTitre($_POST['titre']);
            $a->setResume($_POST['resume']);
            $a->setVignette($page);
            $a->setDescription($_POST['description']);
            $a->setMenu($_POST['menu']);
            $a->setMenusous($_POST['menusous']);
            $a->setTitre_autre($_POST['titre_autre']);
            $a->setTitre_deroulant($_POST['titre_deroulant']);
            $ma->update($a);
			
		$this->_redirect('/administration/listpage');
	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuPage();
        $ma = new Application_Model_EuPageMapper();
		$ma->find($id, $a);
		$this->view->page = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuPage();
        $ma = new Application_Model_EuPageMapper();
		$ma->find($id, $a);
		$this->view->page = $a;
            }
	}
	}



    public function listpageAction()
    {
        /* page administration/listpage - Liste des page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $page = new Application_Model_EuPageMapper();
        $this->view->entries = $page->fetchAll();

        $this->view->tabletri = 1;

    }


    public function supppageAction()
    {
        /* page administration/supppage - Suppression de page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find($id, $page);
		
        $pageM->delete($page->id_page);

        }

		$this->_redirect('/administration/listpage');
    }


    public function publierpageAction()
    {
        /* page administration/publierpage - Publier la page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find($id, $page);
		
        $page->setPublier($this->_request->getParam('publier'));
		$pageM->update($page);
        }

		$this->_redirect('/administration/listpage');
    }


    public function spotlightpageAction()
    {
        /* page administration/spotlightpage - Spotlight sur une page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find($id, $page);
		
        $page->setSpotlight($this->_request->getParam('spotlight'));
		$pageM->update($page);
        }

		$this->_redirect('/administration/listpage');
    }


    public function deroulantpageAction()
    {
        /* page administration/deroulantpage - Rendre déroulant de page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find($id, $page);
		
        $page->setDeroulant($this->_request->getParam('deroulant'));
		$pageM->update($page);
        }

		$this->_redirect('/administration/listpage');
    }


    function monterpageAction()
    {
        /* page administration/monterpage - Ordre monter la page libre d'information */

        $id = (int) $this->_request->getParam('id');
        	if ($id > 0) {
			
        $page = new Application_Model_EuPage();
        $page_mapper = new Application_Model_EuPageMapper();
		$page_mapper->find($id, $page);
		$ordre = $page->ordre;
		
        $page1 = new Application_Model_EuPage();
        $page1_mapper = new Application_Model_EuPageMapper();
		$rows = $page1_mapper->findOrdreMonter($page->menu, $page->ordre);
		$page1_mapper->find($rows->id_page, $page1);
		$ordre1 = $page1->ordre;
			
        $page->setOrdre($ordre1);
		$page_mapper->update($page);

        $page1->setOrdre($ordre);
		$page1_mapper->update($page1);
			
		$this->_redirect('/administration/listpage');
        }
    }
	
	
    function descendrepageAction()
    {
        /* page administration/descendrepage - Ordre descendre la page libre d'information */

        $id = (int) $this->_request->getParam('id');
        	if ($id > 0) {
			
        $page = new Application_Model_EuPage();
        $page_mapper = new Application_Model_EuPageMapper();
		$page_mapper->find($id, $page);
		$ordre = $page->ordre;
		
        $page1 = new Application_Model_EuPage();
        $page1_mapper = new Application_Model_EuPageMapper();
		$rows = $page1_mapper->findOrdreDescendre($page->menu, $page->ordre);
		$page1_mapper->find($rows->id_page, $page1);
		$ordre1 = $page1->ordre;
			
        $page->setOrdre($ordre1);
		$page_mapper->update($page);

        $page1->setOrdre($ordre);
		$page1_mapper->update($page1);
		
		$this->_redirect('/administration/listpage');
        }
    }




    public function adddocumentAction()
    {
        /* page administration/adddocument - Ajout de document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_type_document']) && $_POST['id_type_document']!="" && isset($_POST['nom_document']) && $_POST['nom_document']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_document($compteur);
            $a->setId_type_document($_POST['id_type_document']);
            $a->setNom_document($_POST['nom_document']);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            $a->setPublier($_POST['publier']);
            $a->setAccord(0);
            $a->setDate_creation($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listdocument');
		} else {  $this->view->error = "Choisir le document";  } 
		}
		
    }


    public function adddocument3Action()
    {
        /* page administration/adddocument - Ajout de document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_type_document']) && $_POST['id_type_document']!="" && isset($_POST['nom_document']) && $_POST['nom_document']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_document($compteur);
            $a->setId_type_document($_POST['id_type_document']);
            $a->setNom_document($_POST['nom_document']);
            $a->setDescrip_document($document);
            $a->setDate_debut($_POST['date_debut']);
            $a->setDate_fin($_POST['date_fin']);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            $a->setPublier(1);
            $a->setAccord(0);
            $a->setDate_creation($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listdocument');
		} else {  $this->view->error = "Choisir le document";  } 
		}
		
    }
	
    public function editdocumentAction()
    {
        /* page administration/editdocument - Modification de document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['nom_document']) && $_POST['nom_document']!="" && isset($_POST['date_debut']) && $_POST['date_debut']!="" && isset($_POST['date_fin']) && $_POST['date_fin']!="") {
		
		include("Transfert.php");
		if (isset($_FILES['descrip_document']['name']) && $_FILES['descrip_document']['name']!="") {
		$chemin	= "documents";
		$file = $_FILES['descrip_document']['name'];
		$file1='descrip_document';
		$document = $chemin."/".transfert($chemin,$file1);
		} else {$document = $_POST['descrip_documentold'];}

			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
		$ma->find($_POST['id_document'], $a);
			
            $a->setNom_document($_POST['nom_document']);
            $a->setDescrip_document($document);
            $a->setDate_debut($_POST['date_debut']);
            $a->setDate_fin($_POST['date_fin']);
            $ma->update($a);
			
		$this->_redirect('/administration/listdocument');
	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
		$ma->find2($id, $a);
		$this->view->document = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
		$ma->find2($id, $a);
		$this->view->document = $a;
            }
	}
	}

    public function editdocument3Action()
    {
        /* page administration/editdocument - Modification de document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['nom_document']) && $_POST['nom_document']!="" && isset($_POST['date_debut']) && $_POST['date_debut']!="" && isset($_POST['date_fin']) && $_POST['date_fin']!="") {
		
		include("Transfert.php");
		if (isset($_FILES['descrip_document']['name']) && $_FILES['descrip_document']['name']!="") {
		$chemin	= "documents";
		$file = $_FILES['descrip_document']['name'];
		$file1='descrip_document';
		$document = $chemin."/".transfert($chemin,$file1);
		} else {$document = $_POST['descrip_documentold'];}

			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
		$ma->find($_POST['id_document'], $a);
			
            $a->setNom_document($_POST['nom_document']);
            $a->setDescrip_document($document);
            $a->setDate_debut($_POST['date_debut']);
            $a->setDate_fin($_POST['date_fin']);
            $ma->update($a);
			
		$this->_redirect('/administration/listdocument');
	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
		$ma->find2($id, $a);
		$this->view->document = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
		$ma->find2($id, $a);
		$this->view->document = $a;
            }
	}
	}


    public function listdocumentAction()
    {
        /* page administration/listdocument - Liste des documents */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $document = new Application_Model_EuDocumentMapper();
        $this->view->entries = $document->fetchAll50($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);

        $this->view->tabletri = 1;

    }


    public function listdocument2Action()
    {
        /* page administration/listdocument2 - Liste des documents passés*/

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $document = new Application_Model_EuDocumentMapper();
        $this->view->entries = $document->fetchAll51($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);

        $this->view->tabletri = 1;

    }
	
    public function listdocument3Action()
    {
        /* page administration/listdocument - Liste des documents */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $document = new Application_Model_EuDocumentMapper();
        $this->view->entries = $document->fetchAll50($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);

        $this->view->tabletri = 1;

    }

    public function suppdocumentAction()
    {
        /* page administration/suppdocument - Suppression d'un document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $document = new Application_Model_EuDocument();
        $documentM = new Application_Model_EuDocumentMapper();
        $documentM->find($id, $document);
		
        $documentM->delete($document->id_document);
		//unlink($document->descrip_document);	

        }

		$this->_redirect('/administration/listdocument');
    }


    public function publierdocumentAction()
    {
        /* page administration/publierdocument - Publier un document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $document = new Application_Model_EuDocument();
        $documentM = new Application_Model_EuDocumentMapper();
        $documentM->find($id, $document);
		
        $document->setPublier($this->_request->getParam('publier'));
		$documentM->update($document);
        }

		$this->_redirect('/administration/listdocument');
    }






    public function addagrementAction()
    {
        /* page administration/addagrement - Ajout d'un agrement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_type_agrement']) && $_POST['id_type_agrement']!="" && isset($_POST['id_type_creneau']) && $_POST['id_type_creneau']!="" && isset($_POST['id_filiere']) && $_POST['id_filiere']!="" && isset($_POST['id_type_acteur']) && $_POST['id_type_acteur']!="" && isset($_POST['num_agrement']) && $_POST['num_agrement']!="" && isset($_POST['cel_agrement']) && $_POST['cel_agrement']!="" && isset($_POST['libelle_agrement']) && $_POST['libelle_agrement']!="" && isset($_POST['code_membre_morale_agrement']) && $_POST['code_membre_morale_agrement']!="" && isset($_FILES['desc_agrement']['name']) && $_FILES['desc_agrement']['name']!="") {
		
		include("Transfert.php");
		$chemin	= "agrements";
		$file = $_FILES['desc_agrement']['name'];
		$file1='desc_agrement';
		$agrement = $chemin."/".transfert($chemin,$file1);
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAgrement();
        $ma = new Application_Model_EuAgrementMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_agrement($compteur);
            $a->setId_type_agrement($_POST['id_type_agrement']);
            $a->setNum_agrement($_POST['num_agrement']);
            $a->setLibelle_agrement($_POST['libelle_agrement']);
            $a->setDesc_agrement($agrement);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            //$a->setCode_membre_morale($_POST['code_membre_morale']);
            $a->setCode_membre_morale_agrement($_POST['code_membre_morale_agrement']);
			$a->setDate_agrement($date_id->toString('yyyy-MM-dd'));
            $a->setCel_agrement($_POST['cel_agrement']);
            $a->setId_type_acteur($_POST['id_type_acteur']);
            $a->setId_type_creneau($_POST['id_type_creneau']);
            $a->setId_filiere($_POST['id_filiere']);
            $ma->save($a);
			
			$typeagrementM = new Application_Model_EuTypeAgrementMapper();
$typeagrement = new Application_Model_EuTypeAgrement();
$typeagrementM->find($_POST['id_type_agrement'], $typeagrement);

$typeacteurM = new Application_Model_EuTypeActeurMapper();
$typeacteur = new Application_Model_EuTypeActeur();
$typeacteurM->find($_POST['id_type_acteur'], $typeacteur);
			
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["cel_agrement"], "Vous venez d'avoir un : ".$typeagrement->libelle_type_agrement.", ".$typeacteur->lib_type_acteur.", Numero : ".$_POST['num_agrement']);
			
			
		$this->_redirect('/administration/listagrement');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editagrementAction()
    {
        /* page administration/editagrement - Modification d'un agrement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_type_agrement']) && $_POST['id_type_agrement']!="" && isset($_POST['id_type_creneau']) && $_POST['id_type_creneau']!="" && isset($_POST['id_filiere']) && $_POST['id_filiere']!="" && isset($_POST['id_type_acteur']) && $_POST['id_type_acteur']!="" && isset($_POST['num_agrement']) && $_POST['num_agrement']!="" && isset($_POST['cel_agrement']) && $_POST['cel_agrement']!="" && isset($_POST['libelle_agrement']) && $_POST['libelle_agrement']!="" && isset($_POST['code_membre_morale_agrement']) && $_POST['code_membre_morale_agrement']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['desc_agrement']['name']) && $_FILES['desc_agrement']['name']!=""){
		$chemin	= "agrements";
		$file = $_FILES['desc_agrement']['name'];
		$file1='desc_agrement';
		$agrement = $chemin."/".transfert($chemin,$file1);
		} else {$agrement = $_POST['desc_agrement_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAgrement();
        $ma = new Application_Model_EuAgrementMapper();
		$ma->find($_POST['id_agrement'], $a);
			
            $a->setId_type_agrement($_POST['id_type_agrement']);
            $a->setNum_agrement($_POST['num_agrement']);
            $a->setLibelle_agrement($_POST['libelle_agrement']);
            $a->setDesc_agrement($agrement);
            $a->setCode_membre_morale_agrement($_POST['code_membre_morale_agrement']);
            $a->setId_type_acteur($_POST['id_type_acteur']);
            $a->setCel_agrement($_POST['cel_agrement']);
            $a->setId_type_creneau($_POST['id_type_creneau']);
            $a->setId_filiere($_POST['id_filiere']);
            $ma->update($a);
			
		$this->_redirect('/administration/listagrement');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAgrement();
        $ma = new Application_Model_EuAgrementMapper();
		$ma->find($id, $a);
		$this->view->agrement = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAgrement();
        $ma = new Application_Model_EuAgrementMapper();
		$ma->find($id, $a);
		$this->view->agrement = $a;
            }
	}
	}




    public function listagrementAction()
    {
        /* page administration/listagrement - Liste des agrements */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $agrement = new Application_Model_EuAgrementMapper();
		
if($sessionutilisateur->code_groupe == "agrement_filiere"){
        $this->view->entries = $agrement->fetchAll4IdFiliere($sessionutilisateur->id_filiere);
}else{
        $this->view->entries = $agrement->fetchAll2IdFiliere($sessionutilisateur->id_filiere, $sessionutilisateur->id_utilisateur);
}		

        $this->view->tabletri = 1;

    }


    public function list2agrementAction()
    {
        /* page administration/list2agrement - Liste des agrements deja utilisés */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $agrement = new Application_Model_EuAgrementMapper();
		
if($sessionutilisateur->code_groupe == "agrement_filiere"){
        $this->view->entries = $agrement->fetchAll6IdFiliere($sessionutilisateur->id_filiere);
}else{
        $this->view->entries = $agrement->fetchAll5IdFiliere($sessionutilisateur->id_filiere, $sessionutilisateur->id_utilisateur);
}		

        $this->view->tabletri = 1;

    }

    public function suppagrementAction()
    {
        /* page administration/suppagrement - Suppression des agrements */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $agrement = new Application_Model_EuAgrement();
        $agrementM = new Application_Model_EuAgrementMapper();
        $agrementM->find($id, $agrement);
		
        $agrementM->delete($agrement->id_agrement);
		//unlink($agrement->desc_agrement);	

        }

		$this->_redirect('/administration/listagrement');
    }








    public function addlicenceAction()
    {
        /* page administration/addlicence - Ajout de licence */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['num_licence']) && $_POST['num_licence']!="" && isset($_POST['libelle_licence']) && $_POST['libelle_licence']!="" && isset($_FILES['desc_licence']['name']) && $_FILES['desc_licence']['name']!="") {
		
		include("Transfert.php");
		$chemin	= "licences";
		$file = $_FILES['desc_licence']['name'];
		$file1='desc_licence';
		$licence = $chemin."/".transfert($chemin,$file1);
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuLicence();
        $ma = new Application_Model_EuLicenceMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_licence($compteur);
            $a->setNum_licence($_POST['num_licence']);
            $a->setLibelle_licence($_POST['libelle_licence']);
            $a->setDesc_licence($licence);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            //$a->setCode_membre_morale($_POST['code_membre_morale']);
            $a->setDate_licence($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listlicence');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editlicenceAction()
    {
        /* page administration/editlicence - Modification d'une licence */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['num_licence']) && $_POST['num_licence']!="" && isset($_POST['libelle_licence']) && $_POST['libelle_licence']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['desc_licence']['name']) && $_FILES['desc_licence']['name']!=""){
		$chemin	= "licences";
		$file = $_FILES['desc_licence']['name'];
		$file1='desc_licence';
		$licence = $chemin."/".transfert($chemin,$file1);
		} else {$licence = $_POST['desc_licence_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuLicence();
        $ma = new Application_Model_EuLicenceMapper();
		$ma->find($_POST['id_licence'], $a);
			
            $a->setNum_licence($_POST['num_licence']);
            $a->setLibelle_licence($_POST['libelle_licence']);
            $a->setDesc_licence($licence);
            $ma->update($a);
			
		$this->_redirect('/administration/listlicence');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuLicence();
        $ma = new Application_Model_EuLicenceMapper();
		$ma->find($id, $a);
		$this->view->licence = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuLicence();
        $ma = new Application_Model_EuLicenceMapper();
		$ma->find($id, $a);
		$this->view->licence = $a;
            }
	}
	}




    public function listlicenceAction()
    {
        /* page administration/listlicence - Liste des licences */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $licence = new Application_Model_EuLicenceMapper();
        $this->view->entries = $licence->fetchAll2($sessionutilisateur->id_utilisateur);

        $this->view->tabletri = 1;

    }


    public function supplicenceAction()
    {
        /* page administration/supplicence - Suppression de licence */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $licence = new Application_Model_EuLicence();
        $licenceM = new Application_Model_EuLicenceMapper();
        $licenceM->find($id, $licence);
		
        $licenceM->delete($licence->id_licence);
		//unlink($licence->desc_licence);	

        }

		$this->_redirect('/administration/listlicence');
    }







    public function addpubliciteAction()
    {
        /* page administration/addpublicite - Ajout de publicité */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['type_publicite']) && $_POST['type_publicite']!="" && isset($_POST['categorie_publicite']) && $_POST['categorie_publicite']!="" && isset($_POST['libelle_publicite']) && $_POST['libelle_publicite']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['desc_publicite']['name']) && $_FILES['desc_publicite']['name']!=""){
		$chemin	= "publicites";
		$file = $_FILES['desc_publicite']['name'];
		$file1='desc_publicite';
		$publicite = $chemin."/".transfert($chemin,$file1);
		} else {$publicite = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuPublicite();
        $ma = new Application_Model_EuPubliciteMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_publicite($compteur);
            $a->setType_publicite($_POST['type_publicite']);
            $a->setCategorie_publicite($_POST['categorie_publicite']);
            $a->setLien_publicite($_POST['lien_publicite']);
            $a->setLibelle_publicite($_POST['libelle_publicite']);
            $a->setDesc_publicite($publicite);
            $a->setDuree_publicite($_POST['duree_publicite']);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            $a->setCode_membre_morale($_POST['code_membre_morale']);
            $a->setDate_publicite($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listpublicite');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editpubliciteAction()
    {
        /* page administration/editpublicite - Modification de publicité */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['type_publicite']) && $_POST['type_publicite']!="" && isset($_POST['categorie_publicite']) && $_POST['categorie_publicite']!="" && isset($_POST['libelle_publicite']) && $_POST['libelle_publicite']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['desc_publicite']['name']) && $_FILES['desc_publicite']['name']!=""){
		$chemin	= "publicites";
		$file = $_FILES['desc_publicite']['name'];
		$file1='desc_publicite';
		$publicite = $chemin."/".transfert($chemin,$file1);
		} else {$publicite = $_POST['desc_publicite_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuPublicite();
        $ma = new Application_Model_EuPubliciteMapper();
		$ma->find($_POST['id_publicite'], $a);
			
            $a->setType_publicite($_POST['type_publicite']);
            $a->setLien_publicite($_POST['lien_publicite']);
            $a->setCategorie_publicite($_POST['categorie_publicite']);
            $a->setLibelle_publicite($_POST['libelle_publicite']);
            $a->setDuree_publicite($_POST['duree_publicite']);
            $a->setCode_membre_morale($_POST['code_membre_morale']);
            $a->setDesc_publicite($publicite);
            $ma->update($a);
			
		$this->_redirect('/administration/listpublicite');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuPublicite();
        $ma = new Application_Model_EuPubliciteMapper();
		$ma->find($id, $a);
		$this->view->publicite = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuPublicite();
        $ma = new Application_Model_EuPubliciteMapper();
		$ma->find($id, $a);
		$this->view->publicite = $a;
            }
	}
	}




    public function listpubliciteAction()
    {
        /* page administration/listpublicite - Liste des publicités */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $publicite = new Application_Model_EuPubliciteMapper();
        $this->view->entries = $publicite->fetchAll2($sessionutilisateur->id_utilisateur);

        $this->view->tabletri = 1;

    }


    public function supppubliciteAction()
    {
        /* page administration/supppublicite - Suppression de publicité */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $publicite = new Application_Model_EuPublicite();
        $publiciteM = new Application_Model_EuPubliciteMapper();
        $publiciteM->find($id, $publicite);
		
        $publiciteM->delete($publicite->id_publicite);
		//unlink($publicite->desc_publicite);	

        }

		$this->_redirect('/administration/listpublicite');
    }










    public function addappeloffresAction()
    {
        /* page administration/addappeloffres - Ajout d'un dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_document']) && $_POST['id_document']!="" && isset($_POST['num_appeloffres']) && $_POST['num_appeloffres']!="" && isset($_POST['libelle_appeloffres']) && $_POST['libelle_appeloffres']!="" && isset($_FILES['desc_appeloffres']['name']) && $_FILES['desc_appeloffres']['name']!="") {
		
		include("Transfert.php");
		$chemin	= "appeloffress";
		$file = $_FILES['desc_appeloffres']['name'];
		$file1='desc_appeloffres';
		$appeloffres = $chemin."/".transfert($chemin,$file1);
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_appeloffres($compteur);
            $a->setId_document($_POST['id_document']);
            $a->setNum_appeloffres($_POST['num_appeloffres']);
            $a->setLibelle_appeloffres($_POST['libelle_appeloffres']);
            $a->setDesc_appeloffres($appeloffres);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            $a->setPreselection(0);
            $a->setSelection(0);
            $a->setPropo(0);
            $a->setOkfinal(0);
			$a->setDate_appeloffres($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listappeloffres');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }

    public function addappeloffres3Action()
    {
        /* page administration/addappeloffres - Ajout d'un dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_document']) && $_POST['id_document']!="" && isset($_POST['num_appeloffres']) && $_POST['num_appeloffres']!="" && isset($_POST['libelle_appeloffres']) && $_POST['libelle_appeloffres']!="" && isset($_FILES['desc_appeloffres']['name']) && $_FILES['desc_appeloffres']['name']!="") {
		
		include("Transfert.php");
		$chemin	= "appeloffress";
		$file = $_FILES['desc_appeloffres']['name'];
		$file1='desc_appeloffres';
		$appeloffres = $chemin."/".transfert($chemin,$file1);
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setId_appeloffres($compteur);
            $a->setId_document($_POST['id_document']);
            $a->setNum_appeloffres($_POST['num_appeloffres']);
            $a->setLibelle_appeloffres($_POST['libelle_appeloffres']);
            $a->setDesc_appeloffres($appeloffres);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            $a->setPreselection(0);
            $a->setSelection(0);
            $a->setPropo(0);
            $a->setOkfinal(0);
			$a->setDate_appeloffres($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/administration/listappeloffres3');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }

    public function editappeloffresAction()
    {
        /* page administration/editappeloffres - Modification d'un dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_document']) && $_POST['id_document']!="" && isset($_POST['num_appeloffres']) && $_POST['num_appeloffres']!="" && isset($_POST['libelle_appeloffres']) && $_POST['libelle_appeloffres']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['desc_appeloffres']['name']) && $_FILES['desc_appeloffres']['name']!=""){
		$chemin	= "appeloffress";
		$file = $_FILES['desc_appeloffres']['name'];
		$file1='desc_appeloffres';
		$appeloffres = $chemin."/".transfert($chemin,$file1);
		} else {$appeloffres = $_POST['desc_appeloffres_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
		$ma->find($_POST['id_appeloffres'], $a);
			
            $a->setId_document($_POST['id_document']);
            $a->setNum_appeloffres($_POST['num_appeloffres']);
            $a->setLibelle_appeloffres($_POST['libelle_appeloffres']);
            $a->setDesc_appeloffres($appeloffres);
			$a->setId_utilisateur($sessionutilisateur->id_utilisateur);
            $ma->update($a);
			
		$this->_redirect('/administration/listappeloffres');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
		$ma->find($id, $a);
		$this->view->appeloffres = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
		$ma->find($id, $a);
		$this->view->appeloffres = $a;
            }
	}
	}

    public function editappeloffres3Action()
    {
        /* page administration/editappeloffres - Modification d'un dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['id_document']) && $_POST['id_document']!="" && isset($_POST['num_appeloffres']) && $_POST['num_appeloffres']!="" && isset($_POST['libelle_appeloffres']) && $_POST['libelle_appeloffres']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['desc_appeloffres']['name']) && $_FILES['desc_appeloffres']['name']!=""){
		$chemin	= "appeloffress";
		$file = $_FILES['desc_appeloffres']['name'];
		$file1='desc_appeloffres';
		$appeloffres = $chemin."/".transfert($chemin,$file1);
		} else {$appeloffres = $_POST['desc_appeloffres_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
		$ma->find($_POST['id_appeloffres'], $a);
			
            $a->setId_document($_POST['id_document']);
            $a->setNum_appeloffres($_POST['num_appeloffres']);
            $a->setLibelle_appeloffres($_POST['libelle_appeloffres']);
            $a->setDesc_appeloffres($appeloffres);
			$a->setId_utilisateur($sessionutilisateur->id_utilisateur);
            $ma->update($a);
			
		$this->_redirect('/administration/listappeloffres3');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
		$ma->find($id, $a);
		$this->view->appeloffres = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
		$ma->find($id, $a);
		$this->view->appeloffres = $a;
            }
	}
	}



    public function listappeloffresAction()
    {
        /* page administration/listappeloffres - Liste des dossiers d'appels à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $appeloffres = new Application_Model_EuAppeloffresMapper();
		
if($sessionutilisateur->code_groupe == "detentrice" || $sessionutilisateur->code_groupe == "detentrice_pays" || $sessionutilisateur->code_groupe == "detentrice_region" || $sessionutilisateur->code_groupe == "detentrice_secteur" || $sessionutilisateur->code_groupe == "detentrice_agence"){
	        $this->view->entries = $appeloffres->fetchAll9($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
}else{
	        $this->view->entries = $appeloffres->fetchAll8($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
}

        $this->view->tabletri = 1;

    }


    public function listappeloffres2Action()
    {
        /* page administration/listappeloffres2 - Liste des dossiers d'appels à candidature (DAC) déjà traité */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $appeloffres = new Application_Model_EuAppeloffresMapper();
		
if($sessionutilisateur->code_groupe == "detentrice" || $sessionutilisateur->code_groupe == "detentrice_pays" || $sessionutilisateur->code_groupe == "detentrice_region" || $sessionutilisateur->code_groupe == "detentrice_secteur" || $sessionutilisateur->code_groupe == "detentrice_agence"){
	        $this->view->entries = $appeloffres->fetchAll11($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
}else{
	        $this->view->entries = $appeloffres->fetchAll10($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
}

        $this->view->tabletri = 1;

    }

    public function listappeloffres3Action()
    {
        /* page administration/listappeloffres2 - Liste des dossiers d'appels à candidature (DAC) déjà traité */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $appeloffres = new Application_Model_EuAppeloffresMapper();
		
if($sessionutilisateur->code_groupe == "detentrice" || $sessionutilisateur->code_groupe == "detentrice_pays" || $sessionutilisateur->code_groupe == "detentrice_region" || $sessionutilisateur->code_groupe == "detentrice_secteur" || $sessionutilisateur->code_groupe == "detentrice_agence"){
	        $this->view->entries = $appeloffres->fetchAll12($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
}else{
	        $this->view->entries = $appeloffres->fetchAll10($sessionutilisateur->code_source_create, $sessionutilisateur->code_monde_create, $sessionutilisateur->code_zone_create, $sessionutilisateur->id_pays, $sessionutilisateur->id_region, $sessionutilisateur->code_secteur_create, $sessionutilisateur->code_agence_create);
}

        $this->view->tabletri = 1;

    }
	
	
    public function suppappeloffresAction()
    {
        /* page administration/suppappeloffres - Suppression de dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffresM->delete($appeloffres->id_appeloffres);
		//unlink($appeloffres->desc_appeloffres);	

        }

		$this->_redirect('/administration/listappeloffres');
    }


	
    public function suppappeloffres3Action()
    {
        /* page administration/suppappeloffres - Suppression de dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffresM->delete($appeloffres->id_appeloffres);
		//unlink($appeloffres->desc_appeloffres);	

        }

		$this->_redirect('/administration/listappeloffres3');
    }


    public function preselectionappeloffresAction()
    {
        /* page administration/preselectionappeloffres - Pré-selection des dossiers d'appels à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setPreselection($this->_request->getParam('preselection'));
		$appeloffresM->update($appeloffres);
		
		if($this->_request->getParam('preselection') == 0){
        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setSelection($this->_request->getParam('preselection'));
		$appeloffresM->update($appeloffres);
			}
        }

		$this->_redirect('/administration/listappeloffres');
    }


    public function preselectionappeloffres3Action()
    {
        /* page administration/preselectionappeloffres - Pré-selection des dossiers d'appels à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setPreselection($this->_request->getParam('preselection'));
		$appeloffresM->update($appeloffres);
		
		if($this->_request->getParam('preselection') == 0){
        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setSelection($this->_request->getParam('preselection'));
		$appeloffresM->update($appeloffres);
			}
        }

		$this->_redirect('/administration/listappeloffres3');
    }


    public function selectionappeloffresAction()
    {
        /* page administration/selectionappeloffres - Selection finale de dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
		$resultSet = $appeloffresM->fetchAll6($appeloffres->id_document);
		foreach ($resultSet as $row) {
		$appeloffres2 = new Application_Model_EuAppeloffres();
        $appeloffresM2 = new Application_Model_EuAppeloffresMapper();
        $appeloffresM2->find($row->id_appeloffres, $appeloffres2);	
        $appeloffres2->setSelection(0);
		$appeloffresM2->update($appeloffres2);
		}

        $appeloffres->setSelection($this->_request->getParam('selection'));
		$appeloffresM->update($appeloffres);
				
		}

		$this->_redirect('/administration/listappeloffres');
    }

    public function selectionappeloffres3Action()
    {
        /* page administration/selectionappeloffres - Selection finale de dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
		$resultSet = $appeloffresM->fetchAll6($appeloffres->id_document);
		foreach ($resultSet as $row) {
		$appeloffres2 = new Application_Model_EuAppeloffres();
        $appeloffresM2 = new Application_Model_EuAppeloffresMapper();
        $appeloffresM2->find($row->id_appeloffres, $appeloffres2);	
        $appeloffres2->setSelection(0);
		$appeloffresM2->update($appeloffres2);
		}

        $appeloffres->setSelection($this->_request->getParam('selection'));
		$appeloffresM->update($appeloffres);
				
		}

		$this->_redirect('/administration/listappeloffres3');
    }
	
    public function proposerappeloffresAction()
    {
        /* page administration/proposerappeloffres - Proposer des dossiers d'appels à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setPropo($this->_request->getParam('propo'));
		$appeloffresM->update($appeloffres);
				
		}

		$this->_redirect('/administration/listappeloffres');
    }

    public function okfinalappeloffresAction()
    {
        /* page administration/okfinalappeloffres - Ok final de dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setOkfinal($this->_request->getParam('okfinal'));
		$appeloffresM->update($appeloffres);
				
		}

		$this->_redirect('/administration/listappeloffres');
    }
	
	
    public function okfinalappeloffres3Action()
    {
        /* page administration/okfinalappeloffres - Ok final de dossier d'appel à candidature (DAC) */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($id, $appeloffres);
		
        $appeloffres->setOkfinal($this->_request->getParam('okfinal'));
		$appeloffresM->update($appeloffres);
				
		}

		$this->_redirect('/administration/listappeloffres3');
    }
	
    public function accorddocumentAction()
    {
        /* page administration/accorddocument - Accord de document */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $document = new Application_Model_EuDocument();
        $documentM = new Application_Model_EuDocumentMapper();
        $documentM->find($id, $document);
		
        $appeloffres = new Application_Model_EuAppeloffres();
        $appeloffresM = new Application_Model_EuAppeloffresMapper();
        $appeloffresM->find($this->_request->getParam('num'), $appeloffres);
			
        $document->setAccord($this->_request->getParam('accord'));
		if($this->_request->getParam('accord') == 2){
        $document->setNum_appeloffres($appeloffres->num_appeloffres);
		}
		$documentM->update($document);
		
		if($this->_request->getParam('accord') == 0){
        $appeloffres->setSelection(0);
		$appeloffresM->update($appeloffres);
		}
        }

		$this->_redirect('/administration/listappeloffres');
    }




    public function livrerdemandeAction() 
    {
        /* page administration/livrerdemande - Livrer demande */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


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

        $this->_redirect('/administration/listdemandefrais');
    }








    public function listcontactAction()
    {
        /* page administration/listcontact - Liste des messages de contacts */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $contact = new Application_Model_EuContactMapper();
        $this->view->entries = $contact->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppcontactAction()
    {
        /* page administration/suppcontact - Suppression d'un message de contacts */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $contact = new Application_Model_EuContact();
        $contactM = new Application_Model_EuContactMapper();
        $contactM->find($id, $contact);
		
        $contactM->delete($contact->contact_id);

        }

		$this->_redirect('/administration/listcontact');
    }


    public function detailscontactAction() 
    {
        /* page administration/detailscontact - Detail d'un message de contacts */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $contact = new Application_Model_EuContact();
        $contactM = new Application_Model_EuContactMapper();
        $contactM->find($id, $contact);
		$this->view->contact = $contact;

            }

	}


    public function traitercontactAction()
    {
        /* page administration/traitercontact - Traiter un message de contacts */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $contact = new Application_Model_EuContact();
        $contactM = new Application_Model_EuContactMapper();
        $contactM->find($id, $contact);
		
        $contact->setTraiter($this->_request->getParam('traiter'));
		$contactM->update($contact);
        }

		$this->_redirect('/administration/listcontact');
    }








    public function addtacheAction()
    {
        /* page administration/addtache - Ajout d'une tache */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['tache_description']) && $_POST['tache_description']!="" && isset($_POST['tache_code']) && $_POST['tache_code']!="" && isset($_POST['tache_libelle']) && $_POST['tache_libelle']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['tache_url']['name']) && $_FILES['tache_url']['name']!=""){
		$chemin	= "taches";
		$file = $_FILES['tache_url']['name'];
		$file1='tache_url';
		$tache = $chemin."/".transfert($chemin,$file1);
		} else {$tache = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuTache();
        $ma = new Application_Model_EuTacheMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setTache_id($compteur);
            $a->setTache_description($_POST['tache_description']);
            $a->setTache_code($_POST['tache_code']);
            $a->setTache_libelle($_POST['tache_libelle']);
            $a->setTache_url($tache);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
			
		$this->_redirect('/administration/listtache');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function edittacheAction()
    {
        /* page administration/edittache - Modification d'une tache */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['tache_description']) && $_POST['tache_description']!="" && isset($_POST['tache_code']) && $_POST['tache_code']!="" && isset($_POST['tache_libelle']) && $_POST['tache_libelle']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['tache_url']['name']) && $_FILES['tache_url']['name']!=""){
		$chemin	= "taches";
		$file = $_FILES['tache_url']['name'];
		$file1='tache_url';
		$tache = $chemin."/".transfert($chemin,$file1);
		} else {$tache = $_POST['tache_url_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuTache();
        $ma = new Application_Model_EuTacheMapper();
		$ma->find($_POST['tache_id'], $a);
			
            $a->setTache_description($_POST['tache_description']);
            $a->setTache_code($_POST['tache_code']);
            $a->setTache_libelle($_POST['tache_libelle']);
            $a->setTache_url($tache);
            $ma->update($a);
			
		$this->_redirect('/administration/listtache');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuTache();
        $ma = new Application_Model_EuTacheMapper();
		$ma->find($id, $a);
		$this->view->tache = $a;
            }
	}
		   
	} else {


            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuTache();
        $ma = new Application_Model_EuTacheMapper();
		$ma->find($id, $a);
		$this->view->tache = $a;
            }
	}
	}




    public function listtacheAction()
    {
        /* page administration/listtache - Liste des taches */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $tache = new Application_Model_EuTacheMapper();
        $this->view->entries = $tache->fetchAll();

        $this->view->tabletri = 1;

    }



    public function supptacheAction()
    {
        /* page administration/supptache - Suppression d'une tache */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tache = new Application_Model_EuTache();
        $tacheM = new Application_Model_EuTacheMapper();
        $tacheM->find($id, $tache);
		
        $tacheM->delete($tache->tache_id);
		//unlink($tache->tache_url);	

        }

		$this->_redirect('/administration/listtache');
    }


    public function detailstacheAction() 
    {
        /* page administration/detailstache - Detail d'une tache */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $tache = new Application_Model_EuTache();
        $tacheM = new Application_Model_EuTacheMapper();
        $tacheM->find($id, $tache);
		$this->view->tache = $tache;

            }

	}


    public function publiertacheAction()
    {
        /* page administration/publiertache - Publier une tache */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tache = new Application_Model_EuTache();
        $tacheM = new Application_Model_EuTacheMapper();
        $tacheM->find($id, $tache);
		
        $tache->setPublier($this->_request->getParam('publier'));
		$tacheM->update($tache);
        }

		$this->_redirect('/administration/listtache');
    }











    public function addvideoAction()
    {
        /* page administration/addvideo - Ajout d'une video */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['video_description']) && $_POST['video_description']!="" && isset($_POST['video_categorie']) && $_POST['video_categorie']!="" && isset($_POST['video_libelle']) && $_POST['video_libelle']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuVideo();
        $ma = new Application_Model_EuVideoMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setVideo_id($compteur);
            $a->setVideo_description($_POST['video_description']);
            $a->setVideo_categorie($_POST['video_categorie']);
            $a->setVideo_libelle($_POST['video_libelle']);
            $a->setVideo_type($_POST['video_type']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
			
		$this->_redirect('/administration/listvideo');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editvideoAction()
    {
        /* page administration/editvideo - Modification d'une video */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['video_description']) && $_POST['video_description']!="" && isset($_POST['video_categorie']) && $_POST['video_categorie']!="" && isset($_POST['video_libelle']) && $_POST['video_libelle']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuVideo();
        $ma = new Application_Model_EuVideoMapper();
		$ma->find($_POST['video_id'], $a);
			
            $a->setVideo_description($_POST['video_description']);
            $a->setVideo_categorie($_POST['video_categorie']);
            $a->setVideo_libelle($_POST['video_libelle']);
            $a->setVideo_type($_POST['video_type']);
            $ma->update($a);
			
		$this->_redirect('/administration/listvideo');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuVideo();
        $ma = new Application_Model_EuVideoMapper();
		$ma->find($id, $a);
		$this->view->video = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuVideo();
        $ma = new Application_Model_EuVideoMapper();
		$ma->find($id, $a);
		$this->view->video = $a;
            }
	}
	}




    public function listvideoAction()
    {
        /* page administration/listvideo - Liste des videos */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $video = new Application_Model_EuVideoMapper();
        $this->view->entries = $video->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppvideoAction()
    {
        /* page administration/suppvideo - Supression d'une video */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $video = new Application_Model_EuVideo();
        $videoM = new Application_Model_EuVideoMapper();
        $videoM->find($id, $video);
		
        $videoM->delete($video->video_id);
		//unlink($video->video_url);	

        }

		$this->_redirect('/administration/listvideo');
    }




    public function publiervideoAction()
    {
        /* page administration/publiervideo - Publier une video */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $video = new Application_Model_EuVideo();
        $videoM = new Application_Model_EuVideoMapper();
        $videoM->find($id, $video);
		
        $video->setPublier($this->_request->getParam('publier'));
		$videoM->update($video);
        }

		$this->_redirect('/administration/listvideo');
    }





    public function addmenuAction()
    {
        /* page administration/addmenu - Ajout d'un menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['menu_libelle']) && $_POST['menu_libelle']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuMenu();
        $ma = new Application_Model_EuMenuMapper();
		
		$ordre_last = $ma->findOrdre() + 1;
			
            $compteur = $ma->findConuter() + 1;
            $a->setMenu_id($compteur);
            $a->setMenu_libelle($_POST['menu_libelle']);
            $a->setMenu_type($_POST['menu_type']);
            $a->setOrdre($ordre_last);
            $a->setPublier(0);
            $ma->save($a);
			
		$this->_redirect('/administration/listmenu');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editmenuAction()
    {
        /* page administration/editmenu - Modification d'un menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['menu_libelle']) && $_POST['menu_libelle']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuMenu();
        $ma = new Application_Model_EuMenuMapper();
		$ma->find($_POST['menu_id'], $a);
			
            $a->setMenu_libelle($_POST['menu_libelle']);
            $a->setMenu_type($_POST['menu_type']);
            $ma->update($a);
			
		$this->_redirect('/administration/listmenu');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMenu();
        $ma = new Application_Model_EuMenuMapper();
		$ma->find($id, $a);
		$this->view->menu = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMenu();
        $ma = new Application_Model_EuMenuMapper();
		$ma->find($id, $a);
		$this->view->menu = $a;
            }
	}
	}




    public function listmenuAction()
    {
        /* page administration/listmenu - Liste des menus */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $menu = new Application_Model_EuMenuMapper();
        $this->view->entries = $menu->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppmenuAction()
    {
        /* page administration/suppmenu - Suppression d'un menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $menu = new Application_Model_EuMenu();
        $menuM = new Application_Model_EuMenuMapper();
        $menuM->find($id, $menu);
		
        $menuM->delete($menu->menu_id);
		//unlink($menu->menu_url);	

        }

		$this->_redirect('/administration/listmenu');
    }




    public function publiermenuAction()
    {
        /* page administration/publiermenu - Publier un menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $menu = new Application_Model_EuMenu();
        $menuM = new Application_Model_EuMenuMapper();
        $menuM->find($id, $menu);
		
        $menu->setPublier($this->_request->getParam('publier'));
		$menuM->update($menu);
        }

		$this->_redirect('/administration/listmenu');
    }


    function montermenuAction()
    {
        /* page administration/montermenu - Monter dans l'ordre d'un menu */

        $id = (int) $this->_request->getParam('id');
        	if ($id > 0) {
			
        $menu = new Application_Model_EuMenu();
        $menu_mapper = new Application_Model_EuMenuMapper();
		$menu_mapper->find($id, $menu);
		$ordre = $menu->ordre;
		
        $menu1 = new Application_Model_EuMenu();
        $menu1_mapper = new Application_Model_EuMenuMapper();
		$rows = $menu1_mapper->findOrdreMonter($menu->ordre);
		$menu1_mapper->find($rows->menu_id, $menu1);
		$ordre1 = $menu1->ordre;
			
        $menu->setOrdre($ordre1);
		$menu_mapper->update($menu);

        $menu1->setOrdre($ordre);
		$menu1_mapper->update($menu1);
			
		$this->_redirect('/administration/listmenu');
        }
    }
	
	
    function descendremenuAction()
    {
        /* page administration/descendremenu - Descendre dans l'ordre d'un menu */

        $id = (int) $this->_request->getParam('id');
        	if ($id > 0) {
			
        $menu = new Application_Model_EuMenu();
        $menu_mapper = new Application_Model_EuMenuMapper();
		$menu_mapper->find($id, $menu);
		$ordre = $menu->ordre;
		
        $menu1 = new Application_Model_EuMenu();
        $menu1_mapper = new Application_Model_EuMenuMapper();
		$rows = $menu1_mapper->findOrdreDescendre($menu->ordre);
		$menu1_mapper->find($rows->menu_id, $menu1);
		$ordre1 = $menu1->ordre;
			
        $menu->setOrdre($ordre1);
		$menu_mapper->update($menu);

        $menu1->setOrdre($ordre);
		$menu1_mapper->update($menu1);
		
		$this->_redirect('/administration/listmenu');
        }
    }





    public function addmenusousAction()
    {
        /* page administration/addmenusous - Ajout d'un sous menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['menusous_menu']) && $_POST['menusous_menu']!="" && isset($_POST['menusous_libelle']) && $_POST['menusous_libelle']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuMenuSous();
        $ma = new Application_Model_EuMenuSousMapper();
		
		$ordre_last = $ma->findOrdre($_POST['menusous_menu']) + 1;
			
            $compteur = $ma->findConuter() + 1;
            $a->setMenuSous_id($compteur);
            $a->setMenuSous_menu($_POST['menusous_menu']);
            $a->setMenuSous_libelle($_POST['menusous_libelle']);
            $a->setMenuSous_url($_POST['menusous_url']);
            $a->setOrdre($ordre_last);
            $a->setPublier(0);
            $ma->save($a);
			
		$this->_redirect('/administration/listmenusous');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editmenusousAction()
    {
        /* page administration/editmenusous - Modification d'un sous menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['menusous_menu']) && $_POST['menusous_menu']!="" && isset($_POST['menusous_libelle']) && $_POST['menusous_libelle']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuMenuSous();
        $ma = new Application_Model_EuMenuSousMapper();
		$ma->find($_POST['menusous_id'], $a);
			
            $a->setMenuSous_menu($_POST['menusous_menu']);
            $a->setMenuSous_libelle($_POST['menusous_libelle']);
            $a->setMenuSous_url($_POST['menusous_url']);
            $ma->update($a);
			
		$this->_redirect('/administration/listmenusous');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMenuSous();
        $ma = new Application_Model_EuMenuSousMapper();
		$ma->find($id, $a);
		$this->view->menusous = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMenuSous();
        $ma = new Application_Model_EuMenuSousMapper();
		$ma->find($id, $a);
		$this->view->menusous = $a;
            }
	}
	}




    public function listmenusousAction()
    {
        /* page administration/listmenusous - Liste des sous menus */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $menusous = new Application_Model_EuMenuSousMapper();
        $this->view->entries = $menusous->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppmenusousAction()
    {
        /* page administration/suppmenusous - Suppression d'un sous menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $menusous = new Application_Model_EuMenuSous();
        $menusousM = new Application_Model_EuMenuSousMapper();
        $menusousM->find($id, $menusous);
		
        $menusousM->delete($menusous->menusous_id);
		//unlink($menusous->menusous_url);	

        }

		$this->_redirect('/administration/listmenusous');
    }




    public function publiermenusousAction()
    {
        /* page administration/publiermenusous - Publier un sous menu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $menusous = new Application_Model_EuMenuSous();
        $menusousM = new Application_Model_EuMenuSousMapper();
        $menusousM->find($id, $menusous);
		
        $menusous->setPublier($this->_request->getParam('publier'));
		$menusousM->update($menusous);
        }

		$this->_redirect('/administration/listmenusous');
    }



    function montermenusousAction()
    {
        /* page administration/montermenusous - Monter dans l'ordre d'un sous menu */

         $id = (int) $this->_request->getParam('id');
        	if ($id > 0) {
			
        $menusous = new Application_Model_EuMenuSous();
        $menusous_mapper = new Application_Model_EuMenuSousMapper();
		$menusous_mapper->find($id, $menusous);
		$ordre = $menusous->ordre;
		
        $menusous1 = new Application_Model_EuMenuSous();
        $menusous1_mapper = new Application_Model_EuMenuSousMapper();
		$rows = $menusous1_mapper->findOrdreMonter($menusous->menusous_menu, $menusous->ordre);
		$menusous1_mapper->find($rows->menusous_id, $menusous1);
		$ordre1 = $menusous1->ordre;
			
        $menusous->setOrdre($ordre1);
		$menusous_mapper->update($menusous);

        $menusous1->setOrdre($ordre);
		$menusous1_mapper->update($menusous1);
			
		$this->_redirect('/administration/listmenusous');
        }
    }
	
	
    function descendremenusousAction()
    {
        /* page administration/descendremenusous - Descendre dans l'ordre d'un sous menu */

        $id = (int) $this->_request->getParam('id');
        	if ($id > 0) {
			
        $menusous = new Application_Model_EuMenuSous();
        $menusous_mapper = new Application_Model_EuMenuSousMapper();
		$menusous_mapper->find($id, $menusous);
		$ordre = $menusous->ordre;
		
        $menusous1 = new Application_Model_EuMenuSous();
        $menusous1_mapper = new Application_Model_EuMenuSousMapper();
		$rows = $menusous1_mapper->findOrdreDescendre($menusous->menusous_menu, $menusous->ordre);
		$menusous1_mapper->find($rows->menusous_id, $menusous1);
		$ordre1 = $menusous1->ordre;
			
        $menusous->setOrdre($ordre1);
		$menusous_mapper->update($menusous);

        $menusous1->setOrdre($ordre);
		$menusous1_mapper->update($menusous1);
		
		$this->_redirect('/administration/listmenusous');
        }
    }


    public function listacheteurAction()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
if($sessionutilisateur->code_groupe == "espace_kacm"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert0("PP", "AERL", $sessionutilisateur->code_agence);
}else if($sessionutilisateur->code_groupe == "espace_capa"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert0("PP", "CAPA", $sessionutilisateur->code_agence);
}else{
        $this->view->entries = $acheteur->fetchAll30("PP", $sessionutilisateur->code_agence);
}

        $this->view->tabletri = 1;

    }

    public function listacheteurpmAction()
    {
        /* page administration/listacheteurpm - Liste des acheteurs persones morales de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		


	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
if($sessionutilisateur->code_groupe == "espace_kacm"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert0("PM", "AERL2", $sessionutilisateur->code_agence);
}else if($sessionutilisateur->code_groupe == "espace_capa"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert0("PM", "CAPA", $sessionutilisateur->code_agence);
}else{
        $this->view->entries = $acheteur->fetchAll30("PM", $sessionutilisateur->code_agence);
}

        $this->view->tabletri = 1;

    }
	

    public function listacheteurarchiveAction()
    {
        /* page administration/listacheteurarchive - Liste des acheteurs persones physiques de KACM archive */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
if($sessionutilisateur->code_groupe == "espace_kacm"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert1("PP", "AERL", $sessionutilisateur->code_agence);
}else if($sessionutilisateur->code_groupe == "espace_capa"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert1("PP", "CAPA", $sessionutilisateur->code_agence);
}else{
        $this->view->entries = $acheteur->fetchAll31("PP", $sessionutilisateur->code_agence);
}

        $this->view->tabletri = 1;

    }

    public function listacheteurpmarchiveAction()
    {
        /* page administration/listacheteurpmarchive - Liste des acheteurs persones morales de KACM archive */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		


	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
if($sessionutilisateur->code_groupe == "espace_kacm"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert1("PM", "AERL2", $sessionutilisateur->code_agence);
}else if($sessionutilisateur->code_groupe == "espace_capa"){
        $this->view->entries = $acheteur->fetchAllByTypeTransfert1("PM", "CAPA", $sessionutilisateur->code_agence);
}else{
        $this->view->entries = $acheteur->fetchAll31("PM", $sessionutilisateur->code_agence);
}

        $this->view->tabletri = 1;

    }
	

	
    public function publieracheteur2Action()
    {
        /* page administration/publieracheteur - Publier acheteur persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $acheteur = new Application_Model_EuAcheteur();
        $acheteurM = new Application_Model_EuAcheteurMapper();
        $acheteurM->find($id, $acheteur);
		
        $acheteur->setPublier($this->_request->getParam('publier'));
		$acheteurM->update($acheteur);

        }

		$this->_redirect('/administration/listacheteur');
    }


    public function listacheteur1Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(0, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(0, "");
				}

        $this->view->tabletri = 1;

    }
	
    public function listacheteur2Action()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(1, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(1, "");
				}

        $this->view->tabletri = 1;

    }


	
    public function listacheteur3Action()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(2, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(2, "");
				}

        $this->view->tabletri = 1;

    }


	
    public function listacheteur4Action()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }

	
    public function listacheteur41Action()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }


	
    public function listacheteur5Action()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }

	
	
    public function listacheteur6Action()
    {
        /* page administration/listacheteur - Liste des acheteurs persones physiques de KACM */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $acheteur = new Application_Model_EuAcheteurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $acheteur->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $acheteur->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }


    public function publieracheteurAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		
        $acheteur_mapper = new Application_Model_EuAcheteurMapper();
		
		if($sessionutilisateur->code_agence != "001001001001"){
        $acheteur = $acheteur_mapper->fetchAllByPublier($_POST['id'] - 1, $sessionutilisateur->code_agence);
			}else{
        $acheteur = $acheteur_mapper->fetchAllByPublier($_POST['id'] - 1, "");
				}

		foreach ($acheteur as $entry):
		if(isset($_POST['publier'.$entry->acheteur_id.'']) && $_POST['publier'.$entry->acheteur_id.''] == $_POST['id']){

        $acheteur = new Application_Model_EuAcheteur();
        $acheteurM = new Application_Model_EuAcheteurMapper();
        $acheteurM->find($entry->acheteur_id, $acheteur);
		
        $acheteur->setPublier($_POST['publier'.$entry->acheteur_id.'']);
		$acheteurM->update($acheteur);


$date_id = new Zend_Date(Zend_Date::ISO_8601);


        $validation_quittance = new Application_Model_EuValidationQuittance();
        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
			
            $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
            $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
            $validation_quittance->setValidation_quittance_utilisateur($sessionutilisateur->id_utilisateur);
            $validation_quittance->setValidation_quittance_acheteur($entry->acheteur_id);
            $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $validation_quittance->setPublier(1);
            $validation_quittance_mapper->save($validation_quittance);

		include("Transfert.php");





if($_POST['id'] == 3){


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
if($acheteur->acheteur_type == "PP"){
		
        $achet = new Application_Model_EuAcheteur();
        $achet_mapper = new Application_Model_EuAcheteurMapper();
        $compteur_achet = $achet_mapper->findConuterOrdre($acheteur->acheteur_type);
	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Reçu Bon de Consommation Personne Physique : BC-PP'.ajoutezero($compteur_achet + 1).'</u></em></strong></td>
  </tr>';
		
}else if($acheteur->acheteur_type == "PM"){
		
        $achet = new Application_Model_EuAcheteur();
        $achet_mapper = new Application_Model_EuAcheteurMapper();
        $compteur_achet = $achet_mapper->findConuterOrdre($acheteur->acheteur_type);
	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Reçu Bon de Consommation Personne Morale : BC-PM'.ajoutezero($compteur_achet + 1).'</u></em></strong></td>
  </tr>';
	
}
  
/*$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>QUITTANCE CMFH/CAPS/GAC TOGO N° '.$acheteur->acheteur_id.'</u></em></strong></td>
  </tr>';*/
  
        $acheteur = new Application_Model_EuAcheteur();
        $acheteurM = new Application_Model_EuAcheteurMapper();
        $acheteurM->find($entry->acheteur_id, $acheteur);
		
        $acheteur->setAcheteur_ordre($compteur_achet + 1);
		$acheteurM->update($acheteur);
		  
if($acheteur->acheteur_type == "PP"){
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Nom  &amp; prénom(s) de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$acheteur->acheteur_nom.' '.$acheteur->acheteur_prenom.'</em></strong></p></td>
  </tr>';
}else if($acheteur->acheteur_type == "PM"){
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Raison sociale de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$acheteur->acheteur_raison.'</em></strong></p></td>
  </tr>';
}
$htmlpdf .= '
  <tr>
    <td colspan="4" align="right"><strong><em>Montant Bon de Consommation : '.number_format(($acheteur->mont_transfert), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="left">&nbsp;</td>
    <td align="center"><strong><em>Type</em></strong></td>
    <td align="center"><em><strong>Montant</strong></em></td>
  </tr>
  <tr style="background-color:#999;">
    <td align="left"><em><strong>Achat de Bon de Consommation</strong></em></td>
    <td align="left">&nbsp;</td>
    <td align="center"><em>'.$acheteur->type_transfert.'</em></td>
    <td align="center"><em>'.number_format(($acheteur->mont_transfert), 0, ',', ' ').' FCFA</em></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><em><u>Montant en  lettres&nbsp;</u>: '.lettre(($acheteur->mont_transfert), 50).' CFA</em></td>
    <td colspan="2" align="left"><img src="'.Util_Utils::getParamEsmc(2).'/images/cachet.jpg" /><br />
Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
  </tr>';	
  
/*$htmlpdf .= '
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>';*/
  
  
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center">';
	if($acheteur->acheteur_vignette != "" && (substr($acheteur->acheteur_vignette, 0, 3) == "jpg" || substr($acheteur->acheteur_vignette, 0, 3) == "jpeg" || substr($acheteur->acheteur_vignette, 0, 3) == "JPG" || substr($acheteur->acheteur_vignette, 0, 3) == "JPEG")){
list($width, $height, $type, $attr) = getimagesize(Util_Utils::getParamEsmc(2).$acheteur->acheteur_vignette);
	$pourcent = 700 * 100 / $width;
	$width2 = 700;
	$height2 = $pourcent * $height / 100;
$htmlpdf .= '<img src="'.Util_Utils::getParamEsmc(2).'/'.$acheteur->acheteur_vignette.'" width="'.$width2.'" height="'.$height2.'" />

';
}
$htmlpdf .= '  </td>
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
$filename = ''.Util_Utils::getParamEsmc(1).'/acheteurs.html';
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
if (!is_dir("pdf_acheteur/")) {
mkdir("pdf_acheteur/", 0777);
}
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "pdf_acheteur/ACHETEUR_".str_replace("/", "_", mettreaccents($acheteur->acheteur_id))."_.html";
$newnom = "ACHETEUR_".str_replace("/", "_", mettreaccents($acheteur->acheteur_id)."_");
$newchemin = "pdf_acheteur/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
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

	
		//$this->_redirect($file);




if($acheteur->acheteur_email != ""){

$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Validation Bon de Consommation du recu numero : '.$acheteur->acheteur_numero.' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
if($acheteur->acheteur_type == "PP"){
$mail->addTo($acheteur->acheteur_email, $acheteur->acheteur_nom." ".$acheteur->acheteur_prenom);
}else{
$mail->addTo($acheteur->acheteur_email, $acheteur->acheteur_raison_sociale);
}
$mail->setSubject('Alerte sur la validation  Bon de Consommation: '.$date_id->toString('dd-MM-yyyy HH:mm')); 

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




}



if($_POST['id'] == 1 || $_POST['id'] == 2 || $_POST['id'] == 3){
	
if($_POST['id'] == 1){
	$agrement = "agrement_filiere";
}else if($_POST['id'] == 2){
	$agrement = "agrement_technopole";
}else if($_POST['id'] == 3){
	$agrement = "agrement_acnev";
}
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateur = $utilisateurM->fetchAllByAgenceCodeGroupe($sessionutilisateur->code_agence, $agrement);
		
foreach ($utilisateur as $entryagrement):
if (substr($entryagrement->code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($entryagrement->code_membre, $membre);
$membre_email = $membre->email_membre;
$membre_nom = $membre->nom_membre." ".$membre->prenom_membre;
} else if (substr($entryagrement->code_membre, -1) == "M") {
$membremorale = new Application_Model_EuMembreMorale();
$mapper_membremorale = new Application_Model_EuMembreMoraleMapper();
$mapper_membremorale->find($entryagrement->code_membre, $membremorale);
$membre_email = $membre->email_membre;
$membre_nom = $membre->raison_sociale;
}


if($membre_email != ""){
$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Alerte sur la validation Bon de Consommation du recu numero : '.$entry->acheteur_numero.' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membre_email, $membre_nom);
$mail->setSubject('Alerte sur la validation  Bon de Consommation: '.$date_id->toString('dd-MM-yyyy HH:mm')); 
$mail->send($tr);
}
endforeach;
}


			}
		endforeach;

if($_POST['id'] == 3){
		$this->_redirect('/administration/listacheteur41');
}else{
		$this->_redirect('/administration/listacheteur'.$_POST['id'].'');
	}
        }
    }








    public function listcandidatAction()
    {
        /* page administration/listcandidat - Liste des candidats CMFH */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $candidat = new Application_Model_EuCandidatMapper();
        $this->view->entries = $candidat->fetchAll();

        $this->view->tabletri = 1;

    }

    public function publiercandidatAction()
    {
        /* page administration/publiercandidat - Publier candidat CMFH */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $candidat = new Application_Model_EuCandidat();
        $candidatM = new Application_Model_EuCandidatMapper();
        $candidatM->find($id, $candidat);
		
        $candidat->setPublier($this->_request->getParam('publier'));
		$candidatM->update($candidat);
        }

		$this->_redirect('/administration/listcandidat');
    }






    public function listquittanceAction()
    {
        /* page administration/listquittance - Liste des quitances CMFH/CAPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $quittance = new Application_Model_EuQuittanceMapper();
if ($sessionutilisateur->code_groupe == "espace_cmfh"){
	        $this->view->entries = $quittance->fetchAllByCandidat(1);
}else if ($sessionutilisateur->code_groupe == "espace_caps"){
	        $this->view->entries = $quittance->fetchAllByCandidat(0);
}else{
	        $this->view->entries = $quittance->fetchAll();
}
        $this->view->tabletri = 1;

    }

    public function publierquittanceAction()
    {
        /* page administration/publierquittance - Publier quitance CMFH/CAPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $quittance = new Application_Model_EuQuittance();
        $quittanceM = new Application_Model_EuQuittanceMapper();
        $quittanceM->find($id, $quittance);
		
        $quittance->setPublier($this->_request->getParam('publier'));
        $quittance->setQuittance_code_membre($_POST['quittance_code_membre']);
		$quittanceM->update($quittance);




        $candidat = new Application_Model_EuCandidat();
        $candidatM = new Application_Model_EuCandidatMapper();
        $candidatM->find($quittance->quittance_candidat, $candidat);
		
        $candidat->setPublier($this->_request->getParam('publier'));
		$candidatM->update($candidat);

        }

		$this->_redirect('/administration/listquittance');
    }



    public function detailscandidatAction() 
    {
        /* page administration/detailscandidat - Detail d'un candidat CMFH */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $candidat = new Application_Model_EuCandidat();
        $candidatM = new Application_Model_EuCandidatMapper();
        $candidatM->find($id, $candidat);
		$this->view->candidat = $candidat;

            }

	}





    public function addfichierAction()
    {
        /* page administration/addfichier - Ajout d'un fichier */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['fichier_type']) && $_POST['fichier_type']!="" && isset($_POST['fichier_categorie']) && $_POST['fichier_categorie']!="" && isset($_POST['fichier_libelle']) && $_POST['fichier_libelle']!="" && isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!=""){
		$chemin	= "fichiers";
		$file = $_FILES['fichier_url']['name'];
		$file1='fichier_url';
		$fichier = $chemin."/".transfert($chemin,$file1);
		} else {$fichier = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFichier();
        $ma = new Application_Model_EuFichierMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setFichier_id($compteur);
            $a->setFichier_type($_POST['fichier_type']);
            $a->setFichier_categorie($_POST['fichier_categorie']);
            $a->setFichier_libelle($_POST['fichier_libelle']);
            $a->setFichier_url($fichier);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
			
		$this->_redirect('/administration/listfichier');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editfichierAction()
    {
        /* page administration/editfichier - Modification d'un fichier */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['fichier_type']) && $_POST['fichier_type']!="" && isset($_POST['fichier_categorie']) && $_POST['fichier_categorie']!="" && isset($_POST['fichier_libelle']) && $_POST['fichier_libelle']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!=""){
		$chemin	= "fichiers";
		$file = $_FILES['fichier_url']['name'];
		$file1='fichier_url';
		$fichier = $chemin."/".transfert($chemin,$file1);
		} else {$fichier = $_POST['fichier_url_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFichier();
        $ma = new Application_Model_EuFichierMapper();
		$ma->find($_POST['fichier_id'], $a);
			
            $a->setFichier_type($_POST['fichier_type']);
            $a->setFichier_categorie($_POST['fichier_categorie']);
            $a->setFichier_libelle($_POST['fichier_libelle']);
            $a->setFichier_url($fichier);
            $ma->update($a);
			
		$this->_redirect('/administration/listfichier');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFichier();
        $ma = new Application_Model_EuFichierMapper();
		$ma->find($id, $a);
		$this->view->fichier = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFichier();
        $ma = new Application_Model_EuFichierMapper();
		$ma->find($id, $a);
		$this->view->fichier = $a;
            }
	}
	}




    public function listfichierAction()
    {
        /* page administration/listfichier - Liste des fichiers */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $fichier = new Application_Model_EuFichierMapper();
        $this->view->entries = $fichier->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppfichierAction()
    {
        /* page administration/suppfichier - Suppression d'un fichier */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fichier = new Application_Model_EuFichier();
        $fichierM = new Application_Model_EuFichierMapper();
        $fichierM->find($id, $fichier);
		
        $fichierM->delete($fichier->fichier_id);
		//unlink($fichier->fichier_url);	

        }

		$this->_redirect('/administration/listfichier');
    }




    public function publierfichierAction()
    {
        /* page administration/publierfichier - Publier un fichier */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fichier = new Application_Model_EuFichier();
        $fichierM = new Application_Model_EuFichierMapper();
        $fichierM->find($id, $fichier);
		
        $fichier->setPublier($this->_request->getParam('publier'));
		$fichierM->update($fichier);
        }

		$this->_redirect('/administration/listfichier');
    }







    public function addactualiteAction()
    {
        /* page administration/addactualite - Ajout d'une actualite */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['actualite_resume']) && $_POST['actualite_resume']!="" && isset($_POST['actualite_libelle']) && $_POST['actualite_libelle']!="" && isset($_POST['actualite_date']) && $_POST['actualite_date']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['actualite_vignette']['name']) && $_FILES['actualite_vignette']['name']!=""){
		$chemin	= "actualites";
		$file = $_FILES['actualite_vignette']['name'];
		$file1='actualite_vignette';
		$actualite = $chemin."/".transfert($chemin,$file1);
		} else {$actualite = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuActualite();
        $ma = new Application_Model_EuActualiteMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setActualite_id($compteur);
            $a->setActualite_type($_POST['actualite_type']);
            $a->setActualite_resume($_POST['actualite_resume']);
            $a->setActualite_libelle($_POST['actualite_libelle']);
            $a->setActualite_description($_POST['actualite_description']);
            $a->setActualite_vignette($actualite);
            $a->setActualite_date($_POST['actualite_date']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);

		$this->_redirect('/administration/listactualite');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editactualiteAction()
    {
        /* page administration/editactualite - Modification d'une actualite */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['actualite_resume']) && $_POST['actualite_resume']!="" && isset($_POST['actualite_libelle']) && $_POST['actualite_libelle']!="" && isset($_POST['actualite_date']) && $_POST['actualite_date']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['actualite_vignette']['name']) && $_FILES['actualite_vignette']['name']!=""){
		$chemin	= "actualites";
		$file = $_FILES['actualite_vignette']['name'];
		$file1='actualite_vignette';
		$actualite = $chemin."/".transfert($chemin,$file1);
		} else {$actualite = $_POST['actualite_vignette_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuActualite();
        $ma = new Application_Model_EuActualiteMapper();
		$ma->find($_POST['actualite_id'], $a);
			
            $a->setActualite_type($_POST['actualite_type']);
            $a->setActualite_resume($_POST['actualite_resume']);
            $a->setActualite_libelle($_POST['actualite_libelle']);
            $a->setActualite_description($_POST['actualite_description']);
            $a->setActualite_vignette($actualite);
            $a->setActualite_date($_POST['actualite_date']);
            $ma->update($a);
			
		$this->_redirect('/administration/listactualite');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuActualite();
        $ma = new Application_Model_EuActualiteMapper();
		$ma->find($id, $a);
		$this->view->actualite = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuActualite();
        $ma = new Application_Model_EuActualiteMapper();
		$ma->find($id, $a);
		$this->view->actualite = $a;
            }
	}
	}




    public function listactualiteAction()
    {
        /* page administration/listactualite - Liste des actualites */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $actualite = new Application_Model_EuActualiteMapper();
        $this->view->entries = $actualite->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppactualiteAction()
    {
        /* page administration/suppactualite - Suppression d'une actualite */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $actualite = new Application_Model_EuActualite();
        $actualiteM = new Application_Model_EuActualiteMapper();
        $actualiteM->find($id, $actualite);
		
        $actualiteM->delete($actualite->actualite_id);
		//unlink($actualite->actualite_vignette);	

        }

		$this->_redirect('/administration/listactualite');
    }




    public function publieractualiteAction()
    {
        /* page administration/publieractualite - Publier une actualite */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $actualite = new Application_Model_EuActualite();
        $actualiteM = new Application_Model_EuActualiteMapper();
        $actualiteM->find($id, $actualite);
		
        $actualite->setPublier($this->_request->getParam('publier'));
		$actualiteM->update($actualite);
        }

		$this->_redirect('/administration/listactualite');
    }




    public function listpreinscriptionAction()
    {
        /* page administration/listpreinscription - Liste pré-inscription personne physique */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $preinscription = new Application_Model_EuPreinscriptionMapper();
        $this->view->entries = $preinscription->fetchAll();

        $this->view->tabletri = 1;

    }



    public function listpreinscriptionmoraleAction()
    {
        /* page administration/listpreinscriptionmorale - Liste pré-inscription personne morale */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $preinscriptionmorale = new Application_Model_EuPreinscriptionMoraleMapper();
        $this->view->entries = $preinscriptionmorale->fetchAll();

        $this->view->tabletri = 1;

    }



    public function addcentreAction()
    {
        /* page administration/addcentre - Ajout de centre d'enrolement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['centre_ville']) && $_POST['centre_ville']!="" && isset($_POST['centre_quartier']) && $_POST['centre_quartier']!="" && isset($_POST['centre_libelle']) && $_POST['centre_libelle']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuCentre();
        $ma = new Application_Model_EuCentreMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setCentre_id($compteur);
            $a->setCentre_description($_POST['centre_description']);
            $a->setCentre_quartier($_POST['centre_quartier']);
            $a->setCentre_libelle($_POST['centre_libelle']);
            $a->setCentre_ville($_POST['centre_ville']);
            $a->setId_pays($_POST['id_pays']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
			

                    for ($i = 0; $i < sizeof($_POST['code_membre']); $i++) {
                        $centre_membre = new Application_Model_EuCentreMembre();
                        $m_centre_membre = new Application_Model_EuCentreMembreMapper();

                        $compt_centre_membre = $m_centre_membre->findConuter() + 1;

                        $m_centre = new Application_Model_EuCentreMapper();
                        $compt_centre = $m_centre->findConuter();


                        $centre_membre->setCentre_membre_id($compt_centre_membre);
                        $centre_membre->setCentre_id($compt_centre);
                        $centre_membre->setCode_membre($_POST['code_membre'][$i]);
                        $m_centre_membre->save($centre_membre);
                    }/**/
			
			
		$this->_redirect('/administration/listcentre');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editcentreAction()
    {
        /* page administration/editcentre - Modification de centre d'enrolement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['centre_ville']) && $_POST['centre_ville']!="" && isset($_POST['centre_quartier']) && $_POST['centre_quartier']!="" && isset($_POST['centre_libelle']) && $_POST['centre_libelle']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuCentre();
        $ma = new Application_Model_EuCentreMapper();
		$ma->find($_POST['centre_id'], $a);
			
            $a->setCentre_description($_POST['centre_description']);
            $a->setCentre_quartier($_POST['centre_quartier']);
            $a->setCentre_libelle($_POST['centre_libelle']);
            $a->setCentre_ville($_POST['centre_ville']);
            $a->setId_pays($_POST['id_pays']);
            $ma->update($a);
			
			
			
$centremembreM = new Application_Model_EuCentreMembreMapper();
$centremembre = $centremembreM->fetchAll2($a->centre_id);
foreach ($centremembre as $membre):
        $centremembreM->delete($membre->centre_membre_id);
endforeach;			



                    for ($i = 0; $i < sizeof($_POST['code_membre']); $i++) {
                        $centre_membre = new Application_Model_EuCentreMembre();
                        $m_centre_membre = new Application_Model_EuCentreMembreMapper();

                        $compt_centre_membre = $m_centre_membre->findConuter() + 1;

                        $m_centre = new Application_Model_EuCentreMapper();
                        $compt_centre = $a->centre_id;


                        $centre_membre->setCentre_membre_id($compt_centre_membre);
                        $centre_membre->setCentre_id($compt_centre);
                        $centre_membre->setCode_membre($_POST['code_membre'][$i]);
                        $m_centre_membre->save($centre_membre);
                    }/**/
			
			
			
			
			
			
			
			
		$this->_redirect('/administration/listcentre');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuCentre();
        $ma = new Application_Model_EuCentreMapper();
		$ma->find($id, $a);
		$this->view->centre = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuCentre();
        $ma = new Application_Model_EuCentreMapper();
		$ma->find($id, $a);
		$this->view->centre = $a;
            }
	}
	}




    public function listcentreAction()
    {
        /* page administration/listcentre - Liste de centre d'enrolement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $centre = new Application_Model_EuCentreMapper();
        $this->view->entries = $centre->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppcentreAction()
    {
        /* page administration/suppcentre - Suppression de centre d'enrolement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $centre = new Application_Model_EuCentre();
        $centreM = new Application_Model_EuCentreMapper();
        $centreM->find($id, $centre);
		
        $centreM->delete($centre->centre_id);

        }

		$this->_redirect('/administration/listcentre');
    }




    public function publiercentreAction()
    {
        /* page administration/publiercentre - Publier un centre d'enrolement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');

		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $centre = new Application_Model_EuCentre();
        $centreM = new Application_Model_EuCentreMapper();
        $centreM->find($id, $centre);
		
        $centre->setPublier($this->_request->getParam('publier'));
		$centreM->update($centre);
        }

		$this->_redirect('/administration/listcentre');
    }


    public function suppcentremembreAction()
    {
        /* page administration/suppcentremembre - Suppression d'un membre de centre d'enrolement */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $centremembre = new Application_Model_EuCentreMembre();
        $centremembreM = new Application_Model_EuCentreMembreMapper();
        $centremembreM->find($id, $centremembre);
		
        $centremembreM->delete($centremembre->centre_membre_id);

        }

		$this->_redirect('/administration/listcentre');
    }






    public function addzppeAction()
    {
        /* page administration/addzppe - Ajout de ZPPE */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['zppe_resume']) && $_POST['zppe_resume']!="" && isset($_POST['zppe_libelle']) && $_POST['zppe_libelle']!="" && isset($_POST['zppe_portable']) && $_POST['zppe_portable']!="" && isset($_POST['zppe_email']) && $_POST['zppe_email']!="" && isset($_POST['zppe_login']) && $_POST['zppe_login']!="" && isset($_POST['zppe_password']) && $_POST['zppe_password']==$_POST['confirme']) {
		
		include("Transfert.php");
		if(isset($_FILES['zppe_vignette']['name']) && $_FILES['zppe_vignette']['name']!=""){
		$chemin	= "zppes";
		$file = $_FILES['zppe_vignette']['name'];
		$file1='zppe_vignette';
		$zppe = $chemin."/".transfert($chemin,$file1);
		} else {$zppe = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuZppe();
        $ma = new Application_Model_EuZppeMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setZppe_id($compteur);
            $a->setZppe_resume($_POST['zppe_resume']);
            $a->setZppe_libelle($_POST['zppe_libelle']);
            $a->setZppe_description($_POST['zppe_description']);
            $a->setZppe_vignette($zppe);
            $a->setZppe_login($_POST['zppe_login']);
            $a->setZppe_password(md5($_POST['zppe_password']));
            $a->setZppe_date_genere($date_id->toString('yyyy-MM-dd'));
            $a->setZppe_portable($_POST['zppe_portable']);
            $a->setZppe_email($_POST['zppe_email']);
            $a->setZppe_code_membre($_POST['zppe_membre']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);

		$this->_redirect('/administration/listzppe');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editzppeAction()
    {
        /* page administration/editzppe - Modification de ZPPE */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['zppe_resume']) && $_POST['zppe_resume']!="" && isset($_POST['zppe_libelle']) && $_POST['zppe_libelle']!="" && isset($_POST['zppe_portable']) && $_POST['zppe_portable']!="" && isset($_POST['zppe_email']) && $_POST['zppe_email']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['zppe_vignette']['name']) && $_FILES['zppe_vignette']['name']!=""){
		$chemin	= "zppes";
		$file = $_FILES['zppe_vignette']['name'];
		$file1='zppe_vignette';
		$zppe = $chemin."/".transfert($chemin,$file1);
		} else {$zppe = $_POST['zppe_vignette_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuZppe();
        $ma = new Application_Model_EuZppeMapper();
		$ma->find($_POST['zppe_id'], $a);
			
            $a->setZppe_resume($_POST['zppe_resume']);
            $a->setZppe_libelle($_POST['zppe_libelle']);
            $a->setZppe_description($_POST['zppe_description']);
            $a->setZppe_vignette($zppe);
            //$a->setZppe_login($_POST['zppe_login']);
            //$a->setZppe_password($_POST['zppe_password']);
            $a->setZppe_portable($_POST['zppe_portable']);
            $a->setZppe_email($_POST['zppe_email']);
            $a->setZppe_code_membre($_POST['zppe_membre']);
            $ma->update($a);
			
		$this->_redirect('/administration/listzppe');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuZppe();
        $ma = new Application_Model_EuZppeMapper();
		$ma->find($id, $a);
		$this->view->zppe = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuZppe();
        $ma = new Application_Model_EuZppeMapper();
		$ma->find($id, $a);
		$this->view->zppe = $a;
            }
	}
	}




    public function listzppeAction()
    {
        /* page administration/listzppe - Liste des ZPPEs */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $zppe = new Application_Model_EuZppeMapper();
        $this->view->entries = $zppe->fetchAll();

        $this->view->tabletri = 1;

    }


    public function suppzppeAction()
    {
        /* page administration/suppzppe - Suppression de ZPPE */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $zppe = new Application_Model_EuZppe();
        $zppeM = new Application_Model_EuZppeMapper();
        $zppeM->find($id, $zppe);
		
        $zppeM->delete($zppe->zppe_id);
		//unlink($zppe->zppe_vignette);	

        }

		$this->_redirect('/administration/listzppe');
    }




    public function publierzppeAction()
    {
        /* page administration/publierzppe - Publier un ZPPE */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $zppe = new Application_Model_EuZppe();
        $zppeM = new Application_Model_EuZppeMapper();
        $zppeM->find($id, $zppe);
		
        $zppe->setPublier($this->_request->getParam('publier'));
		$zppeM->update($zppe);
        }

		$this->_redirect('/administration/listzppe');
    }


    public function excelzppeAction()
    {
        /* page administration/excelzppe - Export de ZPPE */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
   
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		
		
		include("Transfert.php");


        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $zppe = new Application_Model_EuZppe();
        $zppeM = new Application_Model_EuZppeMapper();
        $zppeM->find($id, $zppe);
		
		
require_once 'PHPExcel/PHPExcel.php';
		
		
//////////////////////////////

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("MCNP")
							 ->setLastModifiedBy($sessionutilisateur->login)
							 ->setTitle($sessionutilisateur->nom_utilisateur." ".$sessionutilisateur->prenom_utilisateur)
							 ->setSubject("Export Liste Bon")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");

$objPHPExcel->setActiveSheetIndex(0);										  

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);


$objPHPExcel->getActiveSheet()->setCellValue('A1', "#");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Date");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "Numéro");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Montant");
$objPHPExcel->getActiveSheet()->setCellValue('E1', "Montant crédit");
$objPHPExcel->getActiveSheet()->setCellValue('F1', "Code Membre");



        $bon = new Application_Model_EuBonMapper();
        $bonentries = $bon->fetchAllByZppeExcel($zppe->zppe_id, $date_id->toString('yyyy-MM-dd'));
$y = 2;
foreach ($bonentries as $entry):
	
$objPHPExcel->getActiveSheet()->setCellValue('A'.$y.'', $entry->bon_id);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$y.'', $entry->bon_date);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$y.'', $entry->bon_numero);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$y.'', $entry->bon_montant);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$y.'', $entry->bon_montant_credit);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$y.'', $entry->bon_code_membre);

$y++; 	
endforeach;



$objPHPExcel->getActiveSheet()->setTitle($zppe->zppe_libelle);
$objPHPExcel->setActiveSheetIndex(0);





$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

if (!is_dir("excel_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)))) {
mkdir("excel_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)), 0777);
}

rename("../application/controllers/AdministrationController.xlsx", "excel_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle))."/BON_".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)."_".str_replace("/", "-", mettreaccents($zppe->zppe_date_genere)))."_".$date_id->toString('yyyy-MM-dd').".xlsx");

 
 
        $zppe->setZppe_date_genere($date_id->toString('yyyy-MM-dd'));
		$zppeM->update($zppe);
		
		
		
		
$fichier = "excel_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle))."/BON_".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)."_".str_replace("/", "-", mettreaccents($zppe->zppe_date_genere)))."_".$date_id->toString('yyyy-MM-dd').".xlsx";
		
$filena = "BON_".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)."_".str_replace("/", "-", mettreaccents($zppe->zppe_date_genere)))."_".$date_id->toString('yyyy-MM-dd').".xlsx";
		
		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $zppe->zppe_portable, "Un mail vient d'être envoyé à l'adresse ".$zppe->zppe_email.". Ci-joint la liste des bons émis.");        
		
///////////////////////////////

$esmc_email	 = "esmcsarlu@gmail.com";	
		
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('La liste des bons émis depuis '.$zppe->zppe_date_genere.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($zppe->zppe_email, $zppe->zppe_libelle);
$mail->setSubject('Les bons emis depuis '.$zppe->zppe_date_genere.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);
		
		
        }

		$this->_redirect('/administration/listzppe');
    }


    public function addbonAction()
    {
        /* page administration/addbon - Ajout de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['bon_zppe']) && $_POST['bon_zppe']!="" && isset($_POST['bon_numero']) && $_POST['bon_numero']!="" && isset($_POST['bon_code_membre']) && $_POST['bon_code_membre']!="" && isset($_POST['bon_montant']) && $_POST['bon_montant']!="" && isset($_POST['bon_montant_credit']) && $_POST['bon_montant_credit']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuBon();
        $ma = new Application_Model_EuBonMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setBon_id($compteur);
            $a->setBon_zppe($_POST['bon_zppe']);
            $a->setBon_numero($_POST['bon_numero']);
            $a->setBon_montant($_POST['bon_montant']);
            $a->setBon_montant_credit($_POST['bon_montant_credit']);
            $a->setBon_code_membre($_POST['bon_code_membre']);
            $a->setBon_date($date_id->toString('yyyy-MM-dd'));
            $a->setBon_utilisateur($_POST['bon_utilisateur']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);



					
					for($i = 0; $i < count($_POST['bon_detail_reference']); $i++){
        $a = new Application_Model_EuBonDetail();
        $ma = new Application_Model_EuBonDetailMapper();
			
            $compteur_bon_detail = $ma->findConuter() + 1;
            $a->setBon_detail_id($compteur_bon_detail);
            $a->setBon_id($compteur);
            $a->setBon_detail_reference($_POST['bon_detail_reference'][$i]);
            $a->setBon_detail_libelle($_POST['bon_detail_libelle'][$i]);
            $a->setBon_detail_prix_unitaire($_POST['bon_detail_prix_unitaire'][$i]);
            $a->setBon_detail_quantite($_POST['bon_detail_quantite'][$i]);
            $ma->save($a);
                    }





		$this->_redirect('/administration/listbon');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editbonAction()
    {
        /* page administration/editbon - Modification de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['bon_zppe']) && $_POST['bon_zppe']!="" && isset($_POST['bon_numero']) && $_POST['bon_numero']!="" && isset($_POST['bon_code_membre']) && $_POST['bon_code_membre']!="" && isset($_POST['bon_montant']) && $_POST['bon_montant']!="" && isset($_POST['bon_montant_credit']) && $_POST['bon_montant_credit']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuBon();
        $ma = new Application_Model_EuBonMapper();
		$ma->find($_POST['bon_id'], $a);
			
            $a->setBon_zppe($_POST['bon_zppe']);
            $a->setBon_numero($_POST['bon_numero']);
            $a->setBon_montant($_POST['bon_montant']);
            $a->setBon_montant_credit($_POST['bon_montant_credit']);
            $a->setBon_code_membre($_POST['bon_code_membre']);
            $a->setBon_date($date_id->toString('yyyy-MM-dd'));
            $a->setBon_utilisateur($_POST['bon_utilisateur']);
            //$a->setPublier($_POST['publier']);
            $ma->update($a);
			
		$this->_redirect('/administration/listbon');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuBon();
        $ma = new Application_Model_EuBonMapper();
		$ma->find($id, $a);
		$this->view->bon = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuBon();
        $ma = new Application_Model_EuBonMapper();
		$ma->find($id, $a);
		$this->view->bon = $a;
            }
	}
	}




    public function listbonAction()
    {
        /* page administration/listbon - Liste des bons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $bon = new Application_Model_EuBonMapper();
if($sessionutilisateur->code_groupe != "admin_site"){
        $this->view->entries = $bon->fetchAllByUtilisateur($sessionutilisateur->id_utilisateur);
} else {
        $this->view->entries = $bon->fetchAll();
}
        $this->view->tabletri = 1;

    }


    public function suppbonAction()
    {
        /* page administration/suppbon - Suppression de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon = new Application_Model_EuBon();
        $bonM = new Application_Model_EuBonMapper();
        $bonM->find($id, $bon);
		
        $bonM->delete($bon->bon_id);

        }

		$this->_redirect('/administration/listbon');
    }




    public function publierbonAction()
    {
        /* page administration/publierbon - Publier un bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon = new Application_Model_EuBon();
        $bonM = new Application_Model_EuBonMapper();
        $bonM->find($id, $bon);
		
        $bon->setPublier($this->_request->getParam('publier'));
		$bonM->update($bon);
        }

		$this->_redirect('/administration/listbon');
    }

    public function codebarreAction()
    {
        /* page administration/codebarre - Code Barre */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

		$this->view->id = $id;

        }

		//$this->_redirect('/administration/listbon');
    }


    public function pdfbonAction()
    {
        /* page administration/pdfbon - Génération de bon en PDF */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		include("Transfert.php");
		



	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $bon = new Application_Model_EuBon();
        $bonM = new Application_Model_EuBonMapper();
        $bonM->find($id, $bon);

$zppe = new Application_Model_EuZppe();
        $zppeM = new Application_Model_EuZppeMapper();
        $zppeM->find($bon->bon_zppe, $zppe);

        $utilisateur = new Application_Model_EuUtilisateur();
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateurM->find($bon->bon_utilisateur, $utilisateur);



$html = "";

$html .= '
    <page_footer>
        <table>
      <tr>
        <td align="right">
		<barcode type="C128B" value="'.$bon->bon_numero.$utilisateur->code_membre.'" style="width:150mm; height:10mm;" label="none"></barcode>
		</td>
      </tr>
<tr>
	<td><hr></td>
</tr>
<tr>
    <td align="center">Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet<br />
RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425</td>
  </tr>
<tr>
	<td style="width: 34%; text-align: center">[[page_cu]]/[[page_nb]]</td>
</tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="http://testing.gacsource.net/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="middle"><table width="100%" border="0" style="font-size:10px;">
  <tr>
    <td align="right" valign="middle">/__________</td>
    <td align="right" valign="middle">/__________</td>
    <td align="right" valign="middle">/__________</td>
    <td align="right" valign="middle">/__________</td>
    <td align="right" valign="middle">/__________</td>
    <td align="right" valign="middle">/__________</td>
    <td align="right" valign="middle">/__________/</td>
  </tr>
  <tr align="center">
    <td valign="middle">TGSSA</td>
    <td valign="middle">AGSSA</td>
    <td valign="middle">FGSSA</td>
    <td valign="middle">TGSDA</td>
    <td valign="middle">AGSDA</td>
    <td valign="middle">FGSDA</td>
    <td valign="middle">AGSEA</td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>
<strong><u><h2>BON A LIVRER</h2></u></strong>
N°  BON : <strong style="font-size:16px;">'.$bon->bon_numero.'</strong><br />
Date d&rsquo;émission  du Bon : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="60%" align="center" valign="middle"><img src="http://testing.gacsource.net/images/payernonlivre.jpg" width="200" height="100" /></td>
    <td><strong>A <br /><br />'.$zppe->zppe_libelle.'</strong><br />'.$zppe->zppe_resume.'</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>';
        $bon_detail = new Application_Model_EuBonDetailMapper();
        $entriesbondetail = $bon_detail->fetchAll3($id);
if(count($entriesbondetail)>0){	  
$html .= '
  <tr>
    <td colspan="2" width="768"><table border="0" cellpadding="0" cellspacing="0">
      <tr style="background-color:#CCC;">
        <th align="center" style="border:1px solid #CCC;">Ref.</th>
        <th align="center" style="border:1px solid #CCC;">Libellé</th>
        <th align="center" style="border:1px solid #CCC;">Quantité</th>
        <th align="center" style="border:1px solid #CCC;">Prix Unitaire</th>
        <th align="center" style="border:1px solid #CCC;">Montant</th>

      </tr>';
$montanttotal = 0;	  
foreach ($entriesbondetail as $entry):
$montant = $entry->bon_detail_quantite * $entry->bon_detail_prix_unitaire;
$montanttotal += $montant;	  
$html .= '
      <tr>
        <td align="left" style="border:1px solid #CCC;">'.$entry->bon_detail_reference.'</td>
        <td align="left" style="border:1px solid #CCC;">'.$entry->bon_detail_libelle.'</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($entry->bon_detail_quantite, 0, ',', ' ').'</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($entry->bon_detail_prix_unitaire, 0, ',', ' ').'</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($montant, 0, ',', ' ').'</td>
      </tr>';
endforeach;
$montanttva = $montanttotal * 0.18;
$html .= '
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right"><strong>Montant Total HT</strong></td>
        <td align="right" style="border:1px solid #CCC;">'.number_format(($montanttotal - $montanttva), 0, ',', ' ').'</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right"><strong>Montant TVA 18%</strong></td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($montanttva, 0, ',', ' ').'</td>
      </tr>
      <tr>
        <td colspan="4" align="left">Bon  arrêté (en FCFA) &agrave; la somme de : <i>'.lettre($montanttotal, 75).'</i></td>
        <td align="right" style="border:1px solid #CCC;">'.number_format(($montanttotal), 0, ',', ' ').'</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="left">Bon  arrêté (en unités bleues en nr) &agrave; la somme de : <i>'.lettre($bon->bon_montant_credit, 50).'</i></td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($bon->bon_montant_credit, 0, ',', ' ').'</td>
      </tr>
      <tr>
        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>';
	}	  
$html .= '
  <tr>
    <td colspan="2" width="768"><table border="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">Nom &amp;  prénom  <br />
          Emetteur du Bon</td>
        <td align="center">Nom  &amp; prénom Personne <br />
          habileté à viser le Bon</td>
        <td align="center">Reçu par : </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
	  <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
	  <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
	  <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
';
$utilisateurM = new Application_Model_EuUtilisateurMapper();
$utilisateur = new Application_Model_EuUtilisateur();
$utilisateurM->find($bon->bon_utilisateur, $utilisateur);

$html .= '
		<tr>
        <td align="center">'.$utilisateur->nom_utilisateur.' '.$utilisateur->prenom_utilisateur.'</td>
        <td align="center">&nbsp;</td>
	  ';
if (substr($bon->bon_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($bon->bon_code_membre, $membre);

$paysM = new Application_Model_EuPaysMapper();
$pays = new Application_Model_EuPays();
$paysM->find($membre->id_pays, $pays);
$html .= '
        <td align="center">
		'.$membre->nom_membre.' '.$membre->prenom_membre.' <br />
      <strong>'.$membre->code_membre.'</strong>
	  <br />Tél.: '.$membre->tel_membre.' / '.$membre->portable_membre.'
	  </td>
	  ';
} else if (substr($bon->bon_code_membre, -1) == "M") {
$membremorale = new Application_Model_EuMembreMorale();
$mapper_membremorale = new Application_Model_EuMembreMoraleMapper();
$mapper_membremorale->find($bon->bon_code_membre, $membremorale);

$mapper_rep = new Application_Model_EuRepresentationMapper();
$rep = $mapper_rep->findbyrep($membremorale->code_membre_morale);

$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($rep->code_membre, $membre);

$paysM = new Application_Model_EuPaysMapper();
$pays = new Application_Model_EuPays();
$paysM->find($membremorale->id_pays, $pays);
$html .= '
        <td align="center">
	'.$membremorale->raison_sociale.' <br />
      '.$membre->nom_membre.' '.$membre->prenom_membre.' <br />
      <strong>'.$membremorale->code_membre_morale.'</strong><br />
	  N° RCCM : '.$membremorale->num_registre_membre.'
	  <br />Tél.: '.$membremorale->tel_membre.' / '.$membremorale->portable_membre.'
	  </td>
';
$utilisateurM = new Application_Model_EuUtilisateurMapper();
$utilisateur = new Application_Model_EuUtilisateur();
$utilisateurM->find($bon->bon_utilisateur, $utilisateur);
}

$html .= '
      </tr>
	  ';
$html .= '
      <tr>
        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
</table>


';

		
        $bon->setPublier(1);
		$bonM->update($bon);

////////////////////////////////////////////////////////////////////////////////
$filename = '/var/www/html/mcnp/public/bon.html';
$somecontent = $html;

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
if (!is_dir("pdf_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)))) {
mkdir("pdf_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle)), 0777);
}

$newfile = "pdf_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle))."/BON_".str_replace("/", "_", mettreaccents($bon->bon_numero)."_".mettreaccents($bon->bon_code_membre)."_".str_replace("/", "_", mettreaccents($bon->bon_date))).".html"	;
$newnom = "BON_".str_replace("/", "_", mettreaccents($bon->bon_numero)."_".mettreaccents($bon->bon_code_membre)."_".str_replace("/", "_", mettreaccents($bon->bon_date)));
$newchemin = "pdf_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle))."/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
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

unlink($newfile);

		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $zppe->zppe_portable, "Un mail vient d'être envoyé à l'adresse ".$zppe->zppe_email.". Ci-joint le bon émis.");        
///////////////////////////////

$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Le bon &eacute;mis le '.$zppe->zppe_date_genere.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($zppe->zppe_email, $zppe->zppe_libelle);
$mail->setSubject('Un bon emis le '.$zppe->zppe_date_genere.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);
		



////////////////////////////////////////////////////////////////////////////



if (substr($bon->bon_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($bon->bon_code_membre, $membre);
$nom = $membre->nom_membre.' '.$membre->prenom_membre;
} else if (substr($bon->bon_code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$mapper_membre = new Application_Model_EuMembreMoraleMapper();
$mapper_membre->find($bon->bon_code_membre, $membre);
$nom = $membre->raison_sociale;
}
		
		
		
		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $membre->portable_membre, "Un mail vient d'être envoyé à l'adresse ".$membre->email_membre.". Ci-joint le bon émis.");        
///////////////////////////////


$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Le bon &eacute;mis le '.$zppe->zppe_date_genere.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($membre->email_membre, $nom);
$mail->setSubject('Un bon emis le '.$zppe->zppe_date_genere.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);





		
        }

		$this->_redirect('/administration/listbon');
    }


    public function telechargerbonAction()
    {
        /* page administration/telechargerbon - Télécharger de bon */

		/*$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}*/

		include("Transfert.php");

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $bon = new Application_Model_EuBon();
        $bonM = new Application_Model_EuBonMapper();
        $bonM->find($id, $bon);

$zppe = new Application_Model_EuZppe();
        $zppeM = new Application_Model_EuZppeMapper();
        $zppeM->find($bon->bon_zppe, $zppe);

$newnom = "BON_".str_replace("/", "_", mettreaccents($bon->bon_numero)."_".mettreaccents($bon->bon_code_membre)."_".str_replace("/", "_", mettreaccents($bon->bon_date)));
$newchemin = "pdf_bon/".str_replace(" ", "_", mettreaccents($zppe->zppe_libelle))."/"	;

$file = $newchemin.$newnom.'.pdf';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
		//$this->_redirect('/administration/listbon');
		}
	}
	
	
    public function addbondetailAction()
    {
        /* page administration/addbondetail - Ajout detail de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
$this->view->id = $id;

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['bon_detail_reference']) && $_POST['bon_detail_reference']!="" && isset($_POST['bon_detail_libelle']) && $_POST['bon_detail_libelle']!="" && isset($_POST['bon_detail_quantite']) && $_POST['bon_detail_quantite']!="" && isset($_POST['bon_detail_prix_unitaire']) && $_POST['bon_detail_prix_unitaire']!="") {
		
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuBonDetail();
        $ma = new Application_Model_EuBonDetailMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setBon_detail_id($compteur);
            $a->setBon_id($_POST['bon_id']);
            $a->setBon_detail_reference($_POST['bon_detail_reference']);
            $a->setBon_detail_libelle($_POST['bon_detail_libelle']);
            $a->setBon_detail_prix_unitaire($_POST['bon_detail_prix_unitaire']);
            $a->setBon_detail_quantite($_POST['bon_detail_quantite']);
            $ma->save($a);

		//$this->_redirect('/administration/listbondetail');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editbondetailAction()
    {
        /* page administration/editbondetail - Modification detail de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['bon_detail_reference']) && $_POST['bon_detail_reference']!="" && isset($_POST['bon_detail_libelle']) && $_POST['bon_detail_libelle']!="" && isset($_POST['bon_detail_quantite']) && $_POST['bon_detail_quantite']!="" && isset($_POST['bon_detail_prix_unitaire']) && $_POST['bon_detail_prix_unitaire']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuBonDetail();
        $ma = new Application_Model_EuBonDetailMapper();
		$ma->find($_POST['bon_detail_id'], $a);
			
            //$a->setBon_id($_POST['bon_id']);
            $a->setBon_detail_reference($_POST['bon_detail_reference']);
            $a->setBon_detail_libelle($_POST['bon_detail_libelle']);
            $a->setBon_detail_prix_unitaire($_POST['bon_detail_prix_unitaire']);
            $a->setBon_detail_quantite($_POST['bon_detail_quantite']);
            $ma->update($a);
			
		$this->_redirect('/administration/listbondetail/id/'.$_POST['bon_id']);
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuBonDetail();
        $ma = new Application_Model_EuBonDetailMapper();
		$ma->find($id, $a);
		$this->view->bon_detail = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuBonDetail();
        $ma = new Application_Model_EuBonDetailMapper();
		$ma->find($id, $a);
		$this->view->bon_detail = $a;
            }
	}
	}




    public function listbondetailAction()
    {
        /* page administration/listbondetail - Liste detail de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $bon_detail = new Application_Model_EuBonDetailMapper();
        $this->view->entries = $bon_detail->fetchAll3($id);
		
$this->view->id = $id;

        $this->view->tabletri = 1;
            }else{
		$this->_redirect('/administration/listbon');
				}

    }


    public function suppbondetailAction()
    {
        /* page administration/suppbondetail - Suppression detail de bon */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon_detail = new Application_Model_EuBonDetail();
        $bon_detailM = new Application_Model_EuBonDetailMapper();
        $bon_detailM->find($id, $bon_detail);
		
        $bon_detailM->delete($bon_detail->bon_detail_id);

        }

		$this->_redirect('/administration/listbondetail/id/'.$bon_detail->bon_id);
    }




    public function addposteAction()
    {
        /* page administration/addposte - Ajout de poste */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['poste_utilisateur']) && $_POST['poste_utilisateur']!="" && isset($_POST['poste_tache']) && count($_POST['poste_tache']) > 0) {
		
					for($i = 0; $i < count($_POST['poste_tache']); $i++){
                    $poste_mapper = new Application_Model_EuPosteMapper();
                    $poste = new Application_Model_EuPoste();
					
							$poste_compteur = $poste_mapper->findConuter() + 1;					
					
                            $poste->setPoste_id($poste_compteur)
                               ->setPoste_tache($_POST['poste_tache'][$i])
                               ->setPoste_utilisateur($_POST['poste_utilisateur'])
							   ;
                            $poste_mapper->save($poste);
                    }
			

		$this->_redirect('/administration/listposte');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function listposteAction()
    {
        /* page administration/listposte - Liste de poste */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $poste = new Application_Model_EuPosteMapper();
        $this->view->entries = $poste->fetchAll();

        $this->view->tabletri = 1;

    }



    public function suppposteAction()
    {
        /* page administration/suppposte - Suppression de poste */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $poste = new Application_Model_EuPoste();
        $posteM = new Application_Model_EuPosteMapper();
        $posteM->find($id, $poste);
		
        $posteM->delete($poste->poste_id);

        }

		$this->_redirect('/administration/listposte');
    }


    public function liresmsrecuAction()
    {
        /* page administration/liresmsrecu - Lire SMS reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

				$tabelb = new Application_Model_DbTable_EuSmsReceive();
				$selectb = $tabelb->select();
				$selectb->where("etat = ?", 0);
				//$selectb->where("", "");
				$this->view->entries = $tabelb->fetchAll($selectb);

        $this->view->tabletri = 1;
    }

    public function liresmsrecu2Action()
    {
        /* page administration/liresmsrecu - Lire SMS reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

				$tabelb = new Application_Model_DbTable_EuSmsReceive();
				$selectb = $tabelb->select();
				$selectb->where("etat = ?", 1);
				$this->view->entries = $tabelb->fetchAll($selectb);

        $this->view->tabletri = 1;
    }



    public function traitersmsAction()
    {
        /* page administration/traitersms - Traiter SMS reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $smsreceive = new Application_Model_EuSmsReceive();
        $smsreceiveM = new Application_Model_EuSmsReceiveMapper();
        $smsreceiveM->find($id, $smsreceive);
		
        $smsreceive->setEtat($this->_request->getParam('etat'));
		$smsreceiveM->update($smsreceive);

        }

		$this->_redirect('/administration/liresmsrecu');
    }









    public function editquestionreponseAction()
    {
        /* page administration/editquestionreponse - Modification de question reponse */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['question_reponse_nom']) && $_POST['question_reponse_nom']!="" && isset($_POST['question_reponse_categorie']) && $_POST['question_reponse_categorie']!="" && isset($_POST['question_reponse_question']) && $_POST['question_reponse_question']!="" && isset($_POST['question_reponse_reponse']) && $_POST['question_reponse_reponse']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuQuestionReponse();
        $ma = new Application_Model_EuQuestionReponseMapper();
		$ma->find($_POST['question_reponse_id'], $a);
			
            $a->setQuestion_reponse_nom($_POST['question_reponse_nom']);
            $a->setQuestion_reponse_question($_POST['question_reponse_question']);
            $a->setQuestion_reponse_reponse($_POST['question_reponse_reponse']);
            $a->setQuestion_reponse_categorie($_POST['question_reponse_categorie']);
            $a->setQuestion_reponse_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $a->setQuestion_reponse_utilisateur($sessionutilisateur->id_utilisateur);
            $a->setPublier($_POST['publier']);
            $ma->update($a);
			
		$this->_redirect('/administration/listquestionreponse');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuQuestionReponse();
        $ma = new Application_Model_EuQuestionReponseMapper();
		$ma->find($id, $a);
		$this->view->question_reponse = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuQuestionReponse();
        $ma = new Application_Model_EuQuestionReponseMapper();
		$ma->find($id, $a);
		$this->view->question_reponse = $a;
            }
	}
	}




    public function listquestionreponseAction()
    {
        /* page administration/listquestionreponse - Liste de question reponse */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $question_reponse = new Application_Model_EuQuestionReponseMapper();
        $this->view->entries = $question_reponse->fetchAllByCategorie($sessionutilisateur->code_groupe);

        $this->view->tabletri = 1;

    }


    public function suppquestionreponseAction()
    {
        /* page administration/suppquestionreponse - Suppression de question reponse */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $question_reponse = new Application_Model_EuQuestionReponse();
        $question_reponseM = new Application_Model_EuQuestionReponseMapper();
        $question_reponseM->find($id, $question_reponse);
		
        $question_reponseM->delete($question_reponse->question_reponse_id);

        }

		$this->_redirect('/administration/listquestionreponse');
    }



    public function publierquestionreponseAction()
    {
        /* page administration/publierquestionreponse - Publier de question reponse */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
		
        $question_reponse = new Application_Model_EuQuestionReponse();
        $question_reponseM = new Application_Model_EuQuestionReponseMapper();
        $question_reponseM->find($id, $question_reponse);
		
        $question_reponse->setQuestion_reponse_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $question_reponse->setPublier($this->_request->getParam('publier'));
		$question_reponseM->update($question_reponse);
        }

		$this->_redirect('/administration/listquestionreponse');
    }






    public function addrecubpsAction()
    {
        /* page administration/addrecubps - Ajout de reçu BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['recu_bps_libelle']) && $_POST['recu_bps_libelle']!="" && isset($_POST['recu_bps_prk']) && $_POST['recu_bps_prk']!="" && isset($_POST['zppe_id']) && $_POST['zppe_id']!="") {
		
			
        $a = new Application_Model_EuRecuBps();
        $ma = new Application_Model_EuRecuBpsMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setRecu_bps_id($compteur);
            $a->setRecu_bps_libelle($_POST['recu_bps_libelle']);
            $a->setRecu_bps_prk($_POST['recu_bps_prk']);
            $a->setZppe_id($_POST['zppe_id']);
            $ma->save($a);

		$this->_redirect('/administration/listrecubps');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editrecubpsAction()
    {
        /* page administration/editrecubps - Modification de reçu BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['recu_bps_libelle']) && $_POST['recu_bps_libelle']!="" && isset($_POST['recu_bps_prk']) && $_POST['recu_bps_prk']!="" && isset($_POST['zppe_id']) && $_POST['zppe_id']!="") {
		
			
        $a = new Application_Model_EuRecuBps();
        $ma = new Application_Model_EuRecuBpsMapper();
		$ma->find($_POST['recu_bps_id'], $a);
			
            $a->setRecu_bps_libelle($_POST['recu_bps_libelle']);
            $a->setRecu_bps_prk($_POST['recu_bps_prk']);
            $a->setZppe_id($_POST['zppe_id']);
            $ma->update($a);
			
		$this->_redirect('/administration/listrecubps');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuRecuBps();
        $ma = new Application_Model_EuRecuBpsMapper();
		$ma->find($id, $a);
		$this->view->recu_bps = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuRecuBps();
        $ma = new Application_Model_EuRecuBpsMapper();
		$ma->find($id, $a);
		$this->view->recu_bps = $a;
            }
	}
	}




    public function listrecubpsAction()
    {
        /* page administration/listrecubps - Liste de reçu BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $recu_bps = new Application_Model_EuRecuBpsMapper();

        $this->view->entries = $recu_bps->fetchAll();

        $this->view->tabletri = 1;

    }


    public function supprecubpsAction()
    {
        /* page administration/supprecubps - Suppression de reçu BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $recu_bps = new Application_Model_EuRecuBps();
        $recu_bpsM = new Application_Model_EuRecuBpsMapper();
        $recu_bpsM->find($id, $recu_bps);
		
        $recu_bpsM->delete($recu_bps->recu_bps_id);

        }

		$this->_redirect('/administration/listrecubps');
    }







    public function addrecuAction()
    {
        /* page administration/addrecu - Ajout de reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['recu_bps']) && $_POST['recu_bps']!="" && isset($_POST['recu_numero']) && $_POST['recu_numero']!="" && isset($_POST['recu_code_membre']) && $_POST['recu_code_membre']!="" && isset($_POST['recu_montant']) && $_POST['recu_montant']!="" && isset($_POST['recu_montant_credit']) && $_POST['recu_montant_credit']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRecu();
        $ma = new Application_Model_EuRecuMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setRecu_id($compteur);
            $a->setRecu_bps($_POST['recu_bps']);
            $a->setRecu_numero($_POST['recu_numero']);
            $a->setRecu_montant($_POST['recu_montant']);
            $a->setRecu_montant_credit($_POST['recu_montant_credit']);
            $a->setRecu_code_membre($_POST['recu_code_membre']);
            $a->setRecu_date($date_id->toString('yyyy-MM-dd'));
            $a->setRecu_date_debut($_POST['recu_date_debut']);
            $a->setRecu_date_fin($_POST['recu_date_fin']);
            $a->setRecu_facture($_POST['recu_facture']);
            $a->setRecu_utilisateur($_POST['recu_utilisateur']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);

		$this->_redirect('/administration/listrecu');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editrecuAction()
    {
        /* page administration/editrecu - Modification de reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['recu_bps']) && $_POST['recu_bps']!="" && isset($_POST['recu_numero']) && $_POST['recu_numero']!="" && isset($_POST['recu_code_membre']) && $_POST['recu_code_membre']!="" && isset($_POST['recu_montant']) && $_POST['recu_montant']!="" && isset($_POST['recu_montant_credit']) && $_POST['recu_montant_credit']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRecu();
        $ma = new Application_Model_EuRecuMapper();
		$ma->find($_POST['recu_id'], $a);
			
            $a->setRecu_bps($_POST['recu_bps']);
            $a->setRecu_numero($_POST['recu_numero']);
            $a->setRecu_montant($_POST['recu_montant']);
            $a->setRecu_montant_credit($_POST['recu_montant_credit']);
            $a->setRecu_code_membre($_POST['recu_code_membre']);
            $a->setRecu_date($date_id->toString('yyyy-MM-dd'));
            $a->setRecu_date_debut($_POST['recu_date_debut']);
            $a->setRecu_date_fin($_POST['recu_date_fin']);
            $a->setRecu_facture($_POST['recu_facture']);
            //$a->setPublier($_POST['publier']);
            $ma->update($a);
			
		$this->_redirect('/administration/listrecu');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuRecu();
        $ma = new Application_Model_EuRecuMapper();
		$ma->find($id, $a);
		$this->view->recu = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuRecu();
        $ma = new Application_Model_EuRecuMapper();
		$ma->find($id, $a);
		$this->view->recu = $a;
            }
	}
	}




    public function listrecuAction()
    {
        /* page administration/listrecu - Liste de reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $recu = new Application_Model_EuRecuMapper();
if($sessionutilisateur->code_groupe != "admin_site"){
        $this->view->entries = $recu->fetchAllByUtilisateur($sessionutilisateur->id_utilisateur);
} else {
        $this->view->entries = $recu->fetchAll();
        }
		$this->view->tabletri = 1;

    }


    public function supprecuAction()
    {
        /* page administration/supprecu - Suppresion de reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $recu = new Application_Model_EuRecu();
        $recuM = new Application_Model_EuRecuMapper();
        $recuM->find($id, $recu);
		
        $recuM->delete($recu->recu_id);

        }

		$this->_redirect('/administration/listrecu');
    }




    public function publierrecuAction()
    {
        /* page administration/publierrecu - Publier un reçu */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $recu = new Application_Model_EuRecu();
        $recuM = new Application_Model_EuRecuMapper();
        $recuM->find($id, $recu);
		
        $recu->setPublier($this->_request->getParam('publier'));
		$recuM->update($recu);
        }

		$this->_redirect('/administration/listrecu');
    }



    public function pdfrecuAction()
    {
        /* page administration/pdfrecu - Génération de reçu en PDF */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		include("Transfert.php");
		



	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $recu = new Application_Model_EuRecu();
        $recuM = new Application_Model_EuRecuMapper();
        $recuM->find($id, $recu);

$recu_bps = new Application_Model_EuRecuBps();
        $recu_bpsM = new Application_Model_EuRecuBpsMapper();
        $recu_bpsM->find($recu->recu_bps, $recu_bps);

        $utilisateur = new Application_Model_EuUtilisateur();
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateurM->find($recu->recu_utilisateur, $utilisateur);


$html = "";

$html .= '
    <page_footer>
        <table>
<tr>
    <td align="center" style="font-size:7px;">Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet. RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td><img src="http://testing.gacsource.net/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td><strong><u><h3>REÇU DE DEBIT</h3></u></strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%" align="left"><i>N° Reçu : '.$recu->recu_numero.'</i></td>
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="30%" align="center"><i>Du : '.$recu->recu_date_debut.'   à   '.$recu->recu_date_fin.'</i></td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Date d’encaissement : '.$recu->recu_date.'</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%" align="center"><i>';
if (substr($recu->recu_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($recu->recu_code_membre, $membre);

$paysM = new Application_Model_EuPaysMapper();
$pays = new Application_Model_EuPays();
$paysM->find($membre->id_pays, $pays);

$html .= ''.$membre->nom_membre.' '.$membre->prenom_membre.'';

} else if (substr($recu->recu_code_membre, -1) == "M") {
$membremorale = new Application_Model_EuMembreMorale();
$mapper_membremorale = new Application_Model_EuMembreMoraleMapper();
$mapper_membremorale->find($recu->recu_code_membre, $membremorale);

$mapper_rep = new Application_Model_EuRepresentationMapper();
$rep = $mapper_rep->findbyrep($membremorale->code_membre_morale);

$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($rep->code_membre, $membre);

$paysM = new Application_Model_EuPaysMapper();
$pays = new Application_Model_EuPays();
$paysM->find($membremorale->id_pays, $pays);

$html .= ''.$membremorale->raison_sociale.'';
}
	  
$html .= '		
		</i></td>
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="30%" align="right"><i>Code Membre : '.$recu->recu_code_membre.'</i></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th style="border-top:1px dashed color:#C9C; height:23px;" align="left"><i>Période facture</i></th>
        <th style="border-top:1px dashed color:#C9C;" align="center"><i>BPS facturé</i></th>
        <th style="border-top:1px dashed color:#C9C;" align="center"><i>N° Facture</i></th>
        <th style="border-top:1px dashed color:#C9C;" align="center"><i>Montant total</i></th>
        <th style="border-top:1px dashed color:#C9C;" align="center"><i>Montant réglé en nr</i></th>
        <th style="border-top:1px dashed color:#C9C;" align="center"><i>Montant restant</i></th>
      </tr>
      <tr style="background-color:#CCC;">
        <td style="border-top:1px dashed color:#C9C; height:23px;" align="left"><i>Du '.$recu->recu_date_debut.'   à   '.$recu->recu_date_fin.'</i></td>
        <td style="border-top:1px dashed color:#C9C;" align="center"><i>'.$recu_bps->recu_bps_libelle.'</i></td>
        <td style="border-top:1px dashed color:#C9C;" align="center"><i>'.$recu->recu_facture.'</i></td>
        <td style="border-top:1px dashed color:#C9C;" align="center"><i>'.number_format($recu->recu_montant_credit, 0, ',', ' ').'</i></td>
        <td style="border-top:1px dashed color:#C9C;" align="center"><i>'.number_format($recu->recu_montant, 0, ',', ' ').'</i></td>
        <td style="border-top:1px dashed color:#C9C;" align="center"><i>'.number_format(($recu->recu_montant - $recu->recu_montant_credit), 0, ',', ' ').'</i></td>
      </tr>
      <tr>
        <td style="border-top:1px dashed color:#C9C; height:23px;" colspan="6" align="left"><i>Mode de règlement : unités ';
if (substr($recu->recu_code_membre, -1) == "P") {
$html .= 'de consommation ';
} else if (substr($recu->recu_code_membre, -1) == "M") {
$html .= 'd’investissement ';
}
$html .= '<span style="color:#F00">MCNP</span> en non récurrent.</i></td>
        </tr>
      <tr>
        <td style="border-top:1px solid color:#999;border-bottom:1px solid color:#999; height:23px;" colspan="5" align="left"><strong><i>Montant réglé en FCFA ( '.lettre($recu->recu_montant_credit, 75).' )</i></strong></td>
        <td style="border-top:1px solid color:#999;border-bottom:1px solid color:#999;" align="center"><strong><i>'.number_format($recu->recu_montant_credit, 2, ',', ' ').'</i></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><i>Signature de l’émetteur du reçu :</i></td>
  </tr>
  <tr>
    <td align="left"><i>';
$utilisateurM = new Application_Model_EuUtilisateurMapper();
$utilisateur = new Application_Model_EuUtilisateur();
$utilisateurM->find($recu->recu_utilisateur, $utilisateur);

$html .= ''.$utilisateur->nom_utilisateur.' '.$utilisateur->prenom_utilisateur.'';	
	
$html .= '</i></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


';

		
        $recu->setPublier(1);
		$recuM->update($recu);

////////////////////////////////////////////////////////////////////////////////
$filename = '/var/www/html/mcnp/public/recu.html';
$somecontent = $html;

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
if (!is_dir("pdf_recu/".str_replace(" ", "_", mettreaccents($recu_bps->recu_bps_libelle)))) {
mkdir("pdf_recu/".str_replace(" ", "_", mettreaccents($recu_bps->recu_bps_libelle)), 0777);
}

$newfile = "pdf_recu/".str_replace(" ", "_", mettreaccents($recu_bps->recu_bps_libelle))."/RECU_".str_replace("/", "_", mettreaccents($recu->recu_numero)."_".mettreaccents($recu->recu_code_membre)."_".str_replace("/", "_", mettreaccents($recu->recu_date))).".html"	;
$newnom = "RECU_".str_replace("/", "_", mettreaccents($recu->recu_numero)."_".mettreaccents($recu->recu_code_membre)."_".str_replace("/", "_", mettreaccents($recu->recu_date)));
$newchemin = "pdf_recu/".str_replace(" ", "_", mettreaccents($recu_bps->recu_bps_libelle))."/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
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

//$this->_redirect('/html2pdf/examples/projet.php?fichierhtml='.$newfile.'&newnom='.$newnom.'');
unlink($newfile);

///////////////////////////////

$zppe = new Application_Model_EuZppe();
        $zppeM = new Application_Model_EuZppeMapper();
        $zppeM->find($recu_bps->zppe_id, $zppe);


		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $zppe->zppe_portable, "Un mail vient d'être envoyé à l'adresse ".$zppe->zppe_email.". Ci-joint le bon émis.");        
///////////////////////////////

$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Le bon &eacute;mis le '.$zppe->zppe_date_genere.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($zppe->zppe_email, $zppe->zppe_libelle);
$mail->setSubject('Un bon emis le '.$zppe->zppe_date_genere.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);
		



////////////////////////////////////////////////////////////////////////////

if (substr($recu->recu_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($recu->recu_code_membre, $membre);
$nom = $membre->nom_membre.' '.$membre->prenom_membre;
} else if (substr($recu->recu_code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$mapper_membre = new Application_Model_EuMembreMoraleMapper();
$mapper_membre->find($recu->recu_code_membre, $membre);
$nom = $membre->raison_sociale;
}
		
		
		
		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $membre->portable_membre, "Un mail vient d'être envoyé à l'adresse ".$membre->email_membre.". Ci-joint le reçu de votre achat de code SMS.");        
///////////////////////////////

$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Le reçu &eacute;mis le '.$recu->recu_date.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($membre->email_membre, $nom);
$mail->setSubject('Un reçu emis le '.$recu->recu_date.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);
		

				
        }

		$this->_redirect('/administration/listrecu');
    }



    public function telechargerrecuAction()
    {
        /* page administration/telechargerrecu - Télécharger un reçu */

		/*$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}*/

		include("Transfert.php");

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $recu = new Application_Model_EuRecu();
        $recuM = new Application_Model_EuRecuMapper();
        $recuM->find($id, $recu);

$recu_bps = new Application_Model_EuRecuBps();
        $recu_bpsM = new Application_Model_EuRecuBpsMapper();
        $recu_bpsM->find($recu->recu_bps, $recu_bps);

        $utilisateur = new Application_Model_EuUtilisateur();
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateurM->find($recu->recu_utilisateur, $utilisateur);

$newfile = "pdf_recu/".str_replace(" ", "_", mettreaccents($recu_bps->recu_bps_libelle))."/RECU_".str_replace("/", "_", mettreaccents($recu->recu_numero)."_".mettreaccents($recu->recu_code_membre)."_".str_replace("/", "_", mettreaccents($recu->recu_date))).".html"	;
$newnom = "RECU_".str_replace("/", "_", mettreaccents($recu->recu_numero)."_".mettreaccents($recu->recu_code_membre)."_".str_replace("/", "_", mettreaccents($recu->recu_date)));
$newchemin = "pdf_recu/".str_replace(" ", "_", mettreaccents($recu_bps->recu_bps_libelle))."/"	;

$file = $newchemin.$newnom.'.pdf';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
		//$this->_redirect('/administration/listrecu');
		}
	}
	






    public function testAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');

//include("automatisation.php"); 
//codegenerer_envoyer();

        $table = new Application_Model_DbTable_EuSouscription();
        $select = $table->select();
		$select->where("souscription_id >= ?)", 123);
		$select->where("souscription_id <= ?)", 487);
        $resultSet = $table->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
			
		$souscription = new Application_Model_EuSouscription();
        $m_souscription = new Application_Model_EuSouscriptionMapper();
		$m_souscription->find($row->souscription_id, $souscription);
		
            $souscription->setSouscription_souscription($souscription->souscription_id);
            $m_souscription->update($souscription);
        }

    }






    public function addfactureAction()
    {
        /* page administration/addfacture - Ajout de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['facture_numero']) && $_POST['facture_numero']!="" && isset($_POST['facture_code_membre']) && $_POST['facture_code_membre']!="" && isset($_POST['facture_montant']) && $_POST['facture_montant']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFactures();
        $ma = new Application_Model_EuFacturesMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setFacture_id($compteur);
            $a->setFacture_numero($_POST['facture_numero']);
            $a->setFacture_montant($_POST['facture_montant']);
            $a->setFacture_code_membre($_POST['facture_code_membre']);
            $a->setFacture_date($date_id->toString('yyyy-MM-dd'));
            $a->setFacture_utilisateur($_POST['facture_utilisateur']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);



					
					for($i = 0; $i < count($_POST['facture_detail_reference']); $i++){
        $a = new Application_Model_EuFacturesDetail();
        $ma = new Application_Model_EuFacturesDetailMapper();
			
            $compteur_facture_detail = $ma->findConuter() + 1;
            $a->setFacture_detail_id($compteur_facture_detail);
            $a->setFacture_id($compteur);
            $a->setFacture_detail_reference($_POST['facture_detail_reference'][$i]);
            $a->setFacture_detail_libelle($_POST['facture_detail_libelle'][$i]);
            $a->setFacture_detail_prix_unitaire($_POST['facture_detail_prix_unitaire'][$i]);
            $a->setFacture_detail_quantite($_POST['facture_detail_quantite'][$i]);
            $ma->save($a);
                    }



		$this->_redirect('/administration/listfacture');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editfactureAction()
    {
        /* page administration/editfacture - Modification de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['facture_numero']) && $_POST['facture_numero']!="" && isset($_POST['facture_code_membre']) && $_POST['facture_code_membre']!="" && isset($_POST['facture_montant']) && $_POST['facture_montant']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFactures();
        $ma = new Application_Model_EuFacturesMapper();
		$ma->find($_POST['facture_id'], $a);
			
            $a->setFacture_numero($_POST['facture_numero']);
            $a->setFacture_montant($_POST['facture_montant']);
            $a->setFacture_code_membre($_POST['facture_code_membre']);
            $a->setFacture_date($date_id->toString('yyyy-MM-dd'));
            $a->setFacture_utilisateur($_POST['facture_utilisateur']);
            //$a->setPublier($_POST['publier']);
            $ma->update($a);
			
		$this->_redirect('/administration/listfacture');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFactures();
        $ma = new Application_Model_EuFacturesMapper();
		$ma->find($id, $a);
		$this->view->facture = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFactures();
        $ma = new Application_Model_EuFacturesMapper();
		$ma->find($id, $a);
		$this->view->facture = $a;
            }
	}
	}




    public function listfactureAction()
    {
        /* page administration/listfacture - Liste des factures */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $facture = new Application_Model_EuFacturesMapper();
if($sessionutilisateur->code_groupe != "admin_site"){
        $this->view->entries = $facture->fetchAllByUtilisateur($sessionutilisateur->id_utilisateur);
} else {
        $this->view->entries = $facture->fetchAll();
}

        $this->view->tabletri = 1;

    }


    public function suppfactureAction()
    {
        /* page administration/suppfacture - Suppression de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $facture = new Application_Model_EuFactures();
        $factureM = new Application_Model_EuFacturesMapper();
        $factureM->find($id, $facture);
		
        $factureM->delete($facture->facture_id);

        }

		$this->_redirect('/administration/listfacture');
    }




    public function publierfactureAction()
    {
        /* page administration/publierfacture - Publier de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $facture = new Application_Model_EuFactures();
        $factureM = new Application_Model_EuFacturesMapper();
        $factureM->find($id, $facture);
		
        $facture->setPublier($this->_request->getParam('publier'));
		$factureM->update($facture);
        }

		$this->_redirect('/administration/listfacture');
    }



    public function pdffactureAction()
    {
        /* page administration/pdffacture - Génération de facture en PDF */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		include("Transfert.php");
		



	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $facture = new Application_Model_EuFactures();
        $factureM = new Application_Model_EuFacturesMapper();
        $factureM->find($id, $facture);

        $utilisateur = new Application_Model_EuUtilisateur();
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateurM->find($facture->facture_utilisateur, $utilisateur);




$html = "";

$html .= '
<page format="150x130" orientation="P" style="font: arial;">
<table  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border:1px solid #00F;">
<table width="100%" border="0">
  <tr>
    <td style="width: 50%;" valign="bottom"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="border:1px solid #00F; color:#00F;">ESMC<br />
Entreprise Sociale de Marché Commun<br>
          <strong>NIF</strong> : <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br></td>
      </tr>
      <tr>
        <td style="border:1px solid #00F; color:#00F;"><strong>Numéro Fiscal</strong> : </td>
      </tr>
      <tr>
        <td style="border:1px solid #00F; color:#00F;"><strong>N&deg;</strong> : '.$facture->facture_numero.'</td>
      </tr>
    </table></td>
    <td style="width: 50%;" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="right" style="border:1px solid #00F; color:#00F;"><strong>Date</strong> : '.$date_id->toString('dd-MM-yyyy').'</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><br>
          <br>
          <br>
		  <br>
          <br>
          <br>
		  </td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>';
if (substr($facture->facture_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($facture->facture_code_membre, $membre);

$paysM = new Application_Model_EuPaysMapper();
$pays = new Application_Model_EuPays();
$paysM->find($membre->id_pays, $pays);
$html .= '
            <td style="border:1px solid #00F; color:#00F;">
<strong>Client</strong> : '.$membre->code_membre.'<br>
<strong>Nom</strong> : '.$membre->nom_membre.' '.$membre->prenom_membre.'<br>
<strong>Adresse</strong> : '.$membre->bp_membre.' - '.$membre->ville_membre.' - '.$pays->libelle_pays.'<br />
<strong>Téléphone</strong> : '.$membre->tel_membre.' / '.$membre->portable_membre.'
	  </td>
';
} else if (substr($facture->facture_code_membre, -1) == "M") {
$membremorale = new Application_Model_EuMembreMorale();
$mapper_membremorale = new Application_Model_EuMembreMoraleMapper();
$mapper_membremorale->find($facture->facture_code_membre, $membremorale);

$mapper_rep = new Application_Model_EuRepresentationMapper();
$rep = $mapper_rep->findbyrep($membremorale->code_membre_morale);

$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($rep->code_membre, $membre);

$paysM = new Application_Model_EuPaysMapper();
$pays = new Application_Model_EuPays();
$paysM->find($membremorale->id_pays, $pays);
$html .= '
            <td style="border:1px solid #00F; color:#00F;">
<strong>Client</strong> : '.$membremorale->code_membre_morale.'<br>
<strong>NIF</strong> : '.$membremorale->num_registre_membre.'<br>
<strong>Nom</strong> : '.$membre->raison_sociale.'<br>
<strong>Adresse</strong> : '.$membremorale->bp_membre.' - '.$membremorale->ville_membre.' - '.$pays->libelle_pays.'<br />
<strong>Téléphone</strong> : '.$membremorale->tel_membre.' / '.$membremorale->portable_membre.'
		</td>
';
}
	  
$html .= '          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>';
        $facture_detail = new Application_Model_EuFacturesDetailMapper();
        $entriesfacturedetail = $facture_detail->fetchAll3($id);
if(count($entriesfacturedetail)>0){	  
$html .= '
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr style="background-color:#09F;">
        <th style="border:1px solid #00F; color:#FFF;">Rèf.</th>
        <th style="border:1px solid #00F; color:#FFF;">Désignation</th>
        <th style="border:1px solid #00F; color:#FFF;">Quantité</th>
        <th style="border:1px solid #00F; color:#FFF;">Prix Unitaire</th>
        <th style="border:1px solid #00F; color:#FFF;">Montant Total</th>
      </tr>';
$montanttotal = 0;	  
foreach ($entriesfacturedetail as $entry):
$montant = $entry->facture_detail_quantite * $entry->facture_detail_prix_unitaire;
$montanttotal += $montant;	  
$html .= '
      <tr>
        <td align="left" style="border:1px solid #00F; color:#00F;">'.$entry->facture_detail_reference.'</td>
        <td align="left" style="border:1px solid #00F; color:#00F;">'.$entry->facture_detail_libelle.'</td>
        <td align="center" style="border:1px solid #00F; color:#00F;">'.number_format($entry->facture_detail_quantite, 0, ',', ' ').'</td>
        <td align="right" style="border:1px solid #00F; color:#00F;">'.number_format($entry->facture_detail_prix_unitaire, 0, ',', ' ').'</td>
        <td align="right" style="border:1px solid #00F; color:#00F;">'.number_format($montant, 0, ',', ' ').'</td>
      </tr>';
endforeach;
$html .= '
      <tr>
        <td colspan="4" align="right" style="border:1px solid #00F; color:#00F;"><strong>Montant TTC</strong> </td>
        <td align="right" style="border:1px solid #00F; color:#00F;">'.number_format(($montanttotal), 0, ',', ' ').'</td>
      </tr>
      <tr>
        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>';
	}	  
$html .= '
  <tr>
    <td colspan="2"><table style="border:1px solid #00F; color:#00F;" width="100%" border="0">
      <tr>
        <td>Arrêté la présente facture à la somme de (en lettre) : <br>'.lettre($montanttotal, 75).'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
</table>
</page>

';

		
        $facture->setPublier(1);
		$factureM->update($facture);

////////////////////////////////////////////////////////////////////////////////
$filename = '/var/www/html/mcnp/public/facture.html';
$somecontent = $html;

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

$newfile = "pdf_facture/FACTURE_".str_replace("/", "_", mettreaccents($facture->facture_numero)."_".mettreaccents($facture->facture_code_membre)."_".str_replace("/", "_", mettreaccents($facture->facture_date))).".html"	;
$newnom = "FACTURE_".str_replace("/", "_", mettreaccents($facture->facture_numero)."_".mettreaccents($facture->facture_code_membre)."_".str_replace("/", "_", mettreaccents($facture->facture_date)));
$newchemin = "pdf_facture/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A5', 'fr');
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

//$this->_redirect('/html2pdf/examples/projet.php?fichierhtml='.$newfile.'&newnom='.$newnom.'');
unlink($newfile);

///////////////////////////////
///////////////////////////////

if (substr($facture->facture_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($facture->facture_code_membre, $membre);
$nom = $membre->nom_membre.' '.$membre->prenom_membre;
$titre = "enrôlement.";
} else if (substr($facture->facture_code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$mapper_membre = new Application_Model_EuMembreMoraleMapper();
$mapper_membre->find($facture->facture_code_membre, $membre);
$nom = $membre->raison_sociale;
$titre = "mise sur chaine.";
}
		
		
		
		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $membre->portable_membre, "Un mail vient d'être envoyé à l'adresse ".$membre->email_membre.". Ci-joint la facture de votre ".$titre);        
///////////////////////////////

$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('La facture &eacute;mise le '.$facture->facture_date.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($membre->email_membre, $nom);
$mail->setSubject('Une facture emise le '.$facture->facture_date.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);
		

				
        }

		$this->_redirect('/administration/listfacture');
    }



    public function telechargerfactureAction()
    {
        /* page administration/telechargerfacture - Télécharger une facture */

		/*$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}*/

		include("Transfert.php");

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $facture = new Application_Model_EuFactures();
        $factureM = new Application_Model_EuFacturesMapper();
        $factureM->find($id, $facture);

        $utilisateur = new Application_Model_EuUtilisateur();
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateurM->find($facture->facture_utilisateur, $utilisateur);

$newfile = "pdf_facture/FACTURE_".str_replace("/", "_", mettreaccents($facture->facture_numero)."_".mettreaccents($facture->facture_code_membre)."_".str_replace("/", "_", mettreaccents($facture->facture_date))).".html"	;
$newnom = "FACTURE_".str_replace("/", "_", mettreaccents($facture->facture_numero)."_".mettreaccents($facture->facture_code_membre)."_".str_replace("/", "_", mettreaccents($facture->facture_date)));
$newchemin = "pdf_facture/"	;

$file = $newchemin.$newnom.'.pdf';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
		//$this->_redirect('/administration/listfacture');
		}
	}
	




    public function addfacturedetailAction()
    {
        /* page administration/addfacturedetail - Ajout detail de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
$this->view->id = $id;

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['facture_detail_reference']) && $_POST['facture_detail_reference']!="" && isset($_POST['facture_detail_libelle']) && $_POST['facture_detail_libelle']!="" && isset($_POST['facture_detail_quantite']) && $_POST['facture_detail_quantite']!="" && isset($_POST['facture_detail_prix_unitaire']) && $_POST['facture_detail_prix_unitaire']!="") {
		
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFacturesDetail();
        $ma = new Application_Model_EuFacturesDetailMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setFacture_detail_id($compteur);
            $a->setFacture_id($_POST['facture_id']);
            $a->setFacture_detail_reference($_POST['facture_detail_reference']);
            $a->setFacture_detail_libelle($_POST['facture_detail_libelle']);
            $a->setFacture_detail_prix_unitaire($_POST['facture_detail_prix_unitaire']);
            $a->setFacture_detail_quantite($_POST['facture_detail_quantite']);
            $ma->save($a);

		//$this->_redirect('/administration/listfacturedetail');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editfacturedetailAction()
    {
        /* page administration/editfacturedetail - Modification detail de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['facture_detail_reference']) && $_POST['facture_detail_reference']!="" && isset($_POST['facture_detail_libelle']) && $_POST['facture_detail_libelle']!="" && isset($_POST['facture_detail_quantite']) && $_POST['facture_detail_quantite']!="" && isset($_POST['facture_detail_prix_unitaire']) && $_POST['facture_detail_prix_unitaire']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFacturesDetail();
        $ma = new Application_Model_EuFacturesDetailMapper();
		$ma->find($_POST['facture_detail_id'], $a);
			
            //$a->setFacture_id($_POST['facture_id']);
            $a->setFacture_detail_reference($_POST['facture_detail_reference']);
            $a->setFacture_detail_libelle($_POST['facture_detail_libelle']);
            $a->setFacture_detail_prix_unitaire($_POST['facture_detail_prix_unitaire']);
            $a->setFacture_detail_quantite($_POST['facture_detail_quantite']);
            $ma->update($a);
			
		$this->_redirect('/administration/listfacturedetail/id/'.$_POST['facture_id']);
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFacturesDetail();
        $ma = new Application_Model_EuFacturesDetailMapper();
		$ma->find($id, $a);
		$this->view->facture_detail = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFacturesDetail();
        $ma = new Application_Model_EuFacturesDetailMapper();
		$ma->find($id, $a);
		$this->view->facture_detail = $a;
            }
	}
	}




    public function listfacturedetailAction()
    {
        /* page administration/listfacturedetail - Liste des details de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $facture_detail = new Application_Model_EuFacturesDetailMapper();
        $this->view->entries = $facture_detail->fetchAll3($id);
		
$this->view->id = $id;

        $this->view->tabletri = 1;
            }else{
		$this->_redirect('/administration/listfacture');
				}

    }


    public function suppfacturedetailAction()
    {
        /* page administration/suppfacturedetail - Suppression detail de facture */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $facture_detail = new Application_Model_EuFacturesDetail();
        $facture_detailM = new Application_Model_EuFacturesDetailMapper();
        $facture_detailM->find($id, $facture_detail);
		
        $facture_detailM->delete($facture_detail->facture_detail_id);

        }

		$this->_redirect('/administration/listfacturedetail/id/'.$facture_detail->facture_id);
    }





    public function listtraiteAction()
    {
        /* page administration/listtraite - Liste des traites */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                //$select->joinRight('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
            $select->where('eu_tpagcp.escomptable = 3');
            //$select->where('eu_traite.traiter != 8');
        $select->order('eu_tpagcp.date_deb ASC');
        $achats = $tabela->fetchAll($select);
		
		$this->view->achats = $achats;



        $this->view->tabletri = 1;

    }


    public function listtraite2Action()
    {
        /* page administration/listtraite2 - Liste des traites traitées */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
            $select->where('eu_tpagcp.escomptable = 3');
            $select->where('eu_traite.traiter = 8');
        $select->order('eu_tpagcp.date_deb ASC');
        $achats = $tabela->fetchAll($select);
		
		$this->view->achats = $achats;



        $this->view->tabletri = 1;

    }

    public function traitertraiteAction()
    {
        /* page administration/traitertraite - Traiter un traite */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

		$mapper_traite = new Application_Model_EuTraiteMapper();
		$traite2 = $mapper_traite->findTraiteTegcp($id);
		
        $traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($traite2->traite_id, $traite);
		
        $traite->setTraiter(0);
		$traiteM->update($traite);
        }

		$this->_redirect('/administration/listtraite2');
    }







    public function pdftraiteAction()
    {
        /* page administration/pdftraite - Génération de traite en PDF */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		//$this->_helper->layout()->setLayout('layoutpublic');
		include("Transfert.php");
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $periode = (int) $this->_request->getParam('periode');

        $id = (int) $this->_request->getParam('id');
        $codeb = (string) $this->_request->getParam('codeb');
        if (isset($id) && $id != 0) {

	    $id_tpagcp = $id;

	    $tpagcp = new Application_Model_DbTable_EuTpagcp();
        $select = $tpagcp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_tpagcp.code_membre',array('eu_tpagcp.*','eu_membre_morale.*')) 
               ->where('eu_tpagcp.id_tpagcp = ?',$id_tpagcp); 
        $data = $tpagcp->fetchAll($select);
		
		/*//création du document PDF
        $pdf = new Default_Pdf_Reglement(); 
        $pdf->pages = array_reverse($pdf->pages);
        
		$traite1 = new Default_Pdf_Page_Reglement(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
        $pdf->pages[] = $traite1;
		
		//$traite1 = new Default_Pdf_Page_Reglement(Zend_Pdf_Page::SIZE_A4);
        //$pdf->pages[] = $traite1;
		 
		$traite2 = new Default_Pdf_Page_Reglement1(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite2;
		 
		$traite3 = new Default_Pdf_Page_Reglement2(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite3;
		 
		$traite4 = new Default_Pdf_Page_Reglement3(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite4;
		 
		$traite5 = new Default_Pdf_Page_Reglement4(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite5;
		 
		$traite6 = new Default_Pdf_Page_Reglement5(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite6;
		 
		$traite7 = new Default_Pdf_Page_Reglement6(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite7;
		 
		$traite8 = new Default_Pdf_Page_Reglement7(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite8; 
		*/
		
		
		
		foreach($data as $donnees) {
			//$traite1->addTraite2($donnees, $codeb, $periode);
			
			/*$traite2->addTraite($donnees);
			$traite3->addTraite($donnees);
			$traite4->addTraite($donnees);
			$traite5->addTraite($donnees);
			$traite6->addTraite($donnees);
			$traite7->addTraite($donnees);
			$traite8->addTraite($donnees);
			*/

			
           $banque = new Application_Model_EuBanque();
           $banqueM = new Application_Model_EuBanqueMapper();
           $banqueM->find($codeb, $banque);
		   

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
		    $date_traite = new Zend_Date(Zend_Date::ISO_8601);
			$date_deb = new Zend_Date($donnees->date_deb,Zend_Date::ISO_8601);
			$date_fin = new Zend_Date($donnees->date_fin,Zend_Date::ISO_8601);
		    $periodes = Util_Utils::getParametre('periode', 'valeur');

$htmlpdf = "";
/*52CAF3*/
/* backimgx="center" backimgy="bottom" backimgw="100%"*/
$htmlpdf .= '
    <page style="font-size: 14px" backcolor="#D2E2F2" backimg="'.Util_Utils::getParamEsmc(2).'/images/filigrane.gif">
    <page_footer style="font-size: 10px">
	<hr>
<table>
  <tr>
    <td colspan="3" align="center">Siège Social : Wuiti-Atchati,  angle Rue Sagouda, Kiyéou &amp; Bandjéli,   03 B.P. 30038 Lomé-TOGO  Tél. + (228) 22 19 32 71 / 93 66 62 75 / 96 00 11 85</td>
  </tr>
  <tr>
    <td colspan="3" align="center">E-mail  : <a href="mailto:esmcsarlu@gmail.com">esmcsarlu@gmail.com</a></td>
  </tr>
		<tr>
			<th>
			<div align="justify" style="color:#FF0000;">E-BANQUES</div>
			</th>
			<th>
			<div align="justify" style="color:#0000FF;">MOBILE MONEY</div>
			</th>
			<th>
			<div align="justify" style="color:#800080;">ORDINAIRES</div>
			</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td><strong>ORABANK : </strong>63642300101</td>
			<td>&nbsp;</td>
			<td><strong>BIA :</strong> 00436748136</td>
		</tr>
		<tr>
			<td><strong>BAT :</strong> 40181660003</td>
			<td>&nbsp;</td>
			<td><strong>BSIC :</strong> 01001022131700112</td>
		</tr>
		<tr>
			<td><strong>BOA :</strong> 001608630006</td>
			<td><strong>Flooz :</strong> ESMC 96369596</td>
			<td><strong>CPP :</strong> 6310274854001000</td>
		</tr>
		<tr>
			<td><strong>UTB :</strong> 214357610004</td>
			<td>&nbsp;</td>
			<td><strong>CORIS BANK :</strong> 00051624101</td>
		</tr>
		<tr>
			<td><strong>ECOBANK :&nbsp;</strong>7090121421892501</td>
			<td>&nbsp;</td>
			<td><strong>SIAB :</strong> 251104102398</td>
		</tr>
		<tr>
			<td><strong>BTCI :</strong> 022612100101</td>
			<td>&nbsp;</td>
			<td><strong>BPEC :</strong> 019999430001</td>
		</tr>
</table>
    </page_footer>

<table width="768" border="0"  style="font-size: 14px">
<tbody>
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete1.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>ORDRE DE PRELEMENT IRREVOCABLE N° ESMC_OPI_'.$donnees->id_tpagcp.'/0'.$periode.'</strong></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><div style="text-align: center; border: solid 2px #000000; width:200px; height:20px; margin: 5px; padding: 10px;">&nbsp; <strong>'.$donnees->code_membre.'</strong> &nbsp;</div></td>
    <td align="right"><barcode type="C128B" value="'.$donnees->code_membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">En paiement de la facture N° ................................................................................................................................................<br /><br />
...............................................................................................................................................................................................
</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Nous soussignés, <strong>M. SAMA Essohamlon</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Agissant en qualité de <strong>Gérant</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="justify">De l\'ESMC (Entreprise Sociale de  Marché Commun) SARL U au capital de 1&nbsp;000&nbsp;000 F CFA&nbsp;; Siège  social&nbsp;: Lomé(TOGO), Wuiti-Atchati, Angle rue Sagouda, Kiyéou et Bandjéli  03BP 30038, immatriculé au RCCM sous le numéro TG-LOM 2014 B514, Tél 22 19 32  71</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><strong>Donnons  ordre, de façon irrévocable, à MONSIEUR LE DIRECTEUR GENERAL DE LA BANQUE  '.$banque->libelle_banque.' ('.$banque->code_banque.')</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">D\'effectuer un prélèvement de la somme de <strong>'.number_format($donnees->mont_tranche,0,',',' ').' FCFA</strong> ('.lettre($donnees->mont_tranche,0).')</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Le prélèvement devant intervenir à la date du : <strong>'.$date_traite->addDay($periode * $periodes)->toString('dd-MM-yyyy').'</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Au profit de <div style="text-align: center; border: solid 1px #000000; width:80%; margin: 5px; padding: 10px;">&nbsp; <strong>'.$donnees->raison_sociale.'</strong> &nbsp;</div></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="justify">En vue d\'assurer l\'exécution de cet  ordre, j\'autorise la Banque à prélever, dès réception de cet ordre et, en  fonction du montant des 30 jours en cours, les provisions correspondantes sur  le compte N° <div style="text-align: center; border: solid 1px #000000; width:200px; margin: 5px; padding: 10px;">&nbsp; <strong>'.$banque->compte_banque.'</strong> &nbsp;</div></td>
  </tr>
  <tr>
    <td colspan="2" align="justify">Ces instructions ne pourront être  révoquées sans l\'accord écrit et formel du donneur d\'ordre. <br>
Nous vous prions d\'agréer, Monsieur le Directeur Général,  l\'expression de nos sentiments distingués.</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><strong>Visa et cachet du Bénéficiaire</strong></td>
    <td align="right"><strong>Signature  du donneur d\'ordre</strong></td>
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
$filename = ''.Util_Utils::getParamEsmc(1).'/traite.html';
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
if (!is_dir("pdf_traite/")) {
mkdir("pdf_traite/", 0777);
}

$newfile = "pdf_traite/TRAITE_".$donnees->id_tpagcp."_".$periode."_".str_replace("/", "_", mettreaccents($donnees->code_membre_morale)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html";
$newnom = "TRAITE_".$donnees->id_tpagcp."_".$periode."_".str_replace("/", "_", mettreaccents($donnees->code_membre_morale)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_traite/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
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

unlink($newfile);

	
		$this->_redirect($file);








		  
		}
		
		
        $mapper_traite = new Application_Model_EuTraiteMapper();
		$traite = $mapper_traite->findTraiteTegcp($id_tpagcp);
		if($traite === FALSE){
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setTraite_id($compteur);
            $a->setTraite_tegcp($id_tpagcp);
            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->save($a);
			}else{
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();
		$ma->find($traite->traite_id, $a);
			
            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->update($a);
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

    }






    public function addsmsnbreAction()
    {
        /* page administration/addsmsnbre - Ajout nombre de SMS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['sms_nbre_nbre']) && $_POST['sms_nbre_nbre']!="") {
		
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
			
        $smsnbre = new Application_Model_EuSmsNbre();
        $smsnbreM = new Application_Model_EuSmsNbreMapper();
        $smsnbreM->find(1, $smsnbre);

        $smsnbre->setSms_nbre_nbre($smsnbre->getSms_nbre_nbre() + $_POST['sms_nbre_nbre']);
        $smsnbre->setSms_nbre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $smsnbre->setSms_nbre_alerte(0);
		$smsnbreM->update($smsnbre);

		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }





    public function addsmsreceiveAction()
    {
        /* page administration/addsmsreceive - Ajout nombre de SMS */

		//$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		$this->_helper->layout->disableLayout();
 		//$this->_helper->layout()->setLayout('layoutpublic');
		
	//if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
//if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

//$_REQUEST['recipient'] = "90291387";
//$_REQUEST['body'] = "test  yok ";
//$_REQUEST['type'] = "FLOOZ";

$recipient = $this->_request->getParam('recipient');
$body = $this->_request->getParam('body');
$type = $this->_request->getParam('type');

	        //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {
		
	if (isset($recipient) && $recipient!="" && isset($body) && $body!="") {
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
			
        $smsreceive = new Application_Model_EuSmsReceive();
        $smsreceiveM = new Application_Model_EuSmsReceiveMapper();

        $compteursms = $smsreceiveM->findConuter() + 1;

        $smsreceive->setNEng($compteursms);
        $smsreceive->setRecipient($recipient);
        $smsreceive->setSMSBody($body);
        $smsreceive->setTypeExpediteur($type);
        $smsreceive->setDateTime($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $smsreceive->setEtat(0);
		$smsreceiveM->save($smsreceive);
		
/////////////////////////////////////		
/*		
Vous+avez+re%3Fcu+2%2C500+FCFA+du+numero+ETS+ALDAN362362.+Votre+nouveau+solde+Flooz+est+de+112%2C500+FCFA.+Txn+ID+%3A020160312025083.
Vous+avez+re%3Fcu+2%2C500+FCFA+du+numero+ETS+ALDAN362362.+Votre+nouveau+solde+Flooz+est+de+2%2C500+FCFA.+Txn+ID+%3A020160312025083.
Vous+avez+re%3Fcu+2%2C500+FCFA+du+numero+ETS+ALDAN362362.+Votre+nouveau+solde+Flooz+est+de+102%2C500+FCFA.+Txn+ID+%3A020160312025083.
Vous+avez+re%3Fcu+2%2C500+FCFA+du+numero+ETS+ALDAN362362.+Votre+nouveau+solde+Flooz+est+de+2%2C500+FCFA.+Txn+ID+%3A020160312025083.

Vous+avez+recu+1+FCFA+du+22896620384.+Votre+nouveau+solde+Flooz+est+de+51%2C912+FCFA.+ID+de+Txn%3A020160324031727.+
Vous+avez+recu+100+FCFA+du+22896620384.+Votre+nouveau+solde+Flooz+est+de+54,331+FCFA.+ID+de+Txn:020160330035991.+
*/

		$sms = $body;
		
		
		
		$pos2 = stripos($sms, "Flooz");
		$pos3 = stripos($sms, "Vous+avez+recu");
if ($pos2 !== false && $pos3 !== false) { 
		
		
		$pos = stripos($sms, "+du+");
		$sms_suite = substr($sms, ($pos + strlen("+du+")));
		$tab_suite = explode(".", $sms_suite);
		$detail_libelle = str_replace("+", " ", $tab_suite[0]);
		
		$pos = stripos($sms, "ID+de+Txn:");
		$detail_numero = substr($sms, ($pos + strlen("ID+de+Txn:")), -2);
		
		$detail_date = $date_id->toString('yyyy-MM-dd');
		
		$pos = stripos($sms, "Vous+avez+recu+");
		$sms_suite = substr($sms, ($pos + strlen("Vous+avez+recu+")));
		$tab_suite = explode("+", $sms_suite);
		$detail_montant = str_replace(",", "", $tab_suite[0]);
		
		$detail_date_valeur = "";
		
		
		
		
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'));
		if(count($relevebancaire2) > 0){
		
		$relevebancaire_id = $relevebancaire2->relevebancaire_id;
		
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($relevebancaire_id);
            $rb->setRelevebancairedetail_libelle($detail_libelle);
            $rb->setRelevebancairedetail_numero($detail_numero);
            $rb->setRelevebancairedetail_date($detail_date);
            $rb->setRelevebancairedetail_montant($detail_montant);
            $rb->setRelevebancairedetail_date_valeur($detail_date_valeur);
            $rb->setPublier(0);
            $mrb->save($rb);
			
			}else{
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setRelevebancaire_id($compteur);
            $a->setRelevebancaire_banque("FLOOZ");
            $a->setRelevebancaire_utilisateur(1);
            $a->setRelevebancaire_fichier(NULL);
            $a->setRelevebancaire_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $a->setPublier(1);
            $ma->save($a);
			
		
		$relevebancaire_id = $compteur;
		
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($relevebancaire_id);
            $rb->setRelevebancairedetail_libelle($detail_libelle);
            $rb->setRelevebancairedetail_numero($detail_numero);
            $rb->setRelevebancairedetail_date($detail_date);
            $rb->setRelevebancairedetail_montant($detail_montant);
            $rb->setRelevebancairedetail_date_valeur($detail_date_valeur);
            $rb->setPublier(0);
            $mrb->save($rb);
			
				}
	
	
	
		
}




		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		///////////////////////// envoie de mail
		
$esmc_email	 = "enrolesmc@gacsource.com";	
$esmc_email2	 = "enrolesmc@gacsource.com";	

//$smtpServer = 'mail.gacsource.com';
$smtpServer = Util_Utils::getParamEsmc(5);
$username = 'enrolesmc@gacsource.com';
$password = Util_Utils::getParamEsmc(4);
$config = array(//'ssl' => 'tls',
                'auth' => 'login',
                'username' => $username,
                'password' => $password);
$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);

$mail = new Zend_Mail();
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($esmc_email2, 'Message de : '.$type);
$mail->setSubject('Nouveau message : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));
$mail->setBodyHtml("Numero : ".$recipient."<br />Type : ".$type."<br /><br />".$body);
$mail->send($transport);



		
//$this->view->error = "Ok success";
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		
    }










    public function addassociationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['association_mobile']) && $_POST['association_mobile']!="" && isset($_POST['association_nom']) && $_POST['association_nom']!="" && isset($_POST['association_numero']) && $_POST['association_numero']!="" && isset($_POST['association_date_agrement']) && $_POST['association_date_agrement']!="" && isset($_POST['association_email']) && $_POST['association_email']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
		
			
        $date_id = Zend_Date::now();

        $association = new Application_Model_EuAssociation();
        $association_mapper = new Application_Model_EuAssociationMapper();
			
            $compteur_association = $association_mapper->findConuter() + 1;
            $association->setAssociation_id($compteur_association);
            $association->setAssociation_mobile($_POST['association_mobile']);
            $association->setAssociation_nom($_POST['association_nom']);
            $association->setAssociation_numero($_POST['association_numero']);
            $association->setAssociation_date_agrement($_POST['association_date_agrement']);
            $association->setAssociation_email($_POST['association_email']);
            $association->setAssociation_recepisse($_POST['association_recepisse']);
            $association->setAssociation_adresse($_POST['association_adresse']);
            $association->setAssociation_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $association->setId_filiere($_POST["id_filiere"]);
            $association->setCode_type_acteur($_POST["type_acteur"]);
            $association->setCode_statut($_POST["statut_juridique"]);
            $association->setCode_agence($_POST["code_agence"]);
            $association->setPublier(1);
            $association_mapper->save($association);
			



			
        $date_id = Zend_Date::now();

        $membreasso = new Application_Model_EuMembreasso();
        $membreasso_mapper = new Application_Model_EuMembreassoMapper();
			
            $compteur_membreasso = $membreasso_mapper->findConuter() + 1;
            $membreasso->setMembreasso_id($compteur_membreasso);
            $membreasso->setMembreasso_mobile($_POST['association_mobile']);
            $membreasso->setMembreasso_nom($_POST['membreasso_nom']);
            $membreasso->setMembreasso_prenom($_POST['membreasso_prenom']);
            $membreasso->setMembreasso_association($compteur_association);
            $membreasso->setMembreasso_email($_POST['membreasso_email']);
            $membreasso->setMembreasso_login($_POST['membreasso_login']);
            $membreasso->setMembreasso_passe($_POST['membreasso_passe']);
            $membreasso->setMembreasso_type(1);
            $membreasso->setMembreasso_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membreasso->setPublier(1);
            $membreasso_mapper->save($membreasso);
			




		$this->_redirect('/administration/listassociation');
		} else {  $this->view->error = "Champs * obligatoire ..."; }
	}
	 
	}



    public function editassociationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['association_mobile']) && $_POST['association_mobile']!="" && isset($_POST['association_nom']) && $_POST['association_nom']!="" && isset($_POST['association_numero']) && $_POST['association_numero']!="" && isset($_POST['association_date_agrement']) && $_POST['association_date_agrement']!="" && isset($_POST['association_email']) && $_POST['association_email']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($_POST['association_id'], $association);
			
            $association->setAssociation_mobile($_POST['association_mobile']);
            $association->setAssociation_nom($_POST['association_nom']);
            $association->setAssociation_numero($_POST['association_numero']);
            $association->setAssociation_date_agrement($_POST['association_date_agrement']);
            $association->setAssociation_email($_POST['association_email']);
            $association->setAssociation_recepisse($_POST['association_recepisse']);
            $association->setAssociation_adresse($_POST['association_adresse']);
            $association->setId_filiere($_POST["id_filiere"]);
            $association->setCode_type_acteur($_POST["type_acteur"]);
            $association->setCode_statut($_POST["statut_juridique"]);
            $association->setCode_agence($_POST["code_agence"]);
            $m_association->update($association);
			
		$this->_redirect('/administration/listassociation');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAssociation();
        $ma = new Application_Model_EuAssociationMapper();
		$ma->find($id, $a);
		$this->view->association = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAssociation();
        $ma = new Application_Model_EuAssociationMapper();
		$ma->find($id, $a);
		$this->view->association = $a;
            }
	}
	}



    public function listassociationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $association = new Application_Model_EuAssociationMapper();
        $this->view->entries = $association->fetchAll();

        $this->view->tabletri = 1;

    }

    public function publierassociationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($id, $association);
		
        $association->setPublier($this->_request->getParam('publier'));
		$associationM->update($association);
        }

		$this->_redirect('/administration/listassociation');
    }




    public function suppassociationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($id, $association);
		
        $associationM->delete($association->association_id);

        }

		$this->_redirect('/administration/listassociation');
    }



    public function detailsassociationAction() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($id, $association);
		$this->view->association = $association;

            }

	}



    public function listmembreassoAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $membreasso = new Application_Model_EuMembreassoMapper();
        $this->view->entries = $membreasso->fetchAllByMembreasso($id);

            }

        $this->view->tabletri = 1;

    }



    public function localmembreassoAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($id, $membreasso);
		
        $membreasso->setLocal($this->_request->getParam('local'));
		$membreassoM->update($membreasso);
        }

		$this->_redirect('/administration/listmembreasso/id/'.$membreasso->membreasso_association);
    }





    public function listsouscription1Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublier(0, $sessionutilisateur->code_agence);
		
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
				
			}else{
        //$this->view->entries = $souscription->fetchAllByPublier(0, "");
		
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
		
				}

        $this->view->tabletri = 1;

    }


    public function listsouscription2Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublier(1, $sessionutilisateur->code_agence);
			}else{
        //$this->view->entries = $souscription->fetchAllByPublier(1, "");
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
				}

        $this->view->tabletri = 1;

    }


    public function listsouscription3Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublier(2, $sessionutilisateur->code_agence);
			}else{
        //$this->view->entries = $souscription->fetchAllByPublier(2, "");
		        $agence = new Application_Model_EuAgenceMapper();
                $this->view->entries = $agence->fetchAllByAssociation();
        		}

        $this->view->tabletri = 1;

    }


    public function listsouscription4Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $souscription->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $souscription->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }

    public function listsouscription41Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $souscription->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $souscription->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }

    public function listsouscription5Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $souscription->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $souscription->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }

    public function listsouscription6Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
		if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $souscription->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $souscription->fetchAllByPublier(3, "");
				}

        $this->view->tabletri = 1;

    }



    public function listsouscriptionvalidationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $publier = (int)$this->_request->getParam('publier');
			$this->view->publier = $publier;

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublier(0, $sessionutilisateur->code_agence);
		
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
				
			}else{
        //$this->view->entries = $souscription->fetchAllByPublier(0, "");
		
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
		
				}

        $this->view->tabletri = 1;

    }




    public function listsouscriptionerreurAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $publier = (int)$this->_request->getParam('publier');
			$this->view->publier = $publier;

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublier(0, $sessionutilisateur->code_agence);
		
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
				
			}else{
        //$this->view->entries = $souscription->fetchAllByPublier(0, "");
		
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
		
				}

        $this->view->tabletri = 1;

    }




    public function erreursouscriptionAction()
    {
        /* souscription administration/erreursouscription - Erreur la souscription libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['erreurdescription']) && $_POST['erreurdescription']!="") {
		
			
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($_POST['souscription_id'], $souscription);
		
        $souscription->setErreurdescription($_POST['erreurdescription']);
        $souscription->setErreur(1);
		$souscriptionM->update($souscription);
			
if($this->_request->getParam('erreur') == 1){
		$this->_redirect('administration/listsouscription'.($souscription->publier + 1));
	}else{
		$this->_redirect('administration/listsouscriptionerreur');
	}

	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		$this->view->souscription = $souscription;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		$this->view->souscription = $souscription;
            }
	}
	}




    public function erreursouscription1Action()
    {
        /* souscription administration/erreursouscription - Erreur la souscription libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		
        $souscription->setErreur($this->_request->getParam('erreur'));
		$souscriptionM->update($souscription);
        }

if($this->_request->getParam('erreur') == 1){
		$this->_redirect('administration/listsouscription'.($souscription->publier + 1));
	}else{
		$this->_redirect('administration/listsouscriptionerreur');
	}
	
    }



    public function listsouscriptionetatAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->findMoisAnnee();

        $this->view->tabletri = 1;

    }


    public function listsouscriptionetat2Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->fetchAllByCommissionSouscription(0, $debut, $fin);

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
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $partagem = new Application_Model_EuPartagemMapper();
        $this->view->entries = $partagem->fetchAllByCommissionSouscription(0, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
	}
	} /*else {

        $partagem = new Application_Model_EuPartagemMapper();
        $this->view->entries = $partagem->fetchAllByCommissionSouscription(0, "", "");

	}*/
        $this->view->tabletri = 1;


    }


    public function listintegrateuretatAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        $this->view->entries = $integrateur->findMoisAnnee();

        $this->view->tabletri = 1;

    }


    public function listoffreurprojetetatAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $offreurprojet = new Application_Model_EuOffreurProjetMapper();
        $this->view->entries = $offreurprojet->findMoisAnnee();

        $this->view->tabletri = 1;

    }
	
	
    public function listsouscriptionreactivationgieAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublierReactivation(3, $sessionutilisateur->code_agence, 13);
			}else{
        //$this->view->entries = $souscription->fetchAllByPublierReactivation(3, "", 13);
		        $agence = new Application_Model_EuAgenceMapper();
                $this->view->entries = $agence->fetchAllByAssociation();
        		}

        $this->view->tabletri = 1;

    }


    public function listsouscriptionreactivationmcnpAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $souscription->fetchAllByPublierReactivation(3, $sessionutilisateur->code_agence, 20);
			}else{
        //$this->view->entries = $souscription->fetchAllByPublierReactivation(3, "", 20);
		        $agence = new Application_Model_EuAgenceMapper();
                $this->view->entries = $agence->fetchAllByAssociation();
        		}

        $this->view->tabletri = 1;

    }

    public function etatsouscriptionAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $debut = (string)$this->_request->getParam('debut');
            $fin = (string)$this->_request->getParam('fin');
			
			if($debut != "" && $fin != ""){

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->findSomme(0, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
        $this->view->tabletri = 1;
		}else{
		$this->_redirect('/administration/listsouscriptionetat');
			}

    }


    public function etatintegrateurAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $debut = (string)$this->_request->getParam('debut');
            $fin = (string)$this->_request->getParam('fin');
			
			if($debut != "" && $fin != ""){

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->findSommeIntegrateur(0, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
        $this->view->tabletri = 1;
		}else{
		$this->_redirect('/administration/listintegrateuretat');
			}

    }


    public function etatoffreurprojetAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $debut = (string)$this->_request->getParam('debut');
            $fin = (string)$this->_request->getParam('fin');
			
			if($debut != "" && $fin != ""){

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->findSommeOffreurProjet(0, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
        $this->view->tabletri = 1;
		}else{
		$this->_redirect('/administration/listoffreurprojetetat');
			}

    }
	
    public function listmembretierscodeAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $membretierscode = new Application_Model_EuMembretierscodeMapper();
        $this->view->entries = $membretierscode->fetchAllBySouscription($id);
        $this->view->tabletri = 1;
			}

    }
	

    public function detailssouscriptionAction() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		$this->view->souscription = $souscription;

            }

	}





public function publiersouscriptionAction() {
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		
		//$param = (int)$this->_request->getParam('param');
	    //$this->view->param = $param;
		
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
		
	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		
		            $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
					try {
						
        $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		
		if($sessionutilisateur->code_agence != "001001001001"){
        $souscription = $souscription_mapper->fetchAllByPublier($_POST['id'] - 1, $sessionutilisateur->code_agence);
			}else{
        $souscription = $souscription_mapper->fetchAllByPublier($_POST['id'] - 1, "");
				}


		foreach ($souscription as $entry):
		if(isset($_POST['publier'.$entry->souscription_id.'']) && $_POST['publier'.$entry->souscription_id.''] == $_POST['id']){

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($entry->souscription_id, $souscription);
		
        $souscription->setPublier($_POST['publier'.$entry->souscription_id.'']);
		$souscriptionM->update($souscription);


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


        $validation_quittance = new Application_Model_EuValidationQuittance();
        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
			
            $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
            $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
            $validation_quittance->setValidation_quittance_utilisateur($sessionutilisateur->id_utilisateur);
            $validation_quittance->setValidation_quittance_souscription($entry->souscription_id);
            $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $validation_quittance->setPublier(1);
            $validation_quittance_mapper->save($validation_quittance);

		include("Transfert.php");





if($_POST['id'] == 3){


						
								
								$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		                        $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($request->getParam("souscription_banque"),$request->getParam("souscription_numero"),$request->getParam("souscription_date_numero"));
                                if(count($relevebancairedetail) > 0) {
								    if($relevebancairedetail->relevebancairedetail_montant >= $_POST['souscription_montant']) {
										
										
//////////////////////////////////////////////////////////////////////////////////////


								        include("automatisation.php");
								        //validation_automatique($compteur_souscription);
								        
$id_souscription = $entry->souscription_id;
//////////////////////////////////////////
if($souscription->souscription_membreasso != 1){
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
		
		
		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			if($souscription->souscription_programme == "KACM"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}
			
		}else{
			
			if($souscription->souscription_programme == "KACM"){
			$partagea_montant = floor($cumul_recubancaire / 100 * 10);
				}else{
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
					}
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($membreasso->membreasso_association);
            $partagea->setPartagea_souscription($id_souscription);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
            $partagem->setPartagem_souscription($id_souscription);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////

}


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
if($souscription->souscription_personne == "PP"){
		
        $souscrip = new Application_Model_EuSouscription();
        $souscrip_mapper = new Application_Model_EuSouscriptionMapper();
        $compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, "");
		
	if($souscription->souscription_programme == "KACM"){
		if($compteur_souscrip == 0){$compteur_souscrip = 1029;}	
		$unite = 5000;	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Reçu Personne Physique : PP'.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
  </tr>';
	}else if($souscription->souscription_programme == "CMFH"){
		if($compteur_souscrip == 0){$compteur_souscrip = 118;}		
		$unite = 2187.5;	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° QUITTANCE CMFH/CAPS : '.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
  </tr>';
	}
	
}else if($souscription->souscription_personne == "PM"){
	if($souscription->souscription_programme == "KACM"){
		
        $souscrip = new Application_Model_EuSouscription();
        $souscrip_mapper = new Application_Model_EuSouscriptionMapper();
        $compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, $souscription->code_type_acteur);
		
		if($compteur_souscrip == 0 && $souscription->code_type_acteur == "OSE"){$compteur_souscrip = 4;}		
		if($compteur_souscrip == 0 && $souscription->code_type_acteur == "OE"){$compteur_souscrip = 5;}		
		$unite = 70000;	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Reçu '.$souscription->code_type_acteur.' : '.$souscription->code_type_acteur.''.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
  </tr>';
	}else if($souscription->souscription_programme == "CMFH"){
		
        $souscrip = new Application_Model_EuSouscription();
        $souscrip_mapper = new Application_Model_EuSouscriptionMapper();
        $compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, "");
		if($compteur_souscrip == 0){$compteur_souscrip = 118;}		
		$unite = 2187.5;	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° QUITTANCE CMFH/CAPS : '.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
  </tr>';
	}
	
	
}
  
/*$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>QUITTANCE CMFH/CAPS/GAC TOGO N° '.$souscription->souscription_id.'</u></em></strong></td>
  </tr>';*/
  
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($entry->souscription_id, $souscription);
		
        $souscription->setSouscription_ordre($compteur_souscrip + 1);
		$souscriptionM->update($souscription);

  if($souscription->souscription_autonome == 1){
	  $souscription_nombre = $souscription->souscription_nombre - 1;
			if($souscription->souscription_personne == "PP"){
				$autonome = 5000;
			}else if($souscription->souscription_personne == "PM"){
				$autonome = 70000;
				}
	  }else{
	  $souscription_nombre = $souscription->souscription_nombre;
	$autonome = 0;
		  }
		  
if($souscription->souscription_personne == "PP"){
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Nom  &amp; prénom(s) de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$souscription->souscription_nom.' '.$souscription->souscription_prenom.'</em></strong></p></td>
  </tr>';
}else if($souscription->souscription_personne == "PM"){
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Raison sociale de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$souscription->souscription_raison.'</em></strong></p></td>
  </tr>';
}
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><em><u>N°  code(s) SMS CMFH/CAPS/Togo acheté(s): '.$souscription->souscription_nombre.'</u></em></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="center"><strong><em>Montant total : '.number_format(($souscription_nombre * $unite + $autonome), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="center"><em><strong>Nombre de codes achetés</strong></em></td>
    <td align="center"><strong><em>Prix Unitaire d&rsquo;un code</em></strong></td>
    <td align="center"><em><strong>Montant total</strong></em></td>
  </tr>';
  
  if($souscription->souscription_autonome == 1){
$htmlpdf .= '
  <tr style="background-color:#999;">
    <td align="left"><em><strong>Achat de code SMS KACM</strong></em></td>
    <td align="center"><em>1</em></td>
    <td align="center"><em>'.$autonome.' FCFA</em></td>
    <td align="center"><em>'.number_format(($autonome), 0, ',', ' ').' FCFA</em></td>
  </tr>';
  }
				if($souscription->souscription_programme == "CMFH"){
$htmlpdf .= '
  <tr style="background-color:#999;">
    <td align="left"><em><strong>Achat de code SMS  CMFH/CAPS/GAC Togo</strong></em></td>
    <td align="center"><em>'.$souscription_nombre.'</em></td>
    <td align="center"><em>'.$unite.' FCFA</em></td>
    <td align="center"><em>'.number_format(($souscription_nombre * $unite), 0, ',', ' ').' FCFA</em></td>
  </tr>';
  }

$htmlpdf .= '
  <tr>
    <td colspan="2" align="left"><em><u>Montant total en  lettres&nbsp;</u>: '.lettre(($souscription_nombre * $unite + $autonome), 50).' CFA</em></td>
    <td colspan="2" rowspan="3" align="left"><img src="'.Util_Utils::getParamEsmc(2).'/images/cachet.jpg" /><br />
Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
  </tr>';	
  
	if($souscription->souscription_programme == "CMFH"){

$htmlpdf .= '
  <tr>
    <td colspan="2" align="left"><em><u>Gains en Bons d&rsquo;Achat en  Chiffres :</u> '.number_format(($souscription_nombre * 70000 ), 0, ',', ' ').' BA.</em></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><em><u>Gains en Bons d&rsquo;Achat en  lettres :</u> '.lettre2(($souscription_nombre * 70000 ), 50).' </em></td>
  </tr>';
	}else if($souscription->souscription_programme == "KACM"){
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

</page>


  



';

$htmlpdf .= '
  

';

		

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
if (!is_dir("pdf_souscription/")) {
mkdir("pdf_souscription/", 0777);
}
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "pdf_souscription/SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id))."_.html";
$newnom = "SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id)."_");
$newchemin = "pdf_souscription/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
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

        $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
        if($relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($souscription->souscription_banque, $souscription->souscription_numero, $souscription->souscription_date_numero)){
  
        $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
        $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail2M->find($relevebancairedetail->relevebancairedetail_id, $relevebancairedetail2);
		
        $relevebancairedetail2->setPublier(1);
		$relevebancairedetail2M->update($relevebancairedetail2);
		}
	
		//$this->_redirect($file);
        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($souscription->souscription_membreasso, $membreasso);
		
        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($membreasso->membreasso_association, $association);



$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($association->association_email, $association->association_nom);
$mail->setSubject('Recu Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 
$mail->send($tr);







$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membreasso->membreasso_email, $membreasso->membreasso_nom." ".$membreasso->membreasso_prenom);
$mail->setSubject('Recu Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 
$mail->send($tr);









			if($souscription->souscription_programme == "CMFH"){
				
$html .= "<br />";
$html .= "Voici votre Login et Mot de passe qui vous permettent de vous connecter et compléter les informations vous concernant pour être bien classifié dans votre domaine et ainsi être en bonne position pour l’ouverture prochaine du marché MCNP.";
$html .= "<br />";
$html .= "Connectez vous ici : <a href='http://prod.esmcgacsource.com/souscription/login'>Connexion Souscription</a>";
$html .= "<br />";
$html .= "Login : ".$souscription->souscription_login."<br />";
$html .= "<br />";
$html .= "Mot de passe : ".$souscription->souscription_passe."<br />";
$html .= "<br />";

if(isset($souscription->souscription_mobilisateur) && $souscription->souscription_mobilisateur == 1){
$html .= "Vous avez sélectionner l'option Mobilisateur donc utilisez les mêmes Login et Mot de passe pour vous connecter à votre espace Agrément OSE/OE pour pouvoir souscrire d'autres personnes.";
$html .= "<br />";
$html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/association/login'>Connexion Agrément OSE/OE</a>";
$html .= "<br />";
}


if($souscription->souscription_email != ""){
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
$mail->setSubject('Recu Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));

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
			}




}



if($_POST['id'] == 1 || $_POST['id'] == 2 || $_POST['id'] == 3){
	
if($_POST['id'] == 1){
	$agrement = "agrement_filiere";
}else if($_POST['id'] == 2){
	$agrement = "agrement_technopole";
}else if($_POST['id'] == 3){
	$agrement = "agrement_acnev";
}
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateur = $utilisateurM->fetchAllByAgenceCodeGroupe($sessionutilisateur->code_agence, $agrement);
		
foreach ($utilisateur as $entryagrement):
if (substr($entryagrement->code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($entryagrement->code_membre, $membre);
$membre_email = $membre->email_membre;
$membre_nom = $membre->nom_membre." ".$membre->prenom_membre;
} else if (substr($entryagrement->code_membre, -1) == "M") {
$membremorale = new Application_Model_EuMembreMorale();
$mapper_membremorale = new Application_Model_EuMembreMoraleMapper();
$mapper_membremorale->find($entryagrement->code_membre, $membremorale);
$membre_email = $membre->email_membre;
$membre_nom = $membre->raison_sociale;
}


if($membre_email != ""){
$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Alerte sur la validation du recu numero : '.$entry->souscription_numero.' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membre_email, $membre_nom);
$mail->setSubject('Alerte sur la validation : '.$date_id->toString('dd-MM-yyyy HH:mm')); 
$mail->send($tr);
}
endforeach;
}

/////////////////////////////////////////////////////////////////////////////
										$compteur_souscription = $entry->souscription_id;
										
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
			                                            $sessionutilisateur->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
														//$this->view->param = $param;
														$this->_redirect('/administration/listsouscription'.$_POST['id'].'');
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
	                                                    //$this->view->param = $param;
			                                            $sessionutilisateur->error = 'Erreur de traitement : le solde du compte est null';
														$this->_redirect('/administration/listsouscription'.$_POST['id'].'');
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
	                                                //$this->view->param = $param;
			                                        $sessionutilisateur->error = 'Erreur de traitement : le compte est introuvable';
													$this->_redirect('/administration/listsouscription'.$_POST['id'].'');
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
	                                //$this->view->param = $param;
			                        $sessionutilisateur->error = 'Erreur de traitement : le solde du compte CAPS est null';
									$this->_redirect('/administration/listsouscription'.$_POST['id'].'');
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
				                Util_Utils::addSms($compteur,$mobile,'Vous avez la reponse de votre souscription a '.$nbre_compte.' comptes marchands ESMC. Veuillez consultez votre email');
								
								codegenerer($compteur_souscription);
			                }
								$db->commit();
                                $sessionutilisateur->error = "Opération bien effectuée. ";//Votre souscription a été vérifiée.
		                        $this->_redirect('/administration/listsouscription'.$_POST['id'].'');
								
		                    } else {
							    $db->commit();
                                $sessionutilisateur->error = "Opération bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
		                        $this->_redirect('/administration/listsouscription'.$_POST['id'].'');
					                }
		                    }  else {
								$db->commit();
                                $sessionutilisateur->error = "Opération bien effectuée. ";//Votre souscription n’est pas encore vérifiée, revenez plus tard.
		                        $this->_redirect('/administration/listsouscription'.$_POST['id'].'');
			                }
							
							
////////////////////////////////////////////////////////////////////////////


		
			}
		endforeach;

		
if($_POST['id'] == 3){
		$this->_redirect('/administration/listsouscription'.$_POST['id'].'');
}else{
		$this->_redirect('/administration/listsouscription'.$_POST['id'].'');
	}
		
		            }  catch (Exception $exc) {
	                    //$this->view->param = $param;
                        $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();  
		                $this->_redirect('/administration/listsouscription'.$_POST['id'].'');
                        return;
                    }
		
		
		
		
		
		    }   
		
		
		}	
		
	}








    public function listcaracteristiqueAction()
    {
        /* page souscription/listcaracteristique - Liste des caracteristiques */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $caracteristique = new Application_Model_EuCaracteristiqueMapper();
        $this->view->entries = $caracteristique->fetchAll();

        $this->view->tabletri = 1;

    }







    public function addrelevebancaireAction()
    {
        /* page administration/addrelevebancaire - Ajout d'une relevebancaire */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['relevebancaire_utilisateur']) && $_POST['relevebancaire_utilisateur']!="" && isset($_POST['relevebancaire_date']) && $_POST['relevebancaire_date']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['relevebancaire_fichier']['name']) && $_FILES['relevebancaire_fichier']['name']!=""){
		$chemin	= "relevebancaires";
		$file = $_FILES['relevebancaire_fichier']['name'];
		$file1='relevebancaire_fichier';
		$relevebancaire = $chemin."/".transfert($chemin,$file1);
		} else {$relevebancaire = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setRelevebancaire_id($compteur);
            $a->setRelevebancaire_banque($_POST['relevebancaire_banque']);
            $a->setRelevebancaire_utilisateur($_POST['relevebancaire_utilisateur']);
            $a->setRelevebancaire_fichier($relevebancaire);
            $a->setRelevebancaire_date($_POST['relevebancaire_date']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
			
			$fichier = $relevebancaire;
			
			$_fichier = strtolower(substr($relevebancaire, -4));
		if($_fichier == ".csv"){// || $_fichier == ".xls" || $_fichier == "xlsx"
			
/*include 'Classes/PHPExcel/IOFactory.php';
			

		$fichier = $relevebancaire;

if(substr($fichier, -3) == "csv"){
$callStartTime = microtime(true);
$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(';')
                                                    ->setEnclosure('')
                                                    ->setLineEnding("\r\n")
                                                    ->setSheetIndex(0);
$objPHPExcelFromCSV = $objReader->load($fichier);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$callStartTime = microtime(true);
$objWriter2 = PHPExcel_IOFactory::createWriter($objPHPExcelFromCSV, 'Excel5');
$objWriter2->save(str_replace('.csv', '.xls', $fichier));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$inputFileName = substr($fichier, 0, -4).".xls";
}else{
$inputFileName = $fichier;
}
$inputFileName = Util_Utils::getParamEsmc(1)."/".$fichier;

//$inputFileType = 'Excel5';
//	$inputFileType = 'Excel2007';
//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

//$objReader = PHPExcel_IOFactory::createReader($inputFileType);
//$objReader->setReadDataOnly(true);
//$objPHPExcel = $objReader->load($inputFileName);


$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$highestRow = count($sheetData);
//var_dump($sheetData);

$objPHPExcel->setActiveSheetIndex(0);

$espace = "";
$virgule = ",";
$i = 1;
$trouver = 0;
foreach ($sheetData as $value) {
if($_POST['relevebancaire_banque'] == "BAT"){	
list($mont, $virgule1) = explode(",", $sheetData[$i]['E']);
if($sheetData[$i]['A'] != "" && $sheetData[$i]['B'] != "" && $sheetData[$i]['C'] != "" && $sheetData[$i]['D'] != "" && str_replace(" ", "", $mont) > 0){
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle($sheetData[$i]['C']);
            $rb->setRelevebancairedetail_numero($sheetData[$i]['B']);
            $rb->setRelevebancairedetail_date(date_fr_en3($sheetData[$i]['A']));
            $rb->setRelevebancairedetail_montant(str_replace(" ", "", $mont));
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($sheetData[$i]['D']));
            $rb->setPublier(0);
            $mrb->save($rb);
			
			
						
			
	}
	
}else if($_POST['relevebancaire_banque'] == "UTB"){
if($sheetData[$i]['A'] != "" && $sheetData[$i]['B'] != "" && $sheetData[$i]['C'] != "" && (abs(str_replace($espace, $virgule, $sheetData[$i]['D'])) > 0 || abs(str_replace($espace, $virgule, $sheetData[$i]['E'])) > 0)){
	
	if($sheetData[$i]['D'] > 0){$montant = abs(str_replace($espace, $virgule, $sheetData[$i]['D']));}else{abs(str_replace($espace, $virgule, $montant = $sheetData[$i]['E']));}
	
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle($sheetData[$i]['B']);
            $rb->setRelevebancairedetail_numero($sheetData[$i]['F']);
            $rb->setRelevebancairedetail_date(date_fr_en3($sheetData[$i]['A']));
            $rb->setRelevebancairedetail_montant($montant);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($sheetData[$i]['C']));
            $rb->setPublier(0);
            $mrb->save($rb);
	}
	
}else if($_POST['relevebancaire_banque'] == "ORABANK"){
if($sheetData[$i]['A'] != "" && $sheetData[$i]['B'] != "" && $sheetData[$i]['C'] != "" && (abs(str_replace($espace, $virgule, $sheetData[$i]['D'])) > 0 || abs(str_replace($espace, $virgule, $sheetData[$i]['E'])) > 0)){

	if($sheetData[$i]['D'] > 0){$montant = abs(str_replace($espace, $virgule, $sheetData[$i]['D']));}else{$montant = abs(str_replace($espace, $virgule, $sheetData[$i]['E']));}

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle($sheetData[$i]['C']);
            $rb->setRelevebancairedetail_numero(NULL);
            $rb->setRelevebancairedetail_date(date_fr_en3($sheetData[$i]['A']));
            $rb->setRelevebancairedetail_montant($montant);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($sheetData[$i]['B']));
            $rb->setPublier(0);
            $mrb->save($rb);
	}
	

	
}else if($_POST['relevebancaire_banque'] == "BOA"){
if($sheetData[$i]['D'] != "" && $sheetData[$i]['F'] != "" && $sheetData[$i]['I'] != "" && (abs(str_replace($espace, $virgule, $sheetData[$i]['D'])) > 0)){

	$montant = abs(str_replace($espace, $virgule, $sheetData[$i]['D']));

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle($sheetData[$i]['J']);
            $rb->setRelevebancairedetail_numero($sheetData[$i]['I']);
            $rb->setRelevebancairedetail_date(date_fr_en3($sheetData[$i]['F']));
            $rb->setRelevebancairedetail_montant($montant);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($sheetData[$i]['G']));
            $rb->setPublier(0);
            $mrb->save($rb);
	}
	
	
}else if($_POST['relevebancaire_banque'] == "ECOBANK"){
if($sheetData[$i]['A'] != ""){	
	list($un, $deux, $date, $datevaleur, $numero, $libelle, $autres) = explode(",", $sheetData[$i]['A']);
list($un1, $montant, $autres1) = explode('","', $sheetData[$i]['A']);
list($mont, $virgule) = explode(".", $montant);
$mont = str_replace(",", "", $mont);

if($date != "" && $datevaleur != "" && $numero != "" && $libelle != "" && $mont != ""){
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle($libelle);
            $rb->setRelevebancairedetail_numero($numero);
            $rb->setRelevebancairedetail_date(date_fr_en2($date));
            $rb->setRelevebancairedetail_montant($mont);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en2($datevaleur));
            $rb->setPublier(0);
            $mrb->save($rb);			
			
	}
}
	
	}



		
$i++;
}
*/			

if($_POST['relevebancaire_banque'] == "BAT"){	

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($date, $numero, $libelle, $datevaleur, $montant) = explode(";", $line);
$montant = trim($montant);
$montant = strtr($montant, " ", "");
//$montant = str_replace("ÿ", "", $montant);
//$montant = str_replace("Ê", "", $montant);
list($mont, $apresvirgule) = explode(",", $montant);

if($date != "" && $datevaleur != "" && $numero != "" && $libelle != "" && $mont > 0){//

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BAT", trim($numero));
		if(count($relevebancairedetail) == 0){


        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle(trim($libelle));
            $rb->setRelevebancairedetail_numero(trim($numero));
            $rb->setRelevebancairedetail_date(date_fr_en3($date));
            $rb->setRelevebancairedetail_montant($mont);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($datevaleur));
            $rb->setPublier(0);
            $mrb->save($rb);			
			
			}
	}
}	
}else if($_POST['relevebancaire_banque'] == "UTB"){

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($date, $libelle, $datevaleur, $debit, $credit, $numero, $solde) = explode(";", $line);
$montant = trim($credit);
//$montant = str_replace("ÿ", "", $montant);
//$montant = str_replace("Ê", "", $montant);
list($mont, $apresvirgule) = explode(",", $montant);

if($date != "" && $datevaleur != "" && $numero != "" && $libelle != "" && $mont > 0){

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("UTB", trim($numero));
		if(count($relevebancairedetail) == 0){


        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle(trim($libelle));
            $rb->setRelevebancairedetail_numero(trim($numero));
            $rb->setRelevebancairedetail_date(date_fr_en3($date));
            $rb->setRelevebancairedetail_montant($mont);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($datevaleur));
            $rb->setPublier(0);
            $mrb->save($rb);			
		}
	}
}	
}else if($_POST['relevebancaire_banque'] == "ORABANK"){

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($date, $datevaleur, $libelle, $debit, $credit, $solde) = explode(";", $line);//$numero, 
$montant = trim($credit);
//$montant = str_replace("ÿ", "", $montant);
//$montant = str_replace("Ê", "", $montant);
list($mont, $apresvirgule) = explode(",", $montant);

list($date2, $datevaleur2, $libelle2, $debit2, $credit2, $solde2) = explode(";", $lines[$line_num + 1]);//$numero, 

//if($date != "" && $datevaleur != "" && $libelle != "" && $mont > 0){// && $numero != ""
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle(trim($libelle." ".$libelle2));
            $rb->setRelevebancairedetail_numero(NULL);//trim($numero)
            $rb->setRelevebancairedetail_date(date_fr_en3($date));
            $rb->setRelevebancairedetail_montant($mont);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($datevaleur));
            $rb->setPublier(0);
            $mrb->save($rb);			
			
	//}
}	
}else if($_POST['relevebancaire_banque'] == "BOA"){

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($un, $deux, $trois, $montant, $quatre, $date, $datevaleur, $cinq, $numero, $libelle) = explode(";", $line);
$montant = trim($montant);
//$montant = str_replace("ÿ", "", $montant);
//$montant = str_replace("Ê", "", $montant);
list($mont, $apresvirgule) = explode(",", $montant);

if($date != "" && $datevaleur != "" && $numero != "" && $libelle != "" && $mont > 0){

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BOA", trim($numero));
		if(count($relevebancairedetail) == 0){


        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle(trim($libelle));
            $rb->setRelevebancairedetail_numero(trim($numero));
            $rb->setRelevebancairedetail_date(date_fr_en3($date));
            $rb->setRelevebancairedetail_montant($mont);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en3($datevaleur));
            $rb->setPublier(0);
            $mrb->save($rb);			
		}
	}
}	
}else if($_POST['relevebancaire_banque'] == "ECOBANK"){

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($un, $deux, $date, $datevaleur, $numero, $libelle, $autres) = explode(",", $line);
list($un1, $montant, $autres1) = explode('"",""', $line);
list($mont, $virgule) = explode(".", $montant);
$mont = str_replace(",", "", $mont);

if($date != "" && $datevaleur != "" && $numero != "" && $libelle != "" && $mont > 0){

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("ECOBANK", trim($numero));
		if(count($relevebancairedetail) == 0){


        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle($libelle);
            $rb->setRelevebancairedetail_numero($numero);
            $rb->setRelevebancairedetail_date(date_fr_en2($date));
            $rb->setRelevebancairedetail_montant($mont);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en2($datevaleur));
            $rb->setPublier(0);
            $mrb->save($rb);			
		}
	}
}	
}else if($_POST['relevebancaire_banque'] == "FLOOZ"){

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($numero, $mrch, $libelle, $moovesmc, $montant, $date) = explode(";", $line);
$montant = trim($montant);

$montant = str_replace(" ", "", $montant);

if($numero != "" && $mrch != "" && $libelle != "" && $moovesmc != "" && $date != "" && $montant > 0){

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("FLOOZ", trim($numero));
		if(count($relevebancairedetail) == 0){


        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
			
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($compteur);
            $rb->setRelevebancairedetail_libelle(trim($libelle));
            $rb->setRelevebancairedetail_numero(trim($numero));
            $rb->setRelevebancairedetail_date(date_fr_en4($date));
            $rb->setRelevebancairedetail_montant($montant);
            $rb->setRelevebancairedetail_date_valeur(date_fr_en4($date));
            $rb->setPublier(0);
            $mrb->save($rb);			
		}
	}

}	

}	

}	
			
			
/**/		
			


        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByNew($compteur);
		if(count($relevebancairedetail) == 0){
        $relevebancaire_m = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire = $relevebancaire_m->delete($compteur);
$sessionutilisateur->error = "Toutes les données ce relevé sont déjà chargées.";
		}else{
$sessionutilisateur->error = "Opération bien effectuée";
			}


			
			

		$this->_redirect('/administration/listrelevebancaire');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
    }


    public function editrelevebancaireAction()
    {
        /* page administration/editrelevebancaire - Modification d'une relevebancaire */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['relevebancaire_utilisateur']) && $_POST['relevebancaire_utilisateur']!="" && isset($_POST['relevebancaire_date']) && $_POST['relevebancaire_date']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['relevebancaire_fichier']['name']) && $_FILES['relevebancaire_fichier']['name']!=""){
		$chemin	= "relevebancaires";
		$file = $_FILES['relevebancaire_fichier']['name'];
		$file1='relevebancaire_fichier';
		$relevebancaire = $chemin."/".transfert($chemin,$file1);
		} else {$relevebancaire = $_POST['relevebancaire_fichier_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
		$ma->find($_POST['relevebancaire_id'], $a);
			
            $a->setRelevebancaire_banque($_POST['relevebancaire_banque']);
            $a->setRelevebancaire_utilisateur($_POST['relevebancaire_utilisateur']);
            $a->setRelevebancaire_fichier($relevebancaire);
            $a->setRelevebancaire_date($_POST['relevebancaire_date']);
            $ma->update($a);
			
		$this->_redirect('/administration/listrelevebancaire');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
		$ma->find($id, $a);
		$this->view->relevebancaire = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
		$ma->find($id, $a);
		$this->view->relevebancaire = $a;
            }
	}
	}




    public function listrelevebancaireAction()
    {
        /* page administration/listrelevebancaire - Liste des relevebancaires */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $relevebancaire = new Application_Model_EuRelevebancaireMapper();
        $this->view->entries = $relevebancaire->fetchAll();

        $this->view->tabletri = 1;



/*
        $relevebancairedetail = new Application_Model_EuRelevebancairedetailMapper();
        $entriesdetail = $relevebancairedetail->fetchAll10();
		
		$banque = "";
		$numero = "";
		
		foreach ($entriesdetail as $entry){
		
		if($entry->relevebancairedetail_relevebancaire == $banque && $entry->relevebancairedetail_numero == $numero){
			
        $relevebancairedetail2_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail2 = $relevebancairedetail2_m->delete($entry->relevebancairedetail_id);

		}else{
		$banque = $entry->relevebancairedetail_relevebancaire;	
		$numero = $entry->relevebancairedetail_numero;
		}

		}*/


    }


    public function supprelevebancaireAction()
    {
        /* page administration/supprelevebancaire - Suppression d'une relevebancaire */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $relevebancaire = new Application_Model_EuRelevebancaire();
        $relevebancaireM = new Application_Model_EuRelevebancaireMapper();
        $relevebancaireM->find($id, $relevebancaire);
		
        $relevebancaireM->delete($relevebancaire->relevebancaire_id);
		//unlink($relevebancaire->relevebancaire_fichier);	

        }

		$this->_redirect('/administration/listrelevebancaire');
    }




    public function publierrelevebancaireAction()
    {
        /* page administration/publierrelevebancaire - Publier une relevebancaire */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $relevebancaire = new Application_Model_EuRelevebancaire();
        $relevebancaireM = new Application_Model_EuRelevebancaireMapper();
        $relevebancaireM->find($id, $relevebancaire);
		
        $relevebancaire->setPublier($this->_request->getParam('publier'));
		$relevebancaireM->update($relevebancaire);
        }

		$this->_redirect('/administration/listrelevebancaire');
    }




    public function detailsrelevebancaireAction() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $relevebancaire = new Application_Model_EuRelevebancaire();
        $relevebancaireM = new Application_Model_EuRelevebancaireMapper();
        $relevebancaireM->find($id, $relevebancaire);
		$this->view->relevebancaire = $relevebancaire;

            }

	}



    public function listrelevebancairedetailAction()
    {
        /* page administration/listrelevebancairedetail - Liste des detail relevebancaires */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if ($id != 0) {

        $relevebancairedetail = new Application_Model_EuRelevebancairedetailMapper();
        $this->view->entries = $relevebancairedetail->fetchAllByNew($id);
		
        $relevebancaire = new Application_Model_EuRelevebancaire();
        $relevebancaireM = new Application_Model_EuRelevebancaireMapper();
        $relevebancaireM->find($id, $relevebancaire);
		$this->view->relevebancaire = $relevebancaire;
		
        }else{
		$this->_redirect('/administration/listrelevebancaire');
			}

        $this->view->tabletri = 1;

    }





    public function listrelevebancairedetail2Action()
    {
        /* page administration/listrelevebancairedetail2 - Liste des detail relevebancaires */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $code = (string) $this->_request->getParam('code');
        if ($code != "") {

        $relevebancairedetail = new Application_Model_EuRelevebancairedetailMapper();
        $this->view->entries = $relevebancairedetail->fetchAllByCode($code);
		
        $banque = new Application_Model_EuBanque();
        $banqueM = new Application_Model_EuBanqueMapper();
        $banqueM->find($code, $banque);
		$this->view->banque = $banque;
		
        }else{
		$this->_redirect('/administration/listrelevebancaire');
			}

        $this->view->tabletri = 1;

    }





	
    public function listsouscriptioncmfhAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $type = (int) $this->_request->getParam('type');
        if ($type != 0) {
				
        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllBySouscriptionTypeCandidat($type);
		$this->view->type = $type;
        $this->view->tabletri = 1;
        }else{
		$this->_redirect('/administration');
			}

    }



	
    public function listsouscriptioncmfhrechercheAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $type = (int) $this->_request->getParam('type');
        if ($type != 0) {
		$this->view->type = $type;

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['debut']) && $_POST['debut']!="" && isset($_POST['fin']) && $_POST['fin']!="") {
				
        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllBySouscriptionTypeCandidatRecherche($_POST['type'], $_POST['debut'], $_POST['fin']);

        $this->view->tabletri = 1;
	}
	}
        }/*else{
		$this->_redirect('/administration');
			}*/

    }



	
    public  function verifiergcpAction()   {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublic');
			
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
			   
			if (isset($_POST['ok']) && $_POST['ok']=="ok") {
				if  (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
				    $code_membre = $_POST['code_membre'];
					$releve_mapper = new Application_Model_EuReleveMapper();
				    $releve = $releve_mapper->fetchAllByType('GCP',$code_membre);
				    $releve = $releve[0];
				    if  (($releve != NULL) || ($releve->publier != NULL)) {
						if($releve->publier == 0) {
				            $tabela = new Application_Model_DbTable_EuAncienGcp();
                            $select = $tabela->select()->setIntegrityCheck(false);
                            $select->from($tabela,array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve', 'reste', 'code_cat', 'id_credit'))
		                           ->join('eu_ancien_compte_credit','eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit', array('code_membre','code_produit'));
                            $select->order('eu_ancien_gcp.date_conso asc');
			                if ($code_membre != '' || $code_membre != null) {
			                    $select->where('eu_ancien_gcp.code_membre like ?',$code_membre);
			                }
							$this->view->code_membre = $code_membre;
                            $this->view->consult = $tabela->fetchAll($select);
						} else {
					        $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller à la réclamation car vous avez un relevé correct !!! ...";
					    }	
	                } else {
					    $sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
			        }
	            }
				$this->view->tabletri = 1;	
	        }
	}
	
	
	


    public function verifierrpgiAction() {
	    /* page index/relevesalaire - Retrouve salaire */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


        if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		    if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
			    $code_membre = $_POST['code_membre'];
				
				$releve_mapper = new Application_Model_EuReleveMapper();
				$releve = $releve_mapper->fetchAllByType('RPG_I',$code_membre);
				$releve = $releve[0];
				if($releve != NULL ) {
				    if(trim($releve->publier) == 0) {
				        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
				        $select = $tabela->select() ;
                        $select->from($tabela)
		                       ->order('id_credit asc');
			            if ($code_membre != '' || $code_membre != null) {
			              $select->where('code_membre like ?',$code_membre);
				          $select->where('code_produit IN (?)',array('RPGr','RPGnr','Ir','Inr'));
			            }
                        $this->view->credits = $tabela->fetchAll($select);
						$this->view->publier = $releve->publier;
				
			
				        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				        $db_gcp = new Application_Model_DbTable_EuAncienGcp();
                        $select = $tabela->select()->setIntegrityCheck(false);
                        $select->from($db_gcp, array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve','id_credit'))
		                       ->join('eu_ancien_compte_credit', 'eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit', array('code_produit'))
					           ->join('eu_ancien_membre', 'eu_ancien_membre.ancien_code_membre = eu_ancien_gcp.code_membre', array('ancien_code_membre','raison_sociale'));
			            if ($code_membre != '' || $code_membre != null) {
			                $select->where('eu_ancien_compte_credit.code_membre like ?',$code_membre);
			            }
				        $select->order('eu_ancien_gcp.id_credit asc');
                        $this->view->consult = $db_gcp->fetchAll($select);
				
				
				        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				        $db_cnnc = new Application_Model_DbTable_EuAncienCnnc();
				        $select = $db_cnnc->select()->setIntegrityCheck(false);
				        $select->from($db_cnnc)
				               ->join('eu_ancien_compte_credit', 'eu_ancien_compte_credit.id_credit = eu_ancien_cnnc.id_credit', array('code_produit'))
				               ->order('eu_ancien_cnnc.id_credit asc');
			            if ($code_membre != '' || $code_membre != null) {
			                $select->where('eu_ancien_cnnc.code_membre like ?',$code_membre);
				        }
				        $this->view->creditsnc = $db_cnnc->fetchAll($select);
				        $this->view->code_membre = $code_membre;
                     
					    } else {
					      $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller à la réclamation car vous avez un relevé correct !!! ...";
					    } 
					 
                } else {
					   $sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
			    }
					
                }
				$this->view->tabletri = 1;
        }		
	    
	
	}


	public function verifiermf107Action() {
	    /* page index/relevesalaire - Retrouve salaire */
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublic');
		
		if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		
		
		if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		    if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
			    $code_membre = $_POST['code_membre'];
			    $releve_mapper = new Application_Model_EuReleveMapper();
			    $releve = $releve_mapper->fetchAllByType('MF107',$code_membre);
			    $releve = $releve[0];
			    if(($releve != NULL) && ($releve->publier != NULL)) {
		            if(trim($releve->publier) == 0) {
					    $mf107  = new Application_Model_EuMembreFondateur107();
			            $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
		                $tabela = new Application_Model_DbTable_EuRepartitionMf107();
		                $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                        $select->setIntegrityCheck(false)
                               ->join('eu_detail_mf107', 'eu_detail_mf107.id_mf107 = eu_repartition_mf107.id_mf107',array('code_membre','id_mf107','mont_apport','pourcentage','numident'));
		                $select->where('eu_repartition_mf107.code_membre like ?',$code_membre);
			            $select->order('eu_detail_mf107.id_mf107 asc');
		                $result = $tabela->fetchAll($select);
	                    if(count($result) == 0) {
						   $sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
						} else {
                            $this->view->code_membre = $code_membre;						
						    $this->view->unitemf107 = $result;
						}  
		
		            } else {
					    $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller à la réclamation car vous avez un relevé correct !!! ...";
					}
		
		        } else {
				  $sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
				}
	        }
	    }
	    $this->view->tabletri = 1;
	}
	
	
    public function verifiermf11000Action() {
	    /* page index/relevesalaire - Retrouve salaire */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

		
		if (isset($_POST['ok']) && $_POST['ok']=="ok") {
            if (isset($_POST['numero_bon']) && $_POST['numero_bon']!="") {
			    $numero_bon = $_POST['numero_bon'];
			    $releve_mapper = new Application_Model_EuReleveMapper();
			    $releve = $releve_mapper->fetchAllByType('MF11000_PP',$numero_bon);
				$releve = $releve[0];
			    if($releve != NULL) {
			        if($releve->publier == 0) {
		                $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
		                $num_bon = $this->_request->getParam("num_bon");
		                $select = $tabela->select();
	                    $select->where('code_mf11000 like ?',$numero_bon);
			            $select->order('id_rep asc');
			
			            $this->view->unitemf11000 = $tabela->fetchAll($select);
			   
			            ///////////////////////////////////////////////////////////////////////////////////
			   
			            $tab_smsmoney = new Application_Model_DbTable_EuAncienDetailSmsmoney();
		                $select = $tab_smsmoney->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		                $select->setIntegrityCheck(false)
                               ->join('eu_ancien_membre', 'eu_ancien_membre.ancien_code_membre = eu_ancien_detail_smsmoney.code_membre_dist');
		    
	                    $select->where('eu_ancien_detail_smsmoney.num_bon like ?',$numero_bon);
	          
			            $select->where('eu_ancien_detail_smsmoney.origine_sms like ?','MF');
			            $select->order('eu_ancien_detail_smsmoney.id_detail_smsmoney asc');
			
			            $this->view->detailmf11000 = $tabela->fetchAll($select);
						$this->view->numero_bon = $numero_bon;
		
		            } else {
					   $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller à la réclamation car vous avez un relevé correct !!! ...";
			        } 
					 
                } else {
					$sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
				}
		
		    } else {  
	           $this->view->message = "Champs * obligatoire ...";
	        }
		}	
	    $this->view->tabletri = 1;	
	}

    
	
	
	
	public function reglermf107sAction() {
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		if (!isset($sessionutilisateur->login))     {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != "") {$this->_redirect('/administration/confirmation');}
			    
			    if  (isset($_POST['ok']) && $_POST['ok']=="ok") {
                    if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	                    $code_membre = $_POST['code_membre'];
			            $tabela = new Application_Model_DbTable_EuDetailMf107();
			            $select = $tabela->select();
                        $select->where('code_membre  = ?', $code_membre);
				        $select->where('nature = ?',1);
						$select->where('creditcode like ?',"contentieux");
			            $select->order('date_mf107 asc');
				        $result = $tabela->fetchAll($select);
				        if(count($result) == 0) {
				          $sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
			            } else {
				          $this->view->mf107 = $result;
			              $this->view->code_membre = $code_membre;
			            }
	                }	
		        }
				
				if (isset($_POST['ok1']) && $_POST['ok1']=="ok1")  {
				    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $response = false;
		            $rep     = new Application_Model_EuRepartitionMf107();
			        $m_rep   = new Application_Model_EuRepartitionMf107Mapper();
			        $dmf107  = new Application_Model_EuDetailMf107();
			        $m_dmf107= new Application_Model_EuDetailMf107Mapper();
			        $mf107   = new Application_Model_EuMembreFondateur107();
			        $mmf107  = new Application_Model_EuMembreFondateur107Mapper();
					$operation   = new Application_Model_EuAncienneOperation();
		            $m_operation = new Application_Model_EuAncienneOperationMapper();
					$releve_mapper = new Application_Model_EuReleveMapper();
			        $releve_model = new Application_Model_EuReleve();
					$compteur = $_POST['compteur'];
					$x = 1;
					$mont_apport = 0;
					$date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
					try {
					    while ($x <= $compteur) {
						    if(isset($_POST["num$x"])) {
							    $mont = 0;
                                $montant_recu = 0;
							    $id = $_POST["num$x"];
                                $findmf = $m_dmf107->find($id,$dmf107);								
							    $code_proprio = $_POST["code_proprio$x"];
							    $apporteur = $_POST["apporteur$x"];
								$pp = $dmf107->getPourcentage();
                                $mont_apport = $dmf107->getMont_apport();
                                $mont = ($mont_apport * $pp) / 100;
                                $montant_recu = $mont_apport - $mont;
								$dmf107->setNature(0);
                                $m_dmf107->update($dmf107);
								$releve     = $releve_mapper->fetchAllByType('MF107',$apporteur);
			                    $releve     = $releve[0];
			                    $findreleve = $releve_mapper->find($releve->releve_id,$releve_model);
								
                                for ($i=1;$i<=32;$i++)  {
                                    if ($montant_recu > 0) {	
                                       //insertion dans la table eu_repartition_mf107
									   $id_rep = $m_rep->findConuter() + 1;
								       $rep->setId_rep($id_rep);
                                       $rep->setId_mf107($id);
                                       $rep->setCode_membre($apporteur);
                                       $rep->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                       $rep->setMont_rep($montant_recu);
                                       $rep->setId_utilisateur(NULL);
                                       $rep->setMont_reglt(0);
					                   $rep->setSolde_rep($montant_recu);
                                       $rep->setPayer(0);
                                       $m_rep->save($rep);
							        }
									
									if ($mont > 0) {
									   //insertion dans la table eu_repartition_mf107
									   $id_rep = $m_rep->findConuter() + 1;
								       $rep->setId_rep($id_rep);
                                       $rep->setId_mf107($id);
                                       $rep->setCode_membre($code_proprio);
                                       $rep->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                       $rep->setMont_rep($mont);
                                       $rep->setId_utilisateur(NULL);
                                       $rep->setMont_reglt(0);
					                   $rep->setSolde_rep($mont);
                                       $rep->setPayer(0);
                                       $m_rep->save($rep);
									}
							
							    }
							    $releve_model->setPublier(null);
                                $releve_mapper->update($releve_model);
								$countid = $m_operation->findConuter() + 1;
                                $operation->setId_operation($countid)
                                          ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                          ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                          ->setId_utilisateur(null)
                                          ->setCode_membre($apporteur)
                                          ->setMontant_op($mont_apport)
                                          ->setCode_produit('MF107')
                                          ->setLib_op("Reglement")
                                          ->setType_op("Reglement")
                                          ->setCode_cat("TMF107")
							              ->setId_credit($id);
					            $m_operation->save($operation);
                                $response = true;								
					        }
							$x++;	
					    }
						
						if($response) {
				           $db->commit();
				           $sessionutilisateur->errorlogin = "Règlement effectué avec succès ...";
				           $this->_redirect('/administration/reglermf107s');  
				        } else {
                           $sessionutilisateur->errorlogin = "Règlement non effectué ...";
				           $this->_redirect('/administration/reglermf107s');
                        }
						
		            } catch (Exception $exc) {
                        $db->rollback();
                        $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
			            $sessionutilisateur->errorlogin = $message;
                        return;
                    }   
	            }
	}
	
	

    public function reglermf107Action() {
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = clone $date_fin;
		   
		    $response = false;
		    if  (isset($_POST['ok']) && $_POST['ok']=="ok") {
                if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	                $code_membre = $_POST['code_membre'];
			        $tabela = new Application_Model_DbTable_EuDetailMf107();
			        $select = $tabela->select();
                    $select->where('code_membre  = ?', $code_membre);
				    $select->where('nature = ?',1);
			        $select->order('date_mf107 asc');
				    $result = $tabela->fetchAll($select);
				    if(count($result) == 0) {
				      $sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
			        } else {
				      $this->view->mf107 = $result;
			          $this->view->code_membre = $code_membre;
			        }
	            }	
		    }
			
			if (isset($_POST['ok1']) && $_POST['ok1']=="ok1")  {
                $rep      = new Application_Model_EuRepartitionMf107();
			    $m_rep    = new Application_Model_EuRepartitionMf107Mapper();
			    $dmf107   = new Application_Model_EuDetailMf107();
			    $m_dmf107 = new Application_Model_EuDetailMf107Mapper();
			    $mf107    = new Application_Model_EuMembreFondateur107();
			    $mmf107   = new Application_Model_EuMembreFondateur107Mapper();
			    $releve_mapper = new Application_Model_EuReleveMapper();
			    $releve_model = new Application_Model_EuReleve();
			    $operation   = new Application_Model_EuAncienneOperation();
		        $m_operation = new Application_Model_EuAncienneOperationMapper();
			
			    $compteur = $_POST['compteur'];
			    $code_membre = $_POST['code_membre'];
			    $releve     = $releve_mapper->fetchAllByType('MF107',$code_membre);
			    $releve     = $releve[0];
			    $findreleve = $releve_mapper->find($releve->releve_id,$releve_model);
		        $x = 1;
			    $j = 0;
			    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
				    while ($x <= $compteur)   {
				        if(isset($_POST["num$x"])) { 
                            $mont = 0;
                            $montant_recu = 0;					
				            $id = $_POST["num$x"];
						    $pourcentage = (100 - $_POST["pourcentage$x"]);
					        $findmf = $m_dmf107->find($id,$dmf107);
						    $ancienpourcentage = $m_dmf107->pourcentage;
						    $mont = ($dmf107->getMont_apport() * $pourcentage) / 100;
                            $montant_recu = $dmf107->getMont_apport() - $mont;
						    $findmf107 = $mmf107->find($dmf107->getNumident(),$mf107);
						    $code_proprio = $mf107->getCode_membre();
						
						    $dmf107->setPourcentage($pourcentage);
						    $dmf107->setNature(0);
                            $m_dmf107->update($dmf107);
						
						    $mfcredits = $m_rep->fetchRepByMf($id);
				            $nbre_credit = count($mfcredits);
						
						    while($j < $nbre_credit) {
				                $mfcredit = $mfcredits[$j];
                                $id_rep   = $mfcredit->getId_rep();
					            $findrep  = $m_rep->find($id_rep,$rep);
							    if(($code_membre == $mfcredit->getCode_membre())) {
							        $rep->setMont_rep($montant_recu);
                                    $rep->setMont_reglt(0);
					                $rep->setSolde_rep($montant_recu);
							        $m_rep->update($rep);
									
								if($ancienpourcentage == 0) {
                                    if($mont > 0) {
								       $id_rep = $m_rep->findConuter() + 1;
								       $rep->setId_rep($id_rep);
                                       $rep->setId_mf107($id);
                                       $rep->setCode_membre($code_proprio);
                                       $rep->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                       $rep->setMont_rep($mont);
                                       $rep->setId_utilisateur(NULL);
                                       $rep->setMont_reglt(0);
					                   $rep->setSolde_rep($mont);
                                       $rep->setPayer(0);
                                       $m_rep->save($rep);
									}
                                }								
							}
							if(($code_proprio == $mfcredit->getCode_membre())) {
							    $rep->setMont_rep($mont);
                                $rep->setMont_reglt(0);
					            $rep->setSolde_rep($mont);
                                $m_rep->update($rep);							   
							}
                            $j++;							
						}
						$response = true;
			        }
					$x++;
					$countid = $m_operation->findConuter() + 1;
                    $operation->setId_operation($countid)
                              ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                              ->setHeure_op($date_deb->toString('HH:mm:ss'))
                              ->setId_utilisateur(null)
                              ->setCode_membre($code_membre)
                              ->setMontant_op($dmf107->getMont_apport())
                              ->setCode_produit('MF107')
                              ->setLib_op("Reglement")
                              ->setType_op("Reglement")
                              ->setCode_cat("TMF107")
							  ->setId_credit($id);
					$m_operation->save($operation);
			    }
				$releve_model->setPublier(null);
                $releve_mapper->update($releve_model);
				if($response) {
				   $db->commit();
				   $sessionutilisateur->errorlogin = "Règlement effectué avec succès ...";
				   $this->_redirect('/administration/reglermf107');  
				} else {
                   $sessionutilisateur->errorlogin = "Règlement non effectué ...";
				   $this->_redirect('/administration/reglermf107');
                } 				
			} catch (Exception $exc) {
               $db->rollback();
               $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
			   $sessionutilisateur->errorlogin = $message;
               return;
            }
		}		
	}
	
	
	public function recouvrermf107sAction() {
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		if (!isset($sessionutilisateur->login))         {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != "") {$this->_redirect('/administration/confirmation');}
			    $response = false;
			if  (isset($_POST['ok']) && $_POST['ok']=="ok") {
			    $mf107  = new Application_Model_EuMembreFondateur107;
				$mf107_mapper = new Application_Model_EuMembreFondateur107Mapper();
			    $detailmf = new Application_Model_EuDetailMf107();
                $detailmf_mapper = new Application_Model_EuDetailMf107Mapper();
				$date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
				$proprio       = $_POST['membre'];
				$pourcentage   = $_POST['pourcen'];
				$apporteur     = $_POST['apporteur'];
				$montant       = $_POST['montant'];
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
				try {
				    $findproprio = $mf107_mapper->fetchMfByMembre($proprio);
					if($findproprio == NULL) {
					    $sessionutilisateur->errorlogin = "Ce membre $proprio  n' est pas un membre fondateur 107 !!! ...";
					} else {
					    $findproprio = $findproprio[0];
					    $numident = $findproprio->numident;
					    $id_mf107 = $detailmf_mapper->findConuter() + 1;
						$detailmf->setId_mf107($id_mf107);
					    $detailmf->setNumident($numident);
                        $detailmf->setCode_membre($apporteur);
                        $detailmf->setDate_mf107($date_idd->toString('yyyy-MM-dd'));
                        $detailmf->setMont_apport($montant);
                        $detailmf->setId_utilisateur(null);
                        $detailmf->setPourcentage($pourcentage);
                        $detailmf->setProprietaire(null);
		                $detailmf->setCreditcode("contentieux");
						$detailmf->setNature(1);
                        $detailmf_mapper->save($detailmf);
						
						$db->commit();
						$sessionutilisateur->errorlogin = "Recouvrement effectué avec succès ...";
					    $this->_redirect('/administration/recouvrermf107s');
					}
			    } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
					$sessionutilisateur->errorlogin = $message;
                    return;
                }
	        }
	}
	
	
	
	public function recouvrermf107Action() {
	
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		    $response = false;
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
                if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
				    $code_membre = $_POST['code_membre'];
                    $tabela = new Application_Model_DbTable_EuDetailMf107();
					$releve_mapper = new Application_Model_EuReleveMapper();
			        $releve = $releve_mapper->fetchAllByType('MF107',$code_membre);
			        $releve = $releve[0];
					if(($releve != NULL) && ($releve->publier != NULL)) {
					    if($releve->publier == 0 ) {
				            $select = $tabela->select();
                            $select->where('code_membre  = ?', $code_membre);
				            $select->where('nature = ?',0);
			                $select->order('date_mf107 asc');
				            $result = $tabela->fetchAll($select);
				            if(count($result) == 0) {
					           $sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
					        } else {
				               $this->view->mf107 = $result;
			                   $this->view->code_membre    = $code_membre;
					        }
						} else {
					        $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller à la réclamation car vous avez un relevé correct !!! ...";
					    }
						
                    } else {
				        $sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
				    }	
	            }
				
			}
			
			if  (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
			        $dmf107   = new Application_Model_EuDetailMf107();
			        $m_dmf107 = new Application_Model_EuDetailMf107Mapper();
				    $compteur = $_POST['compteur'];
				    $code_membre = $_POST['code_membre'];
				    $x = 1;
					$db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
					try {
					    while ($x <= $compteur) {
				            if(isset($_POST["num$x"])) {  
				                $id = $_POST["num$x"];
					            $findmf107 = $m_dmf107->find($id,$dmf107);
					            $dmf107->setNature(1);
                                $m_dmf107->update($dmf107);
					            $response = true;
				            }
			                $x++;
			            }
	                    if($response) {
						   $db->commit();
				           $sessionutilisateur->errorlogin = "Recouvrement effectué avec succès ...";
					       $this->_redirect('/administration/recouvrermf107');
				        } else {
                           $sessionutilisateur->errorlogin = "Recouvrement non effectué ...";
					       $this->_redirect('/administration/recouvrermf107');
                        }					
			        } catch (Exception $exc) {
                        $db->rollback();
                        $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
					    $sessionutilisateur->errorlogin = $message;
                        return;
                    }					
			}        	
	}
	
	
	
	
	
	
	public function recouvrermf11000Action() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		    $response = false;
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
                if (isset($_POST['num_bon']) && $_POST['num_bon']!="") {
				    $num_bon = $_POST['num_bon'];
				    $releve_mapper = new Application_Model_EuReleveMapper();
				    $releve = $releve_mapper->fetchAllByType('MF11000_PP',$num_bon);
					$releve = $releve[0];
				    if(($releve != NULL) && ($releve->publier != NULL)) {
				        if($releve->publier == 0) {
                            $tabela = new Application_Model_DbTable_EuAncienDetailSmsmoney();
				            $select = $tabela->select();
                            $select->where('num_bon  = ?', $num_bon);
				            $select->where('type_sms <> ?','saisi');
			                $select->order('date_allocation asc');
						    $result = $tabela->fetchAll($select);
						    if(count($result) == 0) {
						       $sessionutilisateur->errorlogin = "Aucun résultat"; 
							} else { 
				               $this->view->mf11000    = $result;
			                   $this->view->num_bon    = $num_bon;
							}
				        } else {
					        $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller au recouvrement car vous avez un relevé correct !!! ...";
			            } 
					 
                    } else {
					    $sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
				    }
	            }
				
			}
			
			if  (isset($_POST['ok1']) && $_POST['ok1']=="ok1") { 
				$dsms   = new Application_Model_EuAncienDetailSmsmoney();
			    $m_dsms = new Application_Model_EuAncienDetailSmsmoneyMapper();
				$rep   = new Application_Model_EuRepartitionMf11000();
			    $m_rep = new Application_Model_EuRepartitionMf11000Mapper();
				$db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
				    $compteur = $_POST['compteur'];
				    $num_bon = $_POST['num_bon'];
				    $x=1;
				    $j=0;
				    $mfcredits = $m_rep->fetchRepByNumBon($num_bon);
				    $nbre_credit = count($mfcredits);
				    while ($j < $nbre_credit) {
				       $mfcredit = $mfcredits[$j];
                       $id_rep = $mfcredit->getId_rep();
					   $findrep = $m_rep->find($id_rep,$rep);
					   $rep->setEtat(1);
                       $m_rep->update($rep);
				       $j++;
				    }
				    while ($x <= $compteur)   {
				        if(isset($_POST["num$x"])) {  
				           $id = $_POST["num$x"];
					       $findsms = $m_dsms->find($id,$dsms);
					       $dsms->setType_sms("saisi");
                           $m_dsms->update($dsms);
					       $response = true;
				        }
			            $x++;
			        }
	
	                if($response) {
					  $db->commit();
				      $sessionutilisateur->errorlogin = "Recouvrement effectué avec succès ...";
					  $this->_redirect('/administration/recouvrermf11000');
				    } else {
					  $sessionutilisateur->errorlogin = "Enrégistrement non effectué ...";
					  $this->_redirect('/administration/recouvrermf11000');
					}
                } catch (Exception $exc) {
				   $db->rollback();
				   $sessionutilisateur->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				   return;
			    }					
                    
	        }		
	
	}
	
	
	
	public function recouvrergcpAction() {
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		if (!isset($sessionutilisateur->login))        {  $this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != "") {  $this->_redirect('/administration/confirmation');}
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
                if  (isset($_POST['code_membre']) && $_POST['code_membre'] !="")  {    
					$code_membre = $_POST['code_membre'];
				    $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
				    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
					$select->setIntegrityCheck(false);
                    $select->where('code_membre = ?', $code_membre);
				    $select->where('montant_credit > ?',0);
			        $select->where('code_produit in (?)', array('RPGnr','Inr'));
				    $select->where('nature = ?',0);
			        $select->order('date_octroi asc');
					$result = $tabela->fetchAll($select);
						
					$tabeld = new Application_Model_DbTable_EuAncienCnnc();
                    $seld = $tabeld->select();
					$seld->where('code_membre = ?',$code_membre);
				    $seld->where('nature = ?',0);
			        $seld->where('libelle in (?)', array('RPGnr','Inr'));
				    $resultnc = $tabeld->fetchAll($seld);
						   
					if(count($result) == 0 && count($resultnc) == 0) {
						$sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
				    } else {
						$this->view->credits      =   $result;
						$this->view->creditncs    =   $resultnc;
			            $this->view->code_membre  =   $code_membre;
				    }
	            }
				
			}

            if  (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
			    $credit = new Application_Model_EuAncienCompteCredit();
			    $m_credit = new Application_Model_EuAncienCompteCreditMapper();
				$cnnc = new Application_Model_EuAncienCnnc();
			    $m_cnnc = new Application_Model_EuAncienCnncMapper();
				$response = false;
				$db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
                    $compteur = $_POST['compteur'];
				    $x = 1;
				    while ($x <= $compteur) {
					    if(isset($_POST["credit$x"])) {
                           $id = $_POST["credit$x"];
					       $findcredit = $m_credit->find($id,$credit);
					       $credit->setNature(1);
                           $m_credit->update($credit);
						}
						
						if(isset($_POST["creditnc$x"])) {
						   $idnc = $_POST["creditnc$x"];
						   $findcreditnc = $m_cnnc->find($idnc,$cnnc);
					       $cnnc->setNature(1);
                           $m_cnnc->update($cnnc);
						}						
					    $response = true;
						$x++;
				    }
					if($response) {
					   $db->commit();
				       $sessionutilisateur->errorlogin = "Recouvrement effectué avec succès ...";
					   $this->_redirect('/administration/recouvrerrpgi');
				    } else {
                       $sessionutilisateur->errorlogin = "Enrégistrement non effectué ...";
					   $this->_redirect('/administration/recouvrerrpgi');
                    }
				} catch (Exception $exc) {
				    $db->rollback();
				    $sessionutilisateur->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				    return;
			    }

			}		
	}
	
	
	

    public function recouvrerrpgiAction() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		    $response = false;
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
                if (isset($_POST['code_membre']) && $_POST['code_membre'] !="") {
				    $code_membre = $_POST['code_membre'];
				    $releve_mapper = new Application_Model_EuReleveMapper();
				    $releve = $releve_mapper->fetchAllByType('RPG_I',$code_membre);
					$releve = $releve[0];
				    if(($releve != NULL) && ($releve->publier != NULL)) {
				        if($releve->publier == 0) {
                            $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
				            $select = $tabela->select();
                            $select->where('code_membre = ?', $code_membre);
			                $select->where('code_produit in (?)', array('RPGnr','Inr'));
				            $select->where('nature = ?',0);
			                $select->order('date_octroi asc');
						    $result = $tabela->fetchAll($select);
				           
						    if(count($result) == 0) {
						      $sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
						    } else {
						      $this->view->credits = $result;
			                  $this->view->code_membre    = $code_membre;
				            }
				        } else {
					        $sessionutilisateur->errorlogin = "Vous ne pouvez pas aller au recouvrement car vous avez un relevé correct !!! ...";
			            }  
                    } else {
					    $sessionutilisateur->errorlogin = "Vous devez d'abord valider votre relevé !!! ...";
				    }
	            }
			}
			
			if  (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
			    $credit = new Application_Model_EuAncienCompteCredit();
			    $m_credit = new Application_Model_EuAncienCompteCreditMapper();
				$db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
				    $compteur = $_POST['compteur'];
				    $x = 1;
				    while ($x <= $compteur) {
				        if(isset($_POST["credit$x"])) {  
				          $id = $_POST["credit$x"];
					      $findcredit = $m_credit->find($id,$credit);
					      $credit->setNature(1);
                          $m_credit->update($credit);
					      $response = true;
				        }
			            $x++;
			        }
				    if($response) {
					   $db->commit();
				       $sessionutilisateur->errorlogin = "Recouvrement effectué avec succès ...";
					   $this->_redirect('/administration/recouvrerrpgi');
				    } else {
                       $sessionutilisateur->errorlogin = "Enrégistrement non effectué ...";
					   $this->_redirect('/administration/recouvrerrpgi');
                    }					
                } catch (Exception $exc) {
				    $db->rollback();
				    $sessionutilisateur->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				    return;
			    }	
            }			
	}


	
    
	
	public function reglergcpAction() {
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublic');
		
		if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		    $response = false;
			
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
			    $code_membre = $_POST['code_membre'];
				$tabela = new Application_Model_DbTable_EuAncienCompteCredit();
				$select = $tabela->select();
                $select->where('code_membre = ?',$code_membre);
				$select->where('montant_credit > ?',0);
			    $select->where('code_produit in (?)', array('RPGnr','Inr'));
				$select->where('nature <> ?',0);
			    $select->order('date_octroi asc');
				$result = $tabela->fetchAll($select);
						
				$tabeld = new Application_Model_DbTable_EuAncienCnnc();
                $seld = $tabeld->select();
			    $seld->where('code_membre = ?',$code_membre);
				$seld->where('nature <> ?',0);
			    $seld->where('libelle in (?)', array('RPGnr','Inr'));
				$resultnc = $tabeld->fetchAll($seld);
						   
				if(count($result) == 0 && count($resultnc) == 0) {
				  $sessionutilisateur->errorlogin = "Aucun résultat !!! ...";
				} else {
				  $this->view->credits     =   $result;
				  $this->view->creditncs   =   $resultnc;
			      $this->view->code_membre =   $code_membre;
				}
	        }
			
			
			if(isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
			
			    $agcp    = new Application_Model_EuAncienGcp();
				$m_agcp  = new Application_Model_EuAncienGcpMapper();
				
				$acredit   = new Application_Model_EuAncienCompteCredit();
				$m_acredit = new Application_Model_EuAncienCompteCreditMapper();
				
				$acnnc   = new Application_Model_EuAncienCnnc();
				$m_acnnc = new Application_Model_EuAncienCnncMapper();
				
				$operation   = new Application_Model_EuAncienneOperation();
				$m_operation = new Application_Model_EuAncienneOperationMapper();
				
				$releve_mapper = new Application_Model_EuReleveMapper();
			    $releve_model  = new Application_Model_EuReleve();
				
				$asmc   = new Application_Model_EuAncienSmc();
				$m_asmc = new Application_Model_EuAncienSmcMapper();
				
				$ategc   = new Application_Model_EuAncienTegc();
				$m_ategc = new Application_Model_EuAncienTegcMapper();
				
				$acc   = new Application_Model_EuAncienCreditConsommer();
				$m_acc = new Application_Model_EuAncienCreditConsommerMapper();
				
				$acapa   =  new Application_Model_EuAncienCapa();
				$m_acapa =  new Application_Model_EuAncienCapaMapper();
				$t_acapa =  new Application_Model_DbTable_EuAncienCapa();
				
				$db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $code_membre = $_POST['code_membre'];
					if (substr($code_membre, -1) == 'P') {
                        $produit = 'RPGnr';
                        $code_cat = "TPAGCRPG";
						$code_compte = "NB-TPAGCRPG-".$code_membre;
                    } else {
                        $produit = 'Inr';
                        $code_cat = "TPAGCI";
						$code_compte = "NB-TPAGCI-".$code_membre;
                    }
					$distr = $_POST['distributeur'];
					$releve     = $releve_mapper->fetchAllByType('GCP',$distr);
			        $releve     = $releve[0];
			        $findreleve = $releve_mapper->find($releve->releve_id,$releve_model);
				    $compteur   = $_POST['compteur'];
				    $x = 1;
					$findtegc = $m_ategc->findByMembre($distr,$ategc);

                    if($findtegc == false) {
					   $db->rollback();
					   $sessionutilisateur->errorlogin = "Le membre distributeur n'est pas un acteur dans une filiere ...";
					   return;
					} else {
					   $code_tegc = $ategc->getCode_tegc();
					}
					
					while ($x <= $compteur)   {
					    $montant_credit = 0;
						$mont_credit    = 0;
						if(isset($_POST["credit$x"]) && $_POST["credit$x"] !="")  {
						    $montant_credit = $_POST["montant_credit$x"];
                            $id = $_POST["credit$x"];
							$selection = $t_acapa->select();
			                $selection->where('id_credit = ?',$id);
				            $result = $t_acapa->fetchAll($selection);
							$row = $result->current();
							$code_capa = $row->code_capa;
					        $findcredit = $m_acredit->find($id,$acredit);
							$countid = $m_operation->findConuter() + 1;
                            $operation->setId_operation($countid)
                                      ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                      ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                      ->setId_utilisateur(null)
                                      ->setCode_membre($code_membre)
                                      ->setMontant_op($montant_credit)
                                      ->setCode_produit($produit)
                                      ->setLib_op("Consommation")
                                      ->setType_op("Conso")
                                      ->setCode_cat($code_cat)
									  ->setId_credit($id);						
                            $m_operation->save($operation);
							
							$id_gcp = $m_agcp->findConuter() + 1;
							$agcp->setId_gcp($id_gcp)
							     ->setCode_tegc($code_tegc)
                                 ->setId_credit($id)
                                 ->setSource($acredit->getSource())
                                 ->setDate_conso($date_deb->toString('yyyy-MM-dd hh:mm:ss'))
                                 ->setCode_membre($distr)
                                 ->setCode_cat($code_cat)
                                 ->setMont_gcp($montant_credit)
                                 ->setMont_preleve(0)
                                 ->setReste($montant_credit);
                            $m_agcp->save($agcp);
							
							$id_conso = $m_acc->findConuter() + 1;
							$acc->setId_consommation($id_conso)
							    ->setId_credit($id)
                                ->setId_operation($countid)
                                ->setCode_produit($produit)
                                ->setCode_compte($code_compte)
                                ->setCode_membre($code_membre)
                                ->setCode_membre_dist($distr)
                                ->setMont_consommation($montant_credit)
                                ->setDate_consommation($date_deb->toString('yyyy-mm-dd'))
                                ->setHeure_consommation($date_deb->toString('hh:mm:ss'));
                            $m_acc->save($acc);
							
							$id_smc = $m_asmc->findConuter() + 1;
							
							$asmc->setId_smc($id_smc)
							     ->setId_credit($id)
                                 ->setDate_smc($date_deb->toString('yyyy-MM-dd'))
                                 ->setMontant($montant_credit)
                                 ->setEntree(0)
                                 ->setSortie(0)
                                 ->setSolde(0)
                                 ->setSource_credit($acredit->getSource())
                                 ->setMontant_solde($montant_credit)
                                 ->setOrigine_smc(0)
                                 ->setType_smc('CNCSnr')
                                 ->setCode_smcipn($countid)
                                 ->setCode_capa($code_capa);
                            $m_asmc->save($asmc);
					        
					
					        $acredit->setMontant_credit($acredit->getMontant_credit() - $montant_credit);
					        $acredit->setNature(0);
                            $m_acredit->update($acredit);
							$response = true;
                        }
						
						if(isset($_POST["creditnc$x"])) {
						    $mont_credit = $_POST["mont_credit$x"];
						    $idnc = $_POST["creditnc$x"];
						    $findcreditnc = $m_acnnc->find($idnc,$acnnc);
						    $id = $acnnc->getId_credit();
							$findcredit = $m_acredit->find($id,$acredit);
						   
						    $selection = $t_acapa->select();
			                $selection->where('id_credit = ?',$id);
				            $result = $t_acapa->fetchAll($selection);
							$row = $result->current();
							$code_capa = $row->code_capa;
							
							$countid = $m_operation->findConuter() + 1;
                            $operation->setId_operation($countid)
                                      ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                      ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                      ->setId_utilisateur(null)
                                      ->setCode_membre($code_membre)
                                      ->setMontant_op($mont_credit)
                                      ->setCode_produit($produit)
                                      ->setLib_op("Consommation")
                                      ->setType_op("Conso")
                                      ->setCode_cat($code_cat)
									  ->setId_credit($id);						
                            $m_operation->save($operation);
							
							$id_gcp = $m_agcp->findConuter() + 1;
							$agcp->setId_gcp($id_gcp)
							     ->setCode_tegc($code_tegc)
                                 ->setId_credit($id)
                                 ->setSource($acredit->getSource())
                                 ->setDate_conso($date_deb->toString('yyyy-MM-dd hh:mm:ss'))
                                 ->setCode_membre($distr)
                                 ->setCode_cat($code_cat)
                                 ->setMont_gcp($mont_credit)
                                 ->setMont_preleve(0)
                                 ->setReste($mont_credit);
                            $m_agcp->save($agcp);
							
							$id_conso = $m_acc->findConuter() + 1;
							$acc->setId_consommation($id_conso)
							    ->setId_credit($id)
                                ->setId_operation($countid)
                                ->setCode_produit($produit)
                                ->setCode_compte($code_compte)
                                ->setCode_membre($code_membre)
                                ->setCode_membre_dist($distr)
                                ->setMont_consommation($mont_credit)
                                ->setDate_consommation($date_deb->toString('yyyy-mm-dd'))
                                ->setHeure_consommation($date_deb->toString('hh:mm:ss'));
                            $m_acc->save($acc);
							
							
						    $id_smc = $m_asmc->findConuter() + 1;
							
							$asmc->setId_smc($id_smc)
							     ->setId_credit($id)
                                 ->setDate_smc($date_deb->toString('yyyy-MM-dd'))
                                 ->setMontant($mont_credit)
                                 ->setEntree(0)
                                 ->setSortie(0)
                                 ->setSolde(0)
                                 ->setSource_credit($acredit->getSource())
                                 ->setMontant_solde($mont_credit)
                                 ->setOrigine_smc(0)
                                 ->setType_smc('CNCSnr')
                                 ->setCode_smcipn($countid)
                                 ->setCode_capa($code_capa);
                            $m_asmc->save($asmc);
						   
						    $acnnc->setMont_credit($acnnc->getMont_credit() - $mont_credit);
					        $acnnc->setNature(0);
                            $m_acnnc->update($acnnc);
							$response = true;
						
						
						}
                        $x++; 					
					} 
			        
					if($response) {
					    $db->commit();
				        $sessionutilisateur->errorlogin = "Reglement effectué avec succès ...";
					    $this->_redirect('/administration/reglergcp');
				    } else {
                        $sessionutilisateur->errorlogin = "Reglement non effectué ...";
					    $this->_redirect('/administration/reglergcp');
                    }
			
			    } catch (Exception $exc) {
				    $db->rollback();
				    $sessionutilisateur->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				    return;
			    }
			
			}
					
			
	}
	
	
    
	
	
	public function reglerrpgiAction() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
		    $response = false;
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
			    $code_membre = $_POST['code_membre'];
		        $tab_gcp = new Application_Model_DbTable_EuAncienGcp();
		        $select  = $tab_gcp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		        $select->setIntegrityCheck(false)
			           //->from('eu_ancien_gcp',array('id_gcp','code_membre','mont_gcp','id_credit'))
                       ->join('eu_ancien_compte_credit','eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit',array('id_credit','code_produit','nature'));
		        $select->where('eu_ancien_compte_credit.code_membre = ?', $code_membre);
				$select->where('eu_ancien_gcp.mont_gcp > ?',0);
			    $select->where('eu_ancien_compte_credit.nature = ?',1);
				$result = $tab_gcp->fetchAll($select);
				
				if(count($result) == 0) {
				   $sessionutilisateur->errorlogin = "Aucun resultat ...";
				} else {
				   $this->view->gcps = $result;
			       $this->view->code_membre    = $code_membre;
				}   
		    }
			
			if  (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
				$date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin; 
				 
				$agcp    = new Application_Model_EuAncienGcp();
				$m_agcp  = new Application_Model_EuAncienGcpMapper();
				
				$acredit = new Application_Model_EuAncienCompteCredit();
				$m_acredit = new Application_Model_EuAncienCompteCreditMapper();
				
				$operation   = new Application_Model_EuAncienneOperation();
				$m_operation = new Application_Model_EuAncienneOperationMapper();
				
				$releve_mapper = new Application_Model_EuReleveMapper();
			    $releve_model = new Application_Model_EuReleve();
				
				$db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
				    $code_membre = $_POST['membre'];
					$releve     = $releve_mapper->fetchAllByType('RPG_I',$code_membre);
			        $releve     = $releve[0];
			        $findreleve = $releve_mapper->find($releve->releve_id,$releve_model);
				    $compteur    = $_POST['compteur'];
				    $x = 1;
				    while ($x <= $compteur)   {
				        if(isset($_POST["gcp$x"])) {
				           $id_gcp  = $_POST["gcp$x"];
					       $findgcp = $m_agcp->find($id_gcp,$agcp);
                           $mont_gcp = $agcp->getMont_gcp();
                           $id_credit = $agcp->getId_credit();
					   
					       $agcp->setMont_gcp(0);
					       $agcp->setMont_preleve(0);
					       $agcp->setReste(0);
                           $m_agcp->update($agcp);
					   
					       $findcredit = $m_acredit->find($id_credit,$acredit);
					       $acredit->setMontant_credit($acredit->getMontant_credit() + $mont_gcp);
					       $m_acredit->update($acredit);
					   
					        // insertion dans la table eu_operation
                            $countid = $m_operation->findConuter() + 1;
						    if(substr($code_membre,19,1) == "P") {
                                $operation->setId_operation($countid)
                                          ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                          ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                          ->setId_utilisateur(null)
                                          ->setCode_membre($code_membre)
                                          ->setMontant_op($mont_gcp)
                                          ->setCode_produit('RPGnr')
                                          ->setLib_op("Reglement")
                                          ->setType_op("Reglement")
                                          ->setCode_cat("TPAGCRPG")
									      ->setId_credit($id_credit);
						    } else  {
							    $operation->setId_operation($countid)
                                          ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                          ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                          ->setId_utilisateur(null)
                                          ->setCode_membre($code_membre)
                                          ->setMontant_op($mont_gcp)
                                          ->setCode_produit('Inr')
                                          ->setLib_op("Reglement")
                                          ->setType_op("Reglement")
                                          ->setCode_cat("TPAGCI")
									     ->setId_credit($id_credit);
                            }						
                            $m_operation->save($operation);
							$response = true;
				        }
					    $x++;    
				    }
					$releve_model->setPublier(null);
                    $releve_mapper->update($releve_model);
		            if($response) {
					    $db->commit();
				        $sessionutilisateur->errorlogin = "Reglement effectué avec succès ...";
					    $this->_redirect('/administration/reglerrpgi');
				    } else {
                        $sessionutilisateur->errorlogin = "Reglement non effectué ...";
					    $this->_redirect('/administration/reglerrpgi');
                    }
                } catch (Exception $exc) {
				    $db->rollback();
				    $sessionutilisateur->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				    return;
			    }					
                    
	        }
	}
	
	
	
	
	public function reglermf11000Action() {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
            if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

		    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = clone $date_fin;
		   
		    $response = false;
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
                if (isset($_POST['num_bon']) && $_POST['num_bon']!="") {
				    $num_bon = $_POST['num_bon'];
                    $tabela = new Application_Model_DbTable_EuAncienDetailSmsmoney();
				    $select = $tabela->select();
                    $select->where('num_bon  = ?', $num_bon);
				    $select->where('type_sms like ?','saisi');
				    $select->where('mont_sms > ?',0);
			        $select->order('date_allocation asc');
				    $resultat = $tabela->fetchAll($select);
				    if(count($resultat) == 0) {
				      $sessionutilisateur->errorlogin = "Aucun résultat ...";
				    } else {
				      $this->view->mf11000 = $resultat;
			          $this->view->num_bon    = $num_bon;
				    }		
	            }	
			}
			
			if  (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
			    $dsms   = new Application_Model_EuAncienDetailSmsmoney();
			    $m_dsms = new Application_Model_EuAncienDetailSmsmoneyMapper();
				
				$rep   = new Application_Model_EuRepartitionMf11000();
			    $m_rep = new Application_Model_EuRepartitionMf11000Mapper();
				
				$operation   = new Application_Model_EuAncienneOperation();
				$m_operation = new Application_Model_EuAncienneOperationMapper();
				$releve_mapper = new Application_Model_EuReleveMapper();
			    $releve_model = new Application_Model_EuReleve();
				
				
				$db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
				    $compteur   = $_POST['compteur'];
					$num_bon = $_POST['num_bon'];
					$releve     = $releve_mapper->fetchAllByType('MF11000',$num_bon);
			        $releve     = $releve[0];
			        $findreleve = $releve_mapper->find($releve->releve_id,$releve_model);
				    $x = 1;
				    $j = 0;
				
				    $mfcredits = $m_rep->fetchRepByNumBon($num_bon);
				    $nbre_credit = count($mfcredits);
				
				    while ($x <= $compteur)   {
				        if(isset($_POST["num$x"])) {
				            $id = $_POST["num$x"];
					        $findsms = $m_dsms->find($id,$dsms);
					        $mont_sms = $dsms->getMont_sms();
					    
						    $dsms->setMont_sms(0);
					        $dsms->setMont_vendu(0);
					        $dsms->setSolde_sms(0);
                            $m_dsms->update($dsms);
						
						    while (($j < $nbre_credit) && ($mont_sms > 0)) {
				                $mfcredit = $mfcredits[$j];
                                $id_rep   = $mfcredit->getId_rep();
					            $findrep  = $m_rep->find($id_rep,$rep);
							    $entree   = $rep->getMont_rep();
							    $sortie   = $rep->getMont_reglt();
							    $solde    = $rep->getSolde_rep();
						        if(($solde + $mont_sms) <= ($entree)) {
                                   $rep->setSolde_rep($rep->getSolde_rep() + $mont_sms);
								   $rep->setMont_reglt($rep->getMont_reglt() - $mont_sms);
                                   $m_rep->update($rep);
                                   $mont_sms = 0;    								
							    } else {
                                   $rep->setSolde_rep($rep->getMont_rep());
								   $rep->setMont_reglt(0);
								   $m_rep->update($rep);
								   $mont_sms = $rep->getMont_rep() - $mont_sms;   
                                }
                                $j++;							
					        }
						    $response = true;
							$countid = $m_operation->findConuter() + 1;
                            $operation->setId_operation($countid)
                                      ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                      ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                      ->setId_utilisateur(null)
                                      ->setCode_membre(null)
                                      ->setMontant_op($mont_sms)
                                      ->setCode_produit('MF11000')
                                      ->setLib_op("Reglement")
                                      ->setType_op("Reglement")
                                      ->setCode_cat("TMF11000")
							          ->setId_credit($num_bon);
					        $m_operation->save($operation);
				        }
					    $x++;   		  
				    }
				        $releve_model->setPublier(null);
                        $releve_mapper->update($releve_model);
				        if($response) {
						   $db->commit();
				           $sessionutilisateur->errorlogin = "Règlement effectué avec succès ...";
				           $this->_redirect('/administration/reglermf11000');
				        } else {
                           $sessionutilisateur->errorlogin = "Règlement non effectué ...";
				           $this->_redirect('/administration/reglermf11000');
                        } 				
				    } catch (Exception $exc) {
				        $db->rollback();
				        $sessionutilisateur->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				        return;
			        }
	        }
	}
	
	
	





    public function listlivraison1Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(0, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(0, "");
				}

    }




    public function listlivraison2Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(1, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(1, "");
				}

    }




    public function listlivraison3Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(2, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(2, "");
				}

    }




    public function listlivraison4Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(3, "");
				}

    }




    public function listlivraison41Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(3, "");
				}

    }




    public function listlivraison5Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(3, "");
				}

    }



    public function listlivraison6Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $livraison = new Application_Model_EuLivraisonMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        $this->view->entries = $livraison->fetchAllByPublier(3, $sessionutilisateur->code_agence);
			}else{
        $this->view->entries = $livraison->fetchAllByPublier(3, "");
				}

    }







    public function publierlivraisonAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		
        $livraison_mapper = new Application_Model_EuLivraisonMapper();
		
		if($sessionutilisateur->code_agence != "001001001001"){
        $livraison = $livraison_mapper->fetchAllByPublier($_POST['id'] - 1, $sessionutilisateur->code_agence);
			}else{
        $livraison = $livraison_mapper->fetchAllByPublier($_POST['id'] - 1, "");
				}

		foreach ($livraison as $entry):
		if(isset($_POST['publier'.$entry->livraison_id.'']) && $_POST['publier'.$entry->livraison_id.''] == $_POST['id']){

        $livraison = new Application_Model_EuLivraison();
        $livraisonM = new Application_Model_EuLivraisonMapper();
        $livraisonM->find($entry->livraison_id, $livraison);
		
        $livraison->setPublier($_POST['publier'.$entry->livraison_id.'']);
		$livraisonM->update($livraison);


$date_id = new Zend_Date(Zend_Date::ISO_8601);


        $validation_quittance = new Application_Model_EuValidationQuittance();
        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
			
            $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
            $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
            $validation_quittance->setValidation_quittance_utilisateur($sessionutilisateur->id_utilisateur);
            $validation_quittance->setValidation_quittance_livraison($entry->livraison_id);
            $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $validation_quittance->setPublier(1);
            $validation_quittance_mapper->save($validation_quittance);

		include("Transfert.php");





if($_POST['id'] == 3){


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
	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Bon de Livraison : BL'.ajoutezero($entry->livraison_id).'</u></em></strong></td>
  </tr>';
		
  
/*$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>QUITTANCE CMFH/CAPS/GAC TOGO N° '.$livraison->livraison_id.'</u></em></strong></td>
  </tr>';*/
  
        $membre_morale = new Application_Model_EuMembreMorale();
        $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
        $membre_moraleM->find($entry->livraison_code_membre, $membre_morale);
		
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Raison sociale de la demande du bon de livraison </u>: </em><strong><em>'.$membre_morale->raison_sociale.'</em></strong></p></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="4" align="right"><strong><em>Montant Bon de Livraison : '.number_format(($livraison->livraison_montant), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center"><em><strong>Montant Bon de Livraison</strong></em></td>
  </tr>';
  
$htmlpdf .= '
  <tr style="background-color:#999;">
    <td align="left"><em>'.$livraison->livraison_libelle.'</em></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center"><em>'.number_format(($livraison->livraison_montant), 0, ',', ' ').' FCFA</em></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="2" align="left"><em><u>Montant en  lettres </u>: '.lettre(($livraison->livraison_montant), 50).' CFA</em></td>
    <td colspan="2" align="left"><img src="'.Util_Utils::getParamEsmc(2).'/images/cachet.jpg" /><br />
Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
  </tr>';	
      
  
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
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
$filename = ''.Util_Utils::getParamEsmc(1).'/livraisons.html';
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
if (!is_dir("pdf_livraison/")) {
mkdir("pdf_livraison/", 0777);
}
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "pdf_livraison/LIVRAISON_".str_replace("/", "_", mettreaccents($livraison->livraison_id))."_.html";
$newnom = "LIVRAISON_".str_replace("/", "_", mettreaccents($livraison->livraison_id)."_");
$newchemin = "pdf_livraison/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'fr');
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

	
		//$this->_redirect($file);




if($membre_morale->email_membre != ""){

$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Bon de Livraison : BL'.ajoutezero($entry->livraison_id).' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membre_morale->email_membre, $membre_morale->raison_sociale);
$mail->setSubject('Bon de Livraison : BL'.ajoutezero($entry->livraison_id).' le '.$date_id->toString('dd-MM-yyyy HH:mm')); 

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




}



if($_POST['id'] == 1 || $_POST['id'] == 2 || $_POST['id'] == 3){
	
if($_POST['id'] == 1){
	$agrement = "agrement_filiere";
}else if($_POST['id'] == 2){
	$agrement = "agrement_technopole";
}else if($_POST['id'] == 3){
	$agrement = "agrement_acnev";
}
        $utilisateurM = new Application_Model_EuUtilisateurMapper();
        $utilisateur = $utilisateurM->fetchAllByAgenceCodeGroupe($sessionutilisateur->code_agence, $agrement);
		
foreach ($utilisateur as $entryagrement):
if (substr($entryagrement->code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($entryagrement->code_membre, $membre);
$membre_email = $membre->email_membre;
$membre_nom = $membre->nom_membre." ".$membre->prenom_membre;
} else if (substr($entryagrement->code_membre, -1) == "M") {
$membremorale = new Application_Model_EuMembreMorale();
$mapper_membremorale = new Application_Model_EuMembreMoraleMapper();
$mapper_membremorale->find($entryagrement->code_membre, $membremorale);
$membre_email = $membre->email_membre;
$membre_nom = $membre->raison_sociale;
}


if($membre_email != ""){
$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Alerte Bon de Livraison : BL'.ajoutezero($entry->livraison_id).' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membre_email, $membre_nom);
$mail->setSubject('Alerte Bon de Livraison : BL'.ajoutezero($entry->livraison_id).' le '.$date_id->toString('dd-MM-yyyy HH:mm')); 
$mail->send($tr);
}
endforeach;
}


			}
		endforeach;

if($_POST['id'] == 3){
		$this->_redirect('/administration/listlivraison41');
}else{
		$this->_redirect('/administration/listlivraison'.$_POST['id'].'');
	}
        }
    }









    public function bonsalaireAction() 
    {
        /* page espacepersonnel/pdfdemandefrais - Livrer demande */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

		include("Transfert.php");


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['montant']) && $_POST['montant']!="" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur']!="" && isset($_POST['code_membre']) && $_POST['code_membre']!="") {
			
            $utilisateur = new Application_Model_EuUtilisateur();
            $m_utilisateur = new Application_Model_EuUtilisateurMapper();
            $m_utilisateur->find($_POST['id_utilisateur'], $utilisateur);
			
			$date = new Zend_Date(Zend_Date::ISO_8601);

            $membre = new Application_Model_EuMembre();
            $m_membre = new Application_Model_EuMembreMapper();
            $m_membre->find($_POST['code_membre'], $membre);





        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuLivraison();
        $ma = new Application_Model_EuLivraisonMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setLivraison_id($compteur);
            $a->setLivraison_code_produit("CNCS");
            $a->setLivraison_libelle("Bon de Salaire de ".$membre->nom_membre." ".$membre->prenom_membre);
            $a->setLivraison_montant($_POST['montant']);
            $a->setLivraison_description(NULL);
            $a->setLivraison_code_membre($_POST['code_membre']);
            $a->setLivraison_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $a->setLivraison_utilisateur($_POST['id_utilisateur']);
            $a->setPublier(1);
            $ma->save($a);


$date_id = new Zend_Date(Zend_Date::ISO_8601);


        $validation_quittance = new Application_Model_EuValidationQuittance();
        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
			
            $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
            $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
            $validation_quittance->setValidation_quittance_utilisateur($_POST['id_utilisateur']);
            $validation_quittance->setValidation_quittance_livraison($compteur);
            $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $validation_quittance->setPublier(1);
            $validation_quittance_mapper->save($validation_quittance);

		include("Transfert.php");







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
	
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Bon de Salaire : BS'.ajoutezero($compteur).'</u></em></strong></td>
  </tr>';
		
  		/*if($utilisateur->code_membre != ""){

        $membre_morale = new Application_Model_EuMembreMorale();
        $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
        $membre_moraleM->find($utilisateur->code_membre, $membre_morale);
  
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Raison sociale </u>: </em><strong><em>'.$membre_morale->raison_sociale.'</em></strong></p></td>
  </tr>';
}*/
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Nom et Prénom(s) </u>: </em><strong><em>'.$membre->nom_membre.' '.$membre->prenom_membre.'</em></strong></p></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="4" align="right"><strong><em>Montant Bon de Salaire : '.number_format(($_POST['montant']), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center"><em><strong>Montant</strong></em></td>
  </tr>';
  
$htmlpdf .= '
  <tr style="background-color:#999;">
    <td align="left"><em><strong>Bon de Salaire de '.$membre->nom_membre.' '.$membre->prenom_membre.'</strong></em></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center"><em>'.number_format(($_POST['montant']), 0, ',', ' ').'</em></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="2" align="left"><em><u>Montant en  lettres </u>: '.lettre(($_POST['montant']), 50).' CFA</em></td>
    <td colspan="2" align="left">Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
  </tr>';	  
  
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
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
$filename = ''.Util_Utils::getParamEsmc(1).'/salaires.html';
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
if (!is_dir("pdf_salaire/")) {
mkdir("pdf_salaire/", 0777);
}
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "pdf_salaire/BONSALAIRE_".str_replace("/", "_", mettreaccents($compteur."_".$_POST['code_membre']))."_.html";
$newnom = "BONSALAIRE_".str_replace("/", "_", mettreaccents($compteur."_".$_POST['code_membre'])."_");
$newchemin = "pdf_salaire/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
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
$filena	= $newnom.'.pdf';

unlink($newfile);

	
		//$this->_redirect($file);




if($membre->email_membre != ""){

$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml("Bon de Salaire : BS".ajoutezero($compteur)." le ".$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($membre->email_membre, $membre->raison_sociale);
$mail->setSubject("Bon de Salaire : BS".ajoutezero($compteur)." le ".$date_id->toString('dd-MM-yyyy HH:mm')); 

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







                $this->_redirect('/administration/detailproposition/id/'.$_POST['appel']);



			
//$sessionmembre->errorlogin = "Validation de la livraison réussie ...";			
			
			/*}else {
$sessionmembre->errorlogin = "Validation de la livraison échouée ...";			
				}*/
			
	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

            $appel = (int)$this->_request->getParam('appel');
			
            $idm = (string)$this->_request->getParam('idm');
            $idu = (int)$this->_request->getParam('idu');
            if ($idm != 0 && $idu != 0) {
			
            $utilisateur = new Application_Model_EuUtilisateur();
            $m_utilisateur = new Application_Model_EuUtilisateurMapper();
            $m_utilisateur->find($idu, $utilisateur);
			
			$date = new Zend_Date(Zend_Date::ISO_8601);

            $membre = new Application_Model_EuMembre();
            $m_membre = new Application_Model_EuMembreMapper();
            $m_membre->find($idm, $membre);

		$this->view->utilisateur = $utilisateur;
		$this->view->membre = $membre;
		
		$this->view->appel = $appel;
            }
	}
		   
	} else {

            $appel = (int)$this->_request->getParam('appel');
			
            $idm = (string)$this->_request->getParam('idm');
            $idu = (int)$this->_request->getParam('idu');
            if ($idm != 0 && $idu != 0) {
			
            $utilisateur = new Application_Model_EuUtilisateur();
            $m_utilisateur = new Application_Model_EuUtilisateurMapper();
            $m_utilisateur->find($idu, $utilisateur);
			
			$date = new Zend_Date(Zend_Date::ISO_8601);

            $membre = new Application_Model_EuMembre();
            $m_membre = new Application_Model_EuMembreMapper();
            $m_membre->find($idm, $membre);

		$this->view->utilisateur = $utilisateur;
		$this->view->membre = $membre;
		
		$this->view->appel = $appel;
            }
	}
	}





    
    public function addbanqueAction() {
		$sessionutilisateur = new Zend_Session_Namespace ( "utilisateur" );
		if (! isset ( $sessionutilisateur->login )) {
			$this->_redirect ( '/administration/login' );
		}
		$this->_helper->layout ()->setLayout ( 'layoutpublic' );
		$request = $this->getRequest ();
		$db = Zend_Db_Table::getDefaultAdapter ();
		$m_banque = new Application_Model_EuBanqueMapper ();
		$rows = $m_banque->fetchAll ();
		$date = new Zend_Date ( Zend_Date::ISO_8601 );
		if ($request->isPost ()) {
			$nom = $request->getParam ( "nom_banque_user" );
			$prenom = $request->getParam ( "prenom_banque_user" );
			$login = $request->getParam ( "login_banque_user" );
			$pwd = $request->getParam ( "pwd_banque_user" );
			$pwd_confirm = $request->getParam ( "c_pwd_banque_user" );
			$banque = $request->getParam ( "code_banque" );
			$role = $request->getParam ( "role" );
			if (strcmp ( $pwd, $pwd_confirm ) == 0) {
				$db->beginTransaction ();
				try {
					$user_banque = new Application_Model_EuBanqueUser ();
					$m_user_banque = new Application_Model_EuBanqueUserMapper ();
					$user_banque->setActiver ( 1 );
					$user_banque->setCodeBanque ( $banque );
					$user_banque->setLoginBanqueUser ( $login );
					$user_banque->setNomBanqueUser ( $nom );
					$user_banque->setPrenomBanqueUser ( $prenom );
					$user_banque->setPwdBanqueUser ( $pwd );
					$user_banque->setPwdChanged ( 0 );
					$user_banque->setRole ( $role );
					$user_banque->setDateCreated ( $date->toString ( "yyyy-MM-dd" ) );
					$user_banque->setIdUtilisateur ( $sessionutilisateur->id_utilisateur );
					$m_user_banque->save ( $user_banque );
					$db->commit ();
					$this->view->rows = $rows;
					$this->_redirect ( "/administration/addbanque" );
				} catch ( Exception $e ) {
					$db->rollBack ();
					$this->view->nom = $nom;
					$this->view->prenom = $prenom;
					$this->view->code_banque = $banque;
					$this->view->login = $login;
					$this->view->pwd = $pwd;
					$this->view->pwd_confirm = $pwd_confirm;
					$this->view->role = $role;
					$this->view->rows = $rows;
					$this->view->message = "Echec d'ajout d'utilisateur; Erreur :" . $e->getMessage () . "->" . $e->getTraceAsString ();
					return;
				}
			} else {
				$this->view->message = "Les mot de passe ne corresondent pas!";
				$this->view->nom = $nom;
				$this->view->prenom = $prenom;
				$this->view->code_banque = $banque;
				$this->view->login = $login;
				$this->view->pwd = $pwd;
				$this->view->pwd_confirm = $pwd_confirm;
				$this->view->role = $role;
				$this->view->rows = $rows;
				return;
			}
		} else {
			$this->view->rows = $rows;
			return;
		}
	}
	
	
	
	public function listintegrateurAction()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $integrateur->fetchAllByPublier(0, $sessionutilisateur->code_agence);
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
			}else{
        //$this->view->entries = $integrateur->fetchAllByPublier(0, "");
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
				}

        $this->view->tabletri = 1;

    }




    public function listintegrateur1Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $integrateur->fetchAllByPublier(1, $sessionutilisateur->code_agence);
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
			}else{
        //$this->view->entries = $integrateur->fetchAllByPublier(1, "");
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
				}

        $this->view->tabletri = 1;

    }



    public function publierintegrateurAction()
    {
        /* page administration/publierintegrateur - Publier l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $integrateur = new Application_Model_EuIntegrateur();
        $integrateurM = new Application_Model_EuIntegrateurMapper();
        $integrateurM->find($id, $integrateur);
		
        $integrateur->setPublier($this->_request->getParam('publier'));
		$integrateurM->update($integrateur);
		
		
		
		
$id_integrateur = $integrateur->integrateur_id;
//////////////////////////////////////////
if($integrateur->integrateur_membreasso != 1){
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
$mail->setFrom(Util_Utils::getParamEsmc(3), $souscription->souscription_nom." ".$souscription->souscription_prenom);
$mail->addTo($souscription->souscription_email, $souscription->souscription_nom." ".$souscription->souscription_prenom);
$mail->setSubject('Formulaire Intégrateur : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send($tr);

	}


			
		
        }

		$this->_redirect('/administration/listintegrateur');
    }
	
	
	


	
	public function listoffreurprojetAction()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $offreur_projet = new Application_Model_EuOffreurProjetMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $offreur_projet->fetchAllByPublier(0, $sessionutilisateur->code_agence);
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
			}else{
        //$this->view->entries = $offreur_projet->fetchAllByPublier(0, "");
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
				}

        $this->view->tabletri = 1;

    }




    public function listoffreurprojet1Action()
    {
        /* page administration/listlivraison - Liste des livraisons */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $offreur_projet = new Application_Model_EuOffreurProjetMapper();
        if($sessionutilisateur->code_agence != "001001001001"){
        //$this->view->entries = $offreur_projet->fetchAllByPublier(1, $sessionutilisateur->code_agence);
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAgence($sessionutilisateur->code_agence);
			}else{
        //$this->view->entries = $offreur_projet->fetchAllByPublier(1, "");
        $agence = new Application_Model_EuAgenceMapper();
        $this->view->entries = $agence->fetchAllByAssociation();
				}

        $this->view->tabletri = 1;

    }

    public function publieroffreurprojetAction()
    {
        /* page administration/publieroffreur_projet - Publier l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $offreur_projet = new Application_Model_EuOffreurProjet();
        $offreur_projetM = new Application_Model_EuOffreurProjetMapper();
        $offreur_projetM->find($id, $offreur_projet);
		
        $offreur_projet->setPublier($this->_request->getParam('publier'));
		$offreur_projetM->update($offreur_projet);
		
		
		
		
$id_offreur_projet = $offreur_projet->offreur_projet_id;
//////////////////////////////////////////
if($offreur_projet->offreur_projet_membreasso != 1){
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
			
		
        }

		$this->_redirect('/administration/listoffreurprojet');
    }
	
	
	





    public function listsouscriptiontableaudebordAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if ((isset($_POST['souscription_type']) && $_POST['souscription_type']!="")
	 || (isset($_POST['souscription_banque']) && $_POST['souscription_banque']!="")
	  || (isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="")
	   || (isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']>0)
	    || (isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="")
		 || (isset($_POST['souscription_type_candidat']) && $_POST['souscription_type_candidat']>0)
		  || (isset($_POST['type_acteur']) && $_POST['type_acteur']!="")
		   || (isset($_POST['statut_juridique']) && $_POST['statut_juridique']!="")
		    || (isset($_POST['code_activite']) && $_POST['code_activite']>0)
			 || (isset($_POST['id_metier']) && $_POST['id_metier']>0)
			  || (isset($_POST['id_competence']) && $_POST['id_competence']>0)
			   || (isset($_POST['id_canton']) && $_POST['id_canton']>0)
			    || (isset($_POST['id_prefecture']) && $_POST['id_prefecture']>0)
				 || (isset($_POST['id_region']) && $_POST['id_region']>0)
				  || (isset($_POST['id_pays']) && $_POST['id_pays']>0)
				   || (isset($_POST['code_zone']) && $_POST['code_zone']!="")){


if (isset($_POST['souscription_type']) && $_POST['souscription_type']!=""){$souscription_type = $_POST['souscription_type'];}else{$souscription_type = "";}
if (isset($_POST['souscription_banque']) && $_POST['souscription_banque']!=""){$souscription_banque = $_POST['souscription_banque'];}else{$souscription_banque = "";}
if (isset($_POST['souscription_personne']) && $_POST['souscription_personne']!=""){$souscription_personne = $_POST['souscription_personne'];}else{$souscription_personne = "";}
if (isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']>0){$souscription_nombre = $_POST['souscription_nombre'];}else{$souscription_nombre = 0;}
if (isset($_POST['souscription_programme']) && $_POST['souscription_programme']!=""){$souscription_programme = $_POST['souscription_programme'];}else{$souscription_programme = "";}
if (isset($_POST['souscription_type_candidat']) && $_POST['souscription_type_candidat']>0){$souscription_type_candidat = $_POST['souscription_type_candidat'];}else{$souscription_type_candidat = 0;}
if (isset($_POST['type_acteur']) && $_POST['type_acteur']!=""){$code_type_acteur = $_POST['type_acteur'];}else{$code_type_acteur = "";}
if (isset($_POST['statut_juridique']) && $_POST['statut_juridique']!=""){$code_statut = $_POST['statut_juridique'];}else{$code_statut = "";}
if (isset($_POST['code_activite']) && $_POST['code_activite']>0){$code_activite = $_POST['code_activite'];}else{$code_activite = 0;}
if (isset($_POST['id_metier']) && $_POST['id_metier']>0){$id_metier = $_POST['id_metier'];}else{$id_metier = 0;}
if (isset($_POST['id_competence']) && $_POST['id_competence']>0){$id_competence = $_POST['id_competence'];}else{$id_competence = 0;}
if (isset($_POST['id_canton']) && $_POST['id_canton']>0){$id_canton = $_POST['id_canton'];}else{$id_canton = 0;}
if (isset($_POST['id_prefecture']) && $_POST['id_prefecture']>0){$id_prefecture = $_POST['id_prefecture'];}else{$id_prefecture = 0;}
if (isset($_POST['id_region']) && $_POST['id_region']>0){$id_region = $_POST['id_region'];}else{$id_region = 0;}
if (isset($_POST['id_pays']) && $_POST['id_pays']>0){$id_pays = $_POST['id_pays'];}else{$id_pays = 0;}
if (isset($_POST['code_zone']) && $_POST['code_zone']!=""){$code_zone = $_POST['code_zone'];}else{$code_zone = "";}





        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByTableauBord(3, $souscription_type, $souscription_banque, $souscription_personne, $souscription_nombre, $souscription_programme, $souscription_type_candidat, $code_type_acteur, $code_statut, $code_activite, $id_metier, $id_competence, $id_canton, $id_prefecture, $id_region, $id_pays, $code_zone);

        $this->view->entriestotal = $souscription->fetchAllByTableauBordTotal(3, $souscription_type, $souscription_banque, $souscription_personne, $souscription_nombre, $souscription_programme, $souscription_type_candidat, $code_type_acteur, $code_statut, $code_activite, $id_metier, $id_competence, $id_canton, $id_prefecture, $id_region, $id_pays, $code_zone);
	}
	}
        $this->view->tabletri = 1;

    }











    public function listsouscriptiontableaudebordreactivationAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if ((isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="")
		  || (isset($_POST['type_acteur']) && $_POST['type_acteur']!="")
		   || (isset($_POST['statut_juridique']) && $_POST['statut_juridique']!="")
		    || (isset($_POST['code_activite']) && $_POST['code_activite']>0)
			 || (isset($_POST['id_metier']) && $_POST['id_metier']>0)
			  || (isset($_POST['id_competence']) && $_POST['id_competence']>0)
			   || (isset($_POST['id_canton']) && $_POST['id_canton']>0)
			    || (isset($_POST['id_prefecture']) && $_POST['id_prefecture']>0)
				 || (isset($_POST['id_region']) && $_POST['id_region']>0)
				  || (isset($_POST['id_pays']) && $_POST['id_pays']>0)
				   || (isset($_POST['code_zone']) && $_POST['code_zone']!="")){


if (isset($_POST['souscription_type']) && $_POST['souscription_type']!=""){$souscription_type = $_POST['souscription_type'];}else{$souscription_type = "";}
if (isset($_POST['souscription_banque']) && $_POST['souscription_banque']!=""){$souscription_banque = $_POST['souscription_banque'];}else{$souscription_banque = "";}
if (isset($_POST['souscription_personne']) && $_POST['souscription_personne']!=""){$souscription_personne = $_POST['souscription_personne'];}else{$souscription_personne = "";}
if (isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']>0){$souscription_nombre = $_POST['souscription_nombre'];}else{$souscription_nombre = 0;}
if (isset($_POST['souscription_programme']) && $_POST['souscription_programme']!=""){$souscription_programme = $_POST['souscription_programme'];}else{$souscription_programme = "";}
if (isset($_POST['souscription_type_candidat']) && $_POST['souscription_type_candidat']>0){$souscription_type_candidat = $_POST['souscription_type_candidat'];}else{$souscription_type_candidat = 0;}
if (isset($_POST['type_acteur']) && $_POST['type_acteur']!=""){$code_type_acteur = $_POST['type_acteur'];}else{$code_type_acteur = "";}
if (isset($_POST['statut_juridique']) && $_POST['statut_juridique']!=""){$code_statut = $_POST['statut_juridique'];}else{$code_statut = "";}
if (isset($_POST['code_activite']) && $_POST['code_activite']>0){$code_activite = $_POST['code_activite'];}else{$code_activite = 0;}
if (isset($_POST['id_metier']) && $_POST['id_metier']>0){$id_metier = $_POST['id_metier'];}else{$id_metier = 0;}
if (isset($_POST['id_competence']) && $_POST['id_competence']>0){$id_competence = $_POST['id_competence'];}else{$id_competence = 0;}
if (isset($_POST['id_canton']) && $_POST['id_canton']>0){$id_canton = $_POST['id_canton'];}else{$id_canton = 0;}
if (isset($_POST['id_prefecture']) && $_POST['id_prefecture']>0){$id_prefecture = $_POST['id_prefecture'];}else{$id_prefecture = 0;}
if (isset($_POST['id_region']) && $_POST['id_region']>0){$id_region = $_POST['id_region'];}else{$id_region = 0;}
if (isset($_POST['id_pays']) && $_POST['id_pays']>0){$id_pays = $_POST['id_pays'];}else{$id_pays = 0;}
if (isset($_POST['code_zone']) && $_POST['code_zone']!=""){$code_zone = $_POST['code_zone'];}else{$code_zone = "";}





        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByTableauBordReactivation(3, $souscription_type, $souscription_banque, $souscription_personne, $souscription_nombre, $souscription_programme, $souscription_type_candidat, $code_type_acteur, $code_statut, $code_activite, $id_metier, $id_competence, $id_canton, $id_prefecture, $id_region, $id_pays, $code_zone);

        $this->view->entriestotal = $souscription->fetchAllByTableauBordReactivationTotal(3, $souscription_type, $souscription_banque, $souscription_personne, $souscription_nombre, $souscription_programme, $souscription_type_candidat, $code_type_acteur, $code_statut, $code_activite, $id_metier, $id_competence, $id_canton, $id_prefecture, $id_region, $id_pays, $code_zone);
	}
	}
        $this->view->tabletri = 1;

    }









    public function editsouscriptionAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            			$id = (int)$this->_request->getParam('id');
	
	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		    if (isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" 
			    && isset($_POST['souscription_autonome']) && $_POST['souscription_autonome']!="" 
				&& isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" 
				&& isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="" 
				//&& isset($_POST['code_activite']) && $_POST['code_activite']!="" 
				&& isset($_POST['souscription_type']) && $_POST['souscription_type']!="" 
				&& isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="" 
				&& isset($_POST['souscription_date_numero']) && $_POST['souscription_date_numero']!="" 
				&& isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']!="" 
				&& isset($_POST['souscription_montant']) && $_POST['souscription_montant']!="") {
		
		            /*$db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
					try {*/
						
						$eusouscription = new Application_Model_DbTable_EuSouscription();
	                    $select = $eusouscription->select()
													->where('souscription_id != ?',$_POST['souscription_id'])
													->where('souscription_login = ?',$_POST['souscription_login'])
													->where('souscription_passe = ?',$_POST['souscription_passe']);
	                    if ($rowseusouscription = $eusouscription->fetchRow($select) && $_POST['souscription_login'] != "") {
                            $sessionutilisateur->error = "Login déjà existant ...";
		 
            $id = $_POST['souscription_id'];
            if ($id != 0) {
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		$this->view->souscription = $a;
            }
	                    }  else if($_POST['souscription_passe'] != $_POST['confirme']) {
                            $sessionutilisateur->error = "Mot de passe incorret ...";
		 
            $id = $_POST['souscription_id'];
            if ($id != 0) {
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		$this->view->souscription = $a;
            }
	                    } else {
						    $date_id = Zend_Date::now();

                            $souscription = new Application_Model_EuSouscription();
                            $souscription_mapper = new Application_Model_EuSouscriptionMapper();
							$souscription_mapper->find($_POST['souscription_id'], $souscription);
		
		                    include("Transfert.php");
		                    if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!="") {
		                        $chemin	= "souscriptions";
		                        $file = $_FILES['souscription_vignette']['name'];
		                        $file1='souscription_vignette';
		                        $souscription_vignette = $chemin."/".transfert($chemin,$file1);
							} else {$souscription_vignette = $_POST['souscription_vignetteold'];}
							
							
							

							//$compteur_souscription = $souscription_mapper->findConuter() + 1;
                            //$souscription->setSouscription_id($compteur_souscription);
                            $souscription->setSouscription_personne($_POST['souscription_personne']);
			                if($_POST['souscription_personne'] == "PP") {
                                $souscription->setSouscription_nom($_POST['souscription_nom']);
                                $souscription->setSouscription_prenom($_POST['souscription_prenom']);
			                } else {
                                $souscription->setSouscription_raison($_POST['souscription_raison']);
                                $souscription->setCode_type_acteur($_POST['type_acteur']);
                                $souscription->setCode_statut($_POST['statut_juridique']);
			                }
                            $souscription->setSouscription_email($_POST['souscription_email']);
                            $souscription->setSouscription_mobile($_POST['souscription_mobile']);
                            //$souscription->setSouscription_membreasso(1);
                            $souscription->setSouscription_type($_POST['souscription_type']);
                            $souscription->setSouscription_numero($_POST['souscription_numero']);
                            $souscription->setSouscription_date_numero($_POST['souscription_date_numero']);
			                if($_POST['souscription_type'] == "Banque") {
                                $souscription->setSouscription_banque($_POST['souscription_banque']);
			                }
                            $souscription->setSouscription_montant($_POST['souscription_montant']);
                            $souscription->setSouscription_nombre($_POST['souscription_nombre']);
                            $souscription->setSouscription_programme($_POST['souscription_programme']);
                            $souscription->setSouscription_type_candidat($_POST['souscription_type_candidat']);
                            
                            //$souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $souscription->setSouscription_vignette($souscription_vignette);
                            //$souscription->setCode_activite($_POST['code_activite']);
                            //$souscription->setId_metier($_POST['id_metier']);
                            //$souscription->setId_competence($_POST['id_competence']);
                            $souscription->setSouscription_ville($_POST['souscription_ville']);
                            $souscription->setSouscription_quartier($_POST['souscription_quartier']);
			                if($_POST['souscription_programme'] == "CMFH") {
                                $souscription->setSouscription_login($_POST['souscription_login']);
                                $souscription->setSouscription_passe($_POST['souscription_passe']);
			                }
			                /*if($souscription_ok == 1) {
                                $souscription->setSouscription_souscription($souscription_first);
				            } else {
                                $souscription->setSouscription_souscription($compteur_souscription);
					        }*/
            
                            $souscription->setSouscription_autonome($_POST['souscription_autonome']);
			                $souscription->setPublier(0);
							$souscription->setId_canton($_POST['id_canton']);
                            $souscription_mapper->update($souscription);
							
							
							///////////////////////////////////////////////////////////////////////////////////////
							
                            $recubancaire1_mapper = new Application_Model_EuRecubancaireMapper();
							$recubancaire1 = $recubancaire1_mapper->fetchAllBySouscriptionOne($_POST['souscription_id']);
							$recubancaire = new Application_Model_EuRecubancaire();
                            $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
							$recubancaire_mapper->find($recubancaire1->recubancaire_id, $recubancaire);

                            //$compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
                            //$recubancaire->setRecubancaire_id($compteur_recubancaire);
                            $recubancaire->setRecubancaire_type($_POST['souscription_type']);
                            $recubancaire->setRecubancaire_numero($_POST['souscription_numero']);
                            $recubancaire->setRecubancaire_date_numero($_POST['souscription_date_numero']);
			                if($_POST['souscription_type'] == "Banque") {
                                $recubancaire->setRecubancaire_banque($_POST['souscription_banque']);
			                }
                            $recubancaire->setRecubancaire_montant($_POST['souscription_montant']);
                            $recubancaire->setRecubancaire_vignette($souscription_vignette);
                            //$recubancaire->setRecubancaire_souscription($compteur_souscription);
			                $recubancaire->setPublier(1);
                            $recubancaire_mapper->update($recubancaire);
							
$sessionutilisateur->error = "Opération bien effectuée ...";

if($sessionutilisateur->code_groupe == "agrement_acnev"){
		$this->_redirect('/administration/listsouscriptionerreur/publier/0');
}else if($sessionutilisateur->code_groupe == "agrement_filiere"){
		$this->_redirect('/administration/listsouscriptionerreur/publier/1');
}else if($sessionutilisateur->code_groupe == "agrement_technopole"){
		$this->_redirect('/administration/listsouscriptionerreur/publier/2');
}else{
		$this->_redirect('/administration/listsouscriptionerreur');
	}

								
								
		
						}
		
		            /*}  catch (Exception $exc) {
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($_POST['souscription_id'], $a);
		$this->view->souscription = $a;
                        $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();  
		                $this->_redirect('/administration/editsouscription/id/'.$id);
                        return;
                    }*/
			
		} else {  $sessionutilisateur->error = "Champs * obligatoire ..."; 
		 
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







    public function listpayementcommissionAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
        $this->view->entries = $payement_commission_mapper->fetchAllByPeriode($debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
	} else {
        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
        $this->view->entries = $payement_commission_mapper->fetchAllByPeriode("", "");
	}
	}

        $this->view->tabletri = 1;


    }




    public function listpayementcommission2Action()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
        $this->view->entries = $payement_commission_mapper->fetchAllByPeriode2($debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
	} else {
        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
        $this->view->entries = $payement_commission_mapper->fetchAllByPeriode2("", "");
	}
	}

        $this->view->tabletri = 1;


    }


    public function payerpayementcommissionAction()
    {
        /* page administration/payerpayementcommission - Publier l'appel d'offre suite à la demande de BPS */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublic');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $date_id = Zend_Date::now();

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $payementcommission = new Application_Model_EuPayementCommission();
        $payementcommissionM = new Application_Model_EuPayementCommissionMapper();
        $payementcommissionM->find($id, $payementcommission);
		
        $payementcommission->setPayement_commission_date_payer($date_id->toString('yyyy-MM-dd'));
        $payementcommission->setPayement_commission_payer($this->_request->getParam('payer'));
		$payementcommissionM->update($payementcommission);
		
		
if($payementcommission->payement_commission_type == 1){
	
        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($payementcommission->membreasso_id, $membreasso);
	  
        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($membreasso->membreasso_association, $association);

        $partagea = new Application_Model_EuPartageaMapper();
        $partage = $partagea->fetchAllByCommissionSouscription($association->association_id, $payementcommission->payement_commission_date_debut, $payementcommission->payement_commission_date_fin);
		
		$montant = $payementcommission->payement_commission_montant;
		foreach ($partage as $entry){
			if($montant >= $entry->partagea_montant){
        $partageaa = new Application_Model_EuPartagea();
        $partageaaM = new Application_Model_EuPartageaMapper();
        $partageaaM->find($entry->partagea_id, $partageaa);
		
        $partageaa->setPartagea_montant_utilise($partageaa->partagea_montant_utilise + $entry->partagea_montant);
        $partageaa->setPartagea_montant_solde($partageaa->partagea_montant_solde - $entry->partagea_montant);
		$partageaaM->update($partageaa);
		
				$montant -= $entry->partagea_montant;
				
				}else if($montant == 0){
					break;
				
				}else if($montant < $entry->partagea_montant){
					
        $partageaa = new Application_Model_EuPartagea();
        $partageaaM = new Application_Model_EuPartageaMapper();
        $partageaaM->find($entry->partagea_id, $partageaa);
		
        $partageaa->setPartagea_montant_utilise($partageaa->partagea_montant_utilise + $montant);
        $partageaa->setPartagea_montant_solde($partageaa->partagea_montant_solde - $montant);
		$partageaaM->update($partageaa);
		break;
					}
			
			}
		
		
		
		
	}else if($payementcommission->payement_commission_type == 2){
        $partagem = new Application_Model_EuPartagemMapper();
        $partage = $partagem->fetchAllByCommissionSouscription($payementcommission->membreasso_id, $payementcommission->payement_commission_date_debut, $payementcommission->payement_commission_date_fin);
		
		$montant = $payementcommission->payement_commission_montant;
		foreach ($partage as $entry){
			if($montant >= $entry->partagem_montant){
        $partagemm = new Application_Model_EuPartagem();
        $partagemmM = new Application_Model_EuPartagemMapper();
        $partagemmM->find($entry->partagem_id, $partagemm);
		
        $partagemm->setPartagem_montant_utilise($partagemm->partagem_montant_utilise + $entry->partagem_montant);
        $partagemm->setPartagem_montant_solde($partagemm->partagem_montant_solde - $entry->partagem_montant);
		$partagemmM->update($partagemm);
		
				$montant -= $entry->partagem_montant;
				
				}else if($montant == 0){
					break;
				
				}else if($montant < $entry->partagem_montant){
					
        $partagemm = new Application_Model_EuPartagem();
        $partagemmM = new Application_Model_EuPartagemMapper();
        $partagemmM->find($entry->partagem_id, $partagemm);
		
        $partagemm->setPartagem_montant_utilise($partagemm->partagem_montant_utilise + $montant);
        $partagemm->setPartagem_montant_solde($partagemm->partagem_montant_solde - $montant);
		$partagemmM->update($partagemm);
		break;
					}
			
			}
		

		}
		
		
		
        }

		$this->_redirect('/administration/listpayementcommission');
    }







    public function transfertpartagemontantAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


        $partagea = new Application_Model_EuPartageaMapper();
        $partage = $partagea->fetchAll();
		foreach ($partage as $entry){
        $partageaa = new Application_Model_EuPartagea();
        $partageaaM = new Application_Model_EuPartageaMapper();
        $partageaaM->find($entry->partagea_id, $partageaa);
		
        $partageaa->setPartagea_montant_utilise(0);
        $partageaa->setPartagea_montant_solde($partageaa->partagea_montant);
		$partageaaM->update($partageaa);
		}



        $partagem = new Application_Model_EuPartagemMapper();
        $partage = $partagem->fetchAll();
		foreach ($partage as $entry){
        $partagemm = new Application_Model_EuPartagem();
        $partagemmM = new Application_Model_EuPartagemMapper();
        $partagemmM->find($entry->partagem_id, $partagemm);
		
        $partagemm->setPartagem_montant_utilise(0);
        $partagemm->setPartagem_montant_solde($partagemm->partagem_montant);
		$partagemmM->update($partagemm);
		}



    }






    public function transfertpayementcommissionAction()
    {
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


$tableau1 = array("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Auml;", "&Aring;", "&Ccedil;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", "&Igrave;", "&Iacute;", "&Icirc;", "&Iuml;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Ugrave;", "&Uacute;", "&Ucirc;", "&Uuml;", "&agrave;", "&aacute;", "&acirc;", "&atilde;", "&auml;", "&aring;", "&ccedil;", "&egrave;", "&eacute;", "&ecirc;", "&euml;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&ugrave;", "&uacute;", "&ucirc;", "&uuml;");

$tableau2 = array("À", "Á", "Â", "Ã", "Ä", "Å", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ò", "Ó", "Ô", "Õ", "Ö", "Ù", "Ú", "Û", "Ü", "à", "á", "â", "ã", "ä", "å", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ð", "ò", "ó", "ô", "õ", "ö", "ù", "ú", "û", "ü");

//$newphrase = str_replace($tableau1, $tableau2, $phrase);

        $date_id = Zend_Date::now();

$fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
$lines = file($fichier);
	
foreach ($lines as $line_num => $line) {

list($nom, $mont) = explode(";", $line);

$nom = trim(str_replace($tableau2, $tableau1, $nom));

        $membreasso_m = new Application_Model_EuMembreassoMapper();
        $membreasso = $membreasso_m->fetchAllByRechercheMembre($nom);
		if($membreasso->membreasso_id > 0){
					

        $payement_commission = new Application_Model_EuPayementCommission();
        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
			
            $compteur_payement_commission = $payement_commission_mapper->findConuter() + 1;
            $payement_commission->setPayement_commission_id($compteur_payement_commission);
	        $payement_commission->setPayement_commission_montant($mont);
            $payement_commission->setPayement_commission_date_demande($date_id->toString('yyyy-MM-dd'));
            $payement_commission->setPayement_commission_demande(1);
	        $payement_commission->setPayement_commission_payer(1);
			$payement_commission->setPayement_commission_date_payer($date_id->toString('yyyy-MM-dd'));
			$payement_commission->setPayement_commission_date_debut($date_debut);
			$payement_commission->setPayement_commission_date_fin($date_fin);
			$payement_commission->setMembreasso_id($membreasso->membreasso_id);
			$payement_commission->setId_type_commission(1);
			$payement_commission->setId_mode_payement(1);
			$payement_commission->setPayement_commission_type(2);
            $payement_commission_mapper->save($payement_commission);
			
			
        $payementcommission = new Application_Model_EuPayementCommission();
        $payementcommissionM = new Application_Model_EuPayementCommissionMapper();
        $payementcommissionM->find($compteur_payement_commission, $payementcommission);
		
			
			
        $partagem = new Application_Model_EuPartagemMapper();
        $partage = $partagem->fetchAllByCommissionSouscription($payementcommission->membreasso_id, $payementcommission->payement_commission_date_debut, $payementcommission->payement_commission_date_fin);
		
		$montant = $payementcommission->payement_commission_montant;
		foreach ($partage as $entry){
			if($montant >= $entry->partagem_montant){
        $partagemm = new Application_Model_EuPartagem();
        $partagemmM = new Application_Model_EuPartagemMapper();
        $partagemmM->find($entry->partagem_id, $partagemm);
		
        $partagemm->setPartagem_montant_utilise($partagemm->partagem_montant_utilise + $entry->partagem_montant);
        $partagemm->setPartagem_montant_solde($partagemm->partagem_montant_solde - $entry->partagem_montant);
		$partagemmM->update($partagemm);
		
				$montant -= $entry->partagem_montant;
				
				}else if($montant == 0){
					break;
				
				}else if($montant < $entry->partagem_montant){
					
        $partagemm = new Application_Model_EuPartagem();
        $partagemmM = new Application_Model_EuPartagemMapper();
        $partagemmM->find($entry->partagem_id, $partagemm);
		
        $partagemm->setPartagem_montant_utilise($partagemm->partagem_montant_utilise + $montant);
        $partagemm->setPartagem_montant_solde($partagemm->partagem_montant_solde - $montant);
		$partagemmM->update($partagemm);
		break;
					}
			
			}
			
			}
		







        $association_m = new Application_Model_EuAssociationMapper();
        $association = $association_m->fetchAllByRechercheAssociation($nom);
		if($association->association_id > 0){
			
        $membreasso_m = new Application_Model_EuMembreassoMapper();
        $membreasso = $membreasso_m->fetchAllByAssociation($association->association_id);
					

        $payement_commission = new Application_Model_EuPayementCommission();
        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
			
            $compteur_payement_commission = $payement_commission_mapper->findConuter() + 1;
            $payement_commission->setPayement_commission_id($compteur_payement_commission);
	        $payement_commission->setPayement_commission_montant($mont);
            $payement_commission->setPayement_commission_date_demande($date_id->toString('yyyy-MM-dd'));
            $payement_commission->setPayement_commission_demande(1);
	        $payement_commission->setPayement_commission_payer(1);
			$payement_commission->setPayement_commission_date_payer($date_id->toString('yyyy-MM-dd'));
			$payement_commission->setPayement_commission_date_debut($date_debut);
			$payement_commission->setPayement_commission_date_fin($date_fin);
			$payement_commission->setMembreasso_id($membreasso->membreasso_id);
			$payement_commission->setId_type_commission(1);
			$payement_commission->setId_mode_payement(1);
			$payement_commission->setPayement_commission_type(1);
            $payement_commission_mapper->save($payement_commission);
			
			
        $payementcommission = new Application_Model_EuPayementCommission();
        $payementcommissionM = new Application_Model_EuPayementCommissionMapper();
        $payementcommissionM->find($compteur_payement_commission, $payementcommission);
		
			
        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($payementcommission->membreasso_id, $membreasso);
	  
        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($membreasso->membreasso_association, $association);

			
        $partagea = new Application_Model_EuPartageaMapper();
        $partage = $partagea->fetchAllByCommissionSouscription($association->association_id, $payementcommission->payement_commission_date_debut, $payementcommission->payement_commission_date_fin);
		
		$montant = $payementcommission->payement_commission_montant;
		foreach ($partage as $entry){
			if($montant >= $entry->partagea_montant){
        $partageaa = new Application_Model_EuPartagea();
        $partageaaM = new Application_Model_EuPartageaMapper();
        $partageaaM->find($entry->partagea_id, $partageaa);
		
        $partageaa->setPartagea_montant_utilise($partageaa->partagea_montant_utilise + $entry->partagea_montant);
        $partageaa->setPartagea_montant_solde($partageaa->partagea_montant_solde - $entry->partagea_montant);
		$partageaaM->update($partageaa);
		
				$montant -= $entry->partagea_montant;
				
				}else if($montant == 0){
					break;
				
				}else if($montant < $entry->partagea_montant){
					
        $partageaa = new Application_Model_EuPartagea();
        $partageaaM = new Application_Model_EuPartageaMapper();
        $partageaaM->find($entry->partagea_id, $partageaa);
		
        $partageaa->setPartagea_montant_utilise($partageaa->partagea_montant_utilise + $montant);
        $partageaa->setPartagea_montant_solde($partageaa->partagea_montant_solde - $montant);
		$partageaaM->update($partageaa);
		break;
					}
			
			}
			
			}
		






}









    }








}

