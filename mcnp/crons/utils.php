<?php


function getParamEsmc($id_param) {
        $param = 0;
        try {
            $tparam = new Application_Model_DbTable_EuParamEsmc();
            $select = $tparam->select();
            $select->where('id_param = ?', $id_param);
            $rows = $tparam->fetchAll($select);
            if (count($rows) > 0) {
                $row = $rows->current();
                $param = $row->valeur_param;
            }
            return $param;
        } catch (Exception $exc) {
            echo "Erreur d'éxécution: " . $exc->getMessage();
        }
    }




function genererPdfTraiteBanque($entries1, $code_banque) {
         ini_set('memory_limit', '512M');

$date_id = new Zend_Date(Zend_Date::ISO_8601);

         $banque = new Application_Model_EuBanque();
         $banqueMapper = new Application_Model_EuBanqueMapper();
         $banqueMapper->find($code_banque, $banque);

$htmlpdf = "";
/**/
//backimgw="100%" backimgh="100%" backimg="'.getParamEsmc(2).'images/OPI3.gif"
$htmlpdf .= '
    <page  backimgx="center" backimgy="top" backbottom="10mm" >
    ';

$htmlpdf .= '
<page_footer>
<table>
    <tr>
        <td align="center">
            <hr>
            <strong>Siège : Angle rues, Sagouda, Kiyéou et Bandjéli, Wuiti-Atsati  03 B.P. :30038 LOME-TOGO</strong><br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Tél. : +(228) 22 26 60 09 / E-mail : esmc@esmcgacsource.com / Site Web : www.esmcgacsource.com</strong>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</table>
</page_footer>
    ';
$htmlpdf .= '
<table width="738" border="0">
<tbody>
  <tr>
    <td colspan="5"><img src="'.getParamEsmc(2).'images/entete.gif" width="738" height="105" /></td>
  </tr>';
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
$htmlpdf .= '
  <tr>
    <td colspan="5" align="left"><strong><u>SECTION INTENDANCE & FINANCE</u></strong></td>
  </tr>';
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><div style="text-align: center; border: solid 2px #000000; width:175px; margin: 3px;"><strong>'.$banque->libelle_banque.'</strong></div></td>
  </tr>';
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  ';
$htmlpdf .= '
  <tr>
    <td colspan="5">Messieurs, <br />
    Par le débit de notre compte '.$banque->compte_banque.' en vos livres veuillez effectuer les prélèvements irrévocables ci-après aux bénéficiaires suivant les références des OPI à date de valeur « échéance »</td>
  </tr>';
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
$htmlpdf .= '
        <tr>
                <td align="center" style="border:#000 1px solid;"><strong>N° d\'ordre</strong></td>
                <td align="center" style="border:#000 1px solid;"><strong>O.P.I. n°</strong></td>
                <td align="center" style="border:#000 1px solid;"><strong>ECHEANCE</strong></td>
                <td align="center" style="border:#000 1px solid;"><strong>BENEFICIAIRE - CONTACT - CPTE BANCAIRE</strong></td>
                <td align="center" style="border:#000 1px solid;"><strong>MONTANT</strong></td>
        </tr>';
$total_montant = 0;
$i = 0;
foreach ($entries1 as $entry):

$i++;
         $traite = new Application_Model_EuTraite();
         $traiteMapper = new Application_Model_EuTraiteMapper();
         $traiteMapper->find($entry->traite_id, $traite);

         $id_tpagcp = $traite->traite_tegcp;

         $tpagcp = new Application_Model_EuTpagcp();
         $tpagcpMapper = new Application_Model_EuTpagcpMapper();
         $tpagcpMapper->find($id_tpagcp, $tpagcp);


    $numero_opi = substr($tpagcp->code_membre, 9, -1).$traite->traite_id;
    $numero_opi2 = substr($tpagcp->code_membre, 9, -1).$traite->traite_id."/".ajoute1zero($traite->traiter)."-".$tpagcp->ntf."/".substr($tpagcp->date_deb, 8, 2)."-".substr($tpagcp->date_deb, 5, 2)."-".substr($tpagcp->date_deb, 0, 4);






/*$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);*/

        //$traite->setMode_paiement($code_banque);
        //$traite->setReference_paiement($num_compte_bancaire);
        $traite->setTraite_numero($numero_opi);
        $traite->setTraite_imprimer(1);
    $traiteMapper->update($traite);

/*$tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($traite->traite_tegcp, $tpagcp);*/

        $tpagcp->setReste_ntf($tpagcp->getReste_ntf() - 1);
        $tpagcp->setSolde($tpagcp->getSolde() - $tpagcp->getMont_tranche());
    $tpagcpMapper->update($tpagcp);


    


  if (substr($tpagcp->code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$membreM = new Application_Model_EuMembreMapper();
$membreM->find($tpagcp->code_membre, $membre);
$designation_membre = $membre->nom_membre." ".$membre->prenom_membre;
  } else if (substr($tpagcp->code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$membreM = new Application_Model_EuMembreMoraleMapper();
$membreM->find($tpagcp->code_membre, $membre);
$designation_membre = $membre->raison_sociale;
  }


$telephoneM = new Application_Model_EuTelephoneMapper();
$telephone = $telephoneM->fetchAllByCodeMembre($tpagcp->code_membre);
$portable_membre = "";
if(count($telephone) > 0){
foreach ($telephone as $telephonevalue) {
$portable_membre .= $telephonevalue->numero_telephone." / ";
}
$portable_membre = substr($portable_membre, 0, -3);
}
$htmlpdf .= '
        <tr>
                <td align="right" style="border:#000 1px solid;">'.$i.'</td>
                <td align="left" style="border:#000 1px solid;">'.$numero_opi2.'</td>
                <td align="center" style="border:#000 1px solid;">'.datefr($traite->traite_date_fin).'</td>
                <td align="left" style="border:#000 1px solid;">'.$designation_membre.' - '.$traite->mode_paiement.':'.$traite->reference_paiement.' - Mobile : '.$portable_membre.'</td>
                <td align="right" style="border:#000 1px solid;">'.number_format($traite->traite_montant,0,',',' ').'</td>
        </tr>';
$total_montant += $traite->traite_montant;
endforeach;
$htmlpdf .= '
        <tr>
                <td align="right" colspan="4" style="border:#000 1px solid;">Total</td>
                <td align="right" style="border:#000 1px solid;">'.number_format($total_montant,0,',',' ').'</td>
        </tr>';
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
$htmlpdf .= '
  <tr>
    <td colspan="5">Arrêté le présent bordereau à la somme de ('.number_format($total_montant,0,',',' ').' FCFA) '.lettre($total_montant, 0).' CFA</td>
  </tr>
';
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right">Signature du donneur d\'ordre <br />
    <img src="'.getParamEsmc(2).'/images/signature_dg_esmc2.gif" width="150" height="88" /><br />
<em><u>Date </u>: </em> &nbsp;&nbsp;&nbsp;&nbsp; <strong><em>'.datefr($date_id->toString('yyyy-MM-dd')).'</em></strong></td>
  </tr>
';


/*$htmlpdf .= '
  <tr>
    <td align="center" colspan="4">
    <hr>
    Siège : Angle rues, Sagouda, Kiyéou et Bandjéli, Wuiti-Atsati  03 B.P. :30038 LOME-TOGO<br />
Tél. : +(228) 22 26 60 09 / E-mail : esmc@esmcgacsource.com / Site Web : www.esmcgacsource.com
</td>
  </tr>
';*/

$htmlpdf .= '
</tbody>
</table>
</page>
';

copy(''.getParamEsmc(1).'/traite.html', ''.getParamEsmc(1).'/traite'.$code_banque.'.html');
////////////////////////////////////////////////////////////////////////////////
$filename = ''.getParamEsmc(1).'/traite'.$code_banque.'.html';
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
if (!is_dir("../../../webfiles/pdf_traite/")) {
mkdir("../../../webfiles/pdf_traite/", 0777);
}

$newfile = "../../../webfiles/pdf_traite/ETAT_OPI_".$code_banque."_".$date_id->toString('dd-MM-yyyy').".html";
$newnom = "ETAT_OPI_".$code_banque."_".$date_id->toString('dd-MM-yyyy');
$newchemin = "../../../webfiles/pdf_traite/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../../public/html2pdf/html2pdf.class.php');
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

unlink($newfile);

        if($_SERVER['SERVER_ADDR'] == getParamEsmc(9)) {
      $domaine = str_replace("prod.", "", getParamEsmcLib(9));
    }else{
      $domaine = str_replace("prod.", "", getParamEsmcLib(10));
    }
        return str_replace("../../../webfiles/", "http://webfiles.".$domaine."/", $file);/**/


}








function genererExcelTraite($entries3) {

           ini_set('memory_limit', '512M');    

        //include("Transfert.php");
        
$date_id = new Zend_Date(Zend_Date::ISO_8601);


require_once 'PHPExcel/PHPExcel.php';
        
//////////////////////////////

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("ESMC")
                             ->setLastModifiedBy("ESMC")
                             ->setTitle("SECTION INTENDANCE & FINANCE")
                             ->setSubject("ETAT DES OPI EMIS LE ".strtoupper(datefr($date_id->toString('yyyy-MM-dd')))."")
                             ->setDescription("Export en excel les états quotidiens des OPI émis le ".(datefr($date_id->toString('yyyy-MM-dd')))."")
                             ->setKeywords("")
                             ->setCategory("");

$objPHPExcel->setActiveSheetIndex(0);                                         

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(37);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);

$objPHPExcel->getActiveSheet()->setCellValue('A1', "SECTION INTENDANCE & FINANCE");

$objPHPExcel->getActiveSheet()->setCellValue('A3', "BORDEREAU DES OPI EMIS LE ".strtoupper(datefr($date_id->toString('yyyy-MM-dd')))."");

$objPHPExcel->getActiveSheet()->setCellValue('A6', "O.P.I. n°");
$objPHPExcel->getActiveSheet()->setCellValue('B6', "ECHEANCE");
$objPHPExcel->getActiveSheet()->setCellValue('C6', "BANQUE E.");
$objPHPExcel->getActiveSheet()->setCellValue('D6', "COMPTE BANCAIRE E.");
$objPHPExcel->getActiveSheet()->setCellValue('E6', "BENEFICIAIRE");
$objPHPExcel->getActiveSheet()->setCellValue('F6', "CONTACT");
$objPHPExcel->getActiveSheet()->setCellValue('G6', "BANQUE R.");
$objPHPExcel->getActiveSheet()->setCellValue('H6', "COMPTE BANCAIRE R.");
$objPHPExcel->getActiveSheet()->setCellValue('I6', "MONTANT");


$y = 7;
$total_montant = 0;    
foreach ($entries3 as $entry):

         $traite = new Application_Model_EuTraite();
         $traiteMapper = new Application_Model_EuTraiteMapper();
         $traiteMapper->find($entry->traite_id, $traite);

         $id_tpagcp = $traite->traite_tegcp;

         $tpagcp = new Application_Model_EuTpagcp();
         $tpagcpMapper = new Application_Model_EuTpagcpMapper();
         $tpagcpMapper->find($id_tpagcp, $tpagcp);


    $numero_opi2 = substr($tpagcp->code_membre, 9, -1).$traite->traite_id."/".ajoute1zero($traite->traiter)."-".$tpagcp->ntf."/".substr($tpagcp->date_deb, 8, 2)."-".substr($tpagcp->date_deb, 5, 2)."-".substr($tpagcp->date_deb, 0, 4);


         $detail_tpagcpM = new Application_Model_EuDetailTpagcpMapper();
         $detail_tpagcp = $detail_tpagcpM->findDetailTpagcpTpagcp($id_tpagcp);

    


  if (substr($tpagcp->code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$membreM = new Application_Model_EuMembreMapper();
$membreM->find($tpagcp->code_membre, $membre);
$designation_membre = $membre->nom_membre." ".$membre->prenom_membre;
  } else if (substr($tpagcp->code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$membreM = new Application_Model_EuMembreMoraleMapper();
$membreM->find($tpagcp->code_membre, $membre);
$designation_membre = $membre->raison_sociale;
  }


$telephoneM = new Application_Model_EuTelephoneMapper();
$telephone = $telephoneM->fetchAllByCodeMembre($tpagcp->code_membre);
$portable_membre = "";
if(count($telephone) > 0){
foreach ($telephone as $telephonevalue) {
$portable_membre .= $telephonevalue->numero_telephone." / ";
}
$portable_membre = substr($portable_membre, 0, -3);
}

$messageopi = "Votre OPI n° ".$numero_opi2." est échu. Merci d'attendre le message de virement sur votre compte. ESMC";
$telephone2M = new Application_Model_EuTelephoneMapper();
$telephone2 = $telephone2M->findByCodeMembre($tpagcp->code_membre);
$compteur = findConuter() + 1;
if($telephone2->compagnie_telephone == "TOGOCEL"){
addSms4($compteur, $telephone2->numero_telephone, $messageopi);
}else if($telephone2->compagnie_telephone == "MOOV"){
addSmsMoov($compteur, $telephone2->numero_telephone, $messageopi);
}




$banque = new Application_Model_EuBanque();
$banqueM = new Application_Model_EuBanqueMapper();
$banqueM->find($traite->traite_code_banque, $banque);


$objPHPExcel->getActiveSheet()->setCellValue('A'.$y.'', $numero_opi2);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$y.'', ($traite->traite_date_fin));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$y.'', $traite->traite_code_banque);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$y.'', $banque->compte_banque);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$y.'', $designation_membre);
if($portable_membre != ""){
$objPHPExcel->getActiveSheet()->setCellValue('F'.$y.'', $portable_membre);
}
$objPHPExcel->getActiveSheet()->setCellValue('G'.$y.'', $traite->mode_paiement);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$y.'', $traite->reference_paiement);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$y.'', $traite->traite_montant);

