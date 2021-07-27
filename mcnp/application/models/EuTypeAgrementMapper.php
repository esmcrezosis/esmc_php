<?php

class Application_Model_EuTypeAgrementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeAgrement');
        }
        return $this->_dbTable;
    }

    public function find($id_type_agrement, Application_Model_EuTypeAgrement $agrement) {
        $result = $this->getDbTable()->find($id_type_agrement);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $agrement->setId_type_agrement($row->id_type_agrement)
                ->setLibelle_type_agrement($row->libelle_type_agrement);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeAgrement();
            $entry->setId_type_agrement($row->id_type_agrement)
                    ->setLibelle_type_agrement($row->libelle_type_agrement);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeAgrement $agrement) {
        $data = array(
            'id_type_agrement' => $agrement->getId_type_agrement(),
            'libelle_type_agrement' => $agrement->getLibelle_type_agrement()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeAgrement $agrement) {
        $data = array(
            'id_type_agrement' => $agrement->getId_type_agrement(),
            'libelle_type_agrement' => $agrement->getLibelle_type_agrement()
        );
        $this->getDbTable()->update($data, array('id_type_agrement = ?' => $agrement->getId_type_agrement()));
    }

    public function delete($id_type_agrement) {
        $this->getDbTable()->delete(array('id_type_agrement = ?' => $id_type_agrement));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_agrement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

