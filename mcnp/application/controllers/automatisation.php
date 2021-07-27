<?php 
function validation_automatique($id_souscription){
 ini_set('memory_limit', '512M');

$id_utilisateur_acnev = 1;
$id_utilisateur_filiere = 2;
$id_utilisateur_technopole = 3;

								$souscription = new Application_Model_EuSouscription();
								$souscriptionM = new Application_Model_EuSouscriptionMapper();
								$souscriptionM->find($id_souscription, $souscription);

								$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
								if($relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($souscription->souscription_banque, $souscription->souscription_numero, $souscription->souscription_date_numero)){



$date_id = new Zend_Date(Zend_Date::ISO_8601);

//////validation acnev
								$souscription = new Application_Model_EuSouscription();
								$souscriptionM = new Application_Model_EuSouscriptionMapper();
								$souscriptionM->find($id_souscription, $souscription);
								
								$souscription->setPublier(1);
								$souscriptionM->update($souscription);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
												$validation_quittance->setValidation_quittance_souscription($souscription->souscription_id);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);




//////validation filere
								$souscription = new Application_Model_EuSouscription();
								$souscriptionM = new Application_Model_EuSouscriptionMapper();
								$souscriptionM->find($id_souscription, $souscription);
								
								$souscription->setPublier(2);
								$souscriptionM->update($souscription);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
												$validation_quittance->setValidation_quittance_souscription($souscription->souscription_id);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);




//////validation technopole
								$souscription = new Application_Model_EuSouscription();
								$souscriptionM = new Application_Model_EuSouscriptionMapper();
								$souscriptionM->find($id_souscription, $souscription);
								
								$souscription->setPublier(3);
								$souscriptionM->update($souscription);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
												$validation_quittance->setValidation_quittance_souscription($souscription->souscription_id);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);



//include("Transfert.php");


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
		
		
		
		/*if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			if($souscription->souscription_programme == "KACM"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}
			
		}else{*/
			
			if($souscription->souscription_programme == "KACM"){
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
				}else{
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
					}
			
		//}
			
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
								$souscriptionM->find($id_souscription, $souscription);
								
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

								
								$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
								if($relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($souscription->souscription_banque, $souscription->souscription_numero, $souscription->souscription_date_numero)){
		
								$relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
								$relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
								$relevebancairedetail2M->find($relevebancairedetail->relevebancairedetail_id, $relevebancairedetail2);
								
								$relevebancairedetail2->setPublier(1);
								$relevebancairedetail2M->update($relevebancairedetail2);
								}
				






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

$newfile = "../../webfiles/pdf_souscription/SOUSCRIPTION_".($souscription->souscription_id)."_.html";
$newnom = "SOUSCRIPTION_".($souscription->souscription_id)."_";
$newchemin = "../../webfiles/pdf_souscription/";

copy($file, $newfile);

				ob_start();
				include(dirname(__FILE__).'/../'.$newfile);
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
$filena = $newnom.'.pdf';

unlink($newfile);





								//$this->_redirect(str_replace("../../webfiles/", "http://webfiles.gacsource.net/", $file));
								$membreasso = new Application_Model_EuMembreasso();
								$membreassoM = new Application_Model_EuMembreassoMapper();
								$membreassoM->find($souscription->souscription_membreasso, $membreasso);
								
								$association = new Application_Model_EuAssociation();
								$associationM = new Application_Model_EuAssociationMapper();
								$associationM->find($membreasso->membreasso_association, $association);



if($association->association_email != ""){
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

}





