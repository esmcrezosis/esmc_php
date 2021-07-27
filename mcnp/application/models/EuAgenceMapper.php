<?php

class Application_Model_EuAgenceMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuAgence');
        }
        return $this->_dbTable;
    }

    public function findBySecteur($id_prefecture) {
        $select = $this->getDbTable()->select();
        $select->where('id_prefecture = ?', $id_prefecture);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return false;
        }
        $entries = array();
		
        foreach ($result as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
          ;
				  
            $entries[] = $entry;
        }
        return $entries;
    }
/*
    public function findAllByGac($code_gac) {
        $select = $this->getDbTable()->select();
        $select->where('code_gac_create = ?', $code_gac);
        $select->orwhere('code_gac_agence = ?', $code_gac);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	*/

    /*public function findByGac($code_gac) {
        $select = $this->getDbTable()->select();
        $select->where('code_gac_create = ?', $code_gac);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
    }*/

    /*public function findByGacAgence($code_gac_agence) {
        $select = $this->getDbTable()->select();
        $select->where('code_gac_agence = ?', $code_gac_agence);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
    }
	*/

    public function getLastCodeAgenceBySect($code_secteur) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_agence) as code'))
                ->where('code_secteur = ?', $code_secteur);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function find($code_agence, Application_Model_EuAgence $agence) {
        $result = $this->getDbTable()->find($code_agence);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $agence->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
          ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
          ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuAgence $agence) {
        $data = array(
            'code_agence' => $agence->getCode_agence(),
			'type_gac' => $agence->getType_gac(),
			'date_creation' => $agence->getDate_creation(),
			'libelle_agence' => $agence->getLibelle_agence(),
			'partenaire' => $agence->getPartenaire(),
            'code_membre' => $agence->getCode_membre(),
            'code_zone' => $agence->getCode_zone(),
            'id_pays' => $agence->getId_pays(),
            'id_region' => $agence->getId_region(),
			'id_prefecture' => $agence->getId_prefecture(),
			'id_canton' => $agence->getId_canton(),
			'code_secteur' => $agence->getCode_secteur()
        );
        $this->getDbTable()->insert($data);
    }


    public function update(Application_Model_EuAgence $agence) {
        $data = array(
          'code_agence' => $agence->getCode_agence(),
		  'type_gac' => $agence->getType_gac(),
		  'date_creation' => $agence->getDate_creation(),
		  'libelle_agence' => $agence->getLibelle_agence(),
		  'partenaire' => $agence->getPartenaire(),
          'code_membre' => $agence->getCode_membre(),
          'code_zone' => $agence->getCode_zone(),
          'id_pays' => $agence->getId_pays(),
          'id_region' => $agence->getId_region(),
		  'id_prefecture' => $agence->getId_prefecture(),
		  'id_canton' => $agence->getId_canton(),
		  'code_secteur' => $agence->getCode_secteur()
        );
        $this->getDbTable()->update($data, array('code_agence = ?' => $agence->getCode_agence()));
    }


    public function delete($code_agence) {
        $this->getDbTable()->delete(array('code_agence = ?' => $code_agence));
    }
	
	

    public function fetchAllByAssociation() {
        $select = $this->getDbTable()->select();
		$select->where("code_agence IN (SELECT code_agence FROM eu_association)");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAllByAgence($code_agence) {
        $select = $this->getDbTable()->select();
		$select->where("code_agence = ?", $code_agence);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAgence();
            $entry->setCode_agence($row->code_agence)
			      ->setType_gac($row->type_gac)
				  ->setDate_creation($row->date_creation)
				  ->setLibelle_agence($row->libelle_agence)
				  ->setPartenaire($row->partenaire)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone($row->code_zone)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
          ;
            $entries[] = $entry;
        }
        return $entries;
    }

}
