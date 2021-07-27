<?php
 
class Application_Model_EuValidationQuittanceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuValidationQuittance');
        }
        return $this->_dbTable;
    }

    public function find($validation_quittance_id, Application_Model_EuValidationQuittance $validation_quittance) {
        $result = $this->getDbTable()->find($validation_quittance_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $validation_quittance->setValidation_quittance_id($row->validation_quittance_id)
                ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
                ->setValidation_quittance_souscription($row->validation_quittance_souscription)
                ->setValidation_quittance_date($row->validation_quittance_date)
                ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				->setValidation_bc($row->validation_bc)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("validation_quittance_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationQuittance();
            $entry->setValidation_quittance_id($row->validation_quittance_id)
	              ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
	              ->setValidation_quittance_souscription($row->validation_quittance_souscription)
				  ->setValidation_quittance_date($row->validation_quittance_date)
                  ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                  ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                  ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                  ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				  ->setValidation_bc($row->validation_bc)
                  ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(validation_quittance_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuValidationQuittance $validation_quittance) {
        $data = array(
            'validation_quittance_id' => $validation_quittance->getValidation_quittance_id(),
            'validation_quittance_utilisateur' => $validation_quittance->getValidation_quittance_utilisateur(),
            'validation_quittance_souscription' => $validation_quittance->getValidation_quittance_souscription(),
            'validation_quittance_date' => $validation_quittance->getValidation_quittance_date(),
            'validation_quittance_acheteur' => $validation_quittance->getValidation_quittance_acheteur(),
            'validation_quittance_livraison' => $validation_quittance->getValidation_quittance_livraison(),
            'validation_quittance_preinscription' => $validation_quittance->getValidation_quittance_preinscription(),
            'validation_quittance_preinscription_morale' => $validation_quittance->getValidation_quittance_preinscription_morale(),
			'validation_bc' => $validation_quittance->getValidation_bc(),
            'publier' => $validation_quittance->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuValidationQuittance $validation_quittance) {
        $data = array(
            'validation_quittance_id' => $validation_quittance->getValidation_quittance_id(),
            'validation_quittance_utilisateur' => $validation_quittance->getValidation_quittance_utilisateur(),
            'validation_quittance_souscription' => $validation_quittance->getValidation_quittance_souscription(),
            'validation_quittance_date' => $validation_quittance->getValidation_quittance_date(),
            'validation_quittance_acheteur' => $validation_quittance->getValidation_quittance_acheteur(),
            'validation_quittance_livraison' => $validation_quittance->getValidation_quittance_livraison(),
            'validation_quittance_preinscription' => $validation_quittance->getValidation_quittance_preinscription(),
            'validation_quittance_preinscription_morale' => $validation_quittance->getValidation_quittance_preinscription_morale(),
			'validation_bc' => $validation_quittance->getValidation_bc(),
            'publier' => $validation_quittance->getPublier()
        );
        $this->getDbTable()->update($data, array('validation_quittance_id = ?' => $validation_quittance->getValidation_quittance_id()));
    }

    public function delete($validation_quittance_id) {
        $this->getDbTable()->delete(array('validation_quittance_id = ?' => $validation_quittance_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("validation_quittance_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationQuittance();
            $entry->setValidation_quittance_id($row->validation_quittance_id)
	                ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
	                ->setValidation_quittance_souscription($row->validation_quittance_souscription)
					->setValidation_quittance_date($row->validation_quittance_date)
                ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				->setValidation_bc($row->validation_bc)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("validation_quittance_type = ? ", $type);
		$select->where("publier = ? ", 1);
		$select->order("validation_quittance_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationQuittance();
            $entry->setValidation_quittance_id($row->validation_quittance_id)
	                ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
	                ->setValidation_quittance_souscription($row->validation_quittance_souscription)
					->setValidation_quittance_date($row->validation_quittance_date)
                ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				->setValidation_bc($row->validation_bc)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("validation_quittance_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("validation_quittance_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationQuittance();
            $entry->setValidation_quittance_id($row->validation_quittance_id)
	                ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
	                ->setValidation_quittance_souscription($row->validation_quittance_souscription)
					->setValidation_quittance_date($row->validation_quittance_date)
                ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				->setValidation_bc($row->validation_bc)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


	
	public function fectchBySouscription($souscription_id) {
	    $select = $this->getDbTable()->select();
		$select->where("validation_quittance_souscription = ? ", $souscription_id);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuValidationQuittance();
            $entry->setValidation_quittance_id($row->validation_quittance_id)
	                ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
	                ->setValidation_quittance_souscription($row->validation_quittance_souscription)
					->setValidation_quittance_date($row->validation_quittance_date)
                ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				->setValidation_bc($row->validation_bc)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function fectchBySouscriptionUtilisateur($souscription_id, $id_utilisateur) {
	    $select = $this->getDbTable()->select();
		$select->where("validation_quittance_souscription = ? ", $souscription_id);
		$select->where("validation_quittance_utilisateur = ? ", $id_utilisateur);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
		if (count($resultSet) == 0) {
           return NULL;
        }
		$row = $resultSet->current();
            $entry = new Application_Model_EuValidationQuittance();
            $entry->setValidation_quittance_id($row->validation_quittance_id)
	                ->setValidation_quittance_utilisateur($row->validation_quittance_utilisateur)
	                ->setValidation_quittance_souscription($row->validation_quittance_souscription)
					->setValidation_quittance_date($row->validation_quittance_date)
                ->setValidation_quittance_acheteur($row->validation_quittance_acheteur)
                ->setValidation_quittance_livraison($row->validation_quittance_livraison)
                ->setValidation_quittance_preinscription($row->validation_quittance_preinscription)
                ->setValidation_quittance_preinscription_morale($row->validation_quittance_preinscription_morale)
				->setValidation_bc($row->validation_bc)
                	->setPublier($row->publier);
			
			return $entry;
	}

	
}


?>
