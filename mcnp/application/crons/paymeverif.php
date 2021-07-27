#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';

             $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
try
{
           ini_set('memory_limit', '512M');    

$date_id = new Zend_Date(Zend_Date::ISO_8601);
$date_buttoir = "2018-11-01";
$today = $date_id->toString('yyyy-MM-dd');
//$this->view->today = $today;

        $traite_mapper = new Application_Model_EuTraiteMapper();

        $traite_montant_tmoney_flooz = $traite_mapper->fetchAllByMembreDebutFinDisponibleImprimerPayerMode2("", $date_buttoir, $today, 1, 0, 0, array("TMONEY", "FLOOZ"));

$textussd = "";
$tab = "";    
foreach ($traite_montant_tmoney_flooz as $entry):

         $traite = new Application_Model_EuTraite();
         $traiteM = new Application_Model_EuTraiteMapper();
         $traiteM->find($entry->traite_id, $traite);

         $id_tpagcp = $traite->traite_tegcp;

         $tpagcp = new Application_Model_EuTpagcp();
         $tpagcpM = new Application_Model_EuTpagcpMapper();
         $tpagcpM->find($id_tpagcp, $tpagcp);


    $numero_opi = substr($tpagcp->code_membre, 9, -1).$traite->traite_id;
    $numero_opi2 = substr($tpagcp->code_membre, 9, -1).$traite->traite_id."/".Util_Utils::ajoute1zero($traite->traiter)."-".$tpagcp->ntf."/".substr($tpagcp->date_deb, 8, 2)."-".substr($tpagcp->date_deb, 5, 2)."-".substr($tpagcp->date_deb, 0, 4);


  if (substr($tpagcp->code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$membreM = new Application_Model_EuMembreMapper();
$membreM->find($tpagcp->code_membre, $membre);
$designation_nom = $membre->nom_membre;
$designation_prenom = $membre->prenom_membre;
  } else if (substr($tpagcp->code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$membreM = new Application_Model_EuMembreMoraleMapper();
$membreM->find($tpagcp->code_membre, $membre);
$designation_nom = $membre->raison_sociale;
$designation_prenom = "";
  }


//TMONEY;001000019152963;0010010010010000191P;EFAMBI YAWA;15-12-2018;22890873331;2453
//list($operateur, $opinum, $code_membre, $nom, $date, $numero1, $montant) = explode(";", $line.";");
	$operateur = "FLOOZ";
	$opinum = $numero_opi;
	$code_membre = $tpagcp->code_membre;
	$nom = $designation_nom." ".$designation_prenom;
	$date = substr($traite->traite_date_fin, 8, 2)."-".substr($traite->traite_date_fin, 5, 2)."-".substr($traite->traite_date_fin, 0, 4);
	$numero1 = $traite->reference_paiement;
	$montant = $traite->traite_montant;

$array = array($operateur, $opinum, $code_membre, $nom, $date, $numero1, $montant);
$line = implode(";", $array);


/**/$traite2M = new Application_Model_EuTraiteMapper();
$traite2 = $traite2M->fetchAllByMembreNumero1($code_membre, $opinum);

$traite = new Application_Model_EuTraite();
$traiteM = new Application_Model_EuTraiteMapper();
$traiteM->find($traite2->traite_id, $traite);

if($traite->traite_payer == 1){
//echo "1<br>";
}else if($traite->traite_payer == 0){

$tab .= $line;    

$numero = substr($numero1, -8);
$numero1 = substr($numero1, -11);
$montant = $montant;
$operateur = $operateur;


if($numero > 0 && $montant > 0 && $operateur != ""){

if($operateur == "TMONEY"){

$messageopi = "Votre OPI No ".$opinum." est echu. Merci d'attendre le message du paiement par ".$operateur.". ESMC";
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSmsPayMeTMONEY($compteur, $numero1, $messageopi);
Util_Utils::addSms3EasysOld($compteur, $numero1, $messageopi);

$textussd .= "sudo gammu -c /etc/tmoney --getussd *145*1*1*".$montant."*".$numero."*1*1234#
! killall gammu
";
}else if($operateur == "FLOOZ"){

$messageopi = "Votre OPI No ".$opinum." est echu. Merci d'attendre le message du paiement par ".$operateur.". ESMC";
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSmsPayMeFLOOZ($compteur, $numero1, $messageopi);

$textussd .= "sudo gammu -c /etc/flooz --getussd *152*1*".$numero."*".$montant."*0000#
! killall gammu
";
}


}/*else{
$db->rollback();//
$sessionutilisateur->error = "Champs * obligatoire ...";                 
}*/

}

endforeach;


$filename = Util_Utils::getParamEsmc(1)."/tab_ussd.txt";
$somecontent = $tab;
////////////////////////////////////////////////////////////////
// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

                // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
                // Le pointeur de fichier est placé à la fin du fichier
                // c'est là que $somecontent sera placé
                if (!$handle = fopen($filename, 'a+')) {
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

$curl = curl_init();

curl_setopt_array($curl, array(
  //CURLOPT_URL => "http://172.16.20.51/tmoneyflooz/api_tmoney.php",
  CURLOPT_URL => "http://payme.gacsource.net/payMe/api_tmoney.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n\t\"textussd\":\"$textussd\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json"//,
    //"postman-token: 0c23ffe9-effc-e301-ff36-7aeef26daa0d"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
               //$db->rollback();
               //$sessionutilisateur->error = $err; 
} else {
  //echo $response;
               //$db->commit();
               //$sessionutilisateur->error = $response; 
        //$this->_redirect('/administration/addpayeralltmoneyflooz');  
}
 








               $db->commit();
  
}
catch (Exception $e)
{
                   $db->rollback();
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
}
