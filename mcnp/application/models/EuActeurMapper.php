 <?php

class Application_Model_EuActeurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuActeur');
        }
        return $this->_dbTable;
    }

    public function find($id_acteur, Application_Model_EuActeur $acteur) {
        $table = new Application_Model_DbTable_EuActeur;
        $select = $table->select();
        $select->where('id_acteur = ?', $id_acteur);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $acteur->setCode_membre($row->code_membre)
               ->setCode_activite($row->code_activite)
               ->setType_acteur($row->type_acteur)
               ->setCode_acteur($row->code_acteur)
               ->setDate_creation($row->date_creation)
               ->setId_utilisateur($row->id_utilisateur)
               ->setId_acteur($row->id_acteur)
			   ->setCode_gac_chaine($row->code_gac_chaine)
			   ->setCode_source_create($row->code_source_create)
			   ->setCode_monde_create($row->code_monde_create)
			   ->setCode_zone_create($row->code_zone_create)
			   ->setId_pays($row->id_pays)
			   ->setId_region($row->id_region)
			   ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
			   ->setCode_secteur_create($row->code_secteur_create)
			   ->setCode_agence_create($row->code_agence_create)
			   ->setCode_division($row->code_division)		
		;
	}
	
	
	public function findByCodeActeur($code_acteur) {
	    $table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_acteur) && $code_acteur !="") {
           $select->where('code_acteur LIKE ?', $code_acteur);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
	
	}
	
	
	
    public function findByActeur($code_membre) {
		$table = new Application_Model_DbTable_EuActeur;
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
          $select->where('code_membre = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	public function findByBpf($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('type_acteur = ?', "PBF");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuActeur();
          $entry->setCode_membre($row->code_membre)
                ->setCode_activite($row->code_activite)
                ->setType_acteur($row->type_acteur)
                ->setCode_acteur($row->code_acteur)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_acteur($row->id_acteur)
				->setCode_gac_chaine($row->code_gac_chaine)
				->setCode_source_create($row->code_source_create)
				->setCode_monde_create($row->code_monde_create)
				->setCode_zone_create($row->code_zone_create)
				->setId_pays($row->id_pays)
				->setId_region($row->id_region)
				->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				->setCode_secteur_create($row->code_secteur_create)
				->setCode_agence_create($row->code_agence_create)
				->setCode_division($row->code_division)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findByAdministrateur($code_membre,$type_acteur) {
	   $table = new Application_Model_DbTable_EuActeur;
	   $select = $table->select();
	   if(isset($code_membre) && $code_membre!="") {
         $select->where('code_membre = ?', $code_membre);
		 $select->where('type_acteur = ?', $type_acteur);
	   }
       $resultSet = $table->fetchAll($select);
       if (0 == count($resultSet)) {
          return false;
       }
       $row = $resultSet->current();
       $entries = array();
       foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
	}
    

    public function save(Application_Model_EuActeur $acteur) {
        $data = array(
			'id_acteur' => $acteur->getId_acteur(),
            'id_utilisateur' => $acteur->getId_utilisateur(),
            'date_creation' => $acteur->getDate_creation(),
            'code_acteur' => $acteur->getCode_acteur(),
            'type_acteur' => $acteur->getType_acteur(),
            'code_activite' => $acteur->getCode_activite(),
            'code_membre' => $acteur->getCode_membre(),
		    'code_gac_chaine' => $acteur->getCode_gac_chaine(),
		    'code_source_create' => $acteur->getCode_source_create(),
		    'code_monde_create' => $acteur->getCode_monde_create(),
		    'code_zone_create' => $acteur->getCode_zone_create(),
		    'id_pays' => $acteur->getId_pays(),
		    'id_region' => $acteur->getId_region(),
			'id_prefecture' => $acteur->getId_prefecture(),
			'id_canton' => $acteur->getId_canton(),
		    'code_secteur_create' => $acteur->getCode_secteur_create(),
		    'code_agence_create' => $acteur->getCode_agence_create(),
		    'code_division' => $acteur->getCode_division()
        );

        $this->getDbTable()->insert($data);
    }
    
	
	
    public function update(Application_Model_EuActeur $acteur) {
        $data = array(
          'id_acteur' => $acteur->getId_acteur(),
          'id_utilisateur' => $acteur->getId_utilisateur(),
          'date_creation' => $acteur->getDate_creation(),
          'code_acteur' => $acteur->getCode_acteur(),
          'type_acteur' => $acteur->getType_acteur(),
          'code_activite' => $acteur->getCode_activite(),
          'code_membre' => $acteur->getCode_membre(),
		  'code_gac_chaine' => $acteur->getCode_gac_chaine(),
		  'code_source_create' => $acteur->getCode_source_create(),
		  'code_monde_create' => $acteur->getCode_monde_create(),
		  'code_zone_create' => $acteur->getCode_zone_create(),
		  'id_pays' => $acteur->getId_pays(),
		  'id_region' => $acteur->getId_region(),
		  'id_prefecture' => $acteur->getId_prefecture(),
			'id_canton' => $acteur->getId_canton(),
		  'code_secteur_create' => $acteur->getCode_secteur_create(),
		  'code_agence_create' => $acteur->getCode_agence_create(),
		  'code_division' => $acteur->getCode_division()
        );
        $this->getDbTable()->update($data, array('id_acteur = ?' => $acteur->getId_acteur()));
    }

    public function delete($id_acteur) {
        $this->getDbTable()->delete(array('id_acteur = ?' => $id_acteur));
    }




///////////////////////////////////////////////////////////////







}

?>
