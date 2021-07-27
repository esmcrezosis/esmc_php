<?php

class Application_Model_EuReglementMfMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuReglementMf');
        }
        return $this->_dbTable;
    }

    public function findMaxReglt() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_reglt_mf) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function find($id_reglt_mf, Application_Model_EuReglementMf $reglement) {
        $result = $this->getDbTable()->find($id_reglt_mf);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $reglement->setId_reglt_mf($row->id_reglt_mf)
                ->setMont_reglt_mf($row->mont_reglt_mf)
                ->setCode_membre($row->code_membre)
                ->setDate_reglt_mf($row->date_reglt_mf)
                ->setType_mf($row->type_mf)
                ->setType_reglt_mf($row->type_reglt_mf)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReglementMf();
            $entry->setId_reglt_mf($row->id_reglt_mf);
            $entry->setMont_reglt_mf($row->mont_reglt_mf);
            $entry->setCode_membre($row->code_membre);
            $entry->setDate_reglt_mf($row->date_reglt_mf);
            $entry->setType_mf($row->type_mf);
            $entry->setType_reglt_mf($row->type_reglt_mf);
            $entry->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuReglementMf $reglement) {
        $data = array(
            'id_reglt_mf' => $reglement->getId_reglt_mf(),
            'mont_reglt_mf' => $reglement->getMont_reglt_mf(),
            'code_membre' => $reglement->getCode_membre(),
            'date_reglt_mf' => $reglement->getDate_reglt_mf(),
            'type_mf' => $reglement->getType_mf(),
            'type_reglt_mf' => $reglement->getType_reglt_mf(),
            'id_utilisateur' => $reglement->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuReglementMf $reglement) {
        $data = array(
            'id_reglt_mf' => $reglement->getId_reglt_mf(),
            'mont_reglt_mf' => $reglement->getMont_reglt_mf(),
            'code_membre' => $reglement->getCode_membre(),
            'date_reglt_mf' => $reglement->getDate_reglt_mf(),
            'type_mf' => $reglement->getType_mf(),
            'type_reglt_mf' => $reglement->getType_reglt_mf(),
            'id_utilisateur' => $reglement->getId_utilisateur()
        );

        $this->getDbTable()->update($data, array('id_reglt_mf = ?' => $reglement->getId_reglt_mf()));
    }

    public function delete($id_reglt_mf) {
        $this->getDbTable()->delete(array('id_reglt_mf = ?' => $id_reglt_mf));
    }

}
