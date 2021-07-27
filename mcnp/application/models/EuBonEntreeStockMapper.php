<?php
class Application_Model_EuBonEntreeStockMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonEntreeStock');
        }
        return $this->_dbTable;
    }
    
    public function find($id_bon_entree_stock, Application_Model_EuBonEntreeStock $bon_entree_stock) {
        $result = $this->getDbTable()->find($id_bon_entree_stock);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $bon_entree_stock->setId_bon_entree_stock($row->id_bon_entree_stock)
                    ->setReference_bon_entree_stock($row->reference_bon_entree_stock)
                    ->setLibelle_bon_entree_stock($row->libelle_bon_entree_stock)
	                ->setDate_bon_entree_stock($row->date_bon_entree_stock)
                    ->setRejet($row->rejet)
                    ->setValider_up($row->valider_up)
                    ->setvalider_down($row->valider_down)
           ->setValid($row->valid)
           ->setEtat($row->etat)
                    ;    
    }
/*
CREATE TABLE `eu_bon_entree_stock` (
    `id_bon_entree_stock` INT(11) NOT NULL AUTO_INCREMENT,
    `reference_bon_entree_stock` VARCHAR(50) NULL DEFAULT NULL,
    `date_bon_entree_stock` DATETIME NOT NULL,
    `rejet` INT(11) NOT NULL,
    `valid_up` INT(11) NOT NULL,
    `valid_down` INT(11) NOT NULL,
    PRIMARY KEY (`id_bon_entree_stock`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
*/
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonEntreeStock();
            $entry->setId_bon_entree_stock($row->id_bon_entree_stock)
                    ->setReference_bon_entree_stock($row->reference_bon_entree_stock)
                    ->setLibelle_bon_entree_stock($row->libelle_bon_entree_stock)
                    ->setDate_bon_entree_stock($row->date_bon_entree_stock)
                    ->setRejet($row->rejet)
                    ->setValider_up($row->valider_up)
                    ->setvalider_down($row->valider_down)
           ->setValid($row->valid)
           ->setEtat($row->etat)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuBonEntreeStock $bon_entree_stock){
        $data = array(
            'id_bon_entree_stock' => $bon_entree_stock->getId_bon_entree_stock(),
            'reference_bon_entree_stock' => $bon_entree_stock->getReference_bon_entree_stock(),
            'libelle_bon_entree_stock' => $bon_entree_stock->getLibelle_bon_entree_stock(),
            'date_bon_entree_stock' => $bon_entree_stock->getDate_bon_entree_stock(),
            'rejet' => $bon_entree_stock->getRejet(),
            'valider_up' => $bon_entree_stock->getValider_up(),
            'valider_down' => $bon_entree_stock->getValider_down(),
            'valid' => $bon_entree_stock->getValid(),
            'etat' => $bon_entree_stock->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonSortieInterne $bon_entree_stock) {
        $data = array(
            'id_bon_entree_stock' => $bon_entree_stock->getId_bon_entree_stock(),
            'reference_bon_entree_stock' => $bon_entree_stock->getReference_bon_entree_stock(),
            'libelle_bon_entree_stock' => $bon_entree_stock->getLibelle_bon_entree_stock(),
            'date_bon_entree_stock' => $bon_entree_stock->getDate_bon_entree_stock(),
            'rejet' => $bon_entree_stock->getRejet(),
            'valider_up' => $bon_entree_stock->getValider_up(),
            'valider_down' => $bon_entree_stock->getValider_down(),
            'valid' => $bon_entree_stock->getValid(),
            'etat' => $bon_entree_stock->getEtat()
        );
        $this->getDbTable()->update($data, array('id_bon_entree_stock = ?' => $bon_entree_stock->getId_bon_entree_stock()));
    }
    
    public function delete($id_bon_entree_stock,$id_bon_entree_stock) {
        $this->getDbTable()->delete(array('id_bon_entree_stock = ?' => $id_bon_entree_stock));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_bon_entree_stock) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>