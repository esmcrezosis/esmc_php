<?php

class Application_Model_EuModeLivraisonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuModeLivraison');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuModeLivraison $modelivraison) {
        $data = array(
            'mode_livraison' => $modelivraison->getMode_livraison(),
            'designation_livraison' => $modelivraison->getDesignation_livraison()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuModeLivraison $modelivraison) {
        $data = array(
            'mode_livraison' => $modelivraison->getMode_livraison(),
            'designation_livraison' => $modelivraison->getDesignation_livraison()
        );
        $this->getDbTable()->update($data, array('mode_livraison' => $modelivraison->getMode_livraison()));
    }

    public function find($mode_livraison, Application_Model_EuModeLivraison $modelivraison) {
        $result = $this->getDbTable()->find($mode_livraison);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $modelivraison->setMode_livraison($row->mode_livraison)
                ->setDesignation_livraison($row->designation_livraison);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuModeLivraison();
            $entry->setMode_livraison($row->mode_livraison)
                  ->setDesignation_livraison($row->designation_livraison);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($mode_livraison) {
        $this->getDbTable()->delete(array('mode_livraison = ?' => $mode_livraison));
    }






    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(mode_livraison) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}