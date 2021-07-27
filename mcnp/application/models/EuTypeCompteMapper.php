<?php

class Application_Model_EuTypeCompteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeCompte');
        }
        return $this->_dbTable;
    }

    public function find($id_type, Application_Model_EuTypeCompte $typecompte) {
        $result = $this->getDbTable()->find($id_type);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $typecompte->setCode_type_compte($row->code_type_compte)
                ->setLib_type($row->lib_type)
                ->setDesc_type($row->desc_type);
    }

    public function save(Application_Model_EuTypeCompte $typecompte) {
        $data = array(
            'code_type_compte' => $typecompte->getCode_type_compte(),
            'lib_type' => $typecompte->getLib_type(),
            'desc_type' => $typecompte->getDesc_type()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeCompte $typecompte) {
        $data = array(
            'code_type_compte' => $typecompte->getCode_type_compte(),
            'lib_type' => $typecompte->getLib_type(),
            'desc_type' => $typecompte->getDesc_type()
        );

        $this->getDbTable()->update($data, array('code_type_compte = ?' => $typecompte->getCode_type_compte()));
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCompte();
            $entry->setCode_type_compte($row->code_type_compte)
                    ->setLib_type($row->lib_type)
                    ->setDesc_type($row->desc_type);
            $entries[] = $entry;
        }
        return $entries;
    } 

    public function delete($code_type_compte) {
        $this->getDbTable()->delete(array('code_type_compte = ?' => $code_type_compte));
    }

}

?>
