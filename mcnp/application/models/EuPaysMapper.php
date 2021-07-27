<?php

class Application_Model_EuPaysMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPays');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPays $pays) {
        $data = array(
            'id_pays' => $pays->getId_pays(),
            'code_pays' => $pays->getCode_pays(),
            'libelle_pays' => $pays->getLibelle_pays(),
            'nationalite' => $pays->getNationalite(),
            'code_telephonique' => $pays->getCode_telephonique(),
            'code_zone' => $pays->getCode_zone()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPays $pays) {
        $data = array(
            'id_pays' => $pays->getId_pays(),
            'code_pays' => $pays->getCode_pays(),
            'libelle_pays' => $pays->getLibelle_pays(),
            'nationalite' => $pays->getNationalite(),
            'code_telephonique' => $pays->getCode_telephonique(),
            'code_zone' => $pays->getCode_zone()
        );
        $this->getDbTable()->update($data, array('id_pays = ?' => $pays->getId_pays()));
    }

    public function find($id_pays, Application_Model_EuPays $pays) {
        $result = $this->getDbTable()->find($id_pays);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $pays->setId_pays($row->id_pays)
                ->setCode_pays($row->code_pays)
                ->setLibelle_pays($row->libelle_pays)
                ->setNationalite($row->nationalite)
                ->setCode_telephonique($row->code_telephonique)
                ->setCode_zone($row->code_zone);
		return true;		
    }

    public function findByCodepays($code_pays) {
        $select = $this->getDbTable()->select();
        $select->where('code_pays= ?', $code_pays);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $pays = new Application_Model_EuPays();
        $pays->setId_pays($row->id_pays)
                ->setCode_pays($row->code_pays)
                ->setLibelle_pays($row->libelle_pays)
                ->setNationalite($row->nationalite)
                ->setCode_telephonique($row->code_telephonique)
                ->setCode_zone($row->code_zone);
        return $pays;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPays();
            $entry->setId_pays($row->id_pays);
            $entry->setCode_pays($row->code_pays);
            $entry->setLibelle_pays($row->libelle_pays);
            $entry->setNationalite($row->nationalite);
            $entry->setCode_telephonique($row->code_telephonique);
            $entry->setCode_zone($row->code_zone);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_pays) {
        $this->getDbTable()->delete(array('id_pays = ?' => $id_pays));
    }

}

