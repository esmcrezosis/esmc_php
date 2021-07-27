<?php

class Application_Model_EuTypeKitMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeKit');
        }
        return $this->_dbTable;
    }

    public function find($id_type_kit, Application_Model_EuTypeKit $kit) {
        $result = $this->getDbTable()->find($id_type_kit);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $kit->setId_type_kit($row->id_type_kit)
                ->setLibelle_type_kit($row->libelle_type_kit);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeKit();
            $entry->setId_type_kit($row->id_type_kit)
                    ->setLibelle_type_kit($row->libelle_type_kit);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeKit $kit) {
        $data = array(
            'id_type_kit' => $kit->getId_type_kit(),
            'libelle_type_kit' => $kit->getLibelle_type_kit()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeKit $kit) {
        $data = array(
            'id_type_kit' => $kit->getId_type_kit(),
            'libelle_type_kit' => $kit->getLibelle_type_kit()
        );
        $this->getDbTable()->update($data, array('id_type_kit = ?' => $kit->getId_type_kit()));
    }

    public function delete($id_type_kit) {
        $this->getDbTable()->delete(array('id_type_kit = ?' => $id_type_kit));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_kit) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

