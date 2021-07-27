#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';

try
{
   

           ini_set('memory_limit', '2000M');    

$date_id = new Zend_Date(Zend_Date::ISO_8601);



        $membre = new Application_Model_EuMembreMapper();
        $entries = $membre->fetchAllAll();

if(count($entries)>0){
    $nom = "";
    $prenom = "";
    $code_membre = "";
foreach ($entries as $entry):

        $membre_doublon1 = new Application_Model_EuMembreDoublonMapper();
        $entries1 = $membre_doublon1->fetchAllByMembre1($entry->code_membre);

        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($entry->code_membre);

        if(count($entries1) > 0 || count($entries2) > 0){
            ///
        }else{

if($entry->nom_membre != $nom || $entry->prenom_membre != $prenom){
    $nom = $entry->nom_membre;
    $prenom = $entry->prenom_membre;
    $code_membre = $entry->code_membre;
}else{

        $table = new Application_Model_DbTable_EuActivation();
        $select = $table->select();
        $select->where("code_membre LIKE '".$entry->code_membre."' ");
        $select->limit(1);
        $activation = $table->fetchRow($select);
        //$activation_m = new Application_Model_EuActivationMapper();
        //$membreasso_id = $activation_m->fetchAllByMembre($entry->code_membre);
        if($activation->membreasso_id > 0){
            $membreasso_id = $activation->membreasso_id;
        }else{
        $table = new Application_Model_DbTable_EuCodeActivation();
        $select = $table->select();
        $select->where("code_membre LIKE '".$entry->code_membre."' ");
        $select->limit(1);
        $code_activation = $table->fetchRow($select);
        //$code_activation_m = new Application_Model_EuCodeActivationMapper();
        //$membreasso_id = $code_activation_m->fetchAllByCodeMembre($entry->code_membre);
        if($code_activation->membreasso_id > 0){
            $membreasso_id = $code_activation->membreasso_id;
        }else{
            $membreasso_id = 0; 
        }
        }

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $membre_doublon = new Application_Model_EuMembreDoublon();
        $membre_doublon_ma = new Application_Model_EuMembreDoublonMapper();
            
            $compteur = $membre_doublon_ma->findConuter() + 1;
            $membre_doublon->setMembre_doublon_id($compteur);
            $membre_doublon->setMembre_doublon_code_membre1($code_membre);
            $membre_doublon->setMembre_doublon_code_membre2($entry->code_membre);
            $membre_doublon->setMembre_doublon_etat(1);
            if($membreasso_id > 0){
            $membre_doublon->setMembreasso_id($membreasso_id);
            }
            $membre_doublon->setMembre_doublon_date($entry->date_identification." ".$entry->heure_identification);
            $membre_doublon_ma->save($membre_doublon);
}

}

//echo $entry->code_membre." ".$entry->nom_membre." ".$entry->prenom_membre." ".$membreasso_id."<br>";
//echo $entry->nom_membre;
//echo $entry->prenom_membre;

endforeach;
}



//////////////////////////////////////////////////////////////////


        $membre_morale = new Application_Model_EuMembreMoraleMapper();
        $entries = $membre_morale->fetchAllAll();

if(count($entries)>0){
    $raison_sociale = "";
    $code_membre_morale = "";
foreach ($entries as $entry):

        $membre_doublon1 = new Application_Model_EuMembreDoublonMapper();
        $entries1 = $membre_doublon1->fetchAllByMembre1($entry->code_membre_morale);

        $membre_doublon2 = new Application_Model_EuMembreDoublonMapper();
        $entries2 = $membre_doublon2->fetchAllByMembre2($entry->code_membre_morale);

        if(count($entries1) > 0 || count($entries2) > 0){
            ///
        }else{

if($entry->raison_sociale != $raison_sociale){
    $raison_sociale = $entry->raison_sociale;
    $code_membre_morale = $entry->code_membre_morale;
}else{

        $table = new Application_Model_DbTable_EuActivation();
        $select = $table->select();
        $select->where("code_membre LIKE '".$entry->code_membre_morale."' ");
        $select->limit(1);
        $activation = $table->fetchRow($select);
        //$activation_m = new Application_Model_EuActivationMapper();
        //$membreasso_id = $activation_m->fetchAllByMembre($entry->code_membre_morale);
        if($activation->membreasso_id > 0){
            $membreasso_id = $activation->membreasso_id;
        }else{
        $table = new Application_Model_DbTable_EuCodeActivation();
        $select = $table->select();
        $select->where("code_membre LIKE '".$entry->code_membre_morale."' ");
        $select->limit(1);
        $code_activation = $table->fetchRow($select);
        //$code_activation_m = new Application_Model_EuCodeActivationMapper();
        //$membreasso_id = $code_activation_m->fetchAllByCodeMembre($entry->code_membre_morale);
        if($code_activation->membreasso_id > 0){
            $membreasso_id = $code_activation->membreasso_id;
        }else{
            $membreasso_id = 0; 
        }
        }

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $membre_doublon = new Application_Model_EuMembreDoublon();
        $membre_doublon_ma = new Application_Model_EuMembreDoublonMapper();
            
            $compteur = $membre_doublon_ma->findConuter() + 1;
            $membre_doublon->setMembre_doublon_id($compteur);
            $membre_doublon->setMembre_doublon_code_membre1($code_membre_morale);
            $membre_doublon->setMembre_doublon_code_membre2($entry->code_membre_morale);
            $membre_doublon->setMembre_doublon_etat(1);
            if($membreasso_id > 0){
            $membre_doublon->setMembreasso_id($membreasso_id);
            }
            $membre_doublon->setMembre_doublon_date($entry->date_identification." ".$entry->heure_identification);
            $membre_doublon_ma->save($membre_doublon);
}

}

//echo $entry->code_membre." ".$entry->nom_membre." ".$entry->prenom_membre." ".$membreasso_id."<br>";
//echo $entry->nom_membre;
//echo $entry->prenom_membre;

endforeach;
}









    
}
catch (Exception $e)
{
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
}
