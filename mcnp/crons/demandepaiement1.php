#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';




     ini_set('memory_limit', '102499999999M');   

             //$db = Zend_Db_Table::getDefaultAdapter();
             //$db->beginTransaction();
        try {







//////////////////////////////////////////////activation commission
   $date_id = new Zend_Date(Zend_Date::ISO_8601);

      $debut = "2017-12-01";
      $fin = "2018-01-31";
        
      $debut = new Zend_Date($debut);
      $fin = new Zend_Date($fin);
      $fin_1 = new Zend_Date($fin);
      $fin->addDay(1);
        
      $debut = $debut->toString('yyyy-MM-dd');
      $fin   = $fin->toString('yyyy-MM-dd');
      $fin_1   = $fin_1->toString('yyyy-MM-dd');
        
        $type_demande = "Activation";
   
        $partagemT = new Application_Model_DbTable_EuPartagem();
        $select = $partagemT->select();
        $select->from($partagemT, array("partagem_membreasso"));
        $select->distinct();
        $select->where("partagem_date >= '".$debut."' AND partagem_date <= '".$fin."'");
        //$select->where("partagem_montant_solde > 0");
        $select->where("partagem_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE guichet = 1))");
        $partagemmm = $partagemT->fetchAll($select);
        foreach ($partagemmm as $rows) {

$membreasso = new Application_Model_EuMembreasso();
$membreasso_mapper = new Application_Model_EuMembreassoMapper();
$membreasso_mapper->find($rows->partagem_membreasso, $membreasso);


if($membreasso->code_membre == "" || $membreasso->code_membre == NULL) {
echo $message = "ESMC. Veuillez mettre à jour votre Code Membre dans votre espace integrateur. Merci<br>";

$phone = "228".$membreasso->membreasso_mobile;
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms2($compteur, $phone, $message);
//Util_Utils::addSms3Easys($compteur, $phone, $message);
//$this->_redirect('/integrateur/editmembreassomembre');
continue;
}

$code_membre_employe = $membreasso->code_membre;

echo $code_membre_employe." .<br>";

$association2 = new Application_Model_EuAssociation();
$association2_mapper = new Application_Model_EuAssociationMapper();
$association2_mapper->find($membreasso->membreasso_association, $association2);
if($association2->guichet == 1){

$code_membre_employeur = $association2->code_membre;

$phone = "228".$association2->association_mobile;
}else{
$membreasso2 = new Application_Model_EuMembreasso();
$membreasso2_mapper = new Application_Model_EuMembreassoMapper();
$membreasso2 = $membreasso2_mapper->fetchAllByAssociation($membreasso->membreasso_association);

//$code_membre_employeur = $membreasso2->code_membre;
$code_membre_employeur = $association2->code_membre;

//$phone = "228".$membreasso2->membreasso_mobile;
$phone = "228".$association2->association_mobile;
}

echo $code_membre_employeur." .<br>";

if($code_membre_employeur == "" || $code_membre_employeur == NULL) {
echo $message = "ESMC. Demandez à votre responsable de mettre à jour son Code Membre dans son espace integrateur. Merci<br>";

//$phone = "228".$membreasso2->membreasso_mobile;
$phone = "228".$association2->association_mobile;
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms2($compteur, $phone, $message);
//Util_Utils::addSms3Easys($compteur, $phone, $message);
//$this->_redirect('/integrateur/adddemande');
continue;
}


$taux_commission = 480;
$montant_commission = 0;
/////////////////////////////////////////////////////////////////////////////////
        $activation_t = new Application_Model_DbTable_EuActivation();
        $select = $activation_t->select();
        $select->from($activation_t, array('COUNT(id_activation) as nombre'));
        $select->where("membreasso_id = ? ", $membreasso->membreasso_id);
        $select->where("date_activation >= '".$debut."' AND date_activation <= '".$fin."'");
        $select->where("code_membre NOT IN (SELECT membre_doublon_code_membre2 FROM eu_membre_doublon)");
        $entries_activation = $activation_t->fetchAll($select);
        //var_dump($entries_activation);
if(count($entries_activation)>0){
    $entry = $entries_activation[0];
if($association2->guichet == 1){
$activation_montant = floor(480 * 25 / 100);
}else{
$activation_montant = floor(109 * 25 / 100); 
}
$activation_montant_activation = $activation_montant * $entry['nombre'];
echo $activation_montant_activation." .1<br>";
}/**/


/*        $activation_t = new Application_Model_DbTable_EuActivation();
        $select = $activation_t->select();
        $select->where("membreasso_id = ? ", $membreasso->membreasso_id);
        $select->where("date_activation >= '".$debut."' AND date_activation <= '".$fin."'");
        $entries_activation = $activation_t->fetchAll($select);
if(count($entries_activation)>0){
$activation_montant_activation = 0;
$activation_montant_utilise_activation = 0;
$activation_montant_solde_activation = 0;
foreach ($entries_activation as $entry):
if($entry->id_activation > 0){
        $activation = new Application_Model_EuActivation();
        $activationM = new Application_Model_EuActivationMapper();
        $activationM->find($entry->id_activation, $activation);
$code_membre = $activation->code_membre;
}
if($code_membre != ""){
        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($code_membre);
      }
if(count($entries2) > 0){
$activation_montant = 0; 
$activation_montant_utilise = 0; 
$activation_montant_solde = 0; 
}else{ 
if($association->guichet == 1){
$activation_montant = floor(480 * 25 / 100);
}else{
$activation_montant = floor(109 * 25 / 100); 
}
$activation_montant = $activation_montant; 
$activation_montant_utilise = 0; 
$activation_montant_solde = $activation_montant; 
}  
$activation_montant_activation += $activation_montant;
$activation_montant_utilise_activation += 0;
$activation_montant_solde_activation += $activation_montant;
endforeach;
}*/

/////////////////////////////////////////////////////////////////////////////////
        $code_activation_t = new Application_Model_DbTable_EuCodeActivation();
        $select = $code_activation_t->select();
        $select->from($code_activation_t, array('COUNT(id_code_activation) as nombre'));
        $select->where("membreasso_id = ? ", $membreasso->membreasso_id);
        $select->where("date_generer >= '".$debut."' AND date_generer <= '".$fin."'");
        $select->where("code_membre NOT IN (SELECT membre_doublon_code_membre2 FROM eu_membre_doublon)");
        $entries_code_activation = $code_activation_t->fetchAll($select);
        //var_dump($entries_code_activation);
if(count($entries_code_activation)>0){
    $entry = $entries_code_activation[0];
if($association2->guichet == 1){
$code_activation_montant = floor(480 * 25 / 100);
}else{
$code_activation_montant = floor(109 * 25 / 100); 
}
$code_activation_montant_code_activation = $code_activation_montant * $entry['nombre'];
echo $code_activation_montant_code_activation." .2<br>";
}/**/


/*        $code_activation_t = new Application_Model_DbTable_EuCodeActivation();
        $select = $code_activation_t->select();
        $select->where("membreasso_id = ? ", $membreasso->membreasso_id);
        $select->where("date_generer >= '".$debut."' AND date_generer <= '".$fin."'");
        $entries_code_activation = $code_activation_t->fetchAll($select);
if(count($entries_code_activation)>0){
$code_activation_montant_code_activation = 0;
$code_activation_montant_utilise_code_activation = 0;
$code_activation_montant_solde_code_activation = 0;
foreach ($entries_code_activation as $entry): 
if($entry->id_code_activation > 0){
        $code_activation = new Application_Model_EuCodeActivation();
        $code_activationM = new Application_Model_EuCodeActivationMapper();
        $code_activationM->find($entry->id_code_activation, $code_activation);
$code_membre = $code_activation->code_membre;
}
if($code_membre != ""){
        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($code_membre);
      }
if(count($entries2) > 0){
$code_activation_montant = 0; 
$code_activation_montant_utilise = 0; 
$code_activation_montant_solde = 0; 
}else{ 
if($association->guichet == 1){
$code_activation_montant = floor(480 * 25 / 100);
}else{
$code_activation_montant = floor(109 * 25 / 100); 
}
$code_activation_montant = $code_activation_montant; 
$code_activation_montant_utilise = 0; 
$code_activation_montant_solde = $code_activation_montant; 
} 
$code_activation_montant_code_activation += $code_activation_montant;
$code_activation_montant_utilise_code_activation += 0;
$code_activation_montant_solde_code_activation += $code_activation_montant;
endforeach;
}
echo $code_activation_montant_code_activation." .<br>";
*/

/////////////////////////////////////////////////////////////////////////////////
/*        $partagem_t = new Application_Model_DbTable_EuPartagem();
        $select = $partagem_t->select();
        $select->where("partagem_membreasso = ? ", $membreasso->membreasso_id);
        $select->where("partagem_date >= '".$debut."' AND partagem_date <= '".$fin."'");
        $entries_partagem = $partagem_t->fetchAll($select);
if(count($entries_partagem)>0){
$partagem_montant_partagem = 0;
$partagem_montant_utilise_partagem = 0;
$partagem_montant_solde_partagem = 0;
foreach ($entries_partagem as $entry):
if($entry->partagem_activation > 0){
        $activation = new Application_Model_EuActivation();
        $activationM = new Application_Model_EuActivationMapper();
        $activationM->find($entry->partagem_activation, $activation);
$code_membre = $activation->code_membre;
}
if($entry->partagem_code_activation > 0){
        $code_activation = new Application_Model_EuCodeActivation();
        $code_activationM = new Application_Model_EuCodeActivationMapper();
        $code_activationM->find($entry->partagem_code_activation, $code_activation);
$code_membre = $code_activation->code_membre;
}
if($code_membre != ""){
        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($code_membre);
      }
if(count($entries2) > 0){
$partagem_montant = 0;
$partagem_montant_utilise = 0; 
$partagem_montant_solde = 0; 
}else{ 
$partagem_montant = $entry->partagem_montant;
$partagem_montant_utilise = $entry->partagem_montant_utilise; 
$partagem_montant_solde = $entry->partagem_montant_solde; 
}
$partagem_montant_partagem += $partagem_montant;
$partagem_montant_utilise_partagem += $partagem_montant_utilise;
$partagem_montant_solde_partagem += $partagem_montant_solde;
endforeach;
}

*/

$montant_commission_employe = $activation_montant_activation + $code_activation_montant_code_activation;
//$montant_commission_employe = $partagem_montant_partagem;
$montant_commission += $montant_commission_employe;
echo $montant_commission." .3<br>";
//$montant_commission += $montant_commission_employe;
/**/
/////////////////////////////////////////////////////////////////////////////////

if($membreasso->membreasso_type == 1){

/////////////////////////////////////////////////////////////////////////////////
        $activation_t = new Application_Model_DbTable_EuActivation();
        $select = $activation_t->select();
        $select->from($activation_t, array('COUNT(id_activation) as nombre'));
        $select->where("membreasso_id IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association2->association_id);
        $select->where("date_activation >= '".$debut."' AND date_activation <= '".$fin."'");
        $select->where("code_membre NOT IN (SELECT membre_doublon_code_membre2 FROM eu_membre_doublon)");
        $entries_activation = $activation_t->fetchAll($select);
        //var_dump($entries_activation);
if(count($entries_activation)>0){
    $entry = $entries_activation[0];
if($association2->guichet == 1){
$activation_montant = floor(480 * 75 / 100);
}else{
$activation_montant = floor(109 * 75 / 100); 
}
$activation_montant_activation = $activation_montant * $entry['nombre'];
echo $activation_montant_activation." .4<br>";
}/**/

/*        $activation_t = new Application_Model_DbTable_EuActivation();
        $select = $activation_t->select();
        $select->where("membreasso_id IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association2->association_id);
        $select->where("date_activation >= '".$debut."' AND date_activation <= '".$fin."'");
        $entries_activation = $activation_t->fetchAll($select);
if(count($entries_activation)>0){
$activation_montant_activation = 0;
$activation_montant_utilise_activation = 0;
$activation_montant_solde_activation = 0;
foreach ($entries_activation as $entry): 
if($entry->id_activation > 0){
        $activation = new Application_Model_EuActivation();
        $activationM = new Application_Model_EuActivationMapper();
        $activationM->find($entry->id_activation, $activation);
$code_membre = $activation->code_membre;
}
if($code_membre != ""){
        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($code_membre);
      }
if(count($entries2) > 0){
$activation_montant = 0; 
$activation_montant_utilise = 0; 
$activation_montant_solde = 0; 
}else{ 
if($association->guichet == 1){
$activation_montant = floor(480 * 75 / 100);
}else{
$activation_montant = floor(109 * 75 / 100); 
}
$activation_montant = $activation_montant; 
$activation_montant_utilise = 0; 
$activation_montant_solde = $activation_montant; 
}  
$activation_montant_activation += $activation_montant;
$activation_montant_utilise_activation += 0;
$activation_montant_solde_activation += $activation_montant;
endforeach;
}  
*/
/////////////////////////////////////////////////////////////////////////////////
        $code_activation_t = new Application_Model_DbTable_EuCodeActivation();
        $select = $code_activation_t->select();
        $select->from($code_activation_t, array('COUNT(id_code_activation) as nombre'));
        $select->where("membreasso_id IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association2->association_id);
        $select->where("date_generer >= '".$debut."' AND date_generer <= '".$fin."'");
        $select->where("code_membre NOT IN (SELECT membre_doublon_code_membre2 FROM eu_membre_doublon)");
        $entries_code_activation = $code_activation_t->fetchAll($select);
        //var_dump($entries_code_activation);
if(count($entries_code_activation)>0){
    $entry = $entries_code_activation[0];
if($association2->guichet == 1){
$code_activation_montant = floor(480 * 75 / 100);
}else{
$code_activation_montant = floor(109 * 75 / 100); 
}
$code_activation_montant_code_activation = $code_activation_montant * $entry['nombre'];
echo $code_activation_montant_code_activation." .5<br>";
}/**/

/*        $code_activation_t = new Application_Model_DbTable_EuCodeActivation();
        $select = $code_activation_t->select();
        $select->where("membreasso_id IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association2->association_id);
        $select->where("date_generer >= '".$debut."' AND date_generer <= '".$fin."'");
        $entries_code_activation = $code_activation_t->fetchAll($select);
if(count($entries_code_activation)>0){
$code_activation_montant_code_activation = 0;
$code_activation_montant_utilise_code_activation = 0;
$code_activation_montant_solde_code_activation = 0;
foreach ($entries_code_activation as $entry): 
if($entry->id_code_activation > 0){
        $code_activation = new Application_Model_EuCodeActivation();
        $code_activationM = new Application_Model_EuCodeActivationMapper();
        $code_activationM->find($entry->id_code_activation, $code_activation);
$code_membre = $code_activation->code_membre;
}
if($code_membre != ""){
        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($code_membre);
      }
if(count($entries2) > 0){
$code_activation_montant = 0; 
$code_activation_montant_utilise = 0; 
$code_activation_montant_solde = 0; 
}else{ 
if($association->guichet == 1){
$code_activation_montant = floor(480 * 75 / 100);
}else{
$code_activation_montant = floor(109 * 75 / 100); 
}
$code_activation_montant = $code_activation_montant; 
$code_activation_montant_utilise = 0; 
$code_activation_montant_solde = $code_activation_montant; 
}  
$code_activation_montant_code_activation += $code_activation_montant;
$code_activation_montant_utilise_code_activation += 0;
$code_activation_montant_solde_code_activation += $code_activation_montant;
endforeach;
}
*/
/////////////////////////////////////////////////////////////////////////////////
/*        $partagea_t = new Application_Model_DbTable_EuPartagea();
        $select = $partagea_t->select();
        $select->where("partagea_association = ? ", $association2->association_id);
        $select->where("partagea_date >= '".$debut."' AND partagea_date <= '".$fin."'");
        $entries_partagea = $partagea_t->fetchAll($select);
if(count($entries_partagea)>0){
$partagea_montant_partagea = 0;
$partagea_montant_utilise_partagea = 0;
$partagea_montant_solde_partagea = 0;
foreach ($entries_partagea as $entry):
if($entry->partagea_activation > 0){
        $activation = new Application_Model_EuActivation();
        $activationM = new Application_Model_EuActivationMapper();
        $activationM->find($entry->partagea_activation, $activation);
$code_membre = $activation->code_membre;
}
if($entry->partagea_code_activation > 0){
        $code_activation = new Application_Model_EuCodeActivation();
        $code_activationM = new Application_Model_EuCodeActivationMapper();
        $code_activationM->find($entry->partagea_code_activation, $code_activation);
$code_membre = $code_activation->code_membre;
}
if($code_membre != ""){
        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($code_membre);
      }
if(count($entries2) > 0){
$partagea_montant = 0; 
$partagea_montant_utilise = 0; 
$partagea_montant_solde = 0; 
}else{ 
$partagea_montant = $entry->partagea_montant; 
$partagea_montant_utilise = $entry->partagea_montant_utilise; 
$partagea_montant_solde = $entry->partagea_montant_solde; 
}  
$partagea_montant_partagea += $partagea_montant;
$partagea_montant_utilise_partagea += $partagea_montant_utilise;
$partagea_montant_solde_partagea += $partagea_montant_solde;
endforeach;
}
*/


$montant_commission_employeur = $activation_montant_activation + $code_activation_montant_code_activation;
//$montant_commission_employeur = $partagea_montant_partagea;
$montant_commission += $montant_commission_employeur;
echo $montant_commission." .6<br>";
//$montant_commission += $montant_commission_employeur;
/**/
/////////////////////////////////////////////////////////////////////////////////
}           

if($montant_commission > 0){
$demande_paiement_mapper = new Application_Model_EuDemandePaiementMapper();
$demande_paiement = $demande_paiement_mapper->fetchAllByQuizaine($code_membre_employeur, $debut, $fin_1, $type_demande); 
//if (count($demande_paiement) > 0) {
$message = "Vous avez déjà émit la demande de paiement de cette quinzaine ...";
//$this->_redirect('/integrateur/adddemande');
//continue;
/*}else if ($montant_commission_employe < Util_Utils::getParamEsmc(18)) {
$message = "Montant insuffisant ...";
//$this->_redirect('/integrateur/adddemande');
//continue;*/
//}else{

//$numero_demande_paiement = strtoupper(Util_Utils::genererCodeSMS(10));
do{
                    $numero_demande_paiement = strtoupper(Util_Utils::genererCodeSMS(10));
                    $demande_paiement2_mapper = new Application_Model_EuDemandePaiementMapper();
                    $demande_paiement2 = $demande_paiement2_mapper->fetchAllByNumero_demande_paiement($numero_demande_paiement);
}while(count($commande2) > 0);/**/

////////demande_paiement
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
$paiement->setMontant_paiement($montant_commission_employe);
$paiement->setDate_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$paiement->setCode_membre_employe($code_membre_employe);
$paiement->setId_demande_paiement($compteur_demande_paiement);
$paiement->setPayer(0);
$paiement_mapper->save($paiement);
echo $montant_commission_employe." .8<br>";

if($membreasso->membreasso_type == 1){
$paiement = new Application_Model_EuPaiement();
$paiement_mapper = new Application_Model_EuPaiementMapper();

$compteur_paiement = $paiement_mapper->findConuter() + 1;
$paiement->setId_paiement($compteur_paiement);
$paiement->setMontant_paiement($montant_commission_employeur);
$paiement->setDate_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$paiement->setCode_membre_employe($code_membre_employeur);
$paiement->setId_demande_paiement($compteur_demande_paiement);
$paiement->setPayer(0);
$paiement_mapper->save($paiement);
echo $montant_commission_employeur." .9<br>";
}

///////detail_paiement
$partagem_mapper = new Application_Model_EuPartagemMapper();
$partagem = $partagem_mapper->fetchAllByCommissionSouscription10($membreasso->membreasso_id, $debut, $fin);
foreach ($partagem as $row) {
      
$detail_paiement = new Application_Model_EuDetailPaiement();
$detail_paiement_mapper = new Application_Model_EuDetailPaiementMapper();

$compteur_detail_paiement = $detail_paiement_mapper->findConuter() + 1;
$detail_paiement->setId_detail_paiement($compteur_detail_paiement);
$detail_paiement->setId_paiement($compteur_paiement);
$detail_paiement->setId_pointage(NULL);
$detail_paiement->setMontant_paiement($row->partagem_montant);
$detail_paiement->setBon_neutre_appro_id(NULL);
$detail_paiement->setSouscription_id($row->partagem_souscription);
$detail_paiement_mapper->save($detail_paiement);


$partagem3 = new Application_Model_EuPartagem();
$partagem3_mapper = new Application_Model_EuPartagemMapper();
$partagem3_mapper->find($row->partagem_id, $partagem3);
      
$partagem3->setPartagem_montant_utilise($partagem3->getPartagem_montant_utilise() + $row->partagem_montant);
$partagem3->setPartagem_montant_solde($partagem3->getPartagem_montant_solde() - $row->partagem_montant);
$partagem3->setPartagem_montant_impot(0);
$partagem3_mapper->update($partagem3);

}
echo count($partagem)." .10<br>";

if($membreasso->membreasso_type == 1){
$partagea_mapper = new Application_Model_EuPartageaMapper();
$partagea = $partagea_mapper->fetchAllByCommissionSouscription10($membreasso->membreasso_association, $debut, $fin);
foreach ($partagea as $row) {
      
$detail_paiement = new Application_Model_EuDetailPaiement();
$detail_paiement_mapper = new Application_Model_EuDetailPaiementMapper();

$compteur_detail_paiement = $detail_paiement_mapper->findConuter() + 1;
$detail_paiement->setId_detail_paiement($compteur_detail_paiement);
$detail_paiement->setId_paiement($compteur_paiement);
$detail_paiement->setId_pointage(NULL);
$detail_paiement->setMontant_paiement($row->partagea_montant);
$detail_paiement->setBon_neutre_appro_id(NULL);
$detail_paiement->setSouscription_id($row->partagea_souscription);
$detail_paiement_mapper->save($detail_paiement);


$partagea3 = new Application_Model_EuPartagea();
$partagea3_mapper = new Application_Model_EuPartageaMapper();
$partagea3_mapper->find($row->partagea_id, $partagea3);
      
$partagea3->setPartagea_montant_utilise($partagea3->getPartagea_montant_utilise() + $row->partagea_montant);
$partagea3->setPartagea_montant_solde($partagea3->getPartagea_montant_solde() - $row->partagea_montant);
$partagea3->setPartagea_montant_impot(0);
$partagea3_mapper->update($partagea3);

}
echo count($partagea)." .11<br>";
}

//}
}
echo "<br><br><br>";
/**/

}







                //$db->commit();
                    
               } catch(Exception $exc) {
                   //$db->rollback();
                   $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
               }









 