$total_montant += $traite->traite_montant;

$y++;   
endforeach;

//$objPHPExcel->getActiveSheet()->setCellValue('A'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('B'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('C'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('D'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('E'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('F'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('G'.($y+1).'', "");
$objPHPExcel->getActiveSheet()->setCellValue('H'.($y+1).'', "Total");
$objPHPExcel->getActiveSheet()->setCellValue('I'.($y+1).'', $total_montant);

$objPHPExcel->getActiveSheet()->setTitle("ETATS OPI");
$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

////////////////////////////////////////////////////////////////////////////

$file = "".getParamEsmc(1)."/../../application/util/Utils.xlsx";

if (!is_dir("../../../webfiles/excel_exports/OPI/")) {
mkdir("../../../webfiles/excel_exports/OPI/", 0777);
}/**/
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "../../../webfiles/excel_exports/OPI/OPI_".$date_id->toString('dd-MM-yyyy')."_.xlsx";
$newnom = "OPI_".$date_id->toString('dd-MM-yyyy')."_";
$newchemin = "../../../webfiles/excel_exports/OPI/";

copy($file, $newfile);

unlink($file);

$file = $newchemin.$newnom.'.xlsx';
$filena = $newnom.'.xlsx';
/**/



if($_SERVER['SERVER_ADDR'] == getParamEsmc(9)) {
      $domaine = str_replace("prod.", "", getParamEsmcLib(9));
    }else{
      $domaine = str_replace("prod.", "", getParamEsmcLib(10));
    }
        return str_replace("../../../webfiles/", "http://webfiles.".$domaine."/", $file);/**/

}









