<?php

class Application_Model_EuNiveauValidMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuNiveauValid');
        }
        return $this->_dbTable;
    }

    public function find($id_niveau_valid, Application_Model_EuNiveauValid $niveau_valid) {
        $result = $this->getDbTable()->find($id_niveau_valid);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $niveau_valid->setId_niveau_valid($row->id_niveau_valid)
                ->setLibelle_niveau_valid($row->libelle_niveau_valid);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuNiveauValid();
            $entry->setId_niveau_valid($row->id_niveau_valid)
                    ->setLibelle_niveau_valid($row->libelle_niveau_valid);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuNiveauValid $niveau_valid) {
        $data = array(
            'id_niveau_valid' => $niveau_valid->getId_niveau_valid(),
            'libelle_niveau_valid' => $niveau_valid->getLibelle_niveau_valid()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuNiveauValid $niveau_valid) {
        $data = array(
            'id_niveau_valid' => $niveau_valid->getId_niveau_valid(),
            'libelle_niveau_valid' => $niveau_valid->getLibelle_niveau_valid()
        );
        $this->getDbTable()->update($data, array('id_niveau_valid = ?' => $niveau_valid->getId_niveau_valid()));
    }

    public function delete($id_niveau_valid) {
        $this->getDbTable()->delete(array('id_niveau_valid = ?' => $id_niveau_valid));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_niveau_valid) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

