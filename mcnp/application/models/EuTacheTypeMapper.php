<?php

class Application_Model_EuTacheTypeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTacheType');
        }
        return $this->_dbTable;
    }

    public function find($tache_type_id, Application_Model_EuTacheType $tache_type) {
        $result = $this->getDbTable()->find($tache_type_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $tache_type->setTache_type_id($row->tache_type_id)
                ->setTache_type_libelle($row->tache_type_libelle);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTacheType();
            $entry->setTache_type_id($row->tache_type_id)
	                ->setTache_type_libelle($row->tache_type_libelle);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(tache_type_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuTacheType $tache_type) {
        $data = array(
            'tache_type_id' => $tache_type->getTache_type_id(),
            'tache_type_libelle' => $tache_type->getTache_type_libelle()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTacheType $tache_type) {
        $data = array(
            'tache_type_id' => $tache_type->getTache_type_id(),
            'tache_type_libelle' => $tache_type->getTache_type_libelle()
        );
        $this->getDbTable()->update($data, array('tache_type_id = ?' => $tache_type->getTache_type_id()));
    }

    public function delete($tache_type_id) {
        $this->getDbTable()->delete(array('tache_type_id = ?' => $tache_type_id));
    }




}


?>
