<?php
 
class Application_Model_EuProjetMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProjet');
        }
        return $this->_dbTable;
    }

    public function find($projet_id, Application_Model_EuProjet $projet) {
        $result = $this->getDbTable()->find($projet_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $projet->setProjet_id($row->projet_id)
                ->setProjet_libelle($row->projet_libelle)
                ->setProjet_type($row->projet_type)
				->setProjet_code_membre($row->projet_code_membre)
                ->setProjet_description($row->projet_description)
                ->setProjet_centrale($row->projet_centrale)
                ->setProjet_date($row->projet_date)
                ->setProjet_stockage($row->projet_stockage)
                ->setProjet_montant($row->projet_montant)
                ->setProjet_montant_final($row->projet_montant_final)
                ->setProjet_observation($row->projet_observation)
                ->setProjet_utilisateur($row->projet_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
	                ->setProjet_libelle($row->projet_libelle)
                    ->setProjet_type($row->projet_type)
					->setProjet_code_membre($row->projet_code_membre)
                    ->setProjet_description($row->projet_description)
	                ->setProjet_centrale($row->projet_centrale)
					->setProjet_date($row->projet_date)
                ->setProjet_stockage($row->projet_stockage)
                ->setProjet_montant($row->projet_montant)
                ->setProjet_montant_final($row->projet_montant_final)
                ->setProjet_observation($row->projet_observation)
                ->setProjet_utilisateur($row->projet_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(projet_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuProjet $projet) {
        $data = array(
            'projet_id' => $projet->getProjet_id(),
            'projet_libelle' => $projet->getProjet_libelle(),
            'projet_type' => $projet->getProjet_type(),
            'projet_description' => $projet->getProjet_description(),
	        'projet_code_membre' => $projet->getProjet_code_membre(),
            'projet_date' => $projet->getProjet_date(),
            'projet_centrale' => $projet->getProjet_centrale(),
            'projet_montant' => $projet->getProjet_montant(),
            'projet_stockage' => $projet->getProjet_stockage(),
            'projet_montant_final' => $projet->getProjet_montant_final(),
            'projet_observation' => $projet->getProjet_observation(),
            'projet_utilisateur' => $projet->getProjet_utilisateur(),
            'code_zone' => $projet->getCode_zone(),
            'id_pays' => $projet->getId_pays(),
            'id_region' => $projet->getId_region(),
            'id_prefecture' => $projet->getId_prefecture(),
            'id_canton' => $projet->getId_canton(),
            'publier' => $projet->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProjet $projet) {
        $data = array(
            'projet_id' => $projet->getProjet_id(),
            'projet_libelle' => $projet->getProjet_libelle(),
            'projet_type' => $projet->getProjet_type(),
            'projet_description' => $projet->getProjet_description(),
			'projet_code_membre' => $projet->getProjet_code_membre(),
            'projet_date' => $projet->getProjet_date(),
            'projet_centrale' => $projet->getProjet_centrale(),
            'projet_montant' => $projet->getProjet_montant(),
            'projet_stockage' => $projet->getProjet_stockage(),
            'projet_montant_final' => $projet->getProjet_montant_final(),
            'projet_observation' => $projet->getProjet_observation(),
            'projet_utilisateur' => $projet->getProjet_utilisateur(),
            'code_zone' => $projet->getCode_zone(),
            'id_pays' => $projet->getId_pays(),
            'id_region' => $projet->getId_region(),
            'id_prefecture' => $projet->getId_prefecture(),
            'id_canton' => $projet->getId_canton(),
            'publier' => $projet->getPublier()
        );
        $this->getDbTable()->update($data, array('projet_id = ?' => $projet->getProjet_id()));
    }

    public function delete($projet_id) {
        $this->getDbTable()->delete(array('projet_id = ?' => $projet_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
	                ->setProjet_libelle($row->projet_libelle)
                    ->setProjet_type($row->projet_type)
					->setProjet_code_membre($row->projet_code_membre)
                    ->setProjet_description($row->projet_description)
	                ->setProjet_centrale($row->projet_centrale)
					->setProjet_date($row->projet_date)
                    ->setProjet_stockage($row->projet_stockage)
                ->setProjet_montant($row->projet_montant)
                ->setProjet_montant_final($row->projet_montant_final)
                ->setProjet_observation($row->projet_observation)
                ->setProjet_utilisateur($row->projet_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	
	public function fetchAllByMembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where("projet_code_membre LIKE '".$code_membre."'");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
	              ->setProjet_libelle($row->projet_libelle)
                  ->setProjet_type($row->projet_type)
			      ->setProjet_code_membre($row->projet_code_membre)
                  ->setProjet_description($row->projet_description)
	              ->setProjet_centrale($row->projet_centrale)
				  ->setProjet_date($row->projet_date)
                ->setProjet_stockage($row->projet_stockage)
                  ->setProjet_montant($row->projet_montant)
                  ->setProjet_montant_final($row->projet_montant_final)
                  ->setProjet_observation($row->projet_observation)
                  ->setProjet_utilisateur($row->projet_utilisateur)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
                  ->setId_prefecture($row->id_prefecture)
                  ->setId_canton($row->id_canton)
                  ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
	}

	
	
    
    public function fetchAllByCanton($id_canton) {
       $select = $this->getDbTable()->select();
       $select->where("id_canton = '".$id_canton."'");
       $select->where("publier >= 1");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
                  ->setProjet_libelle($row->projet_libelle)
                  ->setProjet_type($row->projet_type)
                  ->setProjet_code_membre($row->projet_code_membre)
                  ->setProjet_description($row->projet_description)
                  ->setProjet_centrale($row->projet_centrale)
                  ->setProjet_date($row->projet_date)
                    ->setProjet_stockage($row->projet_stockage)
                  ->setProjet_montant($row->projet_montant)
                  ->setProjet_montant_final($row->projet_montant_final)
                  ->setProjet_observation($row->projet_observation)
                  ->setProjet_utilisateur($row->projet_utilisateur)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
                  ->setId_prefecture($row->id_prefecture)
                  ->setId_canton($row->id_canton)
                  ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAllByProjetType($projet_type) {
        $select = $this->getDbTable()->select();
		$select->where("projet_type = ? ", $projet_type);
		$select->where("publier = ? ", 1);
		$select->order("projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
	                ->setProjet_libelle($row->projet_libelle)
                    ->setProjet_type($row->projet_type)
					->setProjet_code_membre($row->projet_code_membre)
                    ->setProjet_description($row->projet_description)
	                ->setProjet_centrale($row->projet_centrale)
					->setProjet_date($row->projet_date)
                    ->setProjet_stockage($row->projet_stockage)
                ->setProjet_montant($row->projet_montant)
                ->setProjet_montant_final($row->projet_montant_final)
                ->setProjet_observation($row->projet_observation)
                ->setProjet_utilisateur($row->projet_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("projet_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
	                ->setProjet_libelle($row->projet_libelle)
                    ->setProjet_type($row->projet_type)
					->setProjet_code_membre($row->projet_code_membre)
                    ->setProjet_description($row->projet_description)
	                ->setProjet_centrale($row->projet_centrale)
					->setProjet_date($row->projet_date)
                    ->setProjet_stockage($row->projet_stockage)
                ->setProjet_montant($row->projet_montant)
                ->setProjet_montant_final($row->projet_montant_final)
                ->setProjet_observation($row->projet_observation)
                ->setProjet_utilisateur($row->projet_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	
	

    public function fetchAllByUtilisateur($projet_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("projet_utilisateur = ? ", $projet_utilisateur);
		$select->order(array("projet_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProjet();
            $entry->setProjet_id($row->projet_id)
	                ->setProjet_libelle($row->projet_libelle)
                    ->setProjet_type($row->projet_type)
                    ->setProjet_description($row->projet_description)
					->setProjet_code_membre($row->projet_code_membre)
	                ->setProjet_centrale($row->projet_centrale)
					->setProjet_date($row->projet_date)
                    ->setProjet_stockage($row->projet_stockage)
                ->setProjet_montant($row->projet_montant)
                ->setProjet_montant_final($row->projet_montant_final)
                ->setProjet_observation($row->projet_observation)
                ->setProjet_utilisateur($row->projet_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


	
    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MONTH(projet_date) as MOIS, YEAR(projet_date) as ANNEE'));
		$select->distinct();
		$select->where("publier = ? ", 1);
		$select->order(array("projet_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['MOIS'] = $row['MOIS'];
		$entry['ANNEE'] = $row['ANNEE'];
            $entries[] = $entry;
        }
        return $entries;
    }










}


?>
