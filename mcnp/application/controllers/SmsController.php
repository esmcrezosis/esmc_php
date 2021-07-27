<?php

class SmsController extends Zend_Controller_Action   {
      
	  public function init() {
		/* Initialize action controller here */		
        //include("Url.php");   
	  }
	  
	  
	  public function addsmsreceiveAction()
    {
        /* page administration/addsmsreceive - Ajout nombre de SMS */

        //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $this->_helper->layout->disableLayout();
        //$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    //if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
//if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

//$_REQUEST['recipient'] = "90291387";
//$_REQUEST['body'] = "test  yok ";
//$_REQUEST['type'] = "FLOOZ";

$recipient = $_REQUEST['recipient'];
$body = str_replace('\0', '', $_REQUEST['body']);
$type = $_REQUEST['type'];

//$recipient = $this->_request->getParam('recipient');
//$body = $this->_request->getParam('body');
//$type = $this->_request->getParam('type');

            //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {
        
    if ($recipient!="") {
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
        $detail_montant = str_replace("%2C", "", $tab_suite[0]);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("FLOOZ", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "FLOOZ");
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

}





/*Bienvenu(e)+chez+Wari!+MAGNOUDEA+ADJO+KATABALE+vous+a+envoye+85%2C000+CFA++Code:+660+197+357+Disponible+dans+tout+le+reseau+Wari.Payez+vos+factures+ici+et+partout+dans+le+monde+avec+Wari.+Utilisez+www.mywari.com*/
        
        
        $pos2 = stripos($sms, "Wari");
        $pos3 = stripos($sms, "Bienvenu(e)+chez+Wari");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, "Bienvenu(e)+chez+Wari!+");
        $pos4 = stripos($sms, "+vous+a+envoye+");
        $sms_libelle = substr($sms, $pos + strlen("Bienvenu(e)+chez+Wari!+"), $pos4 - ($pos + strlen("Bienvenu(e)+chez+Wari!+")));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($sms, "+vous+a+envoye+");
        $pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen("+vous+a+envoye+"), $pos4 - ($pos + strlen("+vous+a+envoye+")));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("WARI", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "WARI");
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
            $a->setRelevebancaire_banque("WARI");
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

}

        
        
        

/*BATG SMS 2016-07-12 9:16:45 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: DANTSE ASSOU MONTANT = 5000*/
/*BATG SMS 2016-08-03 9:33:08 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: AYENA ADEYEMI MONTANT = 300000*/        
        
        $pos2 = stripos($sms, "BATG");
        $pos3 = stripos($sms, "BATG SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, " PAR: ");
        $pos4 = stripos($sms, " MONTANT ");
        $sms_libelle = substr($sms, $pos + strlen(" PAR: "), $pos4 - ($pos + strlen(" PAR: ")));
        //$detail_libelle = str_replace("+", " ", $sms_libelle);
        $detail_libelle = $sms_libelle;
        
        /*$pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));*/
        $detail_numero = "";
        
        $pos = stripos($sms, "BATG SMS ");
        $sms_date = substr($sms, $pos + strlen("BATG SMS "), 10);
        $detail_date = $sms_date;
        
        $pos = stripos($sms, " MONTANT = ");
        //$pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen(" MONTANT = "));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        /*$relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BAT", trim($detail_numero));

        if(count($relevebancairedetail) == 0){*/
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BAT");
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
            $a->setRelevebancaire_banque("BAT");
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
        
//}

}

        
        
        
        
        

         
/*BOA-SMS: Alerte CREDIT 
 Cpt: 01XXXXX0006 
 Mnt: 5000 
 No: A587497 
 Date: 12/07/2016 
 Date Val: 13/07/2016 
 LBL: VERSEMENT ESPECES ASSOU DANTSE */
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A586941 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ABOULAYE M AB*/
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A587497 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ASSOU DANTSE  */       

$body2 = preg_split("/[\s,]+/", $body);
$body3 = implode(" ", $body2);

$body = $body3;
        
        $pos2 = stripos($body, "BOA");
        $pos3 = stripos($body, "BOA-SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($body, " LBL: ");
        //$pos4 = stripos($body, "+vous+a+envoye+");
        $sms_libelle = substr($body, $pos + strlen(" LBL: "));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($body, " No: ");
        $pos4 = stripos($body, " Date: ");
        $sms_numero = substr($body, $pos + strlen(" No: "), $pos4 - ($pos + strlen(" No: ")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $pos = stripos($body, " Date: ");
        $pos4 = stripos($body, " Date Val: ");
        $sms_date = substr($body, $pos + strlen(" Date: "), $pos4 - ($pos + strlen(" Date: ")));
        list($jour, $mois, $annee) = explode("/", $sms_date);
        $detail_date = $annee."-".$mois."-".$jour;
        //$detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($body, " Mnt: ");
        $pos4 = stripos($body, " No: ");
        $sms_montant = substr($body, $pos + strlen(" Mnt: "), $pos4 - ($pos + strlen(" Mnt: ")));
        $detail_montant = str_replace(",", "", $sms_montant);
        //$detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BOA", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BOA");
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
            $a->setRelevebancaire_banque("BOA");
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

}
        
        
        

         
/*sms ecobank */       
/*
$body2 = preg_split("/[\s,]+/", $body);
$body3 = implode(" ", $body2);

$body = $body3;
        
        $pos2 = stripos($body, "BOA");
        $pos3 = stripos($body, "BOA-SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($body, " LBL: ");
        //$pos4 = stripos($body, "+vous+a+envoye+");
        $sms_libelle = substr($body, $pos + strlen(" LBL: "));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($body, " No: ");
        $pos4 = stripos($body, " Date: ");
        $sms_numero = substr($body, $pos + strlen(" No: "), $pos4 - ($pos + strlen(" No: ")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $pos = stripos($body, " Date: ");
        $pos4 = stripos($body, " Date Val: ");
        $sms_date = substr($body, $pos + strlen(" Date: "), $pos4 - ($pos + strlen(" Date: ")));
        list($jour, $mois, $annee) = explode("/", $sms_date);
        $detail_date = $annee."-".$mois."-".$jour;
        //$detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($body, " Mnt: ");
        $pos4 = stripos($body, " No: ");
        $sms_montant = substr($body, $pos + strlen(" Mnt: "), $pos4 - ($pos + strlen(" Mnt: ")));
        $detail_montant = str_replace(",", "", $sms_montant);
        //$detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BOA", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BOA");
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
            $a->setRelevebancaire_banque("BOA");
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

}
        */
        
          
        
/*      ///////////////////////// envoie de mail
        
$esmc_email  = "enrolesmc@gacsource.com";   
$esmc_email2     = "enrolesmc@gacsource.com";   

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
*/


        
//$this->view->error = "Ok success";
        } //else {  $this->view->error = "Champs * obligatoire ...";  } 
        
    }






public function addsmsreceive2Action()
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

$recipient = $_REQUEST['recipient'];
$body = str_replace('\0', '', $_REQUEST['body']);
$type = $_REQUEST['type'];
$MsgId = $_REQUEST['MsgId'];

//$recipient = $this->_request->getParam('recipient');
//$body = $this->_request->getParam('body');
//$type = $this->_request->getParam('type');

            //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {

    if ($recipient!="") {
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
        $smsreceive->setMsgId($MsgId);
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

        if(strlen(trim($sms)) == 10){
$codesms = substr((trim($sms)), -5);

          $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi(strtoupper($codesms));
          if ($sms_connexion2->sms_connexion_code_recu != "") {

                $telephoneM = new Application_Model_EuTelephoneMapper();
                $telephone = $telephoneM->findByCodeMembreCompagnie($sms_connexion2->sms_connexion_code_membre, "TOGOCEL");
                $portable_membre = $telephone->numero_telephone;

            /*if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($sms_connexion2->sms_connexion_code_membre, $membre);
            $portable_membre = $membre->portable_membre;
            } else if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($sms_connexion2->sms_connexion_code_membre, $membremorale);
            $portable_membre = $membremorale->portable_membre;
            }*/




            if ($portable_membre != "") {
            //if ($portable_membre == $recipient) {$portable_membre
              $compteur = Util_Utils::findConuter() + 1;
              Util_Utils::addSms3Easys($compteur, $portable_membre, $sms_connexion2->sms_connexion_code_recu);

            //}else {
              //$compteur = Util_Utils::findConuter() + 1;
              //Util_Utils::addSms3($compteur, $portable_membre, "Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$sms_connexion2->sms_connexion_code_recu.". Merci. ESMC");
            //}
            }
                      }


        }else {


       
        
        
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
        $detail_montant = str_replace("%2C", "", $tab_suite[0]);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("FLOOZ", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "FLOOZ");
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

}





/*Bienvenu(e)+chez+Wari!+MAGNOUDEA+ADJO+KATABALE+vous+a+envoye+85%2C000+CFA++Code:+660+197+357+Disponible+dans+tout+le+reseau+Wari.Payez+vos+factures+ici+et+partout+dans+le+monde+avec+Wari.+Utilisez+www.mywari.com*/
        
        
        $pos2 = stripos($sms, "Wari");
        $pos3 = stripos($sms, "Bienvenu(e)+chez+Wari");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, "Bienvenu(e)+chez+Wari!+");
        $pos4 = stripos($sms, "+vous+a+envoye+");
        $sms_libelle = substr($sms, $pos + strlen("Bienvenu(e)+chez+Wari!+"), $pos4 - ($pos + strlen("Bienvenu(e)+chez+Wari!+")));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($sms, "+vous+a+envoye+");
        $pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen("+vous+a+envoye+"), $pos4 - ($pos + strlen("+vous+a+envoye+")));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("WARI", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "WARI");
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
            $a->setRelevebancaire_banque("WARI");
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

}

        
        
        