if($membreasso->membreasso_email != ""){
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
}




			if($souscription->souscription_programme == "CMFH"){
				
$html .= "<br />";
$html .= "Voici votre Login et Mot de passe qui vous permettent de vous connecter &acirc; votre espace d'int&eacute;grateur. Veuillez vous int&eacute;grer selon le type d'int&eacute;grateur qui vous convient.";
//$html .= "<br />";
//$html .= "Connectez vous ici : <a href='http://prod.esmcgacsource.com/souscription/login'>Connexion Souscription</a>";
$html .= "<br />";
$html .= "Login : ".$souscription->souscription_login."<br />";
$html .= "<br />";
$html .= "Mot de passe : ".$souscription->souscription_passe."<br />";
$html .= "<br />";

/*if(isset($souscription->souscription_mobilisateur) && $souscription->souscription_mobilisateur == 1){
$html .= "Vous avez sélectionner l'option Mobilisateur donc utilisez les mêmes Login et Mot de passe pour vous connecter à votre espace Agrément OSE/OE pour pouvoir souscrire d'autres personnes.";
$html .= "<br />";
$html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/integrateur/login'>Connexion Agrément OSE/OE</a>";
$html .= "<br />";
}*/

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



    


    function transfertNumeroSouscription() {
 ini_set('memory_limit', '512M');
		
        $souscription = new Application_Model_EuSouscriptionMapper();
        $entries = $souscription->fetchAll();

foreach ($entries as $entry):


//////////////////////////////////////////
			
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
		
            $compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
            $recubancaire->setRecubancaire_id($compteur_recubancaire);
            $recubancaire->setRecubancaire_type($entry->souscription_type);
            $recubancaire->setRecubancaire_numero($entry->souscription_numero);
            $recubancaire->setRecubancaire_date_numero($entry->souscription_date_numero);
			if($entry->souscription_type == "Banque"){
            $recubancaire->setRecubancaire_banque($entry->souscription_banque);
			}
            $recubancaire->setRecubancaire_montant($entry->souscription_montant);
            $recubancaire->setRecubancaire_vignette($entry->souscription_vignette);
            $recubancaire->setRecubancaire_souscription($entry->souscription_id);
			$recubancaire->setPublier(1);
            $recubancaire_mapper->save($recubancaire);
			
endforeach;
    }


}







function codegenerer($id){
 ini_set('memory_limit', '512M');

        $date_id = Zend_Date::now();

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);

        //$mas = new Application_Model_EuMembretiersMapper();
		//$as = $mas->fetchAllBySouscription($id);		
		//count($as) - 
		
		if($souscription->souscription_autonome == 1){
		$nombre = $souscription->souscription_nombre - $souscription->souscription_autonome;
			}else{
		$nombre = $souscription->souscription_nombre;
				}
				
				$htmltxt = "Voici vos codes d'activation de compte marchant
				
				";
				$htmltxt2 = "Voici vos codes d'activation de compte marchant";
				
		for($i = 0; $i < $nombre; $i++){
			
			$membretierscode_code = strtoupper(Util_Utils::genererCodeSMS(8));
			
        $membretierscode = new Application_Model_EuMembretierscode();
        $membretierscode_mapper = new Application_Model_EuMembretierscodeMapper();
            $compteur_membretierscode = $membretierscode_mapper->findConuter() + 1;
            $membretierscode->setMembretierscode_id($compteur_membretierscode);
            $membretierscode->setMembretierscode_membretiers(0);
            $membretierscode->setMembretierscode_code($membretierscode_code);
            $membretierscode->setMembretierscode_souscription($souscription->souscription_id);
            $membretierscode->setPublier(0);
            $membretierscode->setCode_membre(NULL);
            $membretierscode_mapper->save($membretierscode);

				$htmltxt .= '
				'.$membretierscode_code.'
				';
			}



if($souscription->souscription_email != ""){

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/codesgeneres.txt';
$somecontent = $htmltxt;

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
if (!is_dir("txt_codesgeneres/")) {
mkdir("txt_codesgeneres/", 0777);
}

$newfile = "txt_codesgeneres/CODES_GENERES_".($souscription->souscription_id)."_.txt";
$newnom = "CODES_GENERES_".($souscription->souscription_id)."_";
$newchemin = "txt_codesgeneres/";

copy($file, $newfile);


$file = $newchemin.$newnom.'.txt';
$filena	= $newnom.'.txt';

$config = array('auth' => 'login',
																'username' => Util_Utils::getParamEsmc(3),
																'password' => Util_Utils::getParamEsmc(4));
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);        
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($htmltxt2);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($souscription->souscription_email, $souscription->souscription_nom." ".$souscription->souscription_prenom);
$mail->setSubject('Liste des codes d\'activation de compte marchand : '.$date_id->toString('dd-MM-yyyy HH:mm'));

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


