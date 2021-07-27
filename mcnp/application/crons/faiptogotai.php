#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';

             //$db = Zend_Db_Table::getDefaultAdapter();
             //$db->beginTransaction();
try
{
           ini_set('memory_limit', '512M');    

   


        $date_id = new Zend_Date(Zend_Date::ISO_8601);

$dir = "../../webfiles/FAIP-TOGO/TAI/";
$dir2 = "../../webfiles/FAIP-TOGO/TAI_OLD/";
$dir3 = "../../webfiles/FAIP-TOGO/TAI_ERROR/";
    //$findme = "SOUSCRIPTION_".$entry->souscription_id."_.pdf";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $nomfile = basename($file).PHP_EOL;

            $releve = $dir.$file;

                    $fichier = $releve;
/**/
$path_parts = pathinfo($fichier);
//echo $path_parts['dirname'], "\n";
//echo $path_parts['basename'], "\n";
//echo $path_parts['extension'], "\n";
///echo $path_parts['filename'], "\n"; // depuis PHP 5.2.0
list($code_banque1, $autre) = explode("_", $path_parts['filename']);
if($code_banque1 == "FAIP"){




                    $lines = file($fichier);
    
                    foreach ($lines as $line_num => $line) {
                        list($code_banque, $un, $numero, $date2, $montant, $libelle) = explode(";", $line);

                        list($jour, $mois, $annee) = explode("/", $date2);
                        $date = $annee."-".$mois."-".$jour;

                        $pos1 = stripos($libelle, "#");
                        if ($pos1 !== false) {
                            $code_membre_ban = substr($libelle, ($pos1 + 1), 20);
                        }else{
                            $code_membre_ban = "";                        
                        }

$detail_numero = $numero;
$detail_date = $date; 
$detail_montant = str_replace(" ", "", $montant);
//$detail_montant = str_replace(".", "", $montant);
//$detail_montant = str_replace(",", "", $montant);
$detail_libelle = $libelle;

$code_banque_faip_togo = "FAIP";

if($detail_numero != '' && $detail_date != '' && $detail_libelle != '' && $detail_montant > 0 && $code_banque == "FAIP"){
//////////////////////////////////////////////////////////////////////////////////////////
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), $code_banque_faip_togo);
        if(count($relevebancaire2) > 0){
        
        $relevebancaire_id = $relevebancaire2->relevebancaire_id;
        

        $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail2 = $relevebancairedetail2M->fetchAllByBanqueNumeroDate($code_banque_faip_togo, $detail_numero, $date_id->toString('yyyy-MM-dd'));
        if(count($relevebancairedetail2) > 0){
            $relevebancairedetail_id = $relevebancairedetail2->relevebancairedetail_id;

                            echo $this->view->message = "Numéro de banque déjà chargé ...";
                            $ok = 0;

        }else{
        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
            
            $compteur_rbd = $mrb->findConuter() + 1;
            $rb->setRelevebancairedetail_id($compteur_rbd);
            $rb->setRelevebancairedetail_relevebancaire($relevebancaire_id);
            $rb->setRelevebancairedetail_libelle($detail_libelle);
            $rb->setRelevebancairedetail_numero($detail_numero);
            $rb->setRelevebancairedetail_date($detail_date);
            $rb->setRelevebancairedetail_montant($detail_montant);
            $rb->setRelevebancairedetail_date_valeur(NULL);
            $rb->setPublier(0);
            $mrb->save($rb);

            $relevebancairedetail_id = $compteur_rbd;
            $ok = 1;

            }

            }else{
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
            
            $compteur = $ma->findConuter() + 1;
            $a->setRelevebancaire_id($compteur);
            $a->setRelevebancaire_banque($code_banque_faip_togo);
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
            $rb->setRelevebancairedetail_date_valeur(NULL);
            $rb->setPublier(0);
            $mrb->save($rb);
            
            $relevebancairedetail_id = $compteur_rbd;
            $ok = 1;
                }



$ok = Util_Utils::addBAn($code_membre_ban, $detail_numero, $detail_date, $detail_montant, $detail_libelle, $code_banque_faip_togo);






if($ok == 1){

$oldfile = $dir.$file;
$newfile = $dir2.$file;

copy($oldfile, $newfile);
unlink($oldfile);
}else{


$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);        
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Error sur relevé : '.$file.' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo("looky@gacsource.com");
$mail->setSubject('Error sur relevé : '.$file.' du '.$date_id->toString('dd-MM-yyyy HH:mm')); 
$mail->send($tr);


$oldfile = $dir.$file;
$new3file = $dir3.$file;

copy($oldfile, $new3file);
unlink($oldfile);

}


}else{


$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);        
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Error sur relevé : '.$file.' le '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo("looky@gacsource.com");
$mail->setSubject('Error sur relevé : '.$file.' du '.$date_id->toString('dd-MM-yyyy HH:mm')); 
$mail->send($tr);


$oldfile = $dir.$file;
$new3file = $dir3.$file;

copy($oldfile, $new3file);
unlink($oldfile);

}
}  
}          
        }
        closedir($dh);
    }
    }




                //$db->commit();
                    



    
}
catch (Exception $e)
{
                   //$db->rollback();
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
}