/*BATG SMS 2016-07-12 9:16:45 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: DANTSE ASSOU MONTANT = 5000*/
/*BATG SMS 2016-08-03 9:33:08 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: AYENA ADEYEMI MONTANT = 300000*/        
        
        $pos2 = stripos($sms, "BATG");
        $pos3 = stripos($sms, "BATG SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, " PAR: ");
        $pos4 = stripos($sms, " MONTANT ");
        $sms_libelle = substr($sms, $pos + strlen(" PAR: "), $pos4 - ($pos + strlen(" PAR: ")));
        //$detail_libelle = str_replace("+", " ", $sms_libelle);
        $detail_libelle = $sms_libelle;
        
        /*$pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));*/
        $detail_numero = "";
        
        $pos = stripos($sms, "BATG SMS ");
        $sms_date = substr($sms, $pos + strlen("BATG SMS "), 10);
        $detail_date = $sms_date;
        
        $pos = stripos($sms, " MONTANT = ");
        //$pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen(" MONTANT = "));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        /*$relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BAT", trim($detail_numero));

        if(count($relevebancairedetail) == 0){*/
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BAT");
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
            $a->setRelevebancaire_banque("BAT");
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
        
//}


  $message_releve_bancaire2 = Util_Utils::verifReleveBancaire2("BAT", $detail_numero, $detail_date, $detail_montant, $detail_libelle, $compteur_rbd);

if($message_releve_bancaire2 > 0){

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
        $mrb->find($compteur_rbd, $rb);

        $rb->setPublier(2);
        $mrb->update($rb);
}
//$this->_redirect('/sms/addsmsreceive2/'.$message_releve_bancaire2);

}

        
        
        
        
        

         
/*BOA-SMS: Alerte CREDIT 
 Cpt: 01XXXXX0006 
 Mnt: 5000 
 No: A587497 
 Date: 12/07/2016 
 Date Val: 13/07/2016 
 LBL: VERSEMENT ESPECES ASSOU DANTSE */
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A586941 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ABOULAYE M AB*/
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A587497 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ASSOU DANTSE  */       

$body2 = preg_split("/[\s,]+/", $body);
$body3 = implode(" ", $body2);

$body = $body3;
        
        $pos2 = stripos($body, "BOA");
        $pos3 = stripos($body, "BOA-SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($body, " LBL: ");
        //$pos4 = stripos($body, "+vous+a+envoye+");
        $sms_libelle = substr($body, $pos + strlen(" LBL: "));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($body, " No: ");
        $pos4 = stripos($body, " Date: ");
        $sms_numero = substr($body, $pos + strlen(" No: "), $pos4 - ($pos + strlen(" No: ")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $pos = stripos($body, " Date: ");
        $pos4 = stripos($body, " Date Val: ");
        $sms_date = substr($body, $pos + strlen(" Date: "), $pos4 - ($pos + strlen(" Date: ")));
        list($jour, $mois, $annee) = explode("/", $sms_date);
        $detail_date = $annee."-".$mois."-".$jour;
        //$detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($body, " Mnt: ");
        $pos4 = stripos($body, " No: ");
        $sms_montant = substr($body, $pos + strlen(" Mnt: "), $pos4 - ($pos + strlen(" Mnt: ")));
        $detail_montant = str_replace(",", "", $sms_montant);
        //$detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BOA", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BOA");
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
            $a->setRelevebancaire_banque("BOA");
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
        

  $message_releve_bancaire2 = Util_Utils::verifReleveBancaire2("BOA", $detail_numero, $detail_date, $detail_montant, $detail_libelle, $compteur_rbd);

if($message_releve_bancaire2 > 0){

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
        $mrb->find($compteur_rbd, $rb);

        $rb->setPublier(2);
        $mrb->update($rb);
}
//$this->_redirect('/sms/addsmsreceive2/'.$message_releve_bancaire2);
}
}



}


////////////////////////////////////////////////////////////////////////////////////


        $table = new Application_Model_DbTable_EuRelevebancairedetail();
        $select = $table->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = 'BAT')");
        $select->where("relevebancairedetail_numero = ''");
        $resultSet = $table->fetchAll($select);
        foreach ($resultSet as $row) {
            
            if($row->relevebancairedetail_montant > 0){

            $table2 = new Application_Model_DbTable_EuRelevebancairedetail();
            $select2 = $table2->select();
            $select2->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = 'BAT')");
            $select2->where("relevebancairedetail_numero != ''");
            $select2->where("relevebancairedetail_libelle LIKE '%".$row->relevebancairedetail_libelle."%'");
            $select2->where("relevebancairedetail_date LIKE '%".$row->relevebancairedetail_date."%'");
            $select2->where("relevebancairedetail_montant = ".$row->relevebancairedetail_montant."");
            $resultSet2 = $table2->fetchAll($select2);
            foreach ($resultSet2 as $row2) {

            if ($row->publier == 1) {
                    $rb = new Application_Model_EuRelevebancairedetail();
                    $mrb = new Application_Model_EuRelevebancairedetailMapper();
                    $mrb->find($row2->relevebancairedetail_id, $rb);

                    $rb->setPublier(2);
                    $mrb->update($rb);

            }else if ($row->publier == 0){
                    $rb = new Application_Model_EuRelevebancairedetail();
                    $mrb = new Application_Model_EuRelevebancairedetailMapper();
                    $mrb->find($row->relevebancairedetail_id, $rb);

                    $rb->setPublier(2);
                    $mrb->update($rb);
            }

            }
            
            }

        }

////////////////////////////////////////////////////////////////////////////////////


        $this->view->etat = "Status=0";

        } else {$this->view->etat = "Status=2";}

    }




public function addsmsreceive2oldAction()
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

$recipient = $_REQUEST['recipient'];
$body = str_replace('\0', '', $_REQUEST['body']);
$type = $_REQUEST['type'];
$MsgId = $_REQUEST['MsgId'];

//$recipient = $this->_request->getParam('recipient');
//$body = $this->_request->getParam('body');
//$type = $this->_request->getParam('type');

            //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {

    if ($recipient!="") {
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
        $smsreceive->setMsgId($MsgId);
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

        if(strlen(trim($sms)) == 10){
$codesms = substr((trim($sms)), -5);

          $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi(strtoupper($codesms));
          if ($sms_connexion2->sms_connexion_code_recu != "") {

                $telephoneM = new Application_Model_EuTelephoneMapper();
                $telephone = $telephoneM->findByCodeMembreCompagnie($sms_connexion2->sms_connexion_code_membre, "TOGOCEL");
                $portable_membre = $telephone->numero_telephone;

            /*if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($sms_connexion2->sms_connexion_code_membre, $membre);
            $portable_membre = $membre->portable_membre;
            } else if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($sms_connexion2->sms_connexion_code_membre, $membremorale);
            $portable_membre = $membremorale->portable_membre;
            }*/




            if ($portable_membre != "") {
            //if ($portable_membre == $recipient) {$portable_membre
              $compteur = Util_Utils::findConuter() + 1;
              Util_Utils::addSms3Easys($compteur, $portable_membre, $sms_connexion2->sms_connexion_code_recu);

            //}else {
              //$compteur = Util_Utils::findConuter() + 1;
              //Util_Utils::addSms3($compteur, $portable_membre, "Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$sms_connexion2->sms_connexion_code_recu.". Merci. ESMC");
            //}
            }
                      }


        }else {


       
        
        
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
        $detail_montant = str_replace("%2C", "", $tab_suite[0]);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("FLOOZ", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "FLOOZ");
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

}





/*Bienvenu(e)+chez+Wari!+MAGNOUDEA+ADJO+KATABALE+vous+a+envoye+85%2C000+CFA++Code:+660+197+357+Disponible+dans+tout+le+reseau+Wari.Payez+vos+factures+ici+et+partout+dans+le+monde+avec+Wari.+Utilisez+www.mywari.com*/
        
        
        $pos2 = stripos($sms, "Wari");
        $pos3 = stripos($sms, "Bienvenu(e)+chez+Wari");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, "Bienvenu(e)+chez+Wari!+");
        $pos4 = stripos($sms, "+vous+a+envoye+");
        $sms_libelle = substr($sms, $pos + strlen("Bienvenu(e)+chez+Wari!+"), $pos4 - ($pos + strlen("Bienvenu(e)+chez+Wari!+")));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($sms, "+vous+a+envoye+");
        $pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen("+vous+a+envoye+"), $pos4 - ($pos + strlen("+vous+a+envoye+")));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("WARI", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "WARI");
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
            $a->setRelevebancaire_banque("WARI");
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

}

        
        
        

/*BATG SMS 2016-07-12 9:16:45 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: DANTSE ASSOU MONTANT = 5000*/
/*BATG SMS 2016-08-03 9:33:08 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: AYENA ADEYEMI MONTANT = 300000*/        
        
        $pos2 = stripos($sms, "BATG");
        $pos3 = stripos($sms, "BATG SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, " PAR: ");
        $pos4 = stripos($sms, " MONTANT ");
        $sms_libelle = substr($sms, $pos + strlen(" PAR: "), $pos4 - ($pos + strlen(" PAR: ")));
        //$detail_libelle = str_replace("+", " ", $sms_libelle);
        $detail_libelle = $sms_libelle;
        
        /*$pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));*/
        $detail_numero = "";
        
        $pos = stripos($sms, "BATG SMS ");
        $sms_date = substr($sms, $pos + strlen("BATG SMS "), 10);
        $detail_date = $sms_date;
        
        $pos = stripos($sms, " MONTANT = ");
        //$pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen(" MONTANT = "));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        /*$relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BAT", trim($detail_numero));

        if(count($relevebancairedetail) == 0){*/
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BAT");
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
            $a->setRelevebancaire_banque("BAT");
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
        
//}


  $message_releve_bancaire2 = Util_Utils::verifReleveBancaire2("BAT", $detail_numero, $detail_date, $detail_montant, $detail_libelle, $compteur_rbd);

if(is_int($message_releve_bancaire2) || $message_releve_bancaire2 > 0){

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
        $mrb->find($compteur_rbd, $rb);

        $rb->setPublier(2);
        $mrb->update($rb);
}
//$this->_redirect('/sms/addsmsreceive2/'.$message_releve_bancaire2);

}

        
        
        
        
        

         
/*BOA-SMS: Alerte CREDIT 
 Cpt: 01XXXXX0006 
 Mnt: 5000 
 No: A587497 
 Date: 12/07/2016 
 Date Val: 13/07/2016 
 LBL: VERSEMENT ESPECES ASSOU DANTSE */
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A586941 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ABOULAYE M AB*/
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A587497 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ASSOU DANTSE  */       

$body2 = preg_split("/[\s,]+/", $body);
$body3 = implode(" ", $body2);

$body = $body3;
        
        $pos2 = stripos($body, "BOA");
        $pos3 = stripos($body, "BOA-SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($body, " LBL: ");
        //$pos4 = stripos($body, "+vous+a+envoye+");
        $sms_libelle = substr($body, $pos + strlen(" LBL: "));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($body, " No: ");
        $pos4 = stripos($body, " Date: ");
        $sms_numero = substr($body, $pos + strlen(" No: "), $pos4 - ($pos + strlen(" No: ")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $pos = stripos($body, " Date: ");
        $pos4 = stripos($body, " Date Val: ");
        $sms_date = substr($body, $pos + strlen(" Date: "), $pos4 - ($pos + strlen(" Date: ")));
        list($jour, $mois, $annee) = explode("/", $sms_date);
        $detail_date = $annee."-".$mois."-".$jour;
        //$detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($body, " Mnt: ");
        $pos4 = stripos($body, " No: ");
        $sms_montant = substr($body, $pos + strlen(" Mnt: "), $pos4 - ($pos + strlen(" Mnt: ")));
        $detail_montant = str_replace(",", "", $sms_montant);
        //$detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BOA", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BOA");
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
            $a->setRelevebancaire_banque("BOA");
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
        

  $message_releve_bancaire2 = Util_Utils::verifReleveBancaire2("BOA", $detail_numero, $detail_date, $detail_montant, $detail_libelle, $compteur_rbd);

if(is_int($message_releve_bancaire2) || $message_releve_bancaire2 > 0){

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
        $mrb->find($compteur_rbd, $rb);

        $rb->setPublier(2);
        $mrb->update($rb);
}
//$this->_redirect('/sms/addsmsreceive2/'.$message_releve_bancaire2);
}
}



}

        $this->view->etat = "Status=0";

        } else {$this->view->etat = "Status=2";}

    }



public function addsmsreceive2moovAction()
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

$recipient = $_REQUEST['recipient'];
$body = str_replace('\0', '', $_REQUEST['body']);
$type = $_REQUEST['type'];
$MsgId = $_REQUEST['MsgId'];

