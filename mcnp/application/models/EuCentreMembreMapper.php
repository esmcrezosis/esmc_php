<?php

class Application_Model_EuCentreMembreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCentreMembre');
        }
        return $this->_dbTable;
    }

    public function find($centre_membre_id, Application_Model_EuCentreMembre $centre_membre) {
        $result = $this->getDbTable()->find($centre_membre_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $centre_membre->setCentre_membre_id($row->centre_membre_id)
                ->setCentre_id($row->centre_id)
                ->setCode_membre($row->code_membre);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCentreMembre();
            $entry->setCentre_membre_id($row->centre_membre_id)
                    ->setCentre_id($row->centre_id)
                    ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(centre_membre_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCentreMembre $centre_membre) {
        $data = array(
            'centre_membre_id' => $centre_membre->getCentre_membre_id(),
            'centre_id' => $centre_membre->getCentre_id(),
            'code_membre' => $centre_membre->getCode_membre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCentreMembre $centre_membre) {
        $data = array(
            'centre_membre_id' => $centre_membre->getCentre_membre_id(),
            'centre_id' => $centre_membre->getCentre_id(),
            'code_membre' => $centre_membre->getCode_membre()
        );
        $this->getDbTable()->update($data, array('centre_membre_id = ?' => $centre_membre->getCentre_membre_id()));
    }

    public function delete($centre_membre_id) {
        $this->getDbTable()->delete(array('centre_membre_id = ?' => $centre_membre_id));
    }


    public function fetchAll2($centre_id) {
        $select = $this->getDbTable()->select();
		$select->where("centre_id = ? ", $centre_id);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCentreMembre();
            $entry->setCentre_membre_id($row->centre_membre_id)
                    ->setCentre_id($row->centre_id)
                    ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
    

}


?>
