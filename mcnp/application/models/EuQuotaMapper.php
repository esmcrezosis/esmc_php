<?php

class Application_Model_EuQuotaMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQuota');
        }
        return $this->_dbTable;
    }

    public function find($type_quota, Application_Model_EuQuota $quota) {
        $result = $this->getDbTable()->find($type_quota);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $quota->setType_quota($row->type_quota)
                ->setMin_quota($row->min_quota)
                ->setMax_quota($row->max_quota);
        return true;
    }

    public function save(Application_Model_EuQuota $quota) {
        $data = array(
            'type_quota' => $quota->getType_quota(),
            'min_quota' => $quota->getMin_quota(),
            'max_quota' => $quota->getMax_quota()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuQuota $quota) {
        $data = array(
            'type_quota' => $quota->getType_quota(),
            'min_quota' => $quota->getMin_quota(),
            'max_quota' => $quota->getMax_quota()
        );

        $this->getDbTable()->update($data, array('type_quota = ?' => $quota->getType_quota()));
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuota();
            $entry->setType_quota($row->type_quota)
                    ->setMin_quota($row->min_quota)
                    ->setMax_quota($row->min_quota);
            $entries[] = $entry;
        }
        return $entries;
    } 

    public function delete($type_quota) {
        $this->getDbTable()->delete(array('type_quota = ?' => $type_quota));
    }

}

?>