//$recipient = $this->_request->getParam('recipient');
//$body = $this->_request->getParam('body');
//$type = $this->_request->getParam('type');

            //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {

    if ($recipient!="") {
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
        $smsreceive->setMsgId($MsgId);
        $smsreceiveM->save($smsreceive);

/////////////////////////////////////
        $sms = $body;

        if(strlen(trim($sms)) == 10){
$codesms = substr((trim($sms)), -5);

          $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi(strtoupper($codesms));
          if ($sms_connexion2->sms_connexion_code_recu != "") {

                $telephoneM = new Application_Model_EuTelephoneMapper();
                $telephone = $telephoneM->findByCodeMembreCompagnie($sms_connexion2->sms_connexion_code_membre, "MOOV");
                $portable_membre = $telephone->numero_telephone;

            /*if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($sms_connexion2->sms_connexion_code_membre, $membre);
            $portable_membre = $membre->portable_membre;
            } else if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($sms_connexion2->sms_connexion_code_membre, $membremorale);
            $portable_membre = $membremorale->portable_membre;
            }*/

            if ($portable_membre != "") {
            //if ($portable_membre == $recipient) {$portable_membre
              $compteur = Util_Utils::findConuter() + 1;
              Util_Utils::addSmsMoov($compteur, $portable_membre, $sms_connexion2->sms_connexion_code_recu);

            //}else {
              //$compteur = Util_Utils::findConuter() + 1;
              //Util_Utils::addSms3($compteur, $portable_membre, "Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$sms_connexion2->sms_connexion_code_recu.". Merci. ESMC");
            //}
          }
                      }
        }

        $this->view->etat = "Status=0";

        } else {$this->view->etat = "Status=2";}

    }



public function addsmsreceive3Action()
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

$recipient = $_REQUEST['recipient'];
$body = str_replace('\0', '', $_REQUEST['body']);
$type = $_REQUEST['type'];
$MsgId = $_REQUEST['MsgId'];

//$recipient = $this->_request->getParam('recipient');
//$body = $this->_request->getParam('body');
//$type = $this->_request->getParam('type');

            //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {

    if ($recipient!="") {
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
        $smsreceive->setMsgId($MsgId);
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

        if(strlen(trim($sms)) == 10){
$codesms = substr((trim($sms)), -5);

          $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi(strtoupper($codesms));
          if ($sms_connexion2->sms_connexion_code_recu != "") {

                $telephoneM = new Application_Model_EuTelephoneMapper();
                $telephone = $telephoneM->findByCodeMembreCompagnie($sms_connexion2->sms_connexion_code_membre, "TOGOCEL");
                $portable_membre = $telephone->numero_telephone;

            /*if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($sms_connexion2->sms_connexion_code_membre, $membre);
            $portable_membre = $membre->portable_membre;
            } else if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($sms_connexion2->sms_connexion_code_membre, $membremorale);
            $portable_membre = $membremorale->portable_membre;
            }*/

            if ($portable_membre != "") {
            //if ($portable_membre == $recipient) {$portable_membre
              $compteur = Util_Utils::findConuter() + 1;
              Util_Utils::addSms5($compteur, $portable_membre, $sms_connexion2->sms_connexion_code_recu);

            //}else {
              //$compteur = Util_Utils::findConuter() + 1;
              //Util_Utils::addSms3($compteur, $portable_membre, "Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$sms_connexion2->sms_connexion_code_recu.". Merci. ESMC");
            //}
          }
                      }


        }else {


       
        
        
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
        $detail_montant = str_replace("%2C", "", $tab_suite[0]);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("FLOOZ", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "FLOOZ");
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

}





/*Bienvenu(e)+chez+Wari!+MAGNOUDEA+ADJO+KATABALE+vous+a+envoye+85%2C000+CFA++Code:+660+197+357+Disponible+dans+tout+le+reseau+Wari.Payez+vos+factures+ici+et+partout+dans+le+monde+avec+Wari.+Utilisez+www.mywari.com*/
        
        
        $pos2 = stripos($sms, "Wari");
        $pos3 = stripos($sms, "Bienvenu(e)+chez+Wari");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, "Bienvenu(e)+chez+Wari!+");
        $pos4 = stripos($sms, "+vous+a+envoye+");
        $sms_libelle = substr($sms, $pos + strlen("Bienvenu(e)+chez+Wari!+"), $pos4 - ($pos + strlen("Bienvenu(e)+chez+Wari!+")));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($sms, "+vous+a+envoye+");
        $pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen("+vous+a+envoye+"), $pos4 - ($pos + strlen("+vous+a+envoye+")));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("WARI", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "WARI");
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
            $a->setRelevebancaire_banque("WARI");
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

}

        
        
        

/*BATG SMS 2016-07-12 9:16:45 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: DANTSE ASSOU MONTANT = 5000*/
/*BATG SMS 2016-08-03 9:33:08 Alerte Avis de credit sur compte 40181660003: VERSEMENT ESPECES EFFECTUE PAR: AYENA ADEYEMI MONTANT = 300000*/        
        
        $pos2 = stripos($sms, "BATG");
        $pos3 = stripos($sms, "BATG SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($sms, " PAR: ");
        $pos4 = stripos($sms, " MONTANT ");
        $sms_libelle = substr($sms, $pos + strlen(" PAR: "), $pos4 - ($pos + strlen(" PAR: ")));
        //$detail_libelle = str_replace("+", " ", $sms_libelle);
        $detail_libelle = $sms_libelle;
        
        /*$pos = stripos($sms, "Code:+");
        $pos4 = stripos($sms, "+Disponible+");
        $sms_numero = substr($sms, $pos + strlen("Code:+"), $pos4 - ($pos + strlen("Code:+")));*/
        $detail_numero = "";
        
        $pos = stripos($sms, "BATG SMS ");
        $sms_date = substr($sms, $pos + strlen("BATG SMS "), 10);
        $detail_date = $sms_date;
        
        $pos = stripos($sms, " MONTANT = ");
        //$pos4 = stripos($sms, "+CFA+");
        $sms_montant = substr($sms, $pos + strlen(" MONTANT = "));
        $detail_montant = str_replace(",", "", $sms_montant);
        $detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        /*$relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BAT", trim($detail_numero));

        if(count($relevebancairedetail) == 0){*/
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BAT");
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
            $a->setRelevebancaire_banque("BAT");
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
        
//}



  $message_releve_bancaire2 = Util_Utils::verifReleveBancaire2("BAT", $detail_numero, $detail_date, $detail_montant, $detail_libelle, $compteur_rbd);

if(is_int($message_releve_bancaire2) || $message_releve_bancaire2 > 0){

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
        $mrb->find($compteur_rbd, $rb);

        $rb->setPublier(2);
        $mrb->update($rb);
}
//$this->_redirect('/sms/addsmsreceive2/'.$message_releve_bancaire2);
}

        
        
        
        
        

         
/*BOA-SMS: Alerte CREDIT 
 Cpt: 01XXXXX0006 
 Mnt: 5000 
 No: A587497 
 Date: 12/07/2016 
 Date Val: 13/07/2016 
 LBL: VERSEMENT ESPECES ASSOU DANTSE */
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A586941 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ABOULAYE M AB*/
/*BOA-SMS: Alerte CREDIT Cpt: 01XXXXX0006 Mnt: 5000 No: A587497 Date: 12/07/2016 Date Val: 13/07/2016 LBL: VERSEMENT ESPECES ASSOU DANTSE  */       

$body2 = preg_split("/[\s,]+/", $body);
$body3 = implode(" ", $body2);

$body = $body3;
        
        $pos2 = stripos($body, "BOA");
        $pos3 = stripos($body, "BOA-SMS");
if ($pos2 !== false && $pos3 !== false) { 
        
        
        $pos = stripos($body, " LBL: ");
        //$pos4 = stripos($body, "+vous+a+envoye+");
        $sms_libelle = substr($body, $pos + strlen(" LBL: "));
        $detail_libelle = str_replace("+", " ", $sms_libelle);
        
        $pos = stripos($body, " No: ");
        $pos4 = stripos($body, " Date: ");
        $sms_numero = substr($body, $pos + strlen(" No: "), $pos4 - ($pos + strlen(" No: ")));
        $detail_numero = str_replace("+", "", $sms_numero);
        
        $pos = stripos($body, " Date: ");
        $pos4 = stripos($body, " Date Val: ");
        $sms_date = substr($body, $pos + strlen(" Date: "), $pos4 - ($pos + strlen(" Date: ")));
        list($jour, $mois, $annee) = explode("/", $sms_date);
        $detail_date = $annee."-".$mois."-".$jour;
        //$detail_date = $date_id->toString('yyyy-MM-dd');
        
        $pos = stripos($body, " Mnt: ");
        $pos4 = stripos($body, " No: ");
        $sms_montant = substr($body, $pos + strlen(" Mnt: "), $pos4 - ($pos + strlen(" Mnt: ")));
        $detail_montant = str_replace(",", "", $sms_montant);
        //$detail_montant = str_replace("%2C", "", $sms_montant);
        
        $detail_date_valeur = "";
        
        
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("BOA", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "BOA");
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
            $a->setRelevebancaire_banque("BOA");
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
        

  $message_releve_bancaire2 = Util_Utils::verifReleveBancaire2("BOA", $detail_numero, $detail_date, $detail_montant, $detail_libelle, $compteur_rbd);

if(is_int($message_releve_bancaire2) || $message_releve_bancaire2 > 0){

        $rb = new Application_Model_EuRelevebancairedetail();
        $mrb = new Application_Model_EuRelevebancairedetailMapper();
        $mrb->find($compteur_rbd, $rb);

        $rb->setPublier(2);
        $mrb->update($rb);
}
//$this->_redirect('/sms/addsmsreceive2/'.$message_releve_bancaire2);
}

}


}

        $this->view->etat = "Status=0";

        } else {$this->view->etat = "Status=2";}

    }





public function addsmssentAction()
    {
        /* page administration/addsmsreceive - Ajout nombre de SMS */

        //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $this->_helper->layout->disableLayout();
        //$this->_helper->layout()->setLayout('layoutpublic');
      

/*$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms3($compteur, "90291387", "Test envoi. Merci. ESMC");  
*/ 

$compteur = Util_Utils::findConuter() + 1;
              Util_Utils::addSmsMoov($compteur, "96548623", "Veuillez saisir : NGXUK. Merci. ESMC");

$this->view->etat = "Status=0";


}


public function addsmssent2Action()
    {
        /* page administration/addsmsreceive - Ajout nombre de SMS */

        //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $this->_helper->layout->disableLayout();
        //$this->_helper->layout()->setLayout('layoutpublic');
      

/*$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms4($compteur, "90291387", "Test yok. Merci. ESMC");  
*/ 
//$date = urlencode(("07-09-2016 12:24:35"));
//$libelle = urlencode(("Yokamly Ruben LOOKY"));
//$homepage = file_get_contents("http://prod.gacsource.net/sms/addsmswari?transactionid=124585594&amount=10000&libelle=$libelle&transactionDate=$date");

//echo $homepage;
}