function genererExcelTraiteWari($entries2) {

           ini_set('memory_limit', '512M');    

        //include("Transfert.php");
        
$date_id = new Zend_Date(Zend_Date::ISO_8601);


require_once 'PHPExcel/PHPExcel.php';
        
//////////////////////////////

$objPHPExcel = new PHPExcel();

/*$objPHPExcel->getProperties()->setCreator("ESMC")
                             ->setLastModifiedBy("ESMC")
                             ->setTitle("SECTION INTENDANCE & FINANCE")
                             ->setSubject("ETAT DES OPI EMIS LE ".strtoupper(datefr($date_id->toString('yyyy-MM-dd')))."")
                             ->setDescription("Export en excel les états quotidiens des OPI émis le ".(datefr($date_id->toString('yyyy-MM-dd')))."")
                             ->setKeywords("")
                             ->setCategory("");*/

$objPHPExcel->setActiveSheetIndex(0);                                         

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);


$objPHPExcel->getActiveSheet()->setCellValue('A1', "MATRICULE");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "AMOUNT");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "TELEPHONE");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "NOM");
$objPHPExcel->getActiveSheet()->setCellValue('E1', "PRENOM");


$y = 2;
$total_montant = 0;    
foreach ($entries2 as $entry):

         $traite = new Application_Model_EuTraite();
         $traiteMapper = new Application_Model_EuTraiteMapper();
         $traiteMapper->find($entry->traite_id, $traite);

         $id_tpagcp = $traite->traite_tegcp;

         $tpagcp = new Application_Model_EuTpagcp();
         $tpagcpMapper = new Application_Model_EuTpagcpMapper();
         $tpagcpMapper->find($id_tpagcp, $tpagcp);


    $numero_opi = substr($tpagcp->code_membre, 9, -1).$traite->traite_id;
    $numero_opi2 = substr($tpagcp->code_membre, 9, -1).$traite->traite_id."/".ajoute1zero($traite->traiter)."-".$tpagcp->ntf."/".substr($tpagcp->date_deb, 8, 2)."-".substr($tpagcp->date_deb, 5, 2)."-".substr($tpagcp->date_deb, 0, 4);


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




