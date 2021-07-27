<?php

class Application_Model_EuTacheMembreassoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTacheMembreasso');
        }
        return $this->_dbTable;
    }

    public function find($tache_id, Application_Model_EuTacheMembreasso $tache_membreasso) {
        $result = $this->getDbTable()->find($tache_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $tache_membreasso->setTache_id($row->tache_id)
                ->setTache_libelle($row->tache_libelle)
                ->setTache_description($row->tache_description)
                ->setTache_url($row->tache_url)
                ->setTache_asso($row->tache_asso)
                ->setTache_type($row->tache_type)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTacheMembreasso();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_asso($row->tache_asso)
                    ->setTache_type($row->tache_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(tache_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuTacheMembreasso $tache_membreasso) {
        $data = array(
            'tache_id' => $tache_membreasso->getTache_id(),
            'tache_libelle' => $tache_membreasso->getTache_libelle(),
            'tache_description' => $tache_membreasso->getTache_description(),
            'tache_url' => $tache_membreasso->getTache_url(),
            'tache_asso' => $tache_membreasso->getTache_asso(),
            'tache_type' => $tache_membreasso->getTache_type(),
            'publier' => $tache_membreasso->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTacheMembreasso $tache_membreasso) {
        $data = array(
            'tache_id' => $tache_membreasso->getTache_id(),
            'tache_libelle' => $tache_membreasso->getTache_libelle(),
            'tache_description' => $tache_membreasso->getTache_description(),
            'tache_url' => $tache_membreasso->getTache_url(),
            'tache_asso' => $tache_membreasso->getTache_asso(),
            'tache_type' => $tache_membreasso->getTache_type(),
            'publier' => $tache_membreasso->getPublier()
        );
        $this->getDbTable()->update($data, array('tache_id = ?' => $tache_membreasso->getTache_id()));
    }

    public function delete($tache_id) {
        $this->getDbTable()->delete(array('tache_id = ?' => $tache_id));
    }


    public function fetchAllByAssociation($tache_asso) {
        $select = $this->getDbTable()->select();
		$select->where("tache_asso = ? ", $tache_asso);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTacheMembreasso();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_asso($row->tache_asso)
                    ->setTache_type($row->tache_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByAssociation2($tache_asso, $membreasso, $tache_type) {
        $select = $this->getDbTable()->select();
		$select->where("tache_asso = ? ", $tache_asso);
        $select->where("tache_type = ? ", $tache_type);
		$select->where("tache_id NOT IN (SELECT poste_tache FROM eu_poste_membreasso WHERE poste_membreasso = ".$membreasso.") ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTacheMembreasso();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_asso($row->tache_asso)
                    ->setTache_type($row->tache_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function fetchAllByAssociation3($tache_asso, $membreasso, $tache_type) {
        $select = $this->getDbTable()->select();
		$select->where("tache_asso = ? ", $tache_asso);
        $select->where("tache_type = ? ", $tache_type);
		$select->where("tache_id IN (SELECT poste_tache FROM eu_poste_membreasso WHERE poste_membreasso = ".$membreasso.") ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTacheMembreasso();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_asso($row->tache_asso)
                    ->setTache_type($row->tache_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByType($tache_type) {
        $select = $this->getDbTable()->select();
        $select->where("tache_type = ? ", $tache_type);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTacheMembreasso();
            $entry->setTache_id($row->tache_id)
                    ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
                    ->setTache_asso($row->tache_asso)
                    ->setTache_type($row->tache_type)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    

}


?>