public function addsmswariAction()
    {
        /* page administration/addsmswari - Ajout nombre de SMS */

        //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $this->_helper->layout->disableLayout();
        //$this->_helper->layout()->setLayout('layoutpublic');
        
    //if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
//if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
$date_id = new Zend_Date(Zend_Date::ISO_8601);
        
/*
 "transactionid": "124585596",
 "amount": "10000",
 "firtname": "Issa Garadima",
 "lastname": "Bode",
 "transactionDate": "07/09/2016 12:24:35"

$transactionid = $_REQUEST['transactionid'];
$amount = $_REQUEST['amount'];
$libelle = $_REQUEST['libelle'];
$transactionDate = $_REQUEST['transactionDate'];
*/
$detail_numero = $_REQUEST['transactionid'];
$detail_montant = $_REQUEST['amount'];
$detail_libelle = urldecode($_REQUEST['libelle']);

$detail_date = urldecode(substr($_REQUEST['transactionDate'], 6, 4)."-".substr($_REQUEST['transactionDate'], 3, 2)."-".substr($_REQUEST['transactionDate'], 0, 2));
$detail_date_valeur = $detail_date;

if ($_REQUEST['transactionid']!="" && $_REQUEST['libelle']!="" && $_REQUEST['transactionDate']!="" && $_REQUEST['amount']>0) {
        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("WARI", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateWari($date_id->toString('yyyy-MM-dd'), "WARI");
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
            $a->setRelevebancaire_banque("WARI");
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


$this->view->etat = "Status=0";
        
        } else {$this->view->etat = "Status=2";}

        
}        
        


public function addsmswari2Action()
    {
        /* page administration/addsmswari - Ajout nombre de SMS */

        //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $this->_helper->layout->disableLayout();
        //$this->_helper->layout()->setLayout('layoutpublic');
        
    //if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
//if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
$date_id = new Zend_Date(Zend_Date::ISO_8601);
        
/*
 "transactionid": "124585596",
 "amount": "10000",
 "firtname": "Issa Garadima",
 "lastname": "Bode",
 "transactionDate": "07/09/2016 12:24:35"

$transactionid = $_REQUEST['transactionid'];
$amount = $_REQUEST['amount'];
$libelle = $_REQUEST['libelle'];
$transactionDate = $_REQUEST['transactionDate'];
*/
$detail_numero = $this->_request->getParam('transactionid');
$detail_montant = $this->_request->getParam('amount');
$detail_libelle = $this->_request->getParam('libelle');
$detail_date = $this->_request->getParam('transactionDate');

$detail_date = substr($detail_date, 6, 4)."-".substr($detail_date, 3, 2)."-".substr($detail_date, 0, 2);
$detail_date_valeur = $detail_date;

//if ($detail_numero != "" && $detail_libelle != "" && $detail_date != "" && $detail_montant > 0) {
        
        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("WARI", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateWari($date_id->toString('yyyy-MM-dd'), "WARI");
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
            $a->setRelevebancaire_banque("WARI");
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


$this->view->etat = "Status=0";
        
        //} else {$this->view->etat = "Status=2";}

        
}   




public function addsmsreceiveeasysAction()
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

$recipient = $_REQUEST['recipient'];
$body = str_replace('\0', '', $_REQUEST['body']);
$type = $_REQUEST['type'];
//$MsgId = $_REQUEST['MsgId'];
$MsgId = 0;

//$recipient = $this->_request->getParam('recipient');
//$body = $this->_request->getParam('body');
//$type = $this->_request->getParam('type');

            //$id = (int) $this->_request->getParam('id');
//if (isset($_REQUEST['recipient']) && $_REQUEST['recipient']!="" && isset($_REQUEST['body']) && $_REQUEST['body']!="") {

    if ($recipient!="") {
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
        $smsreceive->setMsgId($MsgId);
        $smsreceiveM->save($smsreceive);

/////////////////////////////////////
/*
        $sms = $body;

        if(strlen(trim($sms)) == 10){
$codesms = substr((trim($sms)), -5);

          $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi(strtoupper($codesms));
          if ($sms_connexion2->sms_connexion_code_recu != "") {

                $telephoneM = new Application_Model_EuTelephoneMapper();
                $telephone = $telephoneM->findByCodeMembreCompagnie($sms_connexion2->sms_connexion_code_membre, "TOGOCEL");
                $portable_membre = $telephone->numero_telephone;*/

            /*if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($sms_connexion2->sms_connexion_code_membre, $membre);
            $portable_membre = $membre->portable_membre;
            } else if (substr($sms_connexion2->sms_connexion_code_membre, -1) == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($sms_connexion2->sms_connexion_code_membre, $membremorale);
            $portable_membre = $membremorale->portable_membre;
            }*/



/*
            if ($portable_membre != "") {
            //if ($portable_membre == $recipient) {$portable_membre
              $compteur = Util_Utils::findConuter() + 1;
              Util_Utils::addSms4($compteur, $portable_membre, $sms_connexion2->sms_connexion_code_recu);

            //}else {
              //$compteur = Util_Utils::findConuter() + 1;
              //Util_Utils::addSms3($compteur, $portable_membre, "Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$sms_connexion2->sms_connexion_code_recu.". Merci. ESMC");
            //}
            }
                      }


        }
*/
////////////////////////////////////////////////////////////////////////////////////



        } 

    }






public function addnotificationtmoneyAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');

/*$purchaseref = $_GET['purchaseref'];
$amount = $_GET['amount'];
$currency = $_GET['currency'];
$status = $_GET['status'];
$clientid = $_GET['clientid'];
$cname = $_GET['cname'];
$mobile = $_GET['mobile'];
$paymentref = $_GET['paymentref'];
$payid = $_GET['payid'];
$timestamp = $_GET['timestamp'];
$ipaddr = $_GET['ipaddr'];
$error = $_GET['error'];*/

    $recipient = $_REQUEST['mobile'];
    $body = "cname=".$_REQUEST['cname']." - purchaseref=".$_REQUEST['purchaseref']." - paymentref=".$_REQUEST['paymentref']." - amount=".$_REQUEST['amount']." - currency=".$_REQUEST['currency']." - mobile=".$_REQUEST['mobile']." - payid=".$_REQUEST['payid']." - timestamp=".$_REQUEST['timestamp'];
    $type = "TMONEY";
    $MsgId = $_REQUEST['payid'];

//if($status == "OK"){$etat = 0;}else{$etat = 1;}

    if ($recipient!="") {
        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $smsreceive = new Application_Model_EuSmsReceive();
        $smsreceiveM = new Application_Model_EuSmsReceiveMapper();

        $compteursms = $smsreceiveM->findConuter() + 1;

        $smsreceive->setNEng($compteursms);
        $smsreceive->setRecipient($recipient);
        $smsreceive->setSMSBody($body);
        $smsreceive->setTypeExpediteur($type);
        $smsreceive->setDateTime($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $smsreceive->setEtat($etat);
        $smsreceive->setMsgId($MsgId);
        $smsreceiveM->save($smsreceive);


        $sms = $body;

              $detail_libelle = $_REQUEST['cname'];
              $detail_numero = $_REQUEST['paymentref'];
              $detail_date = $_REQUEST['timestamp'];
              $detail_montant = $_REQUEST['amount'];
              $detail_date_valeur = "";

        

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero("TMONEY", trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), "TMONEY");
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
            $a->setRelevebancaire_banque("TMONEY");
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

        $this->view->etat = "Status=0";

        } else {$this->view->etat = "Status=1";}

    }










public function addnotifasmacarmesAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


              $detail_libelle = $_REQUEST['libelle'];
              $detail_numero = $_REQUEST['numero'];
              $detail_date = $_REQUEST['date_depot'];
              $detail_montant = $_REQUEST['montant'];
              $detail_date_valeur = $_REQUEST['date_depot'];
              $code_membre = $_REQUEST['code_membre'];
              $code_banque = $_REQUEST['code_banque'];

            $ok = 0;

        $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero($code_banque, trim($detail_numero));

        if(count($relevebancairedetail) == 0){
                
        $relevebancaire2M = new Application_Model_EuRelevebancaireMapper();
        $relevebancaire2 = $relevebancaire2M->fetchAllByDateFlooz($date_id->toString('yyyy-MM-dd'), $code_banque);
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

if($code_membre != ""){
$ok = Util_Utils::addBAn($code_membre, $detail_numero, $detail_date, $detail_montant, $detail_libelle, $code_banque);
}else{
$ok = 2;    
}
            
            }else{
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuRelevebancaire();
        $ma = new Application_Model_EuRelevebancaireMapper();
            
            $compteur = $ma->findConuter() + 1;
            $a->setRelevebancaire_id($compteur);
            $a->setRelevebancaire_banque($code_banque);
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
            
if($code_membre != ""){
$ok = Util_Utils::addBAn($code_membre, $detail_numero, $detail_date, $detail_montant, $detail_libelle, $code_banque);
}else{
$ok = 2;    
}
                }
            
}else{
$ok = 3;    
}

if($ok == 1){
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "2", 
                                'message' => "RELEVE BIEN CHARGE ET BAn BIEN EFFECTUE"
                            )
                        );
        //echo "OK";
}else if($ok == 2){
        //echo "OK";
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "RELEVE BIEN CHARGE"
                            )
                        );
}else if($ok == 3){
        //echo "OK";
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "NUMERO DEJA UTILISE"
                            )
                        );
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "KO"
                            )
                        );   
    //echo $detail_libelle; 
}



    }






