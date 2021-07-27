<?php

class Application_Model_EuFiliereGacFiliereMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFiliereGacFiliere');
        }
        return $this->_dbTable;
    }

    public function find($id_filiere, $code_gac_filiere, Application_Model_EuFiliereGacFiliere $filiere) {
        $result = $this->getDbTable()->find($id_filiere, $code_gac_filiere);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $filiere->setId_filiere($row->id_filiere)
                ->setCode_gac_filiere($row->code_gac_filiere);
        return true;
    }

    public function findByGacFiliere($code_gac_filiere) {
        $select = $this->getDbTable()->select();
        $select->where('code_gac_filiere = ?', $code_gac_filiere);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuFiliereGacFiliere();
            $entry->setId_filiere($row->id_filiere)
                    ->setCode_gac_filiere($row->code_gac_filiere);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFiliereGacFiliere();
            $entry->setId_filiere($row->id_filiere)
                    ->setCode_gac_filiere($row->code_gac_filiere);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuFiliereGacFiliere $filiere) {
        $data = array(
            'id_filiere' => $filiere->getId_filiere(),
            'code_gac_filiere' => $filiere->getCode_gac_filiere()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFiliereGacFiliere $filiere) {
        $data = array(
            'id_filiere' => $filiere->getId_filiere(),
            'code_gac_filiere' => $filiere->getCode_gac_filiere()
        );
        $this->getDbTable()->update($data, array('code_gac_filiere = ?' => $filiere->getCode_gac_filiere(), 'id_filiere = ?' => $filiere->getId_filiere()));
    }

    public function delete($code_gac_filiere, $id_filiere) {
        $this->getDbTable()->delete(array('code_gac_filiere = ?' => $code_gac_filiere, 'id_filiere = ?' => $id_filiere));
    }

}

?>
