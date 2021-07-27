<?php
 
class Application_Model_EuTravailleurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTravailleur');
        }
        return $this->_dbTable;
    }

    public function find($travailleur_id, Application_Model_EuTravailleur $travailleur) {
        $result = $this->getDbTable()->find($travailleur_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $travailleur->setTravailleur_id($row->travailleur_id)
                ->setTravailleur_libelle($row->travailleur_libelle)
                ->setTravailleur_type($row->travailleur_type)
				->setTravailleur_code_membre($row->travailleur_code_membre)
                ->setTravailleur_experience($row->travailleur_experience)
                ->setTravailleur_niveau($row->travailleur_niveau)
                ->setTravailleur_date($row->travailleur_date)
                ->setTravailleur_formation($row->travailleur_formation)
                ->setTravailleur_education($row->travailleur_education)
                ->setTravailleur_adresse($row->travailleur_adresse)
                ->setTravailleur_observation($row->travailleur_observation)
                ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                ->setPublier($row->publier)
                ->setId_postes($row->id_postes)
                ->setMontant_prestation($row->montant_prestation)
                ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("travailleur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
	                ->setTravailleur_libelle($row->travailleur_libelle)
                    ->setTravailleur_type($row->travailleur_type)
					->setTravailleur_code_membre($row->travailleur_code_membre)
                    ->setTravailleur_experience($row->travailleur_experience)
	                ->setTravailleur_niveau($row->travailleur_niveau)
					->setTravailleur_date($row->travailleur_date)
                ->setTravailleur_formation($row->travailleur_formation)
                ->setTravailleur_education($row->travailleur_education)
                ->setTravailleur_adresse($row->travailleur_adresse)
                ->setTravailleur_observation($row->travailleur_observation)
                ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier)
                    ->setId_postes($row->id_postes)
                    ->setMontant_prestation($row->montant_prestation)
                    ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                    ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                    ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(travailleur_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuTravailleur $travailleur) {
        $data = array(
            'travailleur_id' => $travailleur->getTravailleur_id(),
            'travailleur_libelle' => $travailleur->getTravailleur_libelle(),
            'travailleur_type' => $travailleur->getTravailleur_type(),
            'travailleur_experience' => $travailleur->getTravailleur_experience(),
	        'travailleur_code_membre' => $travailleur->getTravailleur_code_membre(),
            'travailleur_date' => $travailleur->getTravailleur_date(),
            'travailleur_niveau' => $travailleur->getTravailleur_niveau(),
            'travailleur_education' => $travailleur->getTravailleur_education(),
            'travailleur_formation' => $travailleur->getTravailleur_formation(),
            'travailleur_adresse' => $travailleur->getTravailleur_adresse(),
            'travailleur_observation' => $travailleur->getTravailleur_observation(),
            'travailleur_utilisateur' => $travailleur->getTravailleur_utilisateur(),
            'code_zone' => $travailleur->getCode_zone(),
            'id_pays' => $travailleur->getId_pays(),
            'id_region' => $travailleur->getId_region(),
            'id_prefecture' => $travailleur->getId_prefecture(),
            'id_canton' => $travailleur->getId_canton(),
            'publier' => $travailleur->getPublier(),
            'id_postes' => $travailleur->getId_postes(),
            'montant_prestation' => $travailleur->getMontant_prestation(),
            'travailleur_numero_cin' => $travailleur->getTravailleur_numero_cin(),
            'travailleur_date_delivrance_cin' => $travailleur->getTravailleur_date_delivrance_cin(),
            'travailleur_date_expiration_cin' => $travailleur->getTravailleur_date_expiration_cin()
            
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTravailleur $travailleur) {
        $data = array(
            'travailleur_id' => $travailleur->getTravailleur_id(),
            'travailleur_libelle' => $travailleur->getTravailleur_libelle(),
            'travailleur_type' => $travailleur->getTravailleur_type(),
            'travailleur_experience' => $travailleur->getTravailleur_experience(),
			'travailleur_code_membre' => $travailleur->getTravailleur_code_membre(),
            'travailleur_date' => $travailleur->getTravailleur_date(),
            'travailleur_niveau' => $travailleur->getTravailleur_niveau(),
            'travailleur_education' => $travailleur->getTravailleur_education(),
            'travailleur_formation' => $travailleur->getTravailleur_formation(),
            'travailleur_adresse' => $travailleur->getTravailleur_adresse(),
            'travailleur_observation' => $travailleur->getTravailleur_observation(),
            'travailleur_utilisateur' => $travailleur->getTravailleur_utilisateur(),
            'code_zone' => $travailleur->getCode_zone(),
            'id_pays' => $travailleur->getId_pays(),
            'id_region' => $travailleur->getId_region(),
            'id_prefecture' => $travailleur->getId_prefecture(),
            'id_canton' => $travailleur->getId_canton(),
            'publier' => $travailleur->getPublier(),
            'id_postes' => $travailleur->getId_postes(),
            'montant_prestation' => $travailleur->getMontant_prestation(),
            'travailleur_numero_cin' => $travailleur->getTravailleur_numero_cin(),
            'travailleur_date_delivrance_cin' => $travailleur->getTravailleur_date_delivrance_cin(),
            'travailleur_date_expiration_cin' => $travailleur->getTravailleur_date_expiration_cin()
        );
        $this->getDbTable()->update($data, array('travailleur_id = ?' => $travailleur->getTravailleur_id()));
    }

    public function delete($travailleur_id) {
        $this->getDbTable()->delete(array('travailleur_id = ?' => $travailleur_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("travailleur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
	                ->setTravailleur_libelle($row->travailleur_libelle)
                    ->setTravailleur_type($row->travailleur_type)
					->setTravailleur_code_membre($row->travailleur_code_membre)
                    ->setTravailleur_experience($row->travailleur_experience)
	                ->setTravailleur_niveau($row->travailleur_niveau)
					->setTravailleur_date($row->travailleur_date)
                    ->setTravailleur_formation($row->travailleur_formation)
                ->setTravailleur_education($row->travailleur_education)
                ->setTravailleur_adresse($row->travailleur_adresse)
                ->setTravailleur_observation($row->travailleur_observation)
                ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier)
                    ->setId_postes($row->id_postes)
                    ->setMontant_prestation($row->montant_prestation)
                    ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                    ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                    ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	
	public function fetchAllByMembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where("travailleur_code_membre LIKE '".$code_membre."'");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
	              ->setTravailleur_libelle($row->travailleur_libelle)
                  ->setTravailleur_type($row->travailleur_type)
			      ->setTravailleur_code_membre($row->travailleur_code_membre)
                  ->setTravailleur_experience($row->travailleur_experience)
	              ->setTravailleur_niveau($row->travailleur_niveau)
				  ->setTravailleur_date($row->travailleur_date)
                ->setTravailleur_formation($row->travailleur_formation)
                  ->setTravailleur_education($row->travailleur_education)
                  ->setTravailleur_adresse($row->travailleur_adresse)
                  ->setTravailleur_observation($row->travailleur_observation)
                  ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
                  ->setId_prefecture($row->id_prefecture)
                  ->setId_canton($row->id_canton)
                  ->setPublier($row->publier)
                  ->setId_postes($row->id_postes)
                  ->setMontant_prestation($row->montant_prestation)
                  ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                  ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                  ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                  ;
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
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
                  ->setTravailleur_libelle($row->travailleur_libelle)
                  ->setTravailleur_type($row->travailleur_type)
                  ->setTravailleur_code_membre($row->travailleur_code_membre)
                  ->setTravailleur_experience($row->travailleur_experience)
                  ->setTravailleur_niveau($row->travailleur_niveau)
                  ->setTravailleur_date($row->travailleur_date)
                    ->setTravailleur_formation($row->travailleur_formation)
                  ->setTravailleur_education($row->travailleur_education)
                  ->setTravailleur_adresse($row->travailleur_adresse)
                  ->setTravailleur_observation($row->travailleur_observation)
                  ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
                  ->setId_prefecture($row->id_prefecture)
                  ->setId_canton($row->id_canton)
                  ->setPublier($row->publier)
                  ->setId_postes($row->id_postes)
                  ->setMontant_prestation($row->montant_prestation)
                  ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                  ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                  ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAllByTravailleurType($travailleur_type) {
        $select = $this->getDbTable()->select();
		$select->where("travailleur_type = ? ", $travailleur_type);
		$select->where("publier = ? ", 1);
		$select->order("travailleur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
	                ->setTravailleur_libelle($row->travailleur_libelle)
                    ->setTravailleur_type($row->travailleur_type)
					->setTravailleur_code_membre($row->travailleur_code_membre)
                    ->setTravailleur_experience($row->travailleur_experience)
	                ->setTravailleur_niveau($row->travailleur_niveau)
					->setTravailleur_date($row->travailleur_date)
                    ->setTravailleur_formation($row->travailleur_formation)
                ->setTravailleur_education($row->travailleur_education)
                ->setTravailleur_adresse($row->travailleur_adresse)
                ->setTravailleur_observation($row->travailleur_observation)
                ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier)
                    ->setId_postes($row->id_postes)
                    ->setMontant_prestation($row->montant_prestation)
                    ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                    ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                    ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("travailleur_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("travailleur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
	                ->setTravailleur_libelle($row->travailleur_libelle)
                    ->setTravailleur_type($row->travailleur_type)
					->setTravailleur_code_membre($row->travailleur_code_membre)
                    ->setTravailleur_experience($row->travailleur_experience)
	                ->setTravailleur_niveau($row->travailleur_niveau)
					->setTravailleur_date($row->travailleur_date)
                    ->setTravailleur_formation($row->travailleur_formation)
                ->setTravailleur_education($row->travailleur_education)
                ->setTravailleur_adresse($row->travailleur_adresse)
                ->setTravailleur_observation($row->travailleur_observation)
                ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier)
                    ->setId_postes($row->id_postes)
                    ->setMontant_prestation($row->montant_prestation)
                    ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                    ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                    ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	
	

    public function fetchAllByUtilisateur($travailleur_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("travailleur_utilisateur = ? ", $travailleur_utilisateur);
		$select->order(array("travailleur_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTravailleur();
            $entry->setTravailleur_id($row->travailleur_id)
	                ->setTravailleur_libelle($row->travailleur_libelle)
                    ->setTravailleur_type($row->travailleur_type)
                    ->setTravailleur_experience($row->travailleur_experience)
					->setTravailleur_code_membre($row->travailleur_code_membre)
	                ->setTravailleur_niveau($row->travailleur_niveau)
					->setTravailleur_date($row->travailleur_date)
                    ->setTravailleur_formation($row->travailleur_formation)
                ->setTravailleur_education($row->travailleur_education)
                ->setTravailleur_adresse($row->travailleur_adresse)
                ->setTravailleur_observation($row->travailleur_observation)
                ->setTravailleur_utilisateur($row->travailleur_utilisateur)
                ->setCode_zone($row->code_zone)
                ->setId_pays($row->id_pays)
                ->setId_region($row->id_region)
                ->setId_prefecture($row->id_prefecture)
                ->setId_canton($row->id_canton)
                	->setPublier($row->publier)
                    ->setId_postes($row->id_postes)
                    ->setMontant_prestation($row->montant_prestation)
                    ->setTravailleur_numero_cin($row->travailleur_numero_cin)
                    ->setTravailleur_date_delivrance_cin($row->travailleur_date_delivrance_cin)
                    ->setTravailleur_date_expiration_cin($row->travailleur_date_expiration_cin)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }


	
    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MONTH(travailleur_date) as MOIS, YEAR(travailleur_date) as ANNEE'));
		$select->distinct();
		$select->where("publier = ? ", 1);
		$select->order(array("travailleur_date DESC"));
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