public function addbangrosAction() {
       $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$bon_neutre_numero = $_REQUEST['numero'];
$bon_neutre_date_numero = $_REQUEST['date_depot'];
$bon_neutre_montant = $_REQUEST['montant'];
$bon_neutre_banque = $_REQUEST['code_banque'];

/*echo $_REQUEST['numero'];
echo "<br>";
echo $_REQUEST['date_depot'];
echo "<br>";
echo $_REQUEST['montant'];
echo "<br>";
echo $bon_neutre_banque;*/
            $ok = 0;

  if (
  isset($bon_neutre_banque) && $bon_neutre_banque!="" &&
  isset($bon_neutre_numero) && $bon_neutre_numero!="" && $bon_neutre_numero!=NULL &&
  isset($bon_neutre_date_numero) && $bon_neutre_date_numero!="" &&
  isset($bon_neutre_montant) && $bon_neutre_montant!="") {


                    //$db = Zend_Db_Table::getDefaultAdapter();
                    //$db->beginTransaction();
                    //try {
                            $date_id = Zend_Date::now();
//echo $sessionbanqueopi->error = $bon_neutre_banque;

                                $banque = new Application_Model_EuBanque();
                                $banqueM = new Application_Model_EuBanqueMapper();
                                $banqueM->find($bon_neutre_banque, $banque);
                                if($banque->code_membre_morale != ""){

                                $membre_morale = new Application_Model_EuMembreMorale();
                                $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
                                $membre_moraleM->find($banque->code_membre_morale, $membre_morale);

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



                        /////////////////controle montant
                        if($bon_neutre_banque == "BOA" || $bon_neutre_banque == "UTB" || $bon_neutre_banque == "BAT" || $bon_neutre_banque == "ECOBANK" || $bon_neutre_banque == "ORABANK" || $bon_neutre_banque == "WARI" || $bon_neutre_banque == "BPEC" || $bon_neutre_banque == "CCP" || $bon_neutre_banque == "BTCI" || $bon_neutre_banque == "FAIP" || $bon_neutre_banque == "CECL" || $bon_neutre_banque == "MECIT" || $bon_neutre_banque == "MUTUAL" || $bon_neutre_banque == "MECI" || $bon_neutre_banque == "ASMA") {

                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                            $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                            $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate7($bon_neutre_banque, $bon_neutre_numero, $libellebanques, $bon_neutre_date_numero);
                            
                            if($bon_neutre_banque == "ASMA") {
                               $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                            $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($bon_neutre_banque, $bon_neutre_numero, $bon_neutre_date_numero);
                             
                                if($bon_neutre_montant != $relevebancairedetail->relevebancairedetail_montant) {
                                //$db->rollback();
                                $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT SAISI NON CONFORME AU MONTANT DU VERSEMENT."
                            )
                        );
                                //$this->_redirect('/banqueopi/addbangros');
                                return;
                                }
                            }else if(count($relevebancairedetail) > 0) {
                                if($bon_neutre_montant != $relevebancairedetail->relevebancairedetail_montant) {
                                //$db->rollback();
                                $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT SAISI NON CONFORME AU MONTANT DU VERSEMENT."
                            )
                        );
                                //$this->_redirect('/banqueopi/addbangros');
                                return;
                                }
                            }else{

                                if($bon_neutre_banque == "BAT"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($bon_neutre_banque, $libellebanques, $bon_neutre_date_numero);
                                    if(count($relevebancairedetail) > 0) {
                                        if($bon_neutre_montant != $relevebancairedetail->relevebancairedetail_montant) {
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT SAISI NON CONFORME AU MONTANT DU VERSEMENT."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LES RENSEIGNEMENTS CONCERNANT LE VERSEMENT SONT ERRONES OU NE SONT PAS ENCORE VERIFIABLES."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                } else if($bon_neutre_banque == "ECOBANK"){
                                    $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                    $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate6($bon_neutre_banque, $bon_neutre_numero, $bon_neutre_date_numero);
                                    if(count($relevebancairedetail) > 0) {
                                        if($bon_neutre_montant != $relevebancairedetail->relevebancairedetail_montant) {
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT SAISI NON CONFORME AU MONTANT DU VERSEMENT."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LES RENSEIGNEMENTS CONCERNANT LE VERSEMENT SONT ERRONES OU NE SONT PAS ENCORE VERIFIABLES."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                } else if($bon_neutre_banque == "ORABANK"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($bon_neutre_banque, $libellebanques, $bon_neutre_date_numero);
                                    if(count($relevebancairedetail) > 0) {
                                        if($bon_neutre_montant != $relevebancairedetail->relevebancairedetail_montant) {
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT SAISI NON CONFORME AU MONTANT DU VERSEMENT."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LES RENSEIGNEMENTS CONCERNANT LE VERSEMENT SONT ERRONES OU NE SONT PAS ENCORE VERIFIABLES."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                }else if($bon_neutre_banque == "UTB"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($bon_neutre_banque, $libellebanques, $bon_neutre_date_numero);
                                    if(count($relevebancairedetail) > 0) {
                                        if($bon_neutre_montant != $relevebancairedetail->relevebancairedetail_montant) {
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT SAISI NON CONFORME AU MONTANT DU VERSEMENT."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LES RENSEIGNEMENTS CONCERNANT LE VERSEMENT SONT ERRONES OU NE SONT PAS ENCORE VERIFIABLES."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                }else{
                                        //$db->rollback();
                                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "NUMERO DEJA UTILISE."
                            )
                        );
                                        //$this->_redirect('/banqueopi/addbangros');
                                        return;
                                }
                            }
                        } else {

                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LES RENSEIGNEMENTS CONCERNANT LE VERSEMENT SONT ERRONES OU NE SONT PAS ENCORE VERIFIABLES."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbangros');
                                    return;
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


///////////////////////////////////calcul commission banque//////////////////////////////

//$montant_commission_banque = floor($bon_neutre_montant * Util_Utils::getParamEsmc(17) / 100);
///////////////////////////////////calcul commission banque//////////////////////////////

//if($request->getParam("caution") == "AvecCommission"){

$$montant_commission_2 = 0;
$montant_commission = 0;
$montant = $bon_neutre_montant;
$montant_2 = 0;

do {
    if($montant > Util_Utils::getParamEsmc(23)){
        $montant_2 = Util_Utils::getParamEsmc(23);
        $montant = $montant - Util_Utils::getParamEsmc(23);
    }else{
        $montant_2 = $montant;
        $montant = $montant - $montant;
    }


    if($montant_2 > Util_Utils::getParamEsmc(22) && $montant_2 < Util_Utils::getParamEsmc(23)){
        $montant_commission = floor((Util_Utils::getParamEsmc(22) * Util_Utils::getParamEsmc(19) / 100) + (($montant_2 - Util_Utils::getParamEsmc(22)) * Util_Utils::getParamEsmc(21)));   
    }else if($montant_2 == Util_Utils::getParamEsmc(22)){
        $montant_commission = floor($montant_2 * Util_Utils::getParamEsmc(19) / 100);
    }else if($montant_2 < Util_Utils::getParamEsmc(22)){
        $montant_commission = floor($montant_2 * Util_Utils::getParamEsmc(19) / 100);
    }else if($montant_2 == Util_Utils::getParamEsmc(23)){
        $montant_commission = floor(Util_Utils::getParamEsmc(23) * Util_Utils::getParamEsmc(17) / 100);
    }


$montant_commission_2 = $montant_commission_2 + $montant_commission;
} while ($montant > 0);

$montant_commission_banque = $montant_commission_2;

/*}else if($request->getParam("caution") == "SansCommission"){
    $montant_commission_banque = $request->getParam("bon_neutre_montant");
}*/
                            




/////////////////////////////////////controle code membre
if(isset($bon_neutre_code_membre) && $bon_neutre_code_membre!=""){
if(strlen($bon_neutre_code_membre) != 20) {
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VERIFIEZ BIEN LE NOMBRE DE CARACTERES DU CODE MEMBRE."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbangros');
                                    return;
}else{
if(substr($bon_neutre_code_membre, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($bon_neutre_code_membre, $membre);
                                if(count($membre) == 0){
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VEUILLEZ BIEN SAISIR LE CODE MEMBRE PP ..."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
                                if($bon_neutre_nom == "" || $bon_neutre_nom == NULL){
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "VEUILLEZ BIEN SAISIR LE NOM ET PRENOM(S)"
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
    }
if(substr($bon_neutre_code_membre, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($bon_neutre_code_membre, $membremorale);
                                if(count($membremorale) == 0){
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VEUILLEZ BIEN SAISIR LE CODE MEMBRE PM ..."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
                                if($bon_neutre_raison == "" || $bon_neutre_raison == NULL){
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "VEUILLEZ BIEN SAISIR LA RAISON SOCIALE"
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
    }
}

//////////////////////////////////////////////
                                $ban2M = new Application_Model_EuBanMapper();
                                $ban2 = $ban2M->fetchAllOneMembre();
                                //if($ban2->solde >= $bon_neutre_montant){ 

                                $ban = new Application_Model_EuBan();
                                $banM = new Application_Model_EuBanMapper();
                                $banM->find($ban2->id_ban, $ban);

                                $ban->setMont_vendu($ban->getMont_vendu() + ($bon_neutre_montant + $montant_commission_banque));
                                $ban->setSolde($ban->getSolde() - ($bon_neutre_montant + $montant_commission_banque));
                                //$banM->update($ban);

                                $ban_id = $ban->id_ban;


                            $ban_vendu = new Application_Model_EuBanVendu();
                            $ban_vendu_mapper = new Application_Model_EuBanVenduMapper();

                            $compteur_ban_vendu = $ban_vendu_mapper->findConuter() + 1;
                            $ban_vendu->setId_ban_vendu($compteur_ban_vendu);
                            $ban_vendu->setId_ban($ban_id);
                            $ban_vendu->setDate_ban_vendu($date_id->toString('yyyy-MM-dd'));
                            $ban_vendu->setCode_membre($bon_neutre_code_membre);
                            $ban_vendu->setMont_vendu($bon_neutre_montant + $montant_commission_banque);
                            $ban_vendu->setNumero_recu($bon_neutre_numero);
                            $ban_vendu->setId_user(NULL);
                            //$ban_vendu_mapper->save($ban_vendu);

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
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



/////////////////////////////commission esmc banque
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($id_canton);
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


                                $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
                                $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail2M->find($relevebancairedetail->relevebancairedetail_id, $relevebancairedetail2);

                                $relevebancairedetail2->setPublier(1);
                                $relevebancairedetail2M->update($relevebancairedetail2);
        

                        

                            ///////////////////////////////////////////////////////////////////////////////////////




                            //$db->commit();

                            $sessionbanqueopicode_BAn = $code_BAn;
                            $sessionbanqueopimembre_code = $bon_neutre->bon_neutre_code_membre;

                            $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "BAn BIEN EFFECTUE"
                            )
                        );
/*if($sessionbanqueopimembre_code != "" && $sessionbanqueopimembre_code != NULL){
   echo $sessionbanqueopi->error; .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$sessionbanqueopimembre_code."</strong><br />";
   echo $sessionbanqueopi->error; .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    echo $sessionbanqueopi->error; .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    echo $sessionbanqueopi->error; .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";
*/

                            //$this->_redirect('/banqueopi/addbangros');
                            return;
//
    //

/*} else {  $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn Source insufisant"
                            )
                        );
                         }*/
} else {  $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "CODE MEMBRE INEXISTANTE"
                            )
                        );
                         return;
                     }
} else {  $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BANQUE NON EXISTANTE"
                            )
                        );
                         return;
                     }


                    /*}  catch (Exception $exc) {
                        $db->rollback();
                        //$this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => $exc->getMessage() . ': ' . $exc->getTraceAsString()
                            )
                        );
                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "KO"
                            )
                        );
                        //$this->_redirect('/banqueopi/addbangros');
                        return;
                    }*/


            }   else {  $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "CHAMPS * OBLIGATOIRE ..."
                            )
                        );
                         return;
                     }




//echo $sessionbanqueopi->error;


    }









public function addbanapproAction() {
       $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');

if($_REQUEST['montant'] < 50000000){
    $id_type_acteur = 4;
}else if($_REQUEST['montant'] >= 50000000 && $_REQUEST['montant'] < 100000000){
    $id_type_acteur = 3;
}else if($_REQUEST['montant'] >= 100000000){
    $id_type_acteur = 2;
}
              
              $bon_neutre_appro_montant = $_REQUEST['montant'];
              $bon_neutre_appro_beneficiaire = $_REQUEST['code_membre'];
              $code_banque = $_REQUEST['code_banque'];

            $ok = 0;

        $date_id = Zend_Date::now();

        $request = $this->getRequest ();
        //if ($request->isPost ()) {

$banque = new Application_Model_EuBanque();
$banque_mapper = new Application_Model_EuBanqueMapper();
$banque_mapper->find($code_banque, $banque);
if($banque->code_membre_morale != ""){

$membre_morale = new Application_Model_EuMembreMorale();
$membre_morale_mapper = new Application_Model_EuMembreMoraleMapper();
$membre_morale_mapper->find($banque->code_membre_morale, $membre_morale);



  if (isset($bon_neutre_appro_beneficiaire) && $bon_neutre_appro_beneficiaire!="" && isset($id_type_acteur) && $id_type_acteur!="" && isset($bon_neutre_appro_montant) && $bon_neutre_appro_montant > 0) {

                    //$db = Zend_Db_Table::getDefaultAdapter();
                    //$db->beginTransaction();
                    //try {
                            $date_id = Zend_Date::now();

                //$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
                do{
                                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
                }while(count($bon_neutre_detail2) > 0);

if($bon_neutre_appro_beneficiaire == $banque->code_membre_morale) {
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE DU BENEFICIAIRE DOIT ETRE DIFFERENT DU CODE MEMBRE DE L'APPORTEUR."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbanappro');
                                    return;
}
/////////////////////////////////////controle code membre
if(strlen($bon_neutre_appro_beneficiaire) != 20) {
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VERIFIEZ BIEN LE NOMBRE DE CARACTERES DU CODE MEMBRE."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbanappro');
                                    return;
}else{
if(substr($bon_neutre_appro_beneficiaire, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                if($membre_mapper->find($bon_neutre_appro_beneficiaire, $membre)){
                                }else{
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VEUILLEZ BIEN SAISIR LE CODE MEMBRE PP ..."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbanappro');
                                    return;
                                }
                $canton = $membre->id_canton;
                $nom = $membre->nom_membre;
                $prenom = $membre->prenom_membre;
                $email = $membre->email_membre;
                $mobile = $membre->portable_membre;
                $raison = "";
    } else if(substr($bon_neutre_appro_beneficiaire, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                if($membremorale_mapper->find($bon_neutre_appro_beneficiaire, $membremorale)){
                                }else{
                                  //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VEUILLEZ BIEN SAISIR LE CODE MEMBRE PM ..."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbanappro');
                                    return;
                                }
                $canton = $membremorale->id_canton;
                $nom = "";
                $prenom = "";
                $email = $membremorale->email_membre;
                $mobile = $membremorale->portable_membre;
                $raison = $membremorale->raison_sociale;
    }else{
      //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VEUILLEZ BIEN SAISIR LE CODE MEMBRE..."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbanappro');
                                    return;
    }
}


                                $banque_pcommission = new Application_Model_EuBanquePcommission();
                                $banque_pcommissionM = new Application_Model_EuBanquePcommissionMapper();
                                $banque_pcommission2 = $banque_pcommissionM->fetchAllByCodeBanqueTypeActeur($code_banque, $id_type_acteur, 1);
                                if (count($banque_pcommission2) == 0) {
                                    /****/
                                }else{
                                $banque_pcommission = new Application_Model_EuBanquePcommission();
                                $banque_pcommissionM = new Application_Model_EuBanquePcommissionMapper();
                                $banque_pcommission2 = $banque_pcommissionM->fetchAllByCodeBanqueTypeActeur($code_banque, $id_type_acteur, -1);
                                if (count($banque_pcommission2) == 0) {
                                    //$db->rollback();
                                    $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE POURCENTAGE DE COMMISSION N'EST PAS DEFINI ..."
                            )
                        );
                                    //$this->_redirect('/banqueopi/addbanappro');
                                    return;
                                }
                            }


$bon_neutre_appro_montant = $bon_neutre_appro_montant + ($bon_neutre_appro_montant * $banque_pcommission2->pcommission / 100);


                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($banque->code_membre_morale);
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

if($bon_neutre_appro_montant > $bon_neutre->getBon_neutre_montant_solde()){
  //$db->rollback();
                $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE MONTANT A ALLOUER EST SUPERIEUR AU SOLDE DE VOTRE BAn..."
                            )
                        );
  //$this->_redirect('/banqueopi/addbanappro');
  return;

}else{


$bon_neutre_appro = new Application_Model_EuBonNeutreAppro();
$bon_neutre_appro_mapper = new Application_Model_EuBonNeutreApproMapper();

$compteur_bon_neutre_appro = $bon_neutre_appro_mapper->findConuter() + 1;
$bon_neutre_appro->setBon_neutre_appro_id($compteur_bon_neutre_appro);
$bon_neutre_appro->setBon_neutre_appro_beneficiaire(strtoupper($bon_neutre_appro_beneficiaire));
$bon_neutre_appro->setBon_neutre_appro_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$bon_neutre_appro->setBon_neutre_appro_montant($bon_neutre_appro_montant);
$bon_neutre_appro->setBon_neutre_appro_apporteur($banque->code_membre_morale);
$bon_neutre_appro->setBon_neutre_appro_banque_user(NULL);
$bon_neutre_appro_mapper->save($bon_neutre_appro);





                                //$bon_neutre->setBon_neutre_code($code_BAn);
                                //$bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant());
                $bon_neutre->setBon_neutre_montant_utilise($bon_neutre->getBon_neutre_montant_utilise() + $bon_neutre_appro_montant);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() - $bon_neutre_appro_montant);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;



                                /*$bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                                $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                                $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                                $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                                $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($bon_neutre_appro_beneficiaire, -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($bon_neutre_appro_beneficiaire, -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_utilise2->setBon_neutre_utilise_montant($bon_neutre_appro_montant);
                                $bon_neutre_utilise2M->save($bon_neutre_utilise2);*/

///////////////////////////////////////////////////////////////////////////

$mont = $bon_neutre_appro_montant;

                    $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();
                   
                    $bon_neutre_detail = $bon_neutre_detail_mapper->fetchAllByBonNeutreValide($bon_neutre->bon_neutre_id);
                    foreach ($bon_neutre_detail as $detail){
                                $bon_neutre_detail2 = new Application_Model_EuBonNeutreDetail();
                                $bon_neutre_detail2M = new Application_Model_EuBonNeutreDetailMapper();
                                $bon_neutre_detail2M->find($detail->bon_neutre_detail_id, $bon_neutre_detail2);

if($bon_neutre_detail2->getBon_neutre_detail_banque() == "" || $bon_neutre_detail2->getBon_neutre_detail_banque() == NULL){
$appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();
$appro_detail = $appro_detail_mapper->fetchAllByBanque($detail->bon_neutre_appro_id);
$code_banque = $appro_detail->bon_neutre_appro_detail_banque;
}else{
$code_banque = $bon_neutre_detail2->getBon_neutre_detail_banque();
}

                       if($bon_neutre_detail2->getBon_neutre_detail_type() == "ELI"){
                        $code_banque2 = $bon_neutre_detail2->getBon_neutre_detail_numero();
                       }else if($bon_neutre_detail2->getBon_neutre_detail_type() == "COM"){
                        $code_banque2 = "COM-".$bon_neutre_detail2->getBon_neutre_detail_numero();
                       }else{
                        $code_banque2 = $code_banque;
                       }


                        if($bon_neutre_detail2->getBon_neutre_detail_montant_solde() < $mont){
$mont = $mont - $bon_neutre_detail2->getBon_neutre_detail_montant_solde();

$bon_neutre_appro_detail = new Application_Model_EuBonNeutreApproDetail();
$bon_neutre_appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();

$bon_neutre_appro_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
$bon_neutre_appro_detail->setBon_neutre_detail_id($detail->bon_neutre_detail_id);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$bon_neutre_appro_detail->setBon_neutre_appro_detail_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
$bon_neutre_appro_detail->setBon_neutre_appro_detail_mont_utilise(0);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
$bon_neutre_appro_detail->setBon_neutre_appro_detail_banque($code_banque2);
$bon_neutre_appro_detail_mapper->save($bon_neutre_appro_detail);

                $bon_neutre_detail2->setBon_neutre_detail_montant_utilise($bon_neutre_detail2->getBon_neutre_detail_montant_utilise() + $bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_detail2->setBon_neutre_detail_montant_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde() - $bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_detail2M->update($bon_neutre_detail2);



                                $bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                                $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                                $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                                $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                                $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($bon_neutre_appro_beneficiaire, -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($bon_neutre_appro_beneficiaire, -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_utilise2->setBon_neutre_utilise_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_utilise2->setBon_neutre_detail_id($bon_neutre_detail2->bon_neutre_detail_id);
                       $bon_neutre_utilise2->setUsertable("utilisateur");
                       $bon_neutre_utilise2->setUser_id(1);
                                $bon_neutre_utilise2M->save($bon_neutre_utilise2);

                                
                                }else{

$bon_neutre_appro_detail = new Application_Model_EuBonNeutreApproDetail();
$bon_neutre_appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();

$bon_neutre_appro_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
$bon_neutre_appro_detail->setBon_neutre_detail_id($detail->bon_neutre_detail_id);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$bon_neutre_appro_detail->setBon_neutre_appro_detail_montant($mont);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_mont_utilise(0);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_solde($mont);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_banque($code_banque2);
$bon_neutre_appro_detail_mapper->save($bon_neutre_appro_detail);

                                $bon_neutre_detail2->setBon_neutre_detail_montant_utilise($bon_neutre_detail2->getBon_neutre_detail_montant_utilise() + $mont);
                                $bon_neutre_detail2->setBon_neutre_detail_montant_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde() - $mont);
                                $bon_neutre_detail2M->update($bon_neutre_detail2);


                                $bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                                $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                                $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                                $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                                $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($bon_neutre_appro_beneficiaire, -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($bon_neutre_appro_beneficiaire, -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_utilise2->setBon_neutre_utilise_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_utilise2->setBon_neutre_detail_id($bon_neutre_detail2->bon_neutre_detail_id);
                       $bon_neutre_utilise2->setUsertable("utilisateur");
                       $bon_neutre_utilise2->setUser_id(1);
                                $bon_neutre_utilise2M->save($bon_neutre_utilise2);

                                break;
                                }


                        }
                            


///////////////////////////////////////////////////////////////////////////

                $bon_neutre3_mapper = new Application_Model_EuBonNeutreMapper();
                $bon_neutre3 = $bon_neutre3_mapper->fetchAllByMembre(strtoupper($bon_neutre_appro_beneficiaire));
                if(count($bon_neutre3) > 0){
                  $bon_neutre31 = new Application_Model_EuBonNeutre();
                                $bon_neutre31M = new Application_Model_EuBonNeutreMapper();
                                $bon_neutre31M->find($bon_neutre3->bon_neutre_id, $bon_neutre31);

                                $bon_neutre31->setBon_neutre_code($code_BAn);
                                $bon_neutre31->setBon_neutre_montant($bon_neutre31->getBon_neutre_montant() + $bon_neutre_appro_montant);
                  $bon_neutre31->setBon_neutre_montant_solde($bon_neutre31->getBon_neutre_montant_solde() + $bon_neutre_appro_montant);
                                $bon_neutre31M->update($bon_neutre31);


                                $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                                $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                                $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                                $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                                $bon_neutre_detail->setBon_neutre_id($bon_neutre3->bon_neutre_id);
                                $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                                $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_detail->setBon_neutre_detail_montant($bon_neutre_appro_montant);
                                $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                                $bon_neutre_detail->setBon_neutre_detail_montant_solde($bon_neutre_appro_montant);
                                $bon_neutre_detail->setBon_neutre_detail_banque(NULL);
                                $bon_neutre_detail->setBon_neutre_detail_numero(NULL);
                                $bon_neutre_detail->setBon_neutre_detail_date_numero(NULL);
                                $bon_neutre_detail->setId_canton($canton);
                                $bon_neutre_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                                $bon_neutre_detail_mapper->save($bon_neutre_detail);


                  }else{

                                              $bon_neutre = new Application_Model_EuBonNeutre();
                                  $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                                  $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                                  $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                                  $bon_neutre->setBon_neutre_type("BAn");
                                  $bon_neutre->setBon_neutre_code($code_BAn);
                                  $bon_neutre->setBon_neutre_code_membre(strtoupper($bon_neutre_appro_beneficiaire));
                                  $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                  $bon_neutre->setBon_neutre_montant($bon_neutre_appro_montant);
                                  $bon_neutre->setBon_neutre_montant_utilise(0);
                                  $bon_neutre->setBon_neutre_montant_solde($bon_neutre_appro_montant);
                                  $bon_neutre->setBon_neutre_nom($nom);
                                  $bon_neutre->setBon_neutre_prenom($prenom);
                                  $bon_neutre->setBon_neutre_raison($raison);
                                  $bon_neutre->setBon_neutre_email($email);
                                  $bon_neutre->setBon_neutre_mobile($mobile);
                                  $bon_neutre_mapper->save($bon_neutre);




                                $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                                  $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                                  $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                                  $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                                  $bon_neutre_detail->setBon_neutre_id($compteur_bon_neutre);
                                  $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                                  $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                  $bon_neutre_detail->setBon_neutre_detail_montant($bon_neutre_appro_montant);
                                  $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                                  $bon_neutre_detail->setBon_neutre_detail_montant_solde($bon_neutre_appro_montant);
                                  $bon_neutre_detail->setBon_neutre_detail_banque(NULL);
                                  $bon_neutre_detail->setBon_neutre_detail_numero(NULL);
                                  $bon_neutre_detail->setBon_neutre_detail_date_numero(NULL);
                                  $bon_neutre_detail->setId_canton($canton);
                                  $bon_neutre_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                                  $bon_neutre_detail_mapper->save($bon_neutre_detail);


                    }


                            ///////////////////////////////////////////////////////////////////////////////////////

                            //$db->commit();
                            $sessionbanqueopi->error = "Opération bien effectuée. <br />
Vous venez de faire un approvisionnement de Bon d'Achat neutre (BAn). <br />
Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong>";
                            $sessionbanqueopicode_BAn = $code_BAn;
$this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "BAn BIEN EFFECTUE"
                            )
                        );
                            //$this->_redirect('/banqueopi/addbanappro');
                            return;
}
}   else {
                            //$db->rollback();
                                          $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "LE CODE MEMBRE EST ERRONE. VEUILLEZ BIEN SAISIR LE CODE MEMBRE ..."
                            )
                        );
                            //$this->_redirect('/banqueopi/addbanappro');
                            return;
}

                    /*}  catch (Exception $exc) {
                        //$db->rollback();
                        //$this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "KO";
                        //$this->_redirect('/banqueopi/addbanappro');
                        return;
                    }*/
                  }   else {  $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "CHAMPS * OBLIGATOIRE ..."
                            )
                        );
                         }
                  
    } else {  $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BANQUE NON EXISTANTE"
                            )
                        );
                         }



