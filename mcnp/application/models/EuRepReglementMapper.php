<?php

class Application_Model_EuRepReglementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRepReglement');
        }
        return $this->_dbTable;
    }

    public function find($id_reglt_mf, $id_rep, Application_Model_EuRepReglement $rep_reglt) {
        $result = $this->getDbTable()->find($id_reglt_mf, $id_rep);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $rep_reglt->setId_reglt_mf($row->id_reglt_mf)
                ->setId_rep($row->id_rep)
                ->setMont_rep_reglt($row->mont_rep_reglt);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepReglement();
            $entry->setId_reglt_mf($row->id_reglt_mf)
                    ->setId_rep($row->id_rep)
                    ->setMont_rep_reglt($row->mont_rep_reglt);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuRepReglement $rep_reglt) {
        $data = array(
            'id_reglt_mf' => $rep_reglt->getId_reglt_mf(),
            'id_rep' => $rep_reglt->getId_rep(),
            'mont_rep_reglt' => $rep_reglt->getMont_rep_reglt()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepReglement $rep_reglt) {
        $data = array(
            'id_reglt_mf' => $rep_reglt->getId_reglt_mf(),
            'id_rep' => $rep_reglt->getId_rep(),
            'mont_rep_reglt' => $rep_reglt->getMont_rep_reglt()
        );
        $this->getDbTable()->update($data, array('id_reglt_mf = ?' => $rep_reglt->getId_reglt_mf(), 'id_rep' => $rep_reglt->getId_rep()));
    }

    public function delete($id_reglt_mf, $id_rep) {
        $this->getDbTable()->delete(array('id_reglt_mf = ?' => $id_reglt_mf, 'id_rep' => $id_rep));
    }

}