function recupcodegenerer($id)  {

      ini_set('memory_limit','512M');
      $date_id = Zend_Date::now();
	  
	  $souscription = new Application_Model_EuSouscription();
      $souscriptionM = new Application_Model_EuSouscriptionMapper();
      $souscriptionM->find($id,$souscription);

      $membretierscode = new Application_Model_EuMembretierscodeMapper();
      $entriesmembretierscode = $membretierscode->fetchAllBySouscription($id);
		
	  $htmltxt = "Voici  vos codes d'activation de compte marchand";
	  $htmltxt2 = "Voici vos codes d'activation de compte marchand";
				
      foreach ($entriesmembretierscode as $entrymembretierscode) {
	     $htmltxt .= ''.$entrymembretierscode->membretierscode_code.'';
	  }
	  
	  if($souscription->souscription_email != "")   {
          ////////////////////////////////////////////////////////////////////////////////
          $filename = ''.Util_Utils::getParamEsmc(1).'/codesgeneres.txt';
          $somecontent = $htmltxt;

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
        if (!is_dir("txt_codesgeneres/")) {
           mkdir("txt_codesgeneres/", 0777);
        }

        $newfile = "txt_codesgeneres/CODES_GENERES_".($souscription->souscription_id)."_.txt";
        $newnom = "CODES_GENERES_".($souscription->souscription_id)."_";
        $newchemin = "txt_codesgeneres/";

        copy($file, $newfile);

        $file = $newchemin.$newnom.'.txt';
        $filena	= $newnom.'.txt';

        $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
	
        $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
        Zend_Mail::setDefaultTransport($tr);        
        $mail = new Zend_Mail();
        //$mail->setBodyText('Mon texte de test');
        $mail->setBodyHtml($htmltxt2);
        $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
        $mail->addTo($souscription->souscription_email, $souscription->souscription_nom." ".$souscription->souscription_prenom);
        $mail->setSubject('Liste des codes d\'activation de compte marchand : '.$date_id->toString('dd-MM-yyyy HH:mm'));

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






function codegenerer_envoyer() {
 ini_set('memory_limit', '512M');

        $date_id = Zend_Date::now();
		
        $depot_vente = new Application_Model_EuDepotVenteMapper();
        $entries = $depot_vente->fetchAll();

foreach ($entries as $entry) {

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($entry->souscription_id, $souscription);

        $membretierscode = new Application_Model_EuMembretierscodeMapper();
        $entriesmembretierscode = $membretierscode->fetchAllBySouscription($entry->souscription_id);
		
				$htmltxt = "Voici vos codes d'activation de compte marchant
				
				";
				$htmltxt2 = "Voici vos codes d'activation de compte marchant";
				
foreach ($entriesmembretierscode as $entrymembretierscode){
			
				$htmltxt .= '
				'.$entrymembretierscode->membretierscode_code.'
				';
			}



if($souscription->souscription_email != ""){

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/codesgeneres.txt';
$somecontent = $htmltxt;

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
if (!is_dir("txt_codesgeneres/")) {
mkdir("txt_codesgeneres/", 0777);
}

$newfile = "txt_codesgeneres/CODES_GENERES_".($souscription->souscription_id)."_.txt";
$newnom = "CODES_GENERES_".($souscription->souscription_id)."_";
$newchemin = "txt_codesgeneres/";

copy($file, $newfile);


$file = $newchemin.$newnom.'.txt';
$filena	= $newnom.'.txt';

$config = array('auth' => 'login',
																'username' => Util_Utils::getParamEsmc(3),
																'password' => Util_Utils::getParamEsmc(4));
	
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);        
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($htmltxt2);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($souscription->souscription_email, $souscription->souscription_nom." ".$souscription->souscription_prenom);
$mail->setSubject('Liste des codes d\'activation de compte marchant : '.$date_id->toString('dd-MM-yyyy HH:mm'));

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

   function transfertintegrateur() {
      ini_set('memory_limit','512M');
	  $integrateur = new Application_Model_EuIntegrateurMapper();
      $entries     = $integrateur->fetchAll();
	  $complementquittance = new Application_Model_EuComplementQuittance();
      $complementquittance_mapper = new Application_Model_EuComplementQuittanceMapper(); 
	  foreach ($entries as $entry) :
        /////////////////////////////////////////////////////////////////////
	    $compteur = $complementquittance_mapper->findConuter() + 1;
	    $complementquittance->setId_complement_quittance($compteur);
	    $complementquittance->setIntegrateur_id($entry->integrateur_id);
	    $complementquittance->setSouscription_id($entry->integrateur_souscription);
	    $complementquittance->setDate_complement_quittance($entry->integrateur_date);
	    $complementquittance_mapper->save($complementquittance);
      endforeach;
  }







function transfert_code(){
 ini_set('memory_limit', '512M');
		                                $souscription10M = new Application_Model_EuSouscriptionMapper();
                                        $souscription10 = $souscription10M->fetchAllByPublier(3, "");
										
										foreach ($souscription10 as $entry_souscription10):
										
										$compteur_souscription = $entry_souscription10->souscription_id;

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
										
										
										
										if(($souscription->souscription_programme == 'KACM' 
			                                || $souscription->souscription_programme == 'CMFH') 
				                            && $souscription->souscription_autonome == 1) {
											        
													if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			                                            // Mise à jour du compte de transfert
				                                        $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                                                        $compte_map->update($compte);    
	                                                } /*else {
			                                            $db->rollback();				
			                                            $sessionmcnp->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
														$this->view->param = $param;
														$this->_redirect('/index/addsouscription/param/'.$param);
                                                        return;			   
			                                        }*/
													
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
												
										            }  /*else {
												        $db->rollback();
	                                                    $this->view->param = $param;
			                                            $sessionmcnp->error = 'Erreur de traitement : le solde du compte est null';
														$this->_redirect('/index/addsouscription/param/'.$param);
                                                        return;	
												    }*/
										
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
	                                            } /*else {
			                                        $db->rollback();
	                                                $this->view->param = $param;
			                                        $sessionmcnp->error = 'Erreur de traitement : le compte est introuvable';
													$this->_redirect('/index/addsouscription/param/'.$param);
                                                    return;			   
			                                    }*/
					
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
					
				                } /*else  {
				                    $db->rollback();
	                                $this->view->param = $param;
			                        $sessionmcnp->error = 'Erreur de traitement : le solde du compte CAPS est null';
									$this->_redirect('/index/addsouscription/param/'.$param);
                                    return;
				                }*/
				
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
								/*$db->commit();
                                $sessionmcnp->error = "Opération bien effectuée. Votre souscription a été vérifiée.";
		                        $this->_redirect('/index/addsouscription/param/'.$param);*/
								
		                    /*} else {
							    $db->commit();
                                $sessionmcnp->error = "Opération bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
		                        $this->_redirect('/index/addsouscriptioncomplement');
					                }*/
		                    /*}  else {
								$db->commit();
                                $sessionmcnp->error = "Opération bien effectuée. Votre souscription n’est pas encore vérifiée, revenez plus tard.";
		                        $this->_redirect('/index/recherchesouscription');
			                }
		
		
		                }*/

endforeach;
}







function releve_relevedetail(){
 ini_set('memory_limit', '512M');


        $releve = new Application_Model_EuReleve();
		
        $releve_m = new Application_Model_EuReleveMapper();
		$releves = $releve_m->fetchAll_1();
		foreach ($releves as $entry_releve):
$compteur = $entry_releve->releve_id;

////////////////////////////////////////////////////
$fichier_releve = $entry_releve->releve_fichier;
$jour = substr($fichier_releve, -18, -16);
$mois = substr($fichier_releve, -16, -14);
$annee = substr($fichier_releve, -14, -10);
$releve_date = $annee."-".$mois."-".$jour;

                $a = new Application_Model_EuReleve();
                $ma = new Application_Model_EuReleveMapper();
				$ma->find($entry_releve->releve_id, $a);
			
                $a->setReleve_date($releve_date);
                $ma->update($a);
					
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		
	            $code_membre =  $entry_releve->releve_membre;
////////////////////////////////////////////////////

if($entry_releve->releve_type == "CNCS"){
////////////////////////////////////////////////////relevegiesalairepdf
			
                $a->setReleve_type("CNCS");
                $ma->update($a);


				    $tabela = new Application_Model_DbTable_Credit();
				    $membre = $code_membre;
				    if($membre != '') {
					  $select = $tabela->select();
					  $select->where('membre = ?', $membre);
					  $select->where('libelle like ?','CNCS');
	                }
	                $creditcncs = $tabela->fetchAll($select);
			        $code_membre    = $code_membre;
 foreach ($creditcncs as $entry):  
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->libelle);
                $a->setRelevedetail_credit($entry->codecredi);
                $a->setRelevedetail_montant($entry->montplace);
                $a->setRelevedetail_date($entry->datedeb);
                $a->setPublier(0);
                $ma->save($a);
 endforeach; 
	
////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "SALAIRE"){
////////////////////////////////////////////////////relevesalairepdf
			
                $a->setReleve_type("CNCS");
                $ma->update($a);
	

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
		   
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
            $code_membre = '%';
        }
		$select->where('eu_ancien_compte_credit.code_produit in (?)', array('CNCSnr','CNCSr'));
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $detailsalaire = $tabela->fetchAll($select);
foreach ($detailsalaire as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->code_produit);
                $a->setRelevedetail_credit($entry->id_credit);
                $a->setRelevedetail_montant($entry->montant_place);
                $a->setRelevedetail_date($entry->date_octroi);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 


        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre = ?',$code_membre);
		}
		$select->where('eu_ancien_echange.type_echange like ?','NR/NN');
        $select->order('date_echange asc');
        $escomptesalaire = $tabela->fetchAll($select);
