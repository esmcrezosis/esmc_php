<?php

class Application_Model_EuTypeCreneauMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeCreneau');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTypeCreneau $type_creneau) {
        $data = array(
            'id_type_creneau' => $type_creneau->getId_type_creneau(),
            'libelle_type_creneau' => $type_creneau->getLibelle_type_creneau()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeCreneau $type_creneau) {
        $data = array(
            'id_type_creneau' => $type_creneau->getId_type_creneau(),
            'libelle_type_creneau' => $type_creneau->getLibelle_type_creneau()
        );

        $this->getDbTable()->update($data, array('id_type_creneau = ?' => $type_creneau->getId_type_creneau()));
    }

    public function find($id_type_creneau, Application_Model_EuTypeCreneau $type_crenau) {
        $result = $this->getDbTable()->find($id_type_creneau);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $type_crenau->setId_type_creneau($row->id_type_creneau)
                ->setLibelle_type_creneau($row->libelle_type_creneau);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCreneau();
            $entry->setId_type_creneau($row->id_type_creneau)
                    ->setLibelle_type_creneau($row->libelle_type_creneau);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_type_creneau) {
        $this->getDbTable()->delete(array('id_type_creneau = ?' => $id_type_creneau));
    }

}

