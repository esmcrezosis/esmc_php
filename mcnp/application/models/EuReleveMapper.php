<?php
 
class Application_Model_EuReleveMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuReleve');
        }
        return $this->_dbTable;
    }

    public function find($releve_id, Application_Model_EuReleve $releve) {
        $result = $this->getDbTable()->find($releve_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $releve->setReleve_id($row->releve_id)
                ->setReleve_membre($row->releve_membre)
                ->setReleve_fichier($row->releve_fichier)
                ->setReleve_type($row->releve_type)
                ->setReleve_date($row->releve_date)
                ->setPublier($row->publier)
				->setNew_code_membre($row->new_code_membre)
			   ->setUtilisateur($row->utilisateur)
			   ->setTraiter($row->traiter);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	              ->setReleve_membre($row->releve_membre)
                  ->setReleve_fichier($row->releve_fichier)
	              ->setReleve_type($row->releve_type)
                  ->setReleve_date($row->releve_date)
                  ->setPublier($row->publier)
				  ->setNew_code_membre($row->new_code_membre)
			      ->setUtilisateur($row->utilisateur)
			      ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(releve_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuReleve $releve) {
        $data = array(
            'releve_id' => $releve->getReleve_id(),
            'releve_membre' => $releve->getReleve_membre(),
            'releve_fichier' => $releve->getReleve_fichier(),
            'releve_type' => $releve->getReleve_type(),
            'releve_date' => $releve->getReleve_date(),
            'publier' => $releve->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuReleve $releve) {
        $data = array(
            'releve_id' => $releve->getReleve_id(),
            'releve_membre' => $releve->getReleve_membre(),
            'releve_fichier' => $releve->getReleve_fichier(),
            'releve_type' => $releve->getReleve_type(),
            'releve_date' => $releve->getReleve_date(),
            'publier' => $releve->getPublier(),
			'new_code_membre' => $releve->getNew_code_membre(),
            'utilisateur' => $releve->getUtilisateur(),
            'traiter' => $releve->getTraiter()
        );
        $this->getDbTable()->update($data, array('releve_id = ?' => $releve->getReleve_id()));
    }

    public function delete($releve_id) {
        $this->getDbTable()->delete(array('releve_id = ?' => $releve_id));
    }


    public function fetchAll_1() {
        $select = $this->getDbTable()->select();
		$select->where("publier IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	              ->setReleve_membre($row->releve_membre)
                  ->setReleve_fichier($row->releve_fichier)
	              ->setReleve_type($row->releve_type)
	              ->setReleve_date($row->releve_date)
                  ->setPublier($row->publier)
				  ->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll0() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll1() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ",1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 2);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("releve_type = ? ", $type);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllByType($type,$membre) {
	    $select = $this->getDbTable()->select();
		$select->where("releve_type = ? ", $type);
		$select->where("releve_membre = ? ", $membre);
		$resultSet = $this->getDbTable()->fetchAll($select);
		if (count($resultSet) == 0) {
          return NULL;
        }
        $entries = array();
		foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	              ->setReleve_membre($row->releve_membre)
                  ->setReleve_fichier($row->releve_fichier)
	              ->setReleve_type($row->releve_type)
	              ->setReleve_date($row->releve_date)
                  ->setPublier($row->publier)
				  ->setNew_code_membre($row->new_code_membre)
				  ->setUtilisateur($row->utilisateur)
				  ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;	
	}
	
	
	
    public function fetchAllByTypeMembre1($type, $membre) {
        $select = $this->getDbTable()->select();
		$select->where("releve_type = ? ", $type);
		$select->where("releve_membre = ? ", $membre);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByTypeMembre_1($type, $membre) {
        $select = $this->getDbTable()->select();
		$select->where("releve_type = ? ", $type);
		$select->where("releve_membre = ? ", $membre);
		$select->where("publier = ? ", -1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
			$entries = $entry;
        return $entries;
    }
	
    public function fetchAllByTypeMembre($type, $membre) {
        $select = $this->getDbTable()->select();
		$select->where("releve_type = ? ", $type);
		$select->where("releve_membre = ? ", $membre);
		//$select->where("publier = ? ", -1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuReleve();
            $entry->setReleve_id($row->releve_id)
	                ->setReleve_membre($row->releve_membre)
                    ->setReleve_fichier($row->releve_fichier)
	                ->setReleve_type($row->releve_type)
	                ->setReleve_date($row->releve_date)
                	->setPublier($row->publier)
					->setNew_code_membre($row->new_code_membre)
				    ->setUtilisateur($row->utilisateur)
				    ->setTraiter($row->traiter);
			$entries = $entry;
        return $entries;
    }


}


?>