foreach ($escomptesalaire as $entry): 
                $a = new Application_Model_EuReleveescompte();
                $ma = new Application_Model_EuReleveescompteMapper();
			
                $compteurescompte = $ma->findConuter() + 1;
                $a->setReleveescompte_id($compteurescompte);
                $a->setReleveescompte_releve($compteur);
                $a->setReleveescompte_produit($entry->code_produit);
                $a->setReleveescompte_escompte($entry->id_echange);
                $a->setReleveescompte_montant($entry->montant);
                $a->setReleveescompte_date($entry->date_echange);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

	

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
	    if ($code_membre != '' || $code_membre != null) {
           //$select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
           $code_membre = '%';
        }		
		$select->where('eu_ancien_compte_credit.compte_source like ?','NR-TCNCS-'.$code_membre);
		$select->orwhere('eu_ancien_compte_credit.compte_source like ?','NN-TCNCS-'.$code_membre);
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $echangesalaire = $tabela->fetchAll($select);
foreach ($echangesalaire as $entry): 
                $a = new Application_Model_EuReleveechange();
                $ma = new Application_Model_EuReleveechangeMapper();
			
                $compteurechange = $ma->findConuter() + 1;
                $a->setReleveechange_id($compteurechange);
                $a->setReleveechange_releve($compteur);
                $a->setReleveechange_produit($entry->code_produit);
                $a->setReleveechange_echange($entry->id_credit);
                $a->setReleveechange_montant($entry->montant_place);
                $a->setReleveechange_date($entry->date_octroi);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "CNP"){
////////////////////////////////////////////////////relevegiecreditpdf
			
                $a->setReleve_type("CNP");
                $ma->update($a);
	

				    $tabela = new Application_Model_DbTable_Place();
				    $membre = $code_membre;
				    if($membre != '') {
					    $select = $tabela->select();
					    $select->distinct();
		                $select->from(array('place'),array('num','membre','montant','lib','datedepot'));
					    $select->where('membre = ?', $membre);
						$select->where('montant > ?',0);
					    $select->where('lib like ?','CN'.'%');
	                }
	                $creditrpgi = $tabela->fetchAll($select);
			        $code_membre    = $code_membre;
 foreach ($creditrpgi as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->lib);
                $a->setRelevedetail_credit($entry->num);
                $a->setRelevedetail_montant($entry->montant);
                $a->setRelevedetail_date($entry->datedepot);
                $a->setPublier(0);
                $ma->save($a);
 endforeach; 

////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "RPG_I"){
////////////////////////////////////////////////////relevecreditpdf
			
                $a->setReleve_type("CNP");
                $ma->update($a);
	

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $compte = '';
        $membre = $code_membre;
		$origine = '';
		if($membre != '' && $compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else
		if($compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_octroi asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_octroi asc');
        } else
		if ($origine != '' or $origine != null) {
		    $select = $tabela->select();
            $select->where('compte_source like ?',$origine.'%');
		    $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_octroi asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
		}
        $creditrpgi = $tabela->fetchAll($select);
			        $code_membre    = $membre;
 foreach ($creditrpgi as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->code_produit);
                $a->setRelevedetail_credit($entry->id_credit);
                $a->setRelevedetail_montant($entry->montant_place);
                $a->setRelevedetail_date($entry->date_octroi);
                $a->setPublier(0);
                $ma->save($a);
 endforeach; 




        $tabela = new Application_Model_DbTable_EuAncienCreditConsommer();
        $compte = '';
        //$membre = (string)$this->_request->getParam('code');
		$origine = '';
		if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_consommation asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_consommation asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_consommation asc');
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_consommation asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_consommation asc');
		}
        $creditrpgiconsommer = $tabela->fetchAll($select);
foreach ($creditrpgiconsommer as $entry): 
                $a = new Application_Model_EuRelevecreditc();
                $ma = new Application_Model_EuRelevecreditcMapper();
			
                $compteurcreditc = $ma->findConuter() + 1;
                $a->setRelevecreditc_id($compteurcreditc);
                $a->setRelevecreditc_releve($compteur);
                $a->setRelevecreditc_produit($entry->code_produit);
                $a->setRelevecreditc_creditc($entry->id_consommation);
                $a->setRelevecreditc_montant($entry->mont_consommation);
                $a->setRelevecreditc_date($entry->date_consommation);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 





        $tabela = new Application_Model_DbTable_EuAncienCnnc();
        $compte = '';
        //$membre = (string)$this->_request->getParam('code');
		$origine = '';
		if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('libelle = ?', $compte);
		   $select->where('libelle in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('datefin asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('libelle = ?', $compte);
		   $select->order('datefin asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('libelle = ?', $compte);
			$select->order('datefin asc');
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('libelle in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('datefin asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('libelle in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('datefin asc');
		}
        $creditrpgicnnc = $tabela->fetchAll($select);
foreach ($creditrpgicnnc as $entry): 
                $a = new Application_Model_EuRelevecreditnonc();
                $ma = new Application_Model_EuRelevecreditnoncMapper();
			
                $compteurcreditnonc = $ma->findConuter() + 1;
                $a->setRelevecreditnonc_id($compteurcreditnonc);
                $a->setRelevecreditnonc_releve($compteur);
                $a->setRelevecreditnonc_produit($entry->libelle);
                $a->setRelevecreditnonc_creditnonc($entry->id_cnnc);
                $a->setRelevecreditnonc_montant($entry->mont_credit);
                $a->setRelevecreditnonc_date($entry->datefin);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 



////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "GCP"){
////////////////////////////////////////////////////relevegcppdf
			
                $a->setReleve_type("GCP");
                $ma->update($a);
	

        $tabela = new Application_Model_DbTable_EuAncienGcp();
		//if ($code_membre != '' || $code_membre != null) {
            $select = $tabela->select()->setIntegrityCheck(false);
            $select->from($tabela, array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve', 'reste', 'code_cat', 'id_credit'))
		           ->join('eu_ancien_compte_credit', 'eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit', array('code_membre', 'code_produit'));
            $select->order('eu_ancien_gcp.date_conso asc');
			if ($code_membre != '' || $code_membre != null) {
			   $select->where('eu_ancien_gcp.code_membre like ?',$code_membre);
			}
            $consult = $tabela->fetchAll($select);
	foreach ($consult as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->code_produit);
                $a->setRelevedetail_credit($entry->id_gcp);
                $a->setRelevedetail_montant($entry->mont_gcp);
                $a->setRelevedetail_date($entry->date_conso);
                $a->setPublier(0);
                $ma->save($a);
	endforeach; 


        $tabela = new Application_Model_DbTable_EuAncienEscompte();
        $select = $tabela->select()->setIntegrityCheck(false);
		$select->from($tabela,array('*'));
		$select->join('eu_ancien_membre','eu_ancien_membre.ancien_code_membre = eu_ancien_escompte.code_membre_benef');
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_escompte.code_membre like ?',$code_membre);
		}
        $select->order('eu_ancien_escompte.date_escompte asc');
        $escomptes = $tabela->fetchAll($select);
	foreach ($escomptes as $entry): 
                $a = new Application_Model_EuReleveescompte();
                $ma = new Application_Model_EuReleveescompteMapper();
			
                $compteurescompte = $ma->findConuter() + 1;
                $a->setReleveescompte_id($compteurescompte);
                $a->setReleveescompte_releve($compteur);
                $a->setReleveescompte_produit("GCP");
                $a->setReleveescompte_escompte($entry->id_escompte);
                $a->setReleveescompte_montant($entry->solde);
                $a->setReleveescompte_date($entry->date_escompte);
                $a->setPublier(0);
                $ma->save($a);
	endforeach; 
	

        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre like ?', $code_membre);
		}   
		$select->where('eu_ancien_echange.type_echange like ?','NB/NB');
        $select->order('date_echange asc');
        $echanges = $tabela->fetchAll($select);
	foreach ($echanges as $entry): 
                $a = new Application_Model_EuReleveechange();
                $ma = new Application_Model_EuReleveechangeMapper();
			
                $compteurechange = $ma->findConuter() + 1;
                $a->setReleveechange_id($compteurechange);
                $a->setReleveechange_releve($compteur);
                $a->setReleveechange_produit($entry->code_produit);
                $a->setReleveechange_echange($entry->id_echange);
                $a->setReleveechange_montant($entry->montant);
                $a->setReleveechange_date($entry->date_echange);
                $a->setPublier(0);
                $ma->save($a);
	endforeach; 

////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "FS_FL_FCPS"){
////////////////////////////////////////////////////relevekacmpdf
			
                $a->setReleve_type("KACM");
                $ma->update($a);
	

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   //$code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FS');
			$select->order('NEng asc');
			
			$detailfs = $tabela->fetchAll($select);
foreach ($detailfs as $entry): 
		      if($entry->DestAccount_Consumed == NULL) {
			    $sortie = 0;
				$solde  = $entry->CreditAmount;
			  } else {
			    $sortie = $entry->CreditAmount;
				$solde  = 0;
			  }
 $DateTime = new Zend_Date($entry->DateTime);

                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->Motif);
                $a->setRelevedetail_credit($entry->NEng);
                $a->setRelevedetail_montant($solde);
                $a->setRelevedetail_date($DateTime->toString('yyyy-MM-dd'));
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

	

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   //$code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FL');
			$select->order('NEng asc');
			
			$detailfl = $tabela->fetchAll($select);
foreach ($detailfl as $entry): 
		      if($entry->DestAccount_Consumed == NULL) {
			    $sortie = 0;
				$solde  = $entry->CreditAmount;
			  } else {
			    $sortie = $entry->CreditAmount;
				$solde  = 0;
			  }
 $DateTime = new Zend_Date($entry->DateTime);
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->Motif);
                $a->setRelevedetail_credit($entry->NEng);
                $a->setRelevedetail_montant($solde);
                $a->setRelevedetail_date($DateTime->toString('yyyy-MM-dd'));
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

	

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   //$code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','CPS');
			$select->order('NEng asc');
			
			$detailfcps = $tabela->fetchAll($select);
foreach ($detailfcps as $entry): 
		      if($entry->DestAccount_Consumed == NULL) {
			    $sortie = 0;
				$solde  = $entry->CreditAmount;
			  } else {
			    $sortie = $entry->CreditAmount;
				$solde  = 0;
			  }
 $DateTime = new Zend_Date($entry->DateTime);
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->Motif);
                $a->setRelevedetail_credit($entry->NEng);
                $a->setRelevedetail_montant($solde);
                $a->setRelevedetail_date($DateTime->toString('yyyy-MM-dd'));
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "MF11000_PP"){
////////////////////////////////////////////////////relevemf11000pppdf
			
                $a->setReleve_type("MF11000");
                $ma->update($a);
	
	
$num_bon = $code_membre;
		    $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
		    //$num_bon = $this->_request->getParam("num_bon");
		    $select = $tabela->select();
	        $select->where('code_mf11000 like ?',$num_bon);
			$select->order('id_rep asc');
			
			$detailbon = $tabela->fetchAll($select);
foreach ($detailbon as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit("MF11000");
                $a->setRelevedetail_credit($entry->id_rep);
                $a->setRelevedetail_montant($entry->solde_rep);
                $a->setRelevedetail_date($entry->date_rep);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "MF11000_PM"){
////////////////////////////////////////////////////relevemf11000pmpdf
			
                $a->setReleve_type("MF11000");
                $ma->update($a);
	

		    $tabela = new Application_Model_DbTable_EuAncienDetailSmsmoney();
		    $select = $tabela->select();
		    if($code_membre != '') {
	           $select->where('code_membre_dist like ?',$code_membre);
	        } else {
			   $select->where('code_membre_dist like ?','%');
			}
			$select->where('origine_sms like ?','MF');
			$select->order('id_detail_smsmoney asc');
			
			$detailmf11000 = $tabela->fetchAll($select);
foreach ($detailmf11000 as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit($entry->origine_sms.'11000');
                $a->setRelevedetail_credit($entry->id_detail_smsmoney);
                $a->setRelevedetail_montant($entry->solde_sms);
                $a->setRelevedetail_date($entry->date_allocation);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 

////////////////////////////////////////////////////
}else if($entry_releve->releve_type == "MF107"){
////////////////////////////////////////////////////relevemf107pdf
			
                $a->setReleve_type("MF107");
                $ma->update($a);
	

			$mf107  = new Application_Model_EuMembreFondateur107();
			$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
		    $tabela = new Application_Model_DbTable_EuRepartitionMf107();
		    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                   ->join('eu_detail_mf107', 'eu_detail_mf107.id_mf107 = eu_repartition_mf107.id_mf107',array('code_membre','id_mf107','mont_apport','pourcentage','numident'));
		    $select->where('eu_repartition_mf107.code_membre like ?',$code_membre);
			//$select->order('eu_repartition_mf107.id_rep asc');
			$select->order('eu_detail_mf107.code_membre asc');
		    //$select = $tabela->select();
	        
			$detailmf107 = $tabela->fetchAll($select);
foreach ($detailmf107 as $entry): 
                $a = new Application_Model_EuRelevedetail();
                $ma = new Application_Model_EuRelevedetailMapper();
			
                $compteurdetail = $ma->findConuter() + 1;
                $a->setRelevedetail_id($compteurdetail);
                $a->setRelevedetail_releve($compteur);
                $a->setRelevedetail_produit("MF107");
                $a->setRelevedetail_credit($entry->id_rep);
                $a->setRelevedetail_montant($entry->solde_rep);
                $a->setRelevedetail_date($entry->date_rep);
                $a->setPublier(0);
                $ma->save($a);
endforeach; 
////////////////////////////////////////////////////
		}





		endforeach;
}







function envoie_code_kacm_cmfh(){
	
 ini_set('memory_limit', '512M');
 
$date_id = new Zend_Date(Zend_Date::ISO_8601);

$souscription_M = new Application_Model_EuSouscriptionMapper();
$entries = $souscription_M->fetchAllByCodeKACMCMFH();

foreach ($entries as $entry) {


										$souscription = new Application_Model_EuSouscription();
		                                $souscriptionM = new Application_Model_EuSouscriptionMapper();
                                        $souscriptionM->find($entry->souscription_id, $souscription);

/////////////////////////////quittance
if($souscription->souscription_personne == "PP"){
								
								$souscrip = new Application_Model_EuSouscription();
								$souscrip_mapper = new Application_Model_EuSouscriptionMapper();
								$compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, "");
								
				if($souscription->souscription_programme == "KACM"){
								 
$quittance = 'PP'.ajoutezero($souscription->souscription_ordre);

				}else if($souscription->souscription_programme == "CMFH"){

$quittance = ajoutezero($souscription->souscription_ordre);

				}
				
}else if($souscription->souscription_personne == "PM"){
				if($souscription->souscription_programme == "KACM"){
								
								$souscrip = new Application_Model_EuSouscription();
								$souscrip_mapper = new Application_Model_EuSouscriptionMapper();
								$compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, $souscription->code_type_acteur);
								
$quittance = $souscription->code_type_acteur.ajoutezero($souscription->souscription_ordre);

				}else if($souscription->souscription_programme == "CMFH"){
								
								$souscrip = new Application_Model_EuSouscription();
								$souscrip_mapper = new Application_Model_EuSouscriptionMapper();
								$compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, "");

$quittance = ajoutezero($souscription->souscription_ordre);

				}
}




