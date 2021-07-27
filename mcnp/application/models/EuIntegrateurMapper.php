<?php
 
class Application_Model_EuIntegrateurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuIntegrateur');
        }
        return $this->_dbTable;
    }

    public function find($integrateur_id, Application_Model_EuIntegrateur $integrateur) {
        $result = $this->getDbTable()->find($integrateur_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $integrateur->setIntegrateur_id($row->integrateur_id)
                    ->setIntegrateur_souscription($row->integrateur_souscription)
                    ->setIntegrateur_critere2($row->integrateur_critere2)
                    ->setIntegrateur_critere1($row->integrateur_critere1)
                    ->setIntegrateur_critere3($row->integrateur_critere3)
                    ->setIntegrateur_type($row->integrateur_type)
                    ->setIntegrateur_date($row->integrateur_date)
                    ->setIntegrateur_poste($row->integrateur_poste)
                    ->setIntegrateur_document($row->integrateur_document)
                    ->setIntegrateur_diplome($row->integrateur_diplome)
                    ->setIntegrateur_membreasso($row->integrateur_membreasso)
                    ->setIntegrateur_education($row->integrateur_education)
                    ->setIntegrateur_affiliation($row->integrateur_affiliation)
                    ->setIntegrateur_formation($row->integrateur_formation)
                    ->setIntegrateur_langue($row->integrateur_langue)
                    ->setIntegrateur_experience($row->integrateur_experience)
                    ->setIntegrateur_attestation($row->integrateur_attestation)
                    ->setPublier($row->publier)
				    ->setCode_membre($row->code_membre)
					->setIntegrateurAdresse($row->integrateur_adresse)
					->setIntegrateurCanton($row->integrateur_canton)
					->setIntegrateurVille($row->integrateur_ville)
					;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("integrateur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
			      ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
				  ->setCode_membre($row->code_membre)
				  ->setIntegrateurAdresse($row->integrateur_adresse)
                  ->setPublier($row->publier)
				  ->setIntegrateurVille($row->integrateur_ville)
				  ->setIntegrateurCanton($row->integrateur_canton);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(integrateur_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuIntegrateur $integrateur) {
        $data = array(
            'integrateur_id' => $integrateur->getIntegrateur_id(),
            'integrateur_souscription' => $integrateur->getIntegrateur_souscription(),
            'integrateur_critere2' => $integrateur->getIntegrateur_critere2(),
            'integrateur_critere1' => $integrateur->getIntegrateur_critere1(),
            'integrateur_critere3' => $integrateur->getIntegrateur_critere3(),
            'integrateur_type' => $integrateur->getIntegrateur_type(),
            'integrateur_date' => $integrateur->getIntegrateur_date(),
            'integrateur_poste' => $integrateur->getIntegrateur_poste(),
            'integrateur_document' => $integrateur->getIntegrateur_document(),
            'integrateur_diplome' => $integrateur->getIntegrateur_diplome(),
            'integrateur_membreasso' => $integrateur->getIntegrateur_membreasso(),
            'integrateur_education' => $integrateur->getIntegrateur_education(),
            'integrateur_affiliation' => $integrateur->getIntegrateur_affiliation(),
            'integrateur_formation' => $integrateur->getIntegrateur_formation(),
            'integrateur_langue' => $integrateur->getIntegrateur_langue(),
            'integrateur_experience' => $integrateur->getIntegrateur_experience(),
            'integrateur_attestation' => $integrateur->getIntegrateur_attestation(),
			'integrateur_adresse' => $integrateur->getIntegrateurAdresse(),
			'integrateur_canton' => $integrateur->getIntegrateurCanton(),
			'integrateur_ville' => $integrateur->getIntegrateurVille(),
			'code_membre' => $integrateur->getCode_membre(),
            'publier' => $integrateur->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuIntegrateur $integrateur) {
        $data = array(
            'integrateur_id' => $integrateur->getIntegrateur_id(),
            'integrateur_souscription' => $integrateur->getIntegrateur_souscription(),
            'integrateur_critere2' => $integrateur->getIntegrateur_critere2(),
            'integrateur_critere1' => $integrateur->getIntegrateur_critere1(),
            'integrateur_critere3' => $integrateur->getIntegrateur_critere3(),
            'integrateur_type' => $integrateur->getIntegrateur_type(),
            'integrateur_date' => $integrateur->getIntegrateur_date(),
            'integrateur_poste' => $integrateur->getIntegrateur_poste(),
            'integrateur_document' => $integrateur->getIntegrateur_document(),
            'integrateur_diplome' => $integrateur->getIntegrateur_diplome(),
            'integrateur_membreasso' => $integrateur->getIntegrateur_membreasso(),
            'integrateur_education' => $integrateur->getIntegrateur_education(),
            'integrateur_affiliation' => $integrateur->getIntegrateur_affiliation(),
            'integrateur_formation' => $integrateur->getIntegrateur_formation(),
            'integrateur_langue' => $integrateur->getIntegrateur_langue(),
            'integrateur_experience' => $integrateur->getIntegrateur_experience(),
            'integrateur_attestation' => $integrateur->getIntegrateur_attestation(),
			'integrateur_adresse' => $integrateur->getIntegrateurAdresse(),
			'integrateur_canton' => $integrateur->getIntegrateurCanton(),
			'integrateur_ville' => $integrateur->getIntegrateurVille(),
			'code_membre' => $integrateur->getCode_membre(),
            'publier' => $integrateur->getPublier()
        );
        $this->getDbTable()->update($data, array('integrateur_id = ?' => $integrateur->getIntegrateur_id()));
    }

    public function delete($integrateur_id) {
        $this->getDbTable()->delete(array('integrateur_id = ?' => $integrateur_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("integrateur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
			      ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
				  ->setIntegrateurAdresse($row->integrateur_adresse)
				  ->setIntegrateurCanton($row->integrateur_canton)
				  ->setIntegrateurVille($row->integrateur_ville)
				  ->setCode_membre($row->code_membre)
                  ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByIntegrateur_type($integrateur_type) {
        $select = $this->getDbTable()->select();
		$select->where("integrateur_type = ? ", $integrateur_type);
		$select->where("publier = ? ", 1);
		$select->order("integrateur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
				  ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
				  ->setIntegrateurAdresse($row->integrateur_adresse)
				  ->setIntegrateurCanton($row->integrateur_canton)
				  ->setIntegrateurVille($row->integrateur_ville)
                  ->setPublier($row->publier)
				  ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("integrateur_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("integrateur_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
				  ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
				  ->setIntegrateurAdresse($row->integrateur_adresse)
				  ->setIntegrateurCanton($row->integrateur_canton)
				  ->setIntegrateurVille($row->integrateur_ville)
				  ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
    public function fetchAllByPublier($publier, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		if($code_agence != "") {
		  $select->where("integrateur_souscription IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->order(array("integrateur_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
				  ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
				  ->setCode_membre($row->code_membre)
				  ->setIntegrateurAdresse($row->integrateur_adresse)
				  ->setIntegrateurCanton($row->integrateur_canton)
				  ->setIntegrateurVille($row->integrateur_ville)
                  ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	

    public function fetchAllByMembreasso($integrateur_membreasso) {
        $select = $this->getDbTable()->select();
		$select->where("integrateur_membreasso = ? ", $integrateur_membreasso);
		$select->order(array("integrateur_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
				  ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
				  ->setCode_membre($row->code_membre)
				  ->setIntegrateurCanton($row->integrateur_canton)
				  ->setIntegrateurVille($row->integrateur_ville)
				  ->setIntegrateurAdresse($row->integrateur_adresse);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByAssociation($association) {
        $select = $this->getDbTable()->select();
		$select->where("integrateur_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association);
		$select->order(array("integrateur_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
                ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
                ->setIntegrateur_critere3($row->integrateur_critere3)
          ->setIntegrateur_type($row->integrateur_type)
          ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
          ->setIntegrateurAdresse($row->integrateur_adresse)
          ->setIntegrateurCanton($row->integrateur_canton)
          ->setIntegrateurVille($row->integrateur_ville)
          ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllBySouscription($integrateur_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("integrateur_souscription = ?", $integrateur_souscription);
		$select->order(array("integrateur_id DESC"));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
	              ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
	              ->setIntegrateur_critere3($row->integrateur_critere3)
				  ->setIntegrateur_type($row->integrateur_type)
				  ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
				  ->setIntegrateurAdresse($row->integrateur_adresse)
				  ->setIntegrateurCanton($row->integrateur_canton)
				  ->setIntegrateurVille($row->integrateur_ville)
				  ->setCode_membre($row->code_membre);
			$entries = $entry;
        return $entries;
    }
	
	
	

    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MONTH(integrateur_date) as MOIS, YEAR(integrateur_date) as ANNEE'));
		$select->distinct();
		$select->where("publier = ? ", 1);
		$select->order(array("integrateur_date DESC"));
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

	
	 

    public function fetchAllByCodeMembre($code_membre) {
        $select = $this->getDbTable()->select();
    $select->where("code_membre = ?", $code_membre);
    $select->order(array("integrateur_id DESC"));
    $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
                ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
                ->setIntegrateur_critere3($row->integrateur_critere3)
          ->setIntegrateur_type($row->integrateur_type)
          ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
          ->setIntegrateurAdresse($row->integrateur_adresse)
          ->setIntegrateurCanton($row->integrateur_canton)
          ->setIntegrateurVille($row->integrateur_ville)
          ->setCode_membre($row->code_membre);
      $entries = $entry;
        return $entries;
    }
  
  
  

    public function fetchAllByMembreasso2($integrateur_membreasso) {
        $select = $this->getDbTable()->select();
    $select->where("integrateur_membreasso = ?", $integrateur_membreasso);
    //$select->order(array("integrateur_id DESC"));
    $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
                ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
                ->setIntegrateur_critere3($row->integrateur_critere3)
          ->setIntegrateur_type($row->integrateur_type)
          ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
          ->setIntegrateurAdresse($row->integrateur_adresse)
          ->setIntegrateurCanton($row->integrateur_canton)
          ->setIntegrateurVille($row->integrateur_ville)
          ->setCode_membre($row->code_membre);
      $entries = $entry;
        return $entries;
    }
  






    public function fetchAllByTableauBord($publier, $integrateur_type = 0, $integrateur_membreasso = 0, $integrateur_association = 0, $code_membre = "", $integrateur_ville = 0, $integrateur_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $integrateur_date1 = "", $integrateur_date2 = "") {
        $select = $this->getDbTable()->select();
        $select->where("publier = ? ", $publier);
        if($integrateur_type > 0) {
            $select->where("integrateur_type = ? ", $integrateur_type);
        }
        if($code_membre != "") {
            $select->where("code_membre LIKE '%".$code_membre."%' ");
        }
        if($integrateur_association != ""){
        $select->where("integrateur_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ? )", $integrateur_association);  
        }
        if($integrateur_membreasso > 0){
        $select->where("integrateur_membreasso = ? ", $integrateur_membreasso);  
        }
        if($integrateur_ville > 0) {
          $select->where("integrateur_ville = ? ", $integrateur_ville);
        }
        if($integrateur_canton > 0) {
          $select->where("integrateur_canton = ? ", $integrateur_canton);
        }
        if($id_prefecture > 0) {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
            
        $select->where("(integrateur_date) BETWEEN  '".$integrateur_date1."' AND '".$integrateur_date2."' ");  
        
        $select->order("integrateur_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuIntegrateur();
            $entry->setIntegrateur_id($row->integrateur_id)
                ->setIntegrateur_souscription($row->integrateur_souscription)
                  ->setIntegrateur_critere2($row->integrateur_critere2)
                  ->setIntegrateur_critere1($row->integrateur_critere1)
                ->setIntegrateur_critere3($row->integrateur_critere3)
          ->setIntegrateur_type($row->integrateur_type)
          ->setIntegrateur_date($row->integrateur_date)
                  ->setIntegrateur_poste($row->integrateur_poste)
                  ->setIntegrateur_document($row->integrateur_document)
                  ->setIntegrateur_diplome($row->integrateur_diplome)
                  ->setIntegrateur_membreasso($row->integrateur_membreasso)
                  ->setIntegrateur_education($row->integrateur_education)
                  ->setIntegrateur_affiliation($row->integrateur_affiliation)
                  ->setIntegrateur_formation($row->integrateur_formation)
                  ->setIntegrateur_langue($row->integrateur_langue)
                  ->setIntegrateur_experience($row->integrateur_experience)
                  ->setIntegrateur_attestation($row->integrateur_attestation)
                  ->setPublier($row->publier)
          ->setIntegrateurAdresse($row->integrateur_adresse)
          ->setIntegrateurCanton($row->integrateur_canton)
          ->setIntegrateurVille($row->integrateur_ville)
          ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }





    public function fetchAllByTableauBordNombre($publier, $integrateur_type = 0, $integrateur_membreasso = 0, $integrateur_association = 0, $code_membre = "", $integrateur_ville = 0, $integrateur_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $integrateur_date1 = "", $integrateur_date2 = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(integrateur_id) as COUNT'));
        $select->where("publier = ? ", $publier);
        if($integrateur_type > 0) {
            $select->where("integrateur_type = ? ", $integrateur_type);
        }
        if($code_membre != "") {
            $select->where("code_membre LIKE '%".$code_membre."%' ");
        }
        if($integrateur_association != ""){
        $select->where("integrateur_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ? )", $integrateur_association);  
        }
        if($integrateur_membreasso > 0){
        $select->where("integrateur_membreasso = ? ", $integrateur_membreasso);  
        }
        if($integrateur_ville > 0) {
          $select->where("integrateur_ville = ? ", $integrateur_ville);
        }
        if($integrateur_canton > 0) {
          $select->where("integrateur_canton = ? ", $integrateur_canton);
        }
        if($id_prefecture > 0) {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
          $select->where("integrateur_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
            
        $select->where("(integrateur_date) BETWEEN  '".$integrateur_date1."' AND '".$integrateur_date2."' ");  
        
        $select->order("integrateur_id DESC");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }





}


?>
