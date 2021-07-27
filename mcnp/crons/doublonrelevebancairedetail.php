#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';

try
{
   

           ini_set('memory_limit', '512M');    

$date_id = new Zend_Date(Zend_Date::ISO_8601);



////////////////////////////////////////////////////////////////////////////////////


        $table = new Application_Model_DbTable_EuRelevebancairedetail();
        $select = $table->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque LIKE 'BAT')");
        $select->where("relevebancairedetail_numero LIKE ''");
        $select->where("publier = 0");
        $resultSet = $table->fetchAll($select);
        foreach ($resultSet as $row) {
            
            if(is_numeric($row->relevebancairedetail_montant)){

            $table2 = new Application_Model_DbTable_EuRelevebancairedetail();
            $select2 = $table2->select();
            $select2->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque LIKE 'BAT')");
            $select2->where("relevebancairedetail_numero != ''");
            $select2->where("relevebancairedetail_libelle LIKE '%".$row->relevebancairedetail_libelle."%'");
            //$select2->where("REPLACE(relevebancairedetail_libelle, ' ', '') LIKE '%".str_replace(" ", "", $row->relevebancairedetail_libelle)."%'");
            //$select2->where("REPLACE(relevebancairedetail_libelle, '\'', '') LIKE '%".str_replace("'", "", $row->relevebancairedetail_libelle)."%'");
            //$select2->where("REPLACE(relevebancairedetail_libelle, '\\', '') LIKE '%".str_replace("\\", "", $row->relevebancairedetail_libelle)."%'");
            $select2->where("relevebancairedetail_date LIKE '".$row->relevebancairedetail_date."'");
            $select2->where("relevebancairedetail_montant LIKE ".$row->relevebancairedetail_montant."");
            //$select2->where("publier = 0");
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






    
}
catch (Exception $e)
{
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
}
