<?php
 
class Application_Model_EuActualiteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuActualite');
        }
        return $this->_dbTable;
    }

    public function find($actualite_id, Application_Model_EuActualite $actualite) {
        $result = $this->getDbTable()->find($actualite_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $actualite->setActualite_id($row->actualite_id)
                ->setActualite_libelle($row->actualite_libelle)
                ->setActualite_description($row->actualite_description)
                ->setActualite_resume($row->actualite_resume)
                ->setActualite_type($row->actualite_type)
                ->setActualite_vignette($row->actualite_vignette)
                ->setActualite_date($row->actualite_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("actualite_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActualite();
            $entry->setActualite_id($row->actualite_id)
	                ->setActualite_libelle($row->actualite_libelle)
                    ->setActualite_description($row->actualite_description)
                    ->setActualite_resume($row->actualite_resume)
	                ->setActualite_type($row->actualite_type)
					->setActualite_vignette($row->actualite_vignette)
					->setActualite_date($row->actualite_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(actualite_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuActualite $actualite) {
        $data = array(
            'actualite_id' => $actualite->getActualite_id(),
            'actualite_libelle' => $actualite->getActualite_libelle(),
            'actualite_description' => $actualite->getActualite_description(),
            'actualite_resume' => $actualite->getActualite_resume(),
            'actualite_type' => $actualite->getActualite_type(),
            'actualite_vignette' => $actualite->getActualite_vignette(),
            'actualite_date' => $actualite->getActualite_date(),
            'publier' => $actualite->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuActualite $actualite) {
        $data = array(
            'actualite_id' => $actualite->getActualite_id(),
            'actualite_libelle' => $actualite->getActualite_libelle(),
            'actualite_description' => $actualite->getActualite_description(),
            'actualite_resume' => $actualite->getActualite_resume(),
            'actualite_type' => $actualite->getActualite_type(),
            'actualite_vignette' => $actualite->getActualite_vignette(),
            'actualite_date' => $actualite->getActualite_date(),
            'publier' => $actualite->getPublier()
        );
        $this->getDbTable()->update($data, array('actualite_id = ?' => $actualite->getActualite_id()));
    }

    public function delete($actualite_id) {
        $this->getDbTable()->delete(array('actualite_id = ?' => $actualite_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("actualite_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActualite();
            $entry->setActualite_id($row->actualite_id)
	                ->setActualite_libelle($row->actualite_libelle)
                    ->setActualite_description($row->actualite_description)
                    ->setActualite_resume($row->actualite_resume)
	                ->setActualite_type($row->actualite_type)
					->setActualite_vignette($row->actualite_vignette)
					->setActualite_date($row->actualite_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("actualite_type = ? ", $type);
		$select->where("publier = ? ", 1);
		$select->order("actualite_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActualite();
            $entry->setActualite_id($row->actualite_id)
	                ->setActualite_libelle($row->actualite_libelle)
                    ->setActualite_description($row->actualite_description)
                    ->setActualite_resume($row->actualite_resume)
	                ->setActualite_type($row->actualite_type)
					->setActualite_vignette($row->actualite_vignette)
					->setActualite_date($row->actualite_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("actualite_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("actualite_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActualite();
            $entry->setActualite_id($row->actualite_id)
	                ->setActualite_libelle($row->actualite_libelle)
                    ->setActualite_description($row->actualite_description)
                    ->setActualite_resume($row->actualite_resume)
	                ->setActualite_type($row->actualite_type)
					->setActualite_vignette($row->actualite_vignette)
					->setActualite_date($row->actualite_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