/*$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);*/

        //$traite->setMode_paiement($code_banque);
        //$traite->setReference_paiement($num_compte_bancaire);
        $traite->setTraite_numero($numero_opi);
        $traite->setTraite_imprimer(1);
    $traiteMapper->update($traite);

/*$tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($traite->traite_tegcp, $tpagcp);*/

        $tpagcp->setReste_ntf($tpagcp->getReste_ntf() - 1);
        $tpagcp->setSolde($tpagcp->getSolde() - $tpagcp->getMont_tranche());
    $tpagcpMapper->update($tpagcp);




/////////////////////////tarif wari/////////////
        $tarif_M = new Application_Model_EuTarifMapper();
        $tarif = $tarif_M->fetchAllByMontantTarif($tpagcp->mont_tranche);
        $montant_wari = $tpagcp->mont_tranche - $tarif->montant_tarif;





$objPHPExcel->getActiveSheet()->setCellValue('A'.$y.'', $numero_opi2);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$y.'', $montant_wari);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$y.'', '+'.$traite->reference_paiement);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$y.'', $designation_nom);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$y.'', $designation_prenom);



$total_montant += $tpagcp->mont_tranche;
$y++;   
endforeach;

//$objPHPExcel->getActiveSheet()->setCellValue('A'.($y+1).'', "");
//$objPHPExcel->getActiveSheet()->setCellValue('B'.($y+1).'', "Total");
//$objPHPExcel->getActiveSheet()->setCellValue('C'.($y+1).'', number_format($total_montant,0,',',' '));

$objPHPExcel->getActiveSheet()->setTitle("Wari");
$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

////////////////////////////////////////////////////////////////////////////

$file = "".getParamEsmc(1)."/../../application/util/Utils.xls";

if (!is_dir("../../../webfiles/excel_exports/OPI/")) {
mkdir("../../../webfiles/excel_exports/OPI/", 0777);
}/**/
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "../../../webfiles/excel_exports/OPI/Marchand_DEC_362437_".$date_id->toString('dd-MM-yyyy')."_.xls";
$newnom = "Marchand_DEC_362437_".$date_id->toString('dd-MM-yyyy')."_";
$newchemin = "../../../webfiles/excel_exports/OPI/";

copy($file, $newfile);

unlink($file);

$file = $newchemin.$newnom.'.xls';
$filena = $newnom.'.xls';
/**/



if($_SERVER['SERVER_ADDR'] == getParamEsmc(9)) {
      $domaine = str_replace("prod.", "", getParamEsmcLib(9));
    }else{
      $domaine = str_replace("prod.", "", getParamEsmcLib(10));
    }
        return str_replace("../../../webfiles/", "http://webfiles.".$domaine."/", $file);/**/

}






