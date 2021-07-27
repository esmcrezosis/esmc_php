<?php 

class Application_Model_EuCategorieBpsMapper {

    //put your code here
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
            $this->setDbTable('Application_Model_DbTable_EuCategorieBps');
        }
        return $this->_dbTable;
    }

    public function find($id_categorie, Application_Model_EuCategorieBps $bps) {
        $result = $this->getDbTable()->find($id_categorie);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $bps->setId_categorie($row->id_categorie)
                ->setLibelle_categorie($row->libelle_categorie);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieBps();
            $entry->setId_categorie($row->id_categorie)
                    ->setLibelle_categorie($row->libelle_categorie);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuCategorieBps $bps) {
        $data = array(
            'id_categorie' => $bps->getId_categorie(),
            'libelle_categorie' => $bps->getLibelle_categorie()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCategorieBps $bps) {
        $data = array(
            'id_categorie' => $bps->getId_categorie(),
            'libelle_categorie' => $bps->getLibelle_categorie()
        );
        $this->getDbTable()->update($data, array('id_categorie = ?' => $bps->getId_categorie()));
    }

    public function delete($id_categorie) {
        $this->getDbTable()->delete(array('id_categorie = ?' => $id_categorie));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_categorie) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

