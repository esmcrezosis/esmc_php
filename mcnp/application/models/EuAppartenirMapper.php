<?php

class Application_Model_EuAppartenirMapper
{
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
            $this->setDbTable('Application_Model_DbTable_EuAppartenir');
        }
        return $this->_dbTable;
    }
    
    public function find($code_rayon,$code_gamme, Application_Model_EuAppartenir $appartenir) {
        $result = $this->getDbTable()->find($code_rayon,$code_gamme);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $appartenir->setCode_rayon($row->code_rayon)
                ->setCode_gamme($row->code_gamme);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppartenir();
            $entry->setCode_rayon($row->code_rayon);
            $entry->setCode_gamme($row->code_gamme);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuAppartenir $appartenir) {
        $data = array(
            'code_rayon' => $appartenir->getCode_rayon(),
            'code_gamme' => $appartenir->getCode_gamme(),
            'creer_par' => $appartenir->getCreer_par()
        );

        $this->getDbTable()->insert($data);
    }
    
    public function delete($code_rayon,$code_gamme) {
        $this->getDbTable()->delete(array('code_rayon = ?' => $code_rayon,'code_gamme = ?' => $code_gamme));
    }
}


