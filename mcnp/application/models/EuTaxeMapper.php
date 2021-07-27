<?php

class Application_Model_EuTaxeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTaxe');
        }
        return $this->_dbTable;
    }

    public function find($id_taxe, Application_Model_EuTaxe $taxe) {
        $result = $this->getDbTable()->find($id_taxe);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $taxe->setId_taxe($row->id_taxe)
             ->setLibelle_taxe($row->libelle_taxe)
             ->setTaux_taxe($row->taux_taxe)
             ->setId_pays($row->id_pays);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTaxe();
            $entry->setId_taxe($row->id_taxe);
            $entry->setLibelle_taxe($row->libelle_taxe);
            $entry->setTaux_taxe($row->taux_taxe);
            $entry->setId_pays($row->id_pays);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuTaxe $taxe) {
        $data = array(
            'id_taxe' => $taxe->getId_taxe(),
            'libelle_taxe' => $taxe->getLibelle_taxe(),
            'taux_taxe' => $taxe->getTaux_taxe(),
            'id_pays' => $taxe->getId_pays()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTaxe $taxe) {
        $data = array(
            'id_taxe' => $taxe->getId_taxe(),
            'libelle_taxe' => $taxe->getLibelle_taxe(),
            'taux_taxe' => $taxe->getTaux_taxe(),
            'id_pays' => $taxe->getId_pays()
        );
        $this->getDbTable()->update($data, array('id_taxe = ?' => $taxe->getId_taxe()));
    }

    public function delete($id_taxe) {
        $this->getDbTable()->delete(array('id_taxe = ?' => $id_taxe));
    }

}
