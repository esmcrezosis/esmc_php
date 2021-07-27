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




    $tablee = new Application_Model_DbTable_EuTraite();
    $selecte = $tablee->select();
    $selecte->distinct();
    $selecte->from(array('eu_traite'), 'traite_code_banque');
    $selecte->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $selecte->where('mode_paiement != ?', 'WARI');
    $selecte->where('mode_paiement != ?', 'FAIP');
    $selecte->where('mode_paiement != ?', 'FLOOZ');
    $selecte->where('mode_paiement != ?', 'TMONEY');
    $selecte->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entriese = $tablee->fetchAll($selecte);
foreach ($entriese as $value) {

    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select1->where('bon_id > ?', 0);
    //$select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 0);
    $select1->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select1->where('traite_date_fin <= ?', '2017-05-13');
    $select1->where('traite_code_banque = ?', $value->traite_code_banque);
    $select1->where('mode_paiement = ?', $value->traite_code_banque);
    $select1->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries1 = $table1->fetchAll($select1);

if(count($entries1) > 0){
        $pdf1 = Util_Utils::genererPdfTraiteBanque1($entries1, $value->traite_code_banque);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1, $value->traite_code_banque));

$html = "Ci-joint l'etat des OPI à transférer sur nos comptes du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI à transférer sur nos comptes du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $pdf1;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, 1);
foreach ($banque_email as $banque_email_value) {
$mail->addTo($banque_email_value->email);
}
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, -1);
foreach ($banque_email as $banque_email_value) {
$mail->addCc($banque_email_value->email);
}
$mail->addBcc(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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








    $tablee = new Application_Model_DbTable_EuTraite();
    $selecte = $tablee->select();
    $selecte->distinct();
    $selecte->from(array('eu_traite'), 'traite_code_banque');
    $selecte->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $selecte->where('mode_paiement != ?', 'WARI');
    $selecte->where('mode_paiement != ?', 'FAIP');
    $selecte->where('mode_paiement != ?', 'FLOOZ');
    $selecte->where('mode_paiement != ?', 'TMONEY');
    $selecte->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entriese = $tablee->fetchAll($selecte);
foreach ($entriese as $value) {

    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select1->where('bon_id > ?', 0);
    //$select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 0);
    $select1->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select1->where('traite_date_fin <= ?', '2017-05-13');
    $select1->where('traite_code_banque = ?', $value->traite_code_banque);
    $select1->where('((mode_paiement != ?', $value->traite_code_banque);
    $select1->where('mode_paiement != ?', 'WARI');
    $select1->where('mode_paiement != ?', 'FAIP');
    $select1->where('mode_paiement != ?', 'FLOOZ');
    $select1->where('mode_paiement != ?)', 'TMONEY');
    $select1->orwhere("mode_paiement IS NULL");
    $select1->orwhere("mode_paiement = '')");
    $select1->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries1 = $table1->fetchAll($select1);

if(count($entries1) > 0){
        $pdf1 = Util_Utils::genererPdfTraiteBanque2($entries1, $value->traite_code_banque);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1, $value->traite_code_banque));

$html = "Ci-joint l'etat des OPI à transférer sur les comptes de nos confrères du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI à transférer sur les comptes de nos confrères du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $pdf1;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, 1);
foreach ($banque_email as $banque_email_value) {
$mail->addTo($banque_email_value->email);
}
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, -1);
foreach ($banque_email as $banque_email_value) {
$mail->addCc($banque_email_value->email);
}
$mail->addBcc(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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






    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select2->where('bon_id > ?', 0);
    //$select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'WARI');
    $select2->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteWari($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteWari($entries2));


$html = "Ci-joint l'etat des OPI de WARI à charger sur l'interface administration de WARI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI de WARI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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




    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select2->where('bon_id > ?', 0);
    //$select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'FAIP');
    $select2->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteFAIP($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteFAIP($entries2));


$html = "Ci-joint l'etat des OPI de FAIP à envoyer à FAIP-TOGO du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI de FAIP du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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





    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select2->where('bon_id > ?', 0);
    //$select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'FLOOZ');
    $select2->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteFLOOZ($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteFLOOZ($entries2));


$html = "Ci-joint l'etat des OPI de FLOOZ à envoyer à FLOOZ du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI de FLOOZ du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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





    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select2->where('bon_id > ?', 0);
    //$select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'TMONEY');
    $select2->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteTMONEY($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteTMONEY($entries2));


$html = "Ci-joint l'etat des OPI de TMONEY à envoyer à TMONEY du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI de TMONEY du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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






    $table3 = new Application_Model_DbTable_EuTraite();
    $select3 = $table3->select();
    $select3->where("(bon_type = 'OPI' OR bon_type IS NULL)");
    $select3->where('bon_id > ?', 0);
    //$select3->where('traite_disponible = ?', 1);
    $select3->where('traite_imprimer = ?', 2);
    $select3->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select3->where('traite_date_fin <= ?', '2017-05-13');
    //$select3->where('mode_paiement != ?', 'WARI');
    //$select3->where('mode_paiement != ?', 'FAIP');
    //$select3->where('mode_paiement != ?', 'FLOOZ');
    //$select3->where('mode_paiement != ?', 'TMONEY');
    $select3->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE mode_reglement LIKE 'OPI')");
    $entries3 = $table3->fetchAll($select3);

if(count($entries3) > 0){
        $excel3 = Util_Utils::genererExcelTraite($entries3);
//$this->_redirect(Util_Utils::genererExcelTraite($entries3));


$html = "Ci-joint l'etat de tous les OPI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat de tous les OPI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel3;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
//$mail->addBcc("fiakofi@gacsource.com");
/*$mail->addBcc("gilchrist@gacsource.com");
$mail->addBcc("moussa@gacsource.com");
$mail->addBcc("bidaka@gacsource.com");*/
$mail->setSubject($objet);

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




                $db->commit();

    
}
catch (Exception $e)
{
                   $db->rollback();
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
}