//echo $sessionbanqueopi->error;



    }






public function payeopiAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$code_membre = $_REQUEST['code_membre'];
$numero_opi = $_REQUEST['numero_opi'];
$status = $_REQUEST['status'];
$code_banque = $_REQUEST['code_banque'];

            $ok = 0;

        $traite2_m = new Application_Model_EuTraiteMapper();
        $traite2 = $traite2_m->fetchAllByMembreNumero($code_membre, $numero_opi);
        if(count($traite2) > 0){

        $traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($traite2->traite_id, $traite);

        if($status == "OK"){

            if($traite->traite_payer == 0){
        $traite->setTraite_payer(1);
        $traiteM->update($traite);

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "PAIEMENT OPI BIEN REÇU"
                            )
                        );
    }else{

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "OPI DEJA PAYE"
                            )
                        );

    }
        }else if($status == "NOK"){
        //$traite->setTraite_payer(0);
        //$traiteM->update($traite);

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "OPI NON PAYE"
                            )
                        );
        }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "STATUS NON RENSEIGNE"
                            )
                        );   
}


        }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "NUMERO OPI OU CODE MEMBRE ERRONE"
                            )
                        );   
}



    }





public function addpayeropiAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$code_membre = $_REQUEST['code_membre'];
$date_echeance = $_REQUEST['date_echeance'];
$montant = $_REQUEST['montant'];
$numero_opi = $_REQUEST['numero_opi'];
$code_banque = $_REQUEST['code_banque'];

            $ok = 0;

        $traite2_m = new Application_Model_EuTraiteMapper();
        $traite2 = $traite2_m->fetchAllByMembreNumero($code_membre, $numero_opi);
        if($traite2 !== false){
            if($traite2->traite_date_fin == $date_echeance){
            if($traite2->mode_paiement == $code_banque){
            if($traite2->traite_montant == $montant){
                if($traite2->traite_disponible == 1 && $traite2->traite_imprimer == 1){
                    if($traite2->traite_payer == 0){

                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "PAYER L'OPI",
                                'num_compte_asma' => $traite2->reference_paiement, 
                                'traite_numero' => $traite2->traite_numero
                            )
                        );   

                    }else{
                            $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "OPI DEJA PAYER"
                            )
                        );   
                    }
                }else{
                        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "OPI NON DISPONIBLE"
                            )
                        );   
                }
            }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MONTANT ERRONE"
                            )
                        );
            }
        }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BANQUE NON CORRESPONDANTE"
                            )
                        );
            }
        }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "DATE ECHEANCE NON CONFORME"
                            )
                        );
        }
    }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "OPI NON EXISTANT"
                            )
                        );
        }


    }




    public function addsmsallAction()
    {
        /* page administration/addpage - Création de page libre d'information */

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['smsbody']) && $_POST['smsbody']!="" && isset($_FILES['numero_fichier']['name']) && $_FILES['numero_fichier']['name']!="") {
		
		include("Transfert.php");
            if(isset($_FILES['numero_fichier']['name']) && $_FILES['numero_fichier']['name']!="") {
                $chemin = "numeros";
                $file = $_FILES['numero_fichier']['name'];
                $file1='numero_fichier';
                $fichier = $chemin."/".transfert($chemin,$file1);
            } else {$fichier = "";}
            
            //$fichier = $fichier;
		
$messageopi = $_POST['smsbody'];


            
            $_fichier = strtolower(substr($fichier, -4));
            if($_fichier == ".csv" || $_fichier == ".CSV") { // || $_fichier == ".xls" || $_fichier == "xlsx"
        
                    $fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
                    $lines = file($fichier);
    
                    foreach ($lines as $line_num => $line) {
                        //list($nom, $numero) = explode(";", $line);
                        //$numero = $line;

$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms2($compteur, $line, $messageopi);
Util_Utils::addSms3Easys($compteur, $line, $messageopi);
//Util_Utils::addSms3EasysOld($compteur, $line, $messageopi);

 } 
$sessionutilisateur->error = "SMS bien envoyé ...";                                         
                } 
			
		$this->_redirect('/sms/addsmsall');
		} else {  $sessionutilisateur->error = "Champs * obligatoire ...";  } 
		}
		
    }









