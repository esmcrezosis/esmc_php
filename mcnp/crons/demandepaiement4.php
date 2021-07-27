#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';




     ini_set('memory_limit', '102499999999M');   

             //$db = Zend_Db_Table::getDefaultAdapter();
             //$db->beginTransaction();
        try {








//////////////////////////////////////////////ban commission
   $date_id = new Zend_Date(Zend_Date::ISO_8601);

      //$debut = "2018-03-01";
        $fin = "2018-04-30";

      //$debut = new Zend_Date(Zend_Date::ISO_8601);
      $fin = new Zend_Date($fin);
      $fin_1 = new Zend_Date($fin);
      $fin->addDay(1);
        
      //$debut = $debut->toString('yyyy-MM-dd');
      $fin   = $fin->toString('yyyy-MM-dd');
      $fin_1   = $fin_1->toString('yyyy-MM-dd');

            $type_demande = "BAn";
   $ok = 0;
        $bonneutreapproT = new Application_Model_DbTable_EuBonNeutreAppro();
        $select = $bonneutreapproT->select();
        $select->from($bonneutreapproT, array("bon_neutre_appro_apporteur"));
        $select->distinct();
        //$select->where("bon_neutre_appro_commission = 0");//bon_neutre_appro_date >= '".$debut."' AND 
        //$select->where("bon_neutre_appro_apporteur LIKE '0010010010010000010P'");
        $select->where("bon_neutre_appro_date <= '".$fin."'");//bon_neutre_appro_date >= '".$debut."' AND 
        //$select->where("(bon_neutre_appro_apporteur IN (SELECT code_membre FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE guichet = 1))");
        $select->where("bon_neutre_appro_apporteur IN (SELECT code_membre FROM eu_association WHERE guichet = 1)");
        $bonneutreapprooo = $bonneutreapproT->fetchAll($select);
        foreach ($bonneutreapprooo as $rows) {


/*if($rows->bon_neutre_appro_apporteur == '0010010010010007428P'){
    $ok = 1;
}else{
    if($ok == 1){
        $ok = 1;
    }else{
        $ok = 0;
    }       
}

if($ok == 1){*/

$code_membre_employe = $rows->bon_neutre_appro_apporteur;
echo $code_membre_employe." .1<br>";
        
if($rows->bon_neutre_appro_apporteur == "" || $rows->bon_neutre_appro_apporteur == NULL) {
echo $message = "ESMC. Veuillez mettre à jour votre Code Membre dans votre espace integrateur. Merci"." .2<br>";

$telephone2M = new Application_Model_EuTelephoneMapper();
$telephone2 = $telephone2M->findByCodeMembre($code_membre_employe);
if($telephone2 > 0){
$phone = $telephone2->numero_telephone;
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms2($compteur, $phone, $message);
Util_Utils::addSms3Easys($compteur, $phone, $message);
}
//$this->_redirect('/integrateur/editmembreassomembre');
continue;
}

$code_membre_employeur = $rows->bon_neutre_appro_apporteur;
echo $code_membre_employeur." .3<br>";

if(!isset($code_membre_employeur) || $code_membre_employeur == "" || $code_membre_employeur == NULL) {
echo $message = "ESMC. Demandez à votre responsable de mettre à jour son Code Membre dans son espace integrateur. Merci"." .4<br>";

$telephone2M = new Application_Model_EuTelephoneMapper();
$telephone2 = $telephone2M->findByCodeMembre($code_membre_employeur);
if($telephone2 > 0){
$phone = $telephone2->numero_telephone;
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms2($compteur, $phone, $message);
Util_Utils::addSms3Easys($compteur, $phone, $message);
}
//$this->_redirect('/integrateur/adddemande');
continue;
}


        $bonneutreapproD = new Application_Model_DbTable_EuBonNeutreAppro();
        $selectD = $bonneutreapproD->select();
        $selectD->from($bonneutreapproD, array("bon_neutre_appro_date"));
        //$selectD->distinct();
        $selectD->where('bon_neutre_appro_apporteur = ?', $rows->bon_neutre_appro_apporteur);
        $selectD->where("bon_neutre_appro_date <= '".$fin."'");//bon_neutre_appro_date >= '".$debut."' AND 
        $selectD->where("bon_neutre_appro_id IN (SELECT bon_neutre_appro_id FROM eu_bon_neutre_appro_detail WHERE bon_neutre_detail_id IN (SELECT bon_neutre_detail_id FROM eu_bon_neutre_detail WHERE bon_neutre_detail_banque IS NOT NULL))");
        //$selectD->where("bon_neutre_appro_commission = 0");
        $selectD->where("bon_neutre_appro_banque_user IS NULL");
        //$selectD->where("(bon_neutre_appro_apporteur IN (SELECT code_membre FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE guichet = 1))");
        $selectD->where("bon_neutre_appro_apporteur IN (SELECT code_membre FROM eu_association WHERE guichet = 1)");
        $selectD->order(array('bon_neutre_appro_id ASC'));
        $selectD->limit(1);
        $bonneutreapproooD = $bonneutreapproD->fetchRow($selectD);
        if(count($bonneutreapproooD) > 0){
        //var_dump($bonneutreapproooD);
//$debut = $bonneutreapproooD->bon_neutre_appro_date;
//$debut = "2016-10-11";
//echo $debut = substr($bonneutreapproooD->bon_neutre_appro_date, 0, 10)." .5<br>";
//$debut = $debut->toString('yyyy-MM-dd');." .5<br>"
echo $debut = "2018-04-01";


$code_membre_surveillance = "0010010010010000002M";
$code_compte_surveillance = "NN-TMARGE-0010010010010000002M";

//var_dump($bon_neutre_appro2);

        $bon_neutre_appro2_t = new Application_Model_DbTable_EuBonNeutreAppro();
        $select = $bon_neutre_appro2_t->select();
        if($debut != ""){
        $select->where("bon_neutre_appro_date >= '".$debut."' AND bon_neutre_appro_date <= '".$fin."'");
        }
        if($rows->bon_neutre_appro_apporteur != ""){
        $select->where("bon_neutre_appro_apporteur = ? ", $rows->bon_neutre_appro_apporteur);
            }
        $select->where("bon_neutre_appro_id IN (SELECT bon_neutre_appro_id FROM eu_bon_neutre_appro_detail WHERE bon_neutre_detail_id IN (SELECT bon_neutre_detail_id FROM eu_bon_neutre_detail WHERE bon_neutre_detail_banque IS NOT NULL))");
        //$select->where("bon_neutre_appro_commission = 0");
        $select->where("bon_neutre_appro_banque_user IS NULL");
        //$select->where("(bon_neutre_appro_apporteur IN (SELECT code_membre FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE guichet = 1))");
        $select->where("bon_neutre_appro_apporteur IN (SELECT code_membre FROM eu_association WHERE guichet = 1)");
        $bon_neutre_appro2 = $bon_neutre_appro2_t->fetchAll($select);

$commissiondetails = array();
$i = 0;
$montant_employe2 = 0;

foreach ($bon_neutre_appro2 as $rows_bon_neutre_appro2) {

$bon_neutre_appro_detail2_mapper = new Application_Model_EuBonNeutreApproDetailMapper();
$bon_neutre_appro_detail2 = $bon_neutre_appro_detail2_mapper->fetchAllByAppro($rows_bon_neutre_appro2->bon_neutre_appro_id);
$montant_appro_valide = 0;
foreach ($bon_neutre_appro_detail2 as $rows_bon_neutre_appro_detail2) {

$bon_neutre_detail2 = new Application_Model_EuBonNeutreDetail();
$bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
$bon_neutre_detail2_mapper->find($rows_bon_neutre_appro_detail2->bon_neutre_detail_id, $bon_neutre_detail2);

if($bon_neutre_detail2->bon_neutre_detail_banque != NULL && $bon_neutre_detail2->bon_neutre_detail_banque != ""){
$bon_neutre2 = new Application_Model_EuBonNeutre();
$bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
$bon_neutre2_mapper->find($bon_neutre_detail2->bon_neutre_id, $bon_neutre2);

        $relevebancairedetail2_t = new Application_Model_DbTable_EuRelevebancairedetail();
        $select = $relevebancairedetail2_t->select();
        $select->where("relevebancairedetail_numero LIKE '%".$bon_neutre_detail2->bon_neutre_detail_numero."%'");
        $select->where("(relevebancairedetail_libelle LIKE '%".addslashes($bon_neutre2->bon_neutre_nom." ".$bon_neutre2->bon_neutre_prenom)."%'");
        $select->orwhere("relevebancairedetail_libelle LIKE '%".addslashes($bon_neutre2->bon_neutre_raison)."%')");
        $relevebancairedetail2 = $relevebancairedetail2_t->fetchAll($select);
if(count($relevebancairedetail2) > 0){
$montant_appro_valide += $rows_bon_neutre_appro_detail2->bon_neutre_appro_detail_montant;
}
}
}
$montant_employe2 += $montant_appro_valide;
$commissiondetails[$i][0] = $rows_bon_neutre_appro2->bon_neutre_appro_id;
$commissiondetails[$i][1] = $montant_appro_valide;
$i++;
}

$tauxcommission = Util_Utils::getParamEsmc(17);

$montant_commission = floor($montant_employe2 * $tauxcommission / 100);
echo $montant_employe2." .61<br>";
echo $montant_commission." .62<br>";

if($montant_commission > 0){  
$demande_paiement_mapper = new Application_Model_EuDemandePaiementMapper();
$demande_paiement = $demande_paiement_mapper->fetchAllByQuizaine($code_membre_employeur, $debut, $fin_1, $type_demande); 

if (count($demande_paiement) > 0) {
$message = "Vous avez déjà émit la demande de paiement de cette quinzaine ...";
//$this->_redirect('/integrateur/adddemandeban');
continue;
/*}else if ($montant_commission < Util_Utils::getParamEsmc(18)) {//100
$message = "Montant insuffisant ...";
//$this->_redirect('/integrateur/adddemandeban');
continue;*/
}else{

////////demande_paiement

//$numero_demande_paiement = strtoupper(Util_Utils::genererCodeSMS(10));
do{
                    $numero_demande_paiement = strtoupper(Util_Utils::genererCodeSMS(10));
                    $demande_paiement2_mapper = new Application_Model_EuDemandePaiementMapper();
                    $demande_paiement2 = $demande_paiement2_mapper->fetchAllByNumero_demande_paiement($numero_demande_paiement);
}while(count($commande2) > 0);/**/


$demande_paiement = new Application_Model_EuDemandePaiement();
$demande_paiement_mapper = new Application_Model_EuDemandePaiementMapper();

$compteur_demande_paiement = $demande_paiement_mapper->findConuter() + 1;
$demande_paiement->setId_demande_paiement($compteur_demande_paiement);
$demande_paiement->setMontant_demande_paiement($montant_commission);
$demande_paiement->setDate_demande_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$demande_paiement->setCode_membre_employeur($code_membre_employeur);
$demande_paiement->setPayer(0);
$demande_paiement->setDate_debut($debut);
$demande_paiement->setDate_fin($fin_1);
$demande_paiement->setType_demande($type_demande);
$demande_paiement->setNumero_demande_paiement($numero_demande_paiement);
$demande_paiement_mapper->save($demande_paiement);
echo $montant_commission." .7<br>";


/////paiement
$paiement = new Application_Model_EuPaiement();
$paiement_mapper = new Application_Model_EuPaiementMapper();

$compteur_paiement = $paiement_mapper->findConuter() + 1;
$paiement->setId_paiement($compteur_paiement);
$paiement->setMontant_paiement($montant_commission);
$paiement->setDate_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$paiement->setCode_membre_employe($code_membre_employe);
$paiement->setId_demande_paiement($compteur_demande_paiement);
$paiement->setPayer(0);
$paiement_mapper->save($paiement);
echo $montant_commission." .8<br>";


///////detail_paiement
//$bon_neutre_appro_mapper = new Application_Model_EuBonNeutreApproMapper();
//$bon_neutre_appro = $bon_neutre_appro_mapper->fetchAllByCommission10($rows->bon_neutre_appro_apporteur, $debut, $fin);
//foreach ($bon_neutre_appro as $row) {
for ($i=0; $i < count($commissiondetails); $i++) { 



              ////////////////////////////////////////////////////////////////////////////
$tauxcommission = Util_Utils::getParamEsmc(17);

$montantFraisExploitation = floor($commissiondetails[$i][1] * $tauxcommission / 100);

/*        //creation et utilisation de la source NN
                 $nn = new Application_Model_EuNn();
                 $t_nn = new Application_Model_DbTable_EuNn();
                 $count = $nn->findConuter() + 1;
                 $nn->setId_nn($count)
                    ->setDate_emission($date_id->toString('yyyy-MM-dd HH:mm:ss'))
                    ->setType_emission('Auto Int')
                    ->setMontant_emis($montantFraisExploitation)
                    ->setMontant_remb($montantFraisExploitation)
                    ->setSolde_nn(0.0)
                    ->setEmetteur_nn($code_membre_surveillance)
                    ->setCode_type_nn("NNMARGE")
                    ->setId_utilisateur(NULL);
                 $t_nn->insert($nn->toArray());
        
                    $compteNnMargeSurveillance = $code_compte_surveillance;
                  $compte = new Application_Model_EuCompte();
                  $compteM = new Application_Model_EuCompteMapper();
                  $compteM->find($compteNnMargeSurveillance, $compte);

                  $compte->setSolde($compte->getSolde() + $montantFraisExploitation);
                  $compteM->update($compte);



$mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;

        $place_op = new Application_Model_EuOperation();
                $place_op->setId_operation($compteur)
                        ->setDate_op($date_id->toString('yyyy-MM-dd'))
                        ->setMontant_op($montantFraisExploitation)
                        ->setCode_membre(NULL)
                        ->setCode_membre_morale($code_membre_surveillance)
                        ->setHeure_op($date_id->toString('HH:mm:ss'))
                        ->setCode_produit("NN")
                        ->setId_utilisateur(NULL)
                        ->setLib_op("CREATION DE COMMISSION APPROVISIONNEMENT BAn")
                        ->setCode_cat('BAn')
                        ->setType_op('BAn');
                $mapper_op->save($place_op);*/

//Util_Utils::addOperation($compteur,NULL,$code_membre_surveillance,'BAn',$montantFraisExploitation,'NN',"CREATION DE COMMISSION APPROVISIONNEMENT BAn",'BAn',$date_id->toString('yyyy-MM-dd'), $date_id->toString('HH:mm:ss'), $sessionmembreasso->membreasso_id);
//echo $commissiondetails[$i][0]." .91<br>";                                
echo $commissiondetails[$i][1]." .92<br>";                                
echo $montantFraisExploitation." .93<br>";
              ///////////////////////////////////////////////////////////////////////////////////////



$detail_paiement = new Application_Model_EuDetailPaiement();
$detail_paiement_mapper = new Application_Model_EuDetailPaiementMapper();

$compteur_detail_paiement = $detail_paiement_mapper->findConuter() + 1;
$detail_paiement->setId_detail_paiement($compteur_detail_paiement);
$detail_paiement->setId_paiement($compteur_paiement);
$detail_paiement->setId_pointage(NULL);
$detail_paiement->setMontant_paiement($montantFraisExploitation);
$detail_paiement->setBon_neutre_appro_id($commissiondetails[$i][0]);
$detail_paiement->setSouscription_id(NULL);
$detail_paiement_mapper->save($detail_paiement);


$bon_neutre_appro3 = new Application_Model_EuBonNeutreAppro();
$bon_neutre_appro3_mapper = new Application_Model_EuBonNeutreApproMapper();
$bon_neutre_appro3_mapper->find($commissiondetails[$i][0], $bon_neutre_appro3);
      
$bon_neutre_appro3->setBon_neutre_appro_commission(1);
$bon_neutre_appro3_mapper->update($bon_neutre_appro3);

}

}
}     
}
//}
}







                //$db->commit();
                    
                    
               } catch(Exception $exc) {
                   //$db->rollback();
                   $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
               }


 