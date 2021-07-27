<?php
/**
*
*/
class Application_Model_EuSalaireAffecterMapper{

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
            $this->setDbTable('Application_Model_DbTable_EuSalaireAffecter');
        }
        return $this->_dbTable;
    }
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_affectation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSalaireAffecter();

            $entry->setId_affectation($row->id_affectation)
                    ->setId_credit($row->id_credit)
                    ->setDate_affectation($row->date_affectation)
                    ->setHeure_affectation($row->heure_affectation)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_emp($row->code_membre_emp)
                    ->setMont_affecter($row->mont_affecter)
                    ->setDate_deb($row->date_deb)
                    ->setDate_fin($row->date_fin)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
}
