<?php

class Application_Model_EuStatutJuridiqueMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuStatutJuridique');
        }
        return $this->_dbTable;
    }

    public function find($code_statut, Application_Model_EuStatutJuridique $statutjuridique) {
        $result = $this->getDbTable()->find($code_statut);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $statutjuridique->setCode_statut($row->code_statut)
                        ->setLibelle_statut($row->libelle_statut);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuStatutJuridique();
            $entry->setCode_statut($row->code_statut);
            $entry->setLibelle_statut($row->libelle_statut);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuStatutJuridique $statutjuridique) {
        $data = array(
            'code_statut' => $statutjuridique->getId_religion_membre(),
            'libelle_statut' => $statutjuridique->getLibelle_statut()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuStatutJuridique $statutjuridique) {
        $data = array(
            'code_statut' => $statutjuridique->getId_religion_membre(),
            'libelle_statut' => $statutjuridique->getLibelle_statut()
        );
        $this->getDbTable()->update($data, array('code_statut = ?' => $statutjuridique->getCode_statut()));
    }

    public function delete($code_statut) {
        $this->getDbTable()->delete(array('code_statut = ?' => $code_statut));
    }

}


