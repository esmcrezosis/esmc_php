<?php

class Application_Model_EuReglementMapper
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
            $this->setDbTable('Application_Model_DbTable_EuReglement');
        }
        return $this->_dbTable;
    }
    
    public function findMaxReglt() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_reglt) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    
    
    public function find($id_reglt, Application_Model_EuReglement $reglement) {
        $result = $this->getDbTable()->find($num_reglt);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $reglement->setId_reglt($row->id_reglt)
                  ->setDate_reglt($row->date_reglt)
                  ->setMontant_reglt($row->montant_reglt)
                  ->setCode_facture($row->code_facture);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReglement();
            $entry->setId_reglt($row->id_reglt);
            $entry->setDate_reglt($row->date_reglt);
            $entry->setMontant_reglt($row->montant_reglt);
            $entry->setCode_facture($row->code_facture);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuReglement $reglement) {
        $data = array(
            'id_reglt' => $reglement->getId_reglt(),
            'date_reglt' => $reglement->getDate_reglt(),
            'montant_reglt' => $reglement->getMontant_reglt(),
            'code_facture' => $reglement->getCode_facture()
        );

        $this->getDbTable()->insert($data);
    }
    
     public function update(Application_Model_EuReglement $reglement) {
        $data = array(
            'id_reglt' => $reglement->getId_reglt(),
            'date_reglt' => $reglement->getDate_reglt(),
            'montant_reglt' => $reglement->getMontant_reglt(),
            'code_facture' => $reglement->getCode_facture()
        );

        $this->getDbTable()->update($data, array('id_reglt = ?' => $reglement->getId_reglt()));
    }
    
     public function delete($id_reglt) {
        $this->getDbTable()->delete(array('id_reglt = ?' => $id_reglt));
    }
}