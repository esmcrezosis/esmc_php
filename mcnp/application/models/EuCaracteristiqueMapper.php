<?php
 
class Application_Model_EuCaracteristiqueMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCaracteristique');
        }
        return $this->_dbTable;
    }

    public function find($caracteristique_id, Application_Model_EuCaracteristique $caracteristique) {
        $result = $this->getDbTable()->find($caracteristique_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $caracteristique->setCaracteristique_id($row->caracteristique_id)
                ->setCaracteristique_table_id($row->caracteristique_table_id)
                ->setCaracteristique_libelle($row->caracteristique_libelle)
                ->setCaracteristique_description($row->caracteristique_description)
                ->setCaracteristique_fichier($row->caracteristique_fichier)
                ->setCaracteristique_date($row->caracteristique_date)
                ->setCaracteristique_table($row->caracteristique_table)
                ->setCaracteristique_type($row->caracteristique_type)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaracteristique();
            $entry->setCaracteristique_id($row->caracteristique_id)
                ->setCaracteristique_table_id($row->caracteristique_table_id)
                ->setCaracteristique_libelle($row->caracteristique_libelle)
                ->setCaracteristique_description($row->caracteristique_description)
                ->setCaracteristique_fichier($row->caracteristique_fichier)
                ->setCaracteristique_date($row->caracteristique_date)
                ->setCaracteristique_table($row->caracteristique_table)
                ->setCaracteristique_type($row->caracteristique_type)
                ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(caracteristique_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCaracteristique $caracteristique) {
        $data = array(
            'caracteristique_id' => $caracteristique->getCaracteristique_id(),
            'caracteristique_table_id' => $caracteristique->getCaracteristique_table_id(),
            'caracteristique_libelle' => $caracteristique->getCaracteristique_libelle(),
            'caracteristique_description' => $caracteristique->getCaracteristique_description(),
            'caracteristique_fichier' => $caracteristique->getCaracteristique_fichier(),
            'caracteristique_date' => $caracteristique->getCaracteristique_date(),
            'caracteristique_table' => $caracteristique->getCaracteristique_table(),
            'caracteristique_type' => $caracteristique->getCaracteristique_type(),
            'publier' => $caracteristique->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCaracteristique $caracteristique) {
        $data = array(
            'caracteristique_table_id' => $caracteristique->getCaracteristique_table_id(),
            'caracteristique_libelle' => $caracteristique->getCaracteristique_libelle(),
            'caracteristique_description' => $caracteristique->getCaracteristique_description(),
            'caracteristique_fichier' => $caracteristique->getCaracteristique_fichier(),
            'caracteristique_date' => $caracteristique->getCaracteristique_date(),
            'caracteristique_table' => $caracteristique->getCaracteristique_table(),
            'caracteristique_type' => $caracteristique->getCaracteristique_type(),
            'publier' => $caracteristique->getPublier()
        );
        $this->getDbTable()->update($data, array('caracteristique_id = ?' => $caracteristique->getCaracteristique_id()));
    }

    public function delete($caracteristique_id) {
        $this->getDbTable()->delete(array('caracteristique_id = ?' => $caracteristique_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaracteristique();
            $entry->setCaracteristique_id($row->caracteristique_id)
                ->setCaracteristique_table_id($row->caracteristique_table_id)
                ->setCaracteristique_libelle($row->caracteristique_libelle)
                ->setCaracteristique_description($row->caracteristique_description)
                ->setCaracteristique_fichier($row->caracteristique_fichier)
                ->setCaracteristique_date($row->caracteristique_date)
                ->setCaracteristique_table($row->caracteristique_table)
                ->setCaracteristique_type($row->caracteristique_type)
                ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll20() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaracteristique();
            $entry->setCaracteristique_id($row->caracteristique_id)
                ->setCaracteristique_table_id($row->caracteristique_table_id)
                ->setCaracteristique_libelle($row->caracteristique_libelle)
                ->setCaracteristique_description($row->caracteristique_description)
                ->setCaracteristique_fichier($row->caracteristique_fichier)
                ->setCaracteristique_date($row->caracteristique_date)
                ->setCaracteristique_table($row->caracteristique_table)
                ->setCaracteristique_type($row->caracteristique_type)
                ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByTable($caracteristique_table, $caracteristique_table_id) {
        $select = $this->getDbTable()->select();
        $select->where("caracteristique_table LIKE ? ", $caracteristique_table);
        $select->where("caracteristique_table_id = ? ", $caracteristique_table_id);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaracteristique();
            $entry->setCaracteristique_id($row->caracteristique_id)
                ->setCaracteristique_table_id($row->caracteristique_table_id)
                ->setCaracteristique_libelle($row->caracteristique_libelle)
                ->setCaracteristique_description($row->caracteristique_description)
                ->setCaracteristique_fichier($row->caracteristique_fichier)
                ->setCaracteristique_date($row->caracteristique_date)
                ->setCaracteristique_table($row->caracteristique_table)
                ->setCaracteristique_type($row->caracteristique_type)
                ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByTable2($caracteristique_table, $caracteristique_table_id) {
        $select = $this->getDbTable()->select();
        $select->where("caracteristique_table LIKE ? ", $caracteristique_table);
        $select->where("caracteristique_table_id = ? ", $caracteristique_table_id);
        $select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaracteristique();
            $entry->setCaracteristique_id($row->caracteristique_id)
                ->setCaracteristique_table_id($row->caracteristique_table_id)
                ->setCaracteristique_libelle($row->caracteristique_libelle)
                ->setCaracteristique_description($row->caracteristique_description)
                ->setCaracteristique_fichier($row->caracteristique_fichier)
                ->setCaracteristique_date($row->caracteristique_date)
                ->setCaracteristique_table($row->caracteristique_table)
                ->setCaracteristique_type($row->caracteristique_type)
                ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }




}


?>
