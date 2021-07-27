<?php

class Application_Model_EuTypeContratMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeContrat');
        }
        return $this->_dbTable;
    }

    public function find($id_type_contrat, Application_Model_EuTypeContrat $contrat) {
        $result = $this->getDbTable()->find($id_type_contrat);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $contrat->setId_type_contrat($row->id_type_contrat)
                ->setLibelle_type_contrat($row->libelle_type_contrat);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeContrat();
            $entry->setId_type_contrat($row->id_type_contrat)
                    ->setLibelle_type_contrat($row->libelle_type_contrat);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeContrat $contrat) {
        $data = array(
            'id_type_contrat' => $contrat->getId_type_contrat(),
            'libelle_type_contrat' => $contrat->getLibelle_type_contrat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeContrat $contrat) {
        $data = array(
            'id_type_contrat' => $contrat->getId_type_contrat(),
            'libelle_type_contrat' => $contrat->getLibelle_type_contrat()
        );
        $this->getDbTable()->update($data, array('id_type_contrat = ?' => $contrat->getId_type_contrat()));
    }

    public function delete($id_type_contrat) {
        $this->getDbTable()->delete(array('id_type_contrat = ?' => $id_type_contrat));
    }

}
?>

