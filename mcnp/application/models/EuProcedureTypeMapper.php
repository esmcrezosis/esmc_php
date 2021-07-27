<?php

class Application_Model_EuProcedureTypeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProcedureType');
        }
        return $this->_dbTable;
    }

    public function find($procedure_type_id, Application_Model_EuProcedureType $procedure_type) {
        $result = $this->getDbTable()->find($procedure_type_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $procedure_type->setProcedure_type_id($row->procedure_type_id)
                ->setProcedure_type_libelle($row->procedure_type_libelle);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProcedureType();
            $entry->setProcedure_type_id($row->procedure_type_id)
	                ->setProcedure_type_libelle($row->procedure_type_libelle);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(procedure_type_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuProcedureType $procedure_type) {
        $data = array(
            'procedure_type_id' => $procedure_type->getProcedure_type_id(),
            'procedure_type_libelle' => $procedure_type->getProcedure_type_libelle()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProcedureType $procedure_type) {
        $data = array(
            'procedure_type_id' => $procedure_type->getProcedure_type_id(),
            'procedure_type_libelle' => $procedure_type->getProcedure_type_libelle()
        );
        $this->getDbTable()->update($data, array('procedure_type_id = ?' => $procedure_type->getProcedure_type_id()));
    }

    public function delete($procedure_type_id) {
        $this->getDbTable()->delete(array('procedure_type_id = ?' => $procedure_type_id));
    }




}


?>
