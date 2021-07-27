<?php

class Application_Model_EuSmsNbreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmsNbre');
        }
        return $this->_dbTable;
    }

    public function find($sms_nbre_id, Application_Model_EuSmsNbre $sms_nbre) {
        $result = $this->getDbTable()->find($sms_nbre_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $sms_nbre->setSms_nbre_id($row->sms_nbre_id)
                ->setSms_nbre_nbre($row->sms_nbre_nbre)
                ->setSms_nbre_alerte($row->sms_nbre_alerte)
                ->setSms_nbre_date($row->sms_nbre_date);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsNbre();
            $entry->setSms_nbre_id($row->sms_nbre_id)
                ->setSms_nbre_nbre($row->sms_nbre_nbre)
                ->setSms_nbre_alerte($row->sms_nbre_alerte)
                ->setSms_nbre_date($row->sms_nbre_date);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(sms_nbre_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuSmsNbre $sms_nbre) {
        $data = array(
            'sms_nbre_id' => $sms_nbre->getSms_nbre_id(),
            'sms_nbre_nbre' => $sms_nbre->getSms_nbre_nbre(),
            'sms_nbre_alerte' => $sms_nbre->getSms_nbre_alerte(),
            'sms_nbre_date' => $sms_nbre->getSms_nbre_date()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmsNbre $sms_nbre) {
        $data = array(
            'sms_nbre_id' => $sms_nbre->getSms_nbre_id(),
            'sms_nbre_nbre' => $sms_nbre->getSms_nbre_nbre(),
            'sms_nbre_alerte' => $sms_nbre->getSms_nbre_alerte(),
            'sms_nbre_date' => $sms_nbre->getSms_nbre_date()
        );
        $this->getDbTable()->update($data, array('sms_nbre_id = ?' => $sms_nbre->getSms_nbre_id()));
    }

    public function delete($sms_nbre_id) {
        $this->getDbTable()->delete(array('sms_nbre_id = ?' => $sms_nbre_id));
    }


    

}


?>
