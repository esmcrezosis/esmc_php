<?php

class Application_Model_EuZoneMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuZone');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuZone $zone) {
        $data = array(
            'code_zone' => $zone->getCode_zone(),
            'nom_zone' => $zone->getNom_zone(),
            'date_creation' => $zone->getDate_creation(),
            'id_utilisateur' => $zone->getId_utilisateur(),
            'code_dev' => $zone->getCode_dev()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuZone $zone) {
        $data = array(
            'code_zone' => $zone->getCode_zone(),
            'nom_zone' => $zone->getNom_zone(),
            'date_creation' => $zone->getDate_creation(),
            'id_utilisateur' => $zone->getId_utilisateur(),
            'code_dev' => $zone->getCode_dev()
        );
        $this->getDbTable()->update($data, array('code_zone = ?' => $zone->getCode_zone()));
    }

    public function find($code_zone, Application_Model_EuZone $zone) {
        $result = $this->getDbTable()->find($code_zone);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $zone->setCode_zone($row->code_zone);
        $zone->setNom_zone($row->nom_zone);
        $zone->setDate_creation($row->date_creation);
        $zone->setId_utilisateur($row->id_utilisateur);
        $zone->setCode_dev($row->code_dev);
		return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuZone();
            $entry->setCode_zone($row->code_zone);
            $entry->setNom_zone($row->nom_zone);
            $entry->setDate_creation($row->date_creation);
            $entry->setId_utilisateur($row->id_utilisateur);
            $entry->setCode_dev($row->code_dev);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getLastCodeZone() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_zone) as code'));
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function delete($code_zone) {
        $this->getDbTable()->delete(array('code_zone = ?' => $code_zone));
    }

}