public function membreasmaAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$code_membre = $_REQUEST['code_membre'];
$code_banque = $_REQUEST['code_banque'];
$num_compte_bancaire = $_REQUEST['num_compte_bancaire'];
$option = $_REQUEST['option'];

            $ok = 0;

        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->findByCodeMembreBanqueNum($code_membre, $code_banque, $num_compte_bancaire);
if($compte_bancaire_autre->num_compte_bancaire != ""){

        $compte_bancaire3 = new Application_Model_EuCompteBancaire();
        $compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

        //$compte_bancaire3->setPrincipal(1);
        //$compte_bancaire3M->update($compte_bancaire3);

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "CODE MEMBRE DEJA LIE"
                            )
                        );

}else{

        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->findByBanqueNum($code_banque, $num_compte_bancaire);
if($compte_bancaire_autre->num_compte_bancaire != ""){

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "NUMERO COMPTE ASMA DEJA LIE A UN AUTRE CODE MEMBRE"
                            )
                        );


}else{

                $comptebancaire = new Application_Model_EuCompteBancaire();
                $m_comptebancaire = new Application_Model_EuCompteBancaireMapper();

                    $compteur = $m_comptebancaire->findConuter() + 1;

                    $comptebancaire->setId_compte($compteur);
                    $comptebancaire->setNum_compte_bancaire($num_compte_bancaire);
                    $comptebancaire->setCode_banque($code_banque);
        if(substr($code_membre, -1) == 'P'){
                    $comptebancaire->setCode_membre($code_membre);
        }else{
                    $comptebancaire->setCode_membre_morale($code_membre);
        }
                    $comptebancaire->setPrincipal(1);
                    $m_comptebancaire->save($comptebancaire);


        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($compteur, $code_membre);
        if (count($compte_bancaire_autre) > 0) {

        foreach ($compte_bancaire_autre as $value) {
        $compte_bancaire3 = new Application_Model_EuCompteBancaire();
        $compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

        $compte_bancaire3->setPrincipal(0);
        $compte_bancaire3M->update($compte_bancaire3);
        }
        }


if($option == 1){

        $traite2 = new Application_Model_EuTraiteMapper();
        $traite_autre = $traite2->fetchAllByMembreDateFin($code_membre, $traite_date_fin);

        if (count($traite_autre) > 0) {
        foreach ($traite_autre as $value) {
        $traite3 = new Application_Model_EuTraite();
        $traite3M = new Application_Model_EuTraiteMapper();
        $traite3M->find($value->traite_id, $traite3);

        $traite3->setMode_paiement($code_banque);
        $traite3->setReference_paiement($num_compte_bancaire);
        $traite3M->update($traite3);
        }
        }

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "CODE MEMBRE BIEN LIE AU NUMERO DE COMPTE ASMA. MISE A JOUR OPI BIEN EFFECTUE."
                            )
                        );


}else{

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "CODE MEMBRE BIEN LIE AU NUMERO DE COMPTE ASMA."
                            )
                        );


}


}
}



    }




public function apicomptebancaireAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$code_membre = $_REQUEST['code_membre'];
$code_banque = $_REQUEST['code_banque'];
$type_membre = $_REQUEST['type_membre'];
$raison_sociale = $_REQUEST['raison_sociale'];
$nom_membre = $_REQUEST['nom_membre'];
$prenom_membre = $_REQUEST['prenom_membre'];
$date_nais_membre = $_REQUEST['date_nais_membre'];
$compte_asma = $_REQUEST['compte_asma'];

            $ok = 0;

