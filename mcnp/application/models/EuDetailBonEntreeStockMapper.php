<?php
class Application_Model_EuDetailBonEntreeStockMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (NULL === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuDetailBonEntreeStock');
        }
        return $this->_dbTable;
    }
    
    public function find($id_detail_bon_entree_stock, Application_Model_EuDetailBonEntreeStock $detail_bon_entree_stock) {
        $result = $this->getDbTable()->find($id_detail_bon_entree_stock);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $detail_bon_entree_stock->setId_detail_bon_entree_stock($row->id_detail_bon_entree_stock)
                    ->setId_bon_entree_stock($row->id_bon_entree_stock)
                    ->setReference_articles($row->reference_articles)
                    ->setDesignation_articles($row->designation_articles)
	                ->setUnite_comptage($row->unite_comptage)
	                ->setQuantite($row->quantite)
	                ->setPrix_unitaire($row->prix_unitaire)
	                ->setMontant($row->montant)
	                ->setObservations($row->observations)
           ->setEtat($row->etat)
                    ;    
    }
/*
CREATE TABLE `eu_detail_bon_entree_stock` (
    `id_detail_bon_entree_stock` INT(11) NOT NULL AUTO_INCREMENT,
    `designation_detail_bon_entree_stocks` VARCHAR(255) NOT NULL,
    `unite_comptage` INT(11) NOT NULL DEFAULT '0',
    `quantite` INT(11) NOT NULL DEFAULT '0',
    `prix_unitaire` INT(11) NOT NULL DEFAULT '0',
    `montant` INT(11) NOT NULL DEFAULT '0',
    `observations` LONGTEXT NOT NULL,
    PRIMARY KEY (`id_detail_bon_entree_stock`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
*/
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailBonEntreeStock();
            $entry->setId_detail_bon_entree_stock($row->id_detail_bon_entree_stock)
                    ->setId_bon_entree_stock($row->id_bon_entree_stock)
                    ->setReference_articles($row->reference_articles)
                    ->setDesignation_articles($row->designation_articles)
                    ->setUnite_comptage($row->unite_comptage)
                    ->setQuantite($row->quantite)
                    ->setPrix_unitaire($row->prix_unitaire)
                    ->setMontant($row->montant)
                    ->setObservations($row->observations)
           ->setEtat($row->etat)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuDetailBonEntreeStock $detail_bon_entree_stock){
        $data = array(
            'id_detail_bon_entree_stock' => $detail_bon_entree_stock->getId_detail_bon_entree_stock(),
            'id_bon_entree_stock' => $detail_bon_entree_stock->getId_bon_entree_stock(),
            'reference_articles' => $detail_bon_entree_stock->getReference_articles(),
            'designation_articles' => $detail_bon_entree_stock->getDesignation_articles(),
            'unite_comptage' => $detail_bon_entree_stock->getUnite_comptage(),
            'quantite' => $detail_bon_entree_stock->getQuantite(),
            'prix_unitaire' => $detail_bon_entree_stock->getPrix_unitaire(),
            'montant' => $detail_bon_entree_stock->getMontant(),
            'observations' => $detail_bon_entree_stock->getObservations(),
            'etat' => $detail_bon_entree_stock->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailBonEntreeStock $detail_bon_entree_stock) {
        $data = array(
            'id_detail_bon_entree_stock' => $detail_bon_entree_stock->getId_detail_bon_entree_stock(),
            'id_bon_entree_stock' => $detail_bon_entree_stock->getId_bon_entree_stock(),
            'reference_articles' => $detail_bon_entree_stock->getReference_articles(),
            'designation_articles' => $detail_bon_entree_stock->getDesignation_articles(),
            'unite_comptage' => $detail_bon_entree_stock->getUnite_comptage(),
            'quantite' => $detail_bon_entree_stock->getQuantite(),
            'prix_unitaire' => $detail_bon_entree_stock->getPrix_unitaire(),
            'montant' => $detail_bon_entree_stock->getMontant(),
            'observations' => $detail_bon_entree_stock->getObservations(),
            'etat' => $detail_bon_entree_stock->getEtat()
        );
        $this->getDbTable()->update($data, array('id_detail_bon_entree_stock = ?' => $detail_bon_entree_stock->getId_detail_bon_entree_stock()));
    }
    
    public function delete($id_detail_bon_entree_stock,$id_detail_bon_entree_stock) {
        $this->getDbTable()->delete(array('id_detail_bon_entree_stock = ?' => $id_detail_bon_entree_stock));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_bon_entree_stock) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>