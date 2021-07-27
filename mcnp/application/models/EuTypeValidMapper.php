<?php

class Application_Model_EuTypeValidMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeValid');
        }
        return $this->_dbTable;
    }

    public function find($id_type_valid, Application_Model_EuTypeValid $type_valid) {
        $result = $this->getDbTable()->find($id_type_valid);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $type_valid->setId_type_valid($row->id_type_valid)
                ->setLibelle_type_valid($row->libelle_type_valid);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeValid();
            $entry->setId_type_valid($row->id_type_valid)
                    ->setLibelle_type_valid($row->libelle_type_valid);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeValid $type_valid) {
        $data = array(
            'id_type_valid' => $type_valid->getId_type_valid(),
            'libelle_type_valid' => $type_valid->getLibelle_type_valid()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeValid $type_valid) {
        $data = array(
            'id_type_valid' => $type_valid->getId_type_valid(),
            'libelle_type_valid' => $type_valid->getLibelle_type_valid()
        );
        $this->getDbTable()->update($data, array('id_type_valid = ?' => $type_valid->getId_type_valid()));
    }

    public function delete($id_type_valid) {
        $this->getDbTable()->delete(array('id_type_valid = ?' => $id_type_valid));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_valid) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

