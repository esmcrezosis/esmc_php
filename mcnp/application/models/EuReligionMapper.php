<?php

class Application_Model_EuReligionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuReligion');
        }
        return $this->_dbTable;
    }

    public function find($id_religion_membre, Application_Model_EuReligion $religion) {
        $result = $this->getDbTable()->find($id_religion_membre);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $religion->setId_religion_membre($row->id_religion_membre)
                 ->setLibelle_religion($row->libelle_religion);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReligion();
            $entry->setId_religion_membre($row->id_religion_membre);
            $entry->setLibelle_religion($row->libelle_religion);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuReligion $religion) {
        $data = array(
            'id_religion_membre' => $religion->getId_religion_membre(),
            'libelle_religion' => $religion->getLibelle_religion()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuReligion $religion) {
        $data = array(
            'id_religion_membre' => $religion->getId_religion_membre(),
            'libelle_religion' => $religion->getLibelle_religion()
        );
        $this->getDbTable()->update($data, array('id_religion_membre = ?' => $religion->getId_religion_membre()));
    }

    public function delete($id_religion_membre) {
        $this->getDbTable()->delete(array('id_religion_membre = ?' => $id_religion_membre));
    }

}