if(strlen($code_membre) == 20){

if ($type_membre == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($code_membre, $membre);
if($membre->nom_membre == urldecode($nom_membre) && $membre->prenom_membre == urldecode($prenom_membre) && $membre->date_nais_membre == $date_nais_membre){
        $compte_bancaire_m = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire = $compte_bancaire_m->findByCodeMembreBanqueNum($code_membre, $code_banque, $compte_asma);
if($compte_bancaire->num_compte_bancaire == $compte_asma){

        $compte_bancaire1 = new Application_Model_EuCompteBancaire();
        $compte_bancaire1M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire1M->find($compte_bancaire->id_compte, $compte_bancaire1);

        $compte_bancaire1->setPrincipal(1);
        $compte_bancaire1M->update($compte_bancaire1);

        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($compte_bancaire1->id_compte, $code_membre);

        foreach ($compte_bancaire_autre as $value) {
        $compte_bancaire3 = new Application_Model_EuCompteBancaire();
        $compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

        $compte_bancaire3->setPrincipal(0);
        $compte_bancaire3M->update($compte_bancaire3);
        }

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "COMPTE DEJA CREE",
                                'code_membre' => $compte_bancaire1->code_membre,
                                'compte_asma' => $compte_bancaire1->num_compte_bancaire
                            )
                        );
}else{
                $comptebancaire = new Application_Model_EuCompteBancaire();
                $m_comptebancaire = new Application_Model_EuCompteBancaireMapper();

                    $compteur = $m_comptebancaire->findConuter() + 1;

                    $comptebancaire->setId_compte($compteur);
                    $comptebancaire->setNum_compte_bancaire($compte_asma);
                    $comptebancaire->setCode_banque($code_banque);
        if(substr($code_membre, -1) == 'P'){
                    $comptebancaire->setCode_membre($code_membre);
        }else{
                    $comptebancaire->setCode_membre_morale($code_membre);
        }
                    $comptebancaire->setPrincipal(1);
                    $m_comptebancaire->save($comptebancaire);

        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($comptebancaire->id_compte, $code_membre);

        foreach ($compte_bancaire_autre as $value) {
        $compte_bancaire3 = new Application_Model_EuCompteBancaire();
        $compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

        $compte_bancaire3->setPrincipal(0);
        $compte_bancaire3M->update($compte_bancaire3);
        }

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "COMPTE BIEN CREE",
                                'code_membre' => $comptebancaire->code_membre,
                                'compte_asma' => $comptebancaire->num_compte_bancaire
                            )
                        );
}
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "ERREUR MEMBRE PHYSIQUE"
                            )
                        );
}
} else if ($type_membre == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($code_membre, $membremorale);

                $representation = new Application_Model_EuRepresentation();
                $m_representation  = new Application_Model_EuRepresentationMapper();
                $findrep  = $m_representation->findbyrep($code_membre);

                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($findrep->code_membre, $membre);
if($membremorale->raison_sociale == urldecode($raison_sociale)){
        $compte_bancaire_m = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire = $compte_bancaire_m->findByCodeMembreBanqueNum($code_membre, $code_banque, $compte_asma);
if($compte_bancaire->num_compte_bancaire == $compte_asma){

        $compte_bancaire1 = new Application_Model_EuCompteBancaire();
        $compte_bancaire1M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire1M->find($compte_bancaire->id_compte, $compte_bancaire1);

        $compte_bancaire1->setPrincipal(1);
        $compte_bancaire1M->update($compte_bancaire1);

        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($compte_bancaire1->id_compte, $code_membre);

        foreach ($compte_bancaire_autre as $value) {
        $compte_bancaire3 = new Application_Model_EuCompteBancaire();
        $compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

        $compte_bancaire3->setPrincipal(0);
        $compte_bancaire3M->update($compte_bancaire3);
        }

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "COMPTE DEJA CREE",
                                'code_membre' => $compte_bancaire1->code_membre_morale,
                                'compte_asma' => $compte_bancaire1->num_compte_bancaire
                            )
                        );
}else{
                $comptebancaire = new Application_Model_EuCompteBancaire();
                $m_comptebancaire = new Application_Model_EuCompteBancaireMapper();

                    $compteur = $m_comptebancaire->findConuter() + 1;

                    $comptebancaire->setId_compte($compteur);
                    $comptebancaire->setNum_compte_bancaire($compte_asma);
                    $comptebancaire->setCode_banque($code_banque);
        if(substr($code_membre, -1) == 'P'){
                    $comptebancaire->setCode_membre($code_membre);
        }else{
                    $comptebancaire->setCode_membre_morale($code_membre);
        }
                    $comptebancaire->setPrincipal(1);
                    $m_comptebancaire->save($comptebancaire);

        $compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($comptebancaire->id_compte, $code_membre);

        foreach ($compte_bancaire_autre as $value) {
        $compte_bancaire3 = new Application_Model_EuCompteBancaire();
        $compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
        $compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

        $compte_bancaire3->setPrincipal(0);
        $compte_bancaire3M->update($compte_bancaire3);
        }

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "COMPTE BIEN CREE",
                                'code_membre' => $comptebancaire->code_membre_morale,
                                'compte_asma' => $comptebancaire->num_compte_bancaire
                            )
                        );
}
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "ERREUR MEMBRE MORALE"
                            )
                        );
}
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "ERREUR CODE MEMBRE"
                            )
                        );
}
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "ERREUR CODE MEMBRE"
                            )
                        );
}        






    }





public function apimembreAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$code_membre = $_REQUEST['code_membre'];
$code_banque = $_REQUEST['code_banque'];

            $ok = 0;

if(strlen($code_membre) == 20){

if (substr($code_membre, -1) == "P") {
                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($code_membre, $membre);
if($membre->nom_membre != ""){
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "MEMBRE PHYSIQUE TROUVE", 
                                'type_membre' => "P", 
                                'raison_sociale' => "", 
                                'nom_membre' => $membre->nom_membre, 
                                'prenom_membre' => $membre->prenom_membre, 
                                'date_nais_membre' => $membre->date_nais_membre
                            )
                        );
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MEMBRE PHYSIQUE NON TROUVE"
                            )
                        );
}
} else if (substr($code_membre, -1) == "M") {
                $membremoraleM = new Application_Model_EuMembreMoraleMapper();
                $membremorale = new Application_Model_EuMembreMorale();
                $membremoraleM->find($code_membre, $membremorale);

                $representation = new Application_Model_EuRepresentation();
                $m_representation  = new Application_Model_EuRepresentationMapper();
                $findrep  = $m_representation->findbyrep($code_membre);

                $membreM = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membreM->find($findrep->code_membre, $membre);
if($membremorale->raison_sociale != ""){
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "MEMBRE MORALE TROUVE", 
                                'type_membre' => "M", 
                                'raison_sociale' => $membremorale->raison_sociale, 
                                'nom_membre' => $membre->nom_membre, 
                                'prenom_membre' => $membre->prenom_membre, 
                                'date_nais_membre' => $membre->date_nais_membre
                            )
                        );
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "MEMBRE MORALE NON TROUVE"
                            )
                        );
}
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "ERREUR CODE MEMBRE"
                            )
                        );
}
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "ERREUR CODE MEMBRE"
                            )
                        );
}        


    }




public function addbanflooztmoneyAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$tx_reference = $_REQUEST['tx_reference'];
$identifier = $_REQUEST['identifier'];
$payment_reference = $_REQUEST['payment_reference'];
$amount = $_REQUEST['amount'];
$datetime = $_REQUEST['datetime'];
$code_banque = $_REQUEST['code_banque'];
$status = $_REQUEST['status'];
$payment_method = $_REQUEST['payment_method'];

            $ok = 0;

if($status == 0){

            $relevedetail = new Application_Model_EuRelevebancairedetail ();
            $m_relevedetail = new Application_Model_EuRelevebancairedetailMapper ();
            $m_relevedetail->find($identifier, $relevedetail);

        $relevedetail->setRelevebancairedetail_date_valeur($datetime);
        $relevedetail->setRelevebancairedetail_numero($payment_reference);
        //$relevedetail->setRelevebancairedetail_libelle($relevedetail->relevebancairedetail_libelle);//
        $relevedetail->setPublier(1);
        $m_relevedetail->update($relevedetail);

list($autre1, $autre2) = explode("#", $relevedetail->getRelevebancairedetail_libelle());
$code_membre = substr($autre2,0,20);            
//$code_membre = substr($relevedetail->getRelevebancairedetail_libelle(), (strpos($relevedetail->getRelevebancairedetail_libelle(), "#") + 1), 20);

$ok = Util_Utils::addBAn($code_membre, $tx_reference, $relevedetail->getRelevebancairedetail_date(), $relevedetail->getRelevebancairedetail_montant(), $relevedetail->getRelevebancairedetail_libelle(), $code_banque);


        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "BAn bien effectué"
                            )
                        );

    }else{

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn non effectué"
                            )
                        );

    }



    }



public function addbanfloozAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$tx_reference = $_REQUEST['tx_reference'];
$identifier = $_REQUEST['identifier'];
$phone_number = $_REQUEST['phone_number'];
$amount = $_REQUEST['amount'];
$datetime = $date_id->toString('yyyy-MM-dd HH:mm:ss');
$code_banque = $_REQUEST['code_banque'];
$status = $_REQUEST['status'];

            $ok = 0;

if($status == 0){

            $relevedetail = new Application_Model_EuRelevebancairedetail ();
            $m_relevedetail = new Application_Model_EuRelevebancairedetailMapper ();
            $m_relevedetail->find($identifier, $relevedetail);

        $relevedetail->setRelevebancairedetail_date_valeur($datetime);
        $relevedetail->setRelevebancairedetail_numero($tx_reference);
        $relevedetail->setRelevebancairedetail_libelle($relevedetail->relevebancairedetail_libelle + " - " + $phone_number);
        $relevedetail->setPublier(1);
        $m_relevedetail->update($relevedetail);

list($autre1, $autre2) = explode("#", $relevedetail->getRelevebancairedetail_libelle());
$code_membre = substr($autre2,0,20);            
//$code_membre = substr($relevedetail->getRelevebancairedetail_libelle(), (strpos($relevedetail->getRelevebancairedetail_libelle(), "#") + 1), 20);

$ok = Util_Utils::addBAn($code_membre, $tx_reference, $relevedetail->getRelevebancairedetail_date(), $relevedetail->getRelevebancairedetail_montant(), $relevedetail->getRelevebancairedetail_libelle(), $code_banque);


        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "BAn bien effectué"
                            )
                        );

    }else{

        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn non effectué"
                            )
                        );

    }



    }






public function addbanapproflooztmoneyAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$tx_reference = $_REQUEST['tx_reference'];
$identifier = $_REQUEST['identifier'];
$payment_reference = $_REQUEST['payment_reference'];
$amount = $_REQUEST['amount'];
$datetime = $_REQUEST['datetime'];
$code_banque = $_REQUEST['code_banque'];
$status = $_REQUEST['status'];
$payment_method = $_REQUEST['payment_method'];

            $ok = 0;

if($status == 0){

if($payment_method == "FLOOZ"){
$code_membre = "0000000000000000004M";
}else if($payment_method == "T-Money"){
$code_membre = "0000000000000000005M";
}

$bon_neutre_appro_montant = $amount + ($amount * Util_Utils::getParamEsmc(19) / 100);

$ok = Util_Utils::addBAnAppro($code_membre, $identifier, $bon_neutre_appro_montant);

if($ok == 1){
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "BAn bien effectué"
                            )
                        );
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn non effectué"
                            )
                        );
    }
    }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn non effectué"
                            )
                        );
    }



    }




public function addbangrosflooztmoneyAction() {
       //$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublic');


        $date_id = new Zend_Date(Zend_Date::ISO_8601);


$tx_reference = $_REQUEST['tx_reference'];
$identifier = $_REQUEST['identifier'];
$payment_reference = $_REQUEST['payment_reference'];
$amount = $_REQUEST['amount'];
$datetime = $_REQUEST['datetime'];
$code_banque = $_REQUEST['code_banque'];
$status = $_REQUEST['status'];
$payment_method = ($_REQUEST['payment_method']);

            $ok = 0;

if($status == 0){

//$bon_neutre_appro_montant = $amount + ($amount * Util_Utils::getParamEsmc(19) / 100);

$ok = Util_Utils::addBAnGrosFloozTmoney($payment_method, $identifier, $amount, $payment_reference, $datetime, $tx_reference);

if($ok == 1){
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "1", 
                                'message' => "BAn bien effectué"
                            )
                        );
}else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn non effectué"
                            )
                        );
    }
    }else{
        $this->view->error = Zend_Json::encode(
                            array(
                                'resultat' => "0", 
                                'message' => "BAn non effectué"
                            )
                        );
    }



    }



}
