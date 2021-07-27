<?php

class Application_Model_EuCentraleMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCentrale');
        }
        return $this->_dbTable;
    }

    public function find($centrale_id, Application_Model_EuCentrale $centrale) {
        $result = $this->getDbTable()->find($centrale_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $centrale->setCentrale_id($row->centrale_id)
                ->setCentrale_libelle($row->centrale_libelle)
                ;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCentrale();
            $entry->setCentrale_id($row->centrale_id)
	                ->setCentrale_libelle($row->centrale_libelle)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(centrale_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCentrale $centrale) {
        $data = array(
            'centrale_id' => $centrale->getCentrale_id(),
            'centrale_libelle' => $centrale->getCentrale_libelle()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCentrale $centrale) {
        $data = array(
            'centrale_id' => $centrale->getCentrale_id(),
            'centrale_libelle' => $centrale->getCentrale_libelle()
        );
        $this->getDbTable()->update($data, array('centrale_id = ?' => $centrale->getCentrale_id()));
    }

    public function delete($centrale_id) {
        $this->getDbTable()->delete(array('centrale_id = ?' => $centrale_id));
    }





    

}


?>
