<?php

class Application_Model_EuProcedureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProcedure');
        }
        return $this->_dbTable;
    }

    public function find($procedure_id, Application_Model_EuProcedure $procedure) {
        $result = $this->getDbTable()->find($procedure_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $procedure->setProcedure_id($row->procedure_id)
                ->setProcedure_libelle($row->procedure_libelle)
                ->setProcedure_description($row->procedure_description)
                ->setProcedure_url($row->procedure_url)
                ->setProcedure_nom($row->procedure_nom)
                ->setProcedure_type($row->procedure_type)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProcedure();
            $entry->setProcedure_id($row->procedure_id)
	                ->setProcedure_libelle($row->procedure_libelle)
                    ->setProcedure_description($row->procedure_description)
                    ->setProcedure_url($row->procedure_url)
	                ->setProcedure_nom($row->procedure_nom)
                    ->setProcedure_type($row->procedure_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(procedure_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuProcedure $procedure) {
        $data = array(
            'procedure_id' => $procedure->getProcedure_id(),
            'procedure_libelle' => $procedure->getProcedure_libelle(),
            'procedure_description' => $procedure->getProcedure_description(),
            'procedure_url' => $procedure->getProcedure_url(),
            'procedure_nom' => $procedure->getProcedure_nom(),
            'procedure_type' => $procedure->getProcedure_type(),
            'publier' => $procedure->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProcedure $procedure) {
        $data = array(
            'procedure_id' => $procedure->getProcedure_id(),
            'procedure_libelle' => $procedure->getProcedure_libelle(),
            'procedure_description' => $procedure->getProcedure_description(),
            'procedure_url' => $procedure->getProcedure_url(),
            'procedure_nom' => $procedure->getProcedure_nom(),
            'procedure_type' => $procedure->getProcedure_type(),
            'publier' => $procedure->getPublier()
        );
        $this->getDbTable()->update($data, array('procedure_id = ?' => $procedure->getProcedure_id()));
    }

    public function delete($procedure_id) {
        $this->getDbTable()->delete(array('procedure_id = ?' => $procedure_id));
    }




    public function fetchAllByType($procedure_type) {
        $select = $this->getDbTable()->select();
        $select->where("procedure_type = ? ", $procedure_type);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProcedure();
            $entry->setProcedure_id($row->procedure_id)
                    ->setProcedure_libelle($row->procedure_libelle)
                    ->setProcedure_description($row->procedure_description)
                    ->setProcedure_url($row->procedure_url)
                    ->setProcedure_nom($row->procedure_nom)
                    ->setProcedure_type($row->procedure_type)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    

}


?>
