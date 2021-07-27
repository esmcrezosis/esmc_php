<?php
 
class Application_Model_EuValidationOpiMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuValidationOpi');
        }
        return $this->_dbTable;
    }

    public function find($validation_opi_id, Application_Model_EuValidationOpi $validation_opi) {
        $result = $this->getDbTable()->find($validation_opi_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $validation_opi->setValidation_opi_id($row->validation_opi_id)
                ->setValidation_opi_banque_user($row->validation_opi_banque_user)
                ->setValidation_opi_traite($row->validation_opi_traite)
                ->setValidation_opi_date($row->validation_opi_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("validation_opi_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationOpi();
            $entry->setValidation_opi_id($row->validation_opi_id)
	                ->setValidation_opi_banque_user($row->validation_opi_banque_user)
	                ->setValidation_opi_traite($row->validation_opi_traite)
					->setValidation_opi_date($row->validation_opi_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(validation_opi_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuValidationOpi $validation_opi) {
        $data = array(
            'validation_opi_id' => $validation_opi->getValidation_opi_id(),
            'validation_opi_banque_user' => $validation_opi->getValidation_opi_banque_user(),
            'validation_opi_traite' => $validation_opi->getValidation_opi_traite(),
            'validation_opi_date' => $validation_opi->getValidation_opi_date(),
            'publier' => $validation_opi->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuValidationOpi $validation_opi) {
        $data = array(
            'validation_opi_id' => $validation_opi->getValidation_opi_id(),
            'validation_opi_banque_user' => $validation_opi->getValidation_opi_banque_user(),
            'validation_opi_traite' => $validation_opi->getValidation_opi_traite(),
            'validation_opi_date' => $validation_opi->getValidation_opi_date(),
            'publier' => $validation_opi->getPublier()
        );
        $this->getDbTable()->update($data, array('validation_opi_id = ?' => $validation_opi->getValidation_opi_id()));
    }

    public function delete($validation_opi_id) {
        $this->getDbTable()->delete(array('validation_opi_id = ?' => $validation_opi_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("validation_opi_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationOpi();
            $entry->setValidation_opi_id($row->validation_opi_id)
	                ->setValidation_opi_banque_user($row->validation_opi_banque_user)
	                ->setValidation_opi_traite($row->validation_opi_traite)
					->setValidation_opi_date($row->validation_opi_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("validation_opi_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("validation_opi_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationOpi();
            $entry->setValidation_opi_id($row->validation_opi_id)
	                ->setValidation_opi_banque_user($row->validation_opi_banque_user)
	                ->setValidation_opi_traite($row->validation_opi_traite)
					->setValidation_opi_date($row->validation_opi_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


	
	public function fectchByTraite($traite_id) {
	    $select = $this->getDbTable()->select();
		$select->where("validation_opi_traite = ? ", $traite_id);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationOpi();
            $entry->setValidation_opi_id($row->validation_opi_id)
	                ->setValidation_opi_banque_user($row->validation_opi_banque_user)
	                ->setValidation_opi_traite($row->validation_opi_traite)
					->setValidation_opi_date($row->validation_opi_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function fectchByTraiteBanqueUser($traite_id, $id_banque_user) {
	    $select = $this->getDbTable()->select();
		$select->where("validation_opi_traite = ? ", $traite_id);
		$select->where("validation_opi_banque_user = ? ", $id_banque_user);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
		if (count($resultSet) == 0) {
           return NULL;
        }
		$row = $resultSet->current();
            $entry = new Application_Model_EuValidationOpi();
            $entry->setValidation_opi_id($row->validation_opi_id)
	                ->setValidation_opi_banque_user($row->validation_opi_banque_user)
	                ->setValidation_opi_traite($row->validation_opi_traite)
					->setValidation_opi_date($row->validation_opi_date)
                	->setPublier($row->publier);
			
			return $entry;
	}

	
}


?>