///////////////////////////envoie email

			if($souscription->souscription_programme == "CMFH"){
$html = "";

$html .= "Voici votre Numéro de Quittance, votre Login et votre Mot de passe qui vous permettent de vous connecter.";
$html .= "<br />";
$html .= "Numéro Quittance Souscription : ".$quittance."<br />";
$html .= "<br />";
$html .= "Login : ".$souscription->souscription_login."<br />";
$html .= "<br />";
$html .= "Mot de passe : ".$souscription->souscription_passe."<br />";
$html .= "<br />";
$html .= "Veuillez vous faire intégrer par un intégrateur.";
$html .= "<br />";
$html .= "Cordialement, ";
$html .= "<br />";
$html .= "ESMC";


	
								$membreasso = new Application_Model_EuMembreasso();
								$membreassoM = new Application_Model_EuMembreassoMapper();
								$membreassoM->find($souscription->souscription_membreasso, $membreasso);
								
								$association = new Application_Model_EuAssociation();
								$associationM = new Application_Model_EuAssociationMapper();
								$associationM->find($membreasso->membreasso_association, $association);




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
$mail->setSubject('Rappel de recu Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
/*
$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
*/	
$mail->send($tr);


}else if($membreasso->membreasso_email != ""){
	

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
$mail->setSubject('Rappel de recu Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
/*
$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
*/	
$mail->send($tr);
	
	
}else if($association->association_email != ""){


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
$mail->setSubject('Rappel de recu Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
/*
$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
*/	
$mail->send($tr);

	}

			}


//////////////////////////////////envoi code

										
								        // operation de transfert
										//$souscription = new Application_Model_EuSouscription();
		                                //$souscriptionM = new Application_Model_EuSouscriptionMapper();
                                        //$souscriptionM->find($souscription->souscription_id, $souscription);
										
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
	                                                } /*else {
			                                            $db->rollback();				
			                                            $sessionmcnp->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
														$this->view->param = $param;
														$this->_redirect('/index/addsouscription/param/'.$param);
                                                        return;			   
			                                        }*/
													
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
												
										            }  /*else {
												        $db->rollback();
	                                                    $this->view->param = $param;
			                                            $sessionmcnp->error = 'Erreur de traitement : le solde du compte est null';
														$this->_redirect('/index/addsouscription/param/'.$param);
                                                        return;	
												    }*/
										
										}
										
								/*		
								$db->commit();
                                $sessionmcnp->error = "Opération bien effectuée. Votre souscription a été vérifiée.";
		                        $this->_redirect('/index/addsouscription/param/'.$param);*/
								







}







}





