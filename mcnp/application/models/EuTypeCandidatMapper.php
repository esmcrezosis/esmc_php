<?php

class Application_Model_EuTypeCandidatMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeCandidat');
        }
        return $this->_dbTable;
    }

    public function find($id_type_candidat, Application_Model_EuTypeCandidat $candidat) {
        $result = $this->getDbTable()->find($id_type_candidat);
        if (0 == count($result)) {
           return;
        }
        $row = $result->current();
        $candidat->setId_type_candidat($row->id_type_candidat)
                 ->setLibelle_type_candidat($row->libelle_type_candidat)
                 ->setOption_type_candidat($row->option_type_candidat);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                    ->setLibelle_type_candidat($row->libelle_type_candidat)
                ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeCandidat $candidat) {
        $data = array(
            'id_type_candidat' => $candidat->getId_type_candidat(),
            'libelle_type_candidat' => $candidat->getLibelle_type_candidat(),
            'option_type_candidat' => $candidat->getOption_type_candidat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeCandidat $candidat) {
        $data = array(
            'id_type_candidat' => $candidat->getId_type_candidat(),
            'libelle_type_candidat' => $candidat->getLibelle_type_candidat(),
            'option_type_candidat' => $candidat->getOption_type_candidat()
        );
        $this->getDbTable()->update($data, array('id_type_candidat = ?' => $candidat->getId_type_candidat()));
    }

    public function delete($id_type_candidat) {
        $this->getDbTable()->delete(array('id_type_candidat = ?' => $id_type_candidat));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_candidat) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

	public function fetchAllOffreurProjet() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat in (?) ", array(6,7));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchAllIntegrateur() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat not in (?) ",array(6,7));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchAllIntegrateurose() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat in (?) ",array(8,12,13));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur8() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat in (?) ",array(8,9));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function fetchByIntegrateur9() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",9);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	
	
	public function fetchByIntegrateur1() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",1);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur2() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",2);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur3() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",3);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur4() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",4);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur5() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",5);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur10() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",10);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchByIntegrateur11() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",11);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function fetchByIntegrateur12() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",12);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}


        public function fetchByIntegrateur13() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ",13);
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                  ->setLibelle_type_candidat($row->libelle_type_candidat)
                  ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	
	
	
	
    public function fetchAllByType($id_type_candidat) {
        $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ", $id_type_candidat);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCandidat();
            $entry->setId_type_candidat($row->id_type_candidat)
                    ->setLibelle_type_candidat($row->libelle_type_candidat)
                ->setOption_type_candidat($row->option_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
    }
	


}
?>

