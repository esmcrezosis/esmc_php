<?php

class Application_Model_EuTacheMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTache');
        }
        return $this->_dbTable;
    }

    public function find($tache_id, Application_Model_EuTache $tache) {
        $result = $this->getDbTable()->find($tache_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $tache->setTache_id($row->tache_id)
                ->setTache_libelle($row->tache_libelle)
                ->setTache_description($row->tache_description)
                ->setTache_url($row->tache_url)
                ->setTache_code($row->tache_code)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTache();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_code($row->tache_code)
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

    public function save(Application_Model_EuTache $tache) {
        $data = array(
            'tache_id' => $tache->getTache_id(),
            'tache_libelle' => $tache->getTache_libelle(),
            'tache_description' => $tache->getTache_description(),
            'tache_url' => $tache->getTache_url(),
            'tache_code' => $tache->getTache_code(),
            'publier' => $tache->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTache $tache) {
        $data = array(
            'tache_id' => $tache->getTache_id(),
            'tache_libelle' => $tache->getTache_libelle(),
            'tache_description' => $tache->getTache_description(),
            'tache_url' => $tache->getTache_url(),
            'tache_code' => $tache->getTache_code(),
            'publier' => $tache->getPublier()
        );
        $this->getDbTable()->update($data, array('tache_id = ?' => $tache->getTache_id()));
    }

    public function delete($tache_id) {
        $this->getDbTable()->delete(array('tache_id = ?' => $tache_id));
    }


    public function fetchAllByCodeGroupe($tache_code) {
        $select = $this->getDbTable()->select();
		$select->where("tache_code = ? ", $tache_code);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTache();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_code($row->tache_code)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByCodeGroupe2($tache_code, $utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("tache_code = ? ", $tache_code);
		$select->where("tache_id NOT IN (SELECT poste_tache FROM eu_poste WHERE poste_utilisateur = ".$utilisateur.") ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTache();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_code($row->tache_code)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function fetchAllByCodeGroupe3($tache_code, $utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("tache_code = ? ", $tache_code);
		$select->where("tache_id IN (SELECT poste_tache FROM eu_poste WHERE poste_utilisateur = ".$utilisateur.") ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTache();
            $entry->setTache_id($row->tache_id)
	                ->setTache_libelle($row->tache_libelle)
                    ->setTache_description($row->tache_description)
                    ->setTache_url($row->tache_url)
	                ->setTache_code($row->tache_code)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
