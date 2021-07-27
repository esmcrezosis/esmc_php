<?php

class Application_Model_EuCreditCodeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCreditCode');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCreditCode $CreditCode) {
        $data = array(
            'code_compte' => $CreditCode->getCode_compte(),
            'credit_code' => $CreditCode->getCredit_code()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCreditCode $CreditCode) {
        $data = array(
             'code_compte' => $CreditCode->getCode_compte(),
            'credit_code' => $CreditCode->getCredit_code()
        );
        $this->getDbTable()->update($data, array('code_compte = ?' => $CreditCode->getCode_compte()));
    }

    public function find($code_compte, Application_Model_EuCreditCode $CreditCode) {
        $result = $this->getDbTable()->find($code_compte);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $CreditCode->setCode_compte($row->code_compte)
                ->setCredit_code($row->credit_code);
        return true;
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCreditCode();
            $entry->setCode_compte($row->code_compte)
               	->setCredit_code($row->credit_code);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_compte) {
        $this->getDbTable()->delete(array('code_compte = ?' => $code_compte));
    }






}


