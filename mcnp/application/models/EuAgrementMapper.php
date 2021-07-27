<?php

class Application_Model_EuAgrementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAgrement');
        }
        return $this->_dbTable;
    }

    public function find($id_agrement, Application_Model_EuAgrement $agrement) {
        $result = $this->getDbTable()->find($id_agrement);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $agrement->setId_agrement($row->id_agrement)
                 ->setId_type_agrement($row->id_type_agrement)
                 ->setNum_agrement($row->num_agrement)
                 ->setLibelle_agrement($row->libelle_agrement)
                 ->setDesc_agrement($row->desc_agrement)
                 ->setDate_agrement($row->date_agrement)
                 ->setCode_membre_morale($row->code_membre_morale)
                 ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
                 ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                 ->setId_utilisateur($row->id_utilisateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                  ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_agrement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


	public function findagrementfiliere($num_agrement) {
	   $select = $this->getDbTable()->select();
	   $select->where('num_agrement LIKE ?', $num_agrement)
            ->where('code_membre_morale IS NULL')
			  ->where('id_type_agrement = ?',1);
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) > 0) {
		    $row = $results->current();
            $agrement = new Application_Model_EuAgrement();
            $agrement->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                     ->setNum_agrement($row->num_agrement)
					 ->setLibelle_agrement($row->libelle_agrement)
                     ->setDesc_agrement($row->desc_agrement)
                     ->setDate_agrement($row->date_agrement)
                	 ->setCode_membre_morale($row->code_membre_morale)
					 ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	                 ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                     ->setId_utilisateur($row->id_utilisateur);
            return $agrement; 
		   } 
		   else {
               return false;
           }
	}
	
	
	public function findagrementfilierebymembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where('code_membre_morale LIKE ?', $code_membre)
			  ->where('id_type_agrement = ?',1);
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) > 0) {
		    $row = $results->current();
            $agrement = new Application_Model_EuAgrement();
            $agrement->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                     ->setNum_agrement($row->num_agrement)
					 ->setLibelle_agrement($row->libelle_agrement)
                     ->setDesc_agrement($row->desc_agrement)
                     ->setDate_agrement($row->date_agrement)
                	 ->setCode_membre_morale($row->code_membre_morale)
					 ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	                 ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                     ->setId_utilisateur($row->id_utilisateur);
            return $agrement; 
		   } 
		   else {
               return false;
           }
	}
	
	
	
	
	
	public function findagrementacnev($num_agrement) {
	   $select = $this->getDbTable()->select();
	   $select->where('num_agrement LIKE ?', $num_agrement)
            ->where('code_membre_morale IS NULL')
			  ->where('id_type_agrement = ?',2);
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) > 0) {
		    $row = $results->current();
            $agrement = new Application_Model_EuAgrement();
            $agrement->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                     ->setNum_agrement($row->num_agrement)
					 ->setLibelle_agrement($row->libelle_agrement)
                     ->setDesc_agrement($row->desc_agrement)
                     ->setDate_agrement($row->date_agrement)
                	 ->setCode_membre_morale($row->code_membre_morale)
					 ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	                 ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                     ->setId_utilisateur($row->id_utilisateur);
               return $agrement; 
		   } 
		   else {
               return false;
           }
	}
	
	public function findagrementacnevbymembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where('code_membre_morale LIKE ?', $code_membre)
			  ->where('id_type_agrement = ?',2);
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) > 0) {
		    $row = $results->current();
            $agrement = new Application_Model_EuAgrement();
            $agrement->setId_agrement($row->id_agrement)
	                 ->setId_type_agrement($row->id_type_agrement)
                     ->setNum_agrement($row->num_agrement)
					 ->setLibelle_agrement($row->libelle_agrement)
                     ->setDesc_agrement($row->desc_agrement)
                     ->setDate_agrement($row->date_agrement)
                	 ->setCode_membre_morale($row->code_membre_morale)
					 ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	                 ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                     ->setId_utilisateur($row->id_utilisateur);
               return $agrement; 
		   } 
		   else {
               return false;
           }
	}
	
	
	
	
	
	
	public function findagrementtechno($num_agrement) {
	   $select = $this->getDbTable()->select();
	   $select->where('num_agrement LIKE ?', $num_agrement)
            ->where('code_membre_morale IS NULL')
			  ->where('id_type_agrement = ?',3);
       $results = $this->getDbTable()->fetchAll($select);
	   if (count($results) > 0) {
		  $row = $results->current();
          $agrement = new Application_Model_EuAgrement();
          $agrement->setId_agrement($row->id_agrement)
	               ->setId_type_agrement($row->id_type_agrement)
                   ->setNum_agrement($row->num_agrement)
				   ->setLibelle_agrement($row->libelle_agrement)
                   ->setDesc_agrement($row->desc_agrement)
                   ->setDate_agrement($row->date_agrement)
                   ->setCode_membre_morale($row->code_membre_morale)
				   ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	               ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                   ->setId_utilisateur($row->id_utilisateur);
            return $agrement; 
		} 
		else {
            return false;
        }
	}
	
	
	public function findagrementtechnobymembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where('code_membre_morale LIKE ?', $code_membre)
			  ->where('id_type_agrement = ?',3);
       $results = $this->getDbTable()->fetchAll($select);
	   if (count($results) > 0) {
		  $row = $results->current();
          $agrement = new Application_Model_EuAgrement();
          $agrement->setId_agrement($row->id_agrement)
	               ->setId_type_agrement($row->id_type_agrement)
                   ->setNum_agrement($row->num_agrement)
				   ->setLibelle_agrement($row->libelle_agrement)
                   ->setDesc_agrement($row->desc_agrement)
                   ->setDate_agrement($row->date_agrement)
                   ->setCode_membre_morale($row->code_membre_morale)
				   ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	               ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                   ->setId_utilisateur($row->id_utilisateur);
            return $agrement; 
		} 
		else {
            return false;
        }
	}
	
	
	
	
	
	
	
	
    public function save(Application_Model_EuAgrement $agrement) {
        $data = array(
            'id_agrement' => $agrement->getId_agrement(),
            'id_type_agrement' => $agrement->getId_type_agrement(),
            'num_agrement' => $agrement->getNum_agrement(),
            'libelle_agrement' => $agrement->getLibelle_agrement(),
            'desc_agrement' => $agrement->getDesc_agrement(),
            'date_agrement' => $agrement->getDate_agrement(),
            'code_membre_morale' => $agrement->getCode_membre_morale(),
            'code_membre_morale_agrement' => $agrement->getCode_membre_morale_agrement(),
            'id_type_acteur' => $agrement->getId_type_acteur(),
            'cel_agrement' => $agrement->getCel_agrement(),
            'id_type_creneau' => $agrement->getId_type_creneau(),
            'id_filiere' => $agrement->getId_filiere(),
            'id_utilisateur' => $agrement->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAgrement $agrement) {
        $data = array(
            'id_agrement' => $agrement->getId_agrement(),
            'id_type_agrement' => $agrement->getId_type_agrement(),
            'num_agrement' => $agrement->getNum_agrement(),
            'libelle_agrement' => $agrement->getLibelle_agrement(),
            'desc_agrement' => $agrement->getDesc_agrement(),
            'date_agrement' => $agrement->getDate_agrement(),
            'code_membre_morale' => $agrement->getCode_membre_morale(),
            'code_membre_morale_agrement' => $agrement->getCode_membre_morale_agrement(),
            'id_type_acteur' => $agrement->getId_type_acteur(),
            'cel_agrement' => $agrement->getCel_agrement(),
            'id_type_creneau' => $agrement->getId_type_creneau(),
            'id_filiere' => $agrement->getId_filiere(),
            'id_utilisateur' => $agrement->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_agrement = ?' => $agrement->getId_agrement()));
    }

    public function delete($id_agrement) {
        $this->getDbTable()->delete(array('id_agrement = ?' => $id_agrement));
    }


    public function fetchAll2($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->where("code_membre_morale IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll2CodeDivision($code_division = "", $id_utilisateur = 0) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_acteur WHERE code_division = ? )", $code_division);
		$select->where("code_membre_morale IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
                  ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_agrement) as count'));
		$select->where("num_agrement LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_agrement) as count'));
		//$select->where("num_agrement = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }
	
    public function fetchAll4() {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll4CodeDivision($code_division) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_acteur WHERE code_division = ? )", $code_division);
		$select->where("code_membre_morale IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll6() {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale IS NOT NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll6CodeDivision($code_division) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale IS NOT NULL");
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_acteur WHERE code_division = ? )", $code_division);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll5($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->where("code_membre_morale IS NOT NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll5CodeDivision($code_division, $id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_acteur WHERE code_division = ? )", $code_division);
		$select->where("code_membre_morale IS NOT NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    
	
	
	
	
	
    public function fetchAll2IdFiliere($id_filiere = "", $id_utilisateur = 0) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_tete_division WHERE id_filiere = ? )", $id_filiere);
		$select->where("code_membre_morale IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll4IdFiliere($id_filiere) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_tete_division WHERE id_filiere = ? )", $id_filiere);
		$select->where("code_membre_morale IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll5IdFiliere($id_filiere, $id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_tete_division WHERE id_filiere = ? )", $id_filiere);
		$select->where("code_membre_morale IS NOT NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll6IdFiliere($id_filiere) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale IS NOT NULL");
		$select->where("code_membre_morale_agrement IN (SELECT code_membre FROM eu_tete_division WHERE id_filiere = ? )", $id_filiere);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgrement();
            $entry->setId_agrement($row->id_agrement)
	              ->setId_type_agrement($row->id_type_agrement)
                  ->setNum_agrement($row->num_agrement)
				  ->setLibelle_agrement($row->libelle_agrement)
                  ->setDesc_agrement($row->desc_agrement)
                  ->setDate_agrement($row->date_agrement)
                  ->setCode_membre_morale($row->code_membre_morale)
				  ->setCode_membre_morale_agrement($row->code_membre_morale_agrement)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCel_agrement($row->cel_agrement)
	              ->setId_type_creneau($row->id_type_creneau)
                 ->setId_filiere($row->id_filiere)
	              ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}

?>
