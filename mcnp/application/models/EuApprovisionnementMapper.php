<?php
 
class Application_Model_EuApprovisionnementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuApprovisionnement');
        }
        return $this->_dbTable;
    }

    public function find($id_approvisionnement, Application_Model_EuApprovisionnement $approvisionnement) {
        $result = $this->getDbTable()->find($id_approvisionnement);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $approvisionnement->setId_approvisionnement($row->id_approvisionnement)
                          ->setCode_membre_apporteur($row->code_membre_apporteur)
                          ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                          ->setDate_approvisionnement($row->date_approvisionnement)
                          ->setType_approvisionnement($row->type_approvisionnement)
				          ->setMontant_approvisionnement($row->montant_approvisionnement)
						  ->setId_canton();
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuApprovisionnement();
            $entry->setId_approvisionnement($row->id_approvisionnement)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setDate_approvisionnement($row->date_approvisionnement)
                  ->setType_approvisionnement($row->type_approvisionnement)
				  ->setMontant_approvisionnement($row->montant_approvisionnement)
				  ->setId_canton();
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_approvisionnement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuApprovisionnement $approvisionnement) {
        $data = array(
          'id_approvisionnement' => $approvisionnement->getId_approvisionnement(),
          'code_membre_apporteur' => $approvisionnement->getCode_membre_apporteur(),
          'code_membre_beneficiaire' => $approvisionnement->getCode_membre_beneficiaire(),
		  'date_approvisionnement' => $approvisionnement->getDate_approvisionnement(),
          'type_approvisionnement' => $approvisionnement->getType_approvisionnement(),
          'montant_approvisionnement' => $approvisionnement->getMontant_approvisionnement(),
		  'id_canton' => $approvisionnement->getId_canton()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuApprovisionnement $approvisionnement) {
        $data = array(
          'id_approvisionnement' => $approvisionnement->getId_approvisionnement(),
          'code_membre_apporteur' => $approvisionnement->getCode_membre_apporteur(),
          'code_membre_beneficiaire' => $approvisionnement->getCode_membre_beneficiaire(),
		  'date_approvisionnement' => $approvisionnement->getDate_approvisionnement(),
          'type_approvisionnement' => $approvisionnement->getType_approvisionnement(),
          'montant_approvisionnement' => $approvisionnement->getMontant_approvisionnement(),
		  'id_canton' => $approvisionnement->getId_canton()
        );
        $this->getDbTable()->update($data, array('id_approvisionnement = ?' => $approvisionnement->getId_approvisionnement()));
    }
	
	
	public function fetchAllByBeneficiaire($beneficiaire) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_beneficiaire like ? ", $beneficiaire);
		$select->where("type_approvisionnement = ? ", "APPRO_BC");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuApprovisionnement();
            $entry->setId_approvisionnement($row->id_approvisionnement)
	              ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setDate_approvisionnement($row->date_approvisionnement)
                  ->setMontant_approvisionnement($row->montant_approvisionnement)
				  ->setId_canton($row->id_canton)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function fetchAllByBeneficiaireBL($beneficiaire) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_beneficiaire like ? ", $beneficiaire);
		$select->where("type_approvisionnement = ? ", "APPRO_BL");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuApprovisionnement();
            $entry->setId_approvisionnement($row->id_approvisionnement)
	              ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setDate_approvisionnement($row->date_approvisionnement)
                  ->setMontant_approvisionnement($row->montant_approvisionnement)
				  ->setId_canton($row->id_canton)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

	public function fetchAllByApporteurBL($apporteur) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_apporteur like ? ", $apporteur);
		$select->where("type_approvisionnement = ? ", "APPRO_BL");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuApprovisionnement();
           $entry->setId_approvisionnement($row->id_approvisionnement)
	             ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setDate_approvisionnement($row->date_approvisionnement)
                 ->setMontant_approvisionnement($row->montant_approvisionnement)
				 ->setId_canton($row->id_canton);
           $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	
	
	public function fetchAllByBeneficiaireBS($beneficiaire) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_beneficiaire like ? ", $beneficiaire);
		$select->where("type_approvisionnement = ? ", "APPRO_BS");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuApprovisionnement();
            $entry->setId_approvisionnement($row->id_approvisionnement)
	              ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setDate_approvisionnement($row->date_approvisionnement)
                  ->setMontant_approvisionnement($row->montant_approvisionnement)
				  ->setId_canton($row->id_canton)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

	public function fetchAllByApporteurBS($apporteur) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_apporteur like ? ", $apporteur);
		$select->where("type_approvisionnement = ? ", "APPRO_BS");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuApprovisionnement();
           $entry->setId_approvisionnement($row->id_approvisionnement)
	             ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setDate_approvisionnement($row->date_approvisionnement)
                 ->setMontant_approvisionnement($row->montant_approvisionnement)
				 ->setId_canton($row->id_canton);
           $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function fetchAllByBeneficiaireBAI($beneficiaire) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_beneficiaire like ? ", $beneficiaire);
		$select->where("type_approvisionnement = ? ", "APPRO_BAI");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuApprovisionnement();
            $entry->setId_approvisionnement($row->id_approvisionnement)
	              ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setDate_approvisionnement($row->date_approvisionnement)
                  ->setMontant_approvisionnement($row->montant_approvisionnement)
				  ->setId_canton($row->id_canton)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

	public function fetchAllByApporteurBAI($apporteur) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_apporteur like ? ", $apporteur);
		$select->where("type_approvisionnement = ? ", "APPRO_BAI");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuApprovisionnement();
           $entry->setId_approvisionnement($row->id_approvisionnement)
	             ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setDate_approvisionnement($row->date_approvisionnement)
                 ->setMontant_approvisionnement($row->montant_approvisionnement)
				 ->setId_canton($row->id_canton);
           $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	
    public function fetchAllByApporteur($apporteur) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_apporteur like ? ", $apporteur);
		$select->where("type_approvisionnement = ? ", "APPRO_BC");
		$select->order("id_approvisionnement DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuApprovisionnement();
           $entry->setId_approvisionnement($row->id_approvisionnement)
	             ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setDate_approvisionnement($row->date_approvisionnement)
                 ->setMontant_approvisionnement($row->montant_approvisionnement)
				 ->setId_canton($row->id_canton);
           $entries[] = $entry;
        }
        return $entries;
    }
	
	

    public function delete($id_approvisionnement) {
        $this->getDbTable()->delete(array('id_approvisionnement = ?' => $id_approvisionnement));
    }

}


?>
