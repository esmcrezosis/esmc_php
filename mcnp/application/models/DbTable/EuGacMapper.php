<?php

class Application_Model_EuGacMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGac');
        }
        return $this->_dbTable;
    }

    public function find($code_gac, Application_Model_EuGac $gac) {
        $result = $this->getDbTable()->find($code_gac);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $gac->setCode_gac($row->code_gac)
            ->setCode_membre($row->code_membre)
                ->setNom_gac($row->nom_gac)
                ->setCode_zone($row->code_zone)
                ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_gac($row->type_gac)
				->setId_pays($row->id_pays)
				->setId_region($row->id_region)
				->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
                ->setGroupe($row->groupe)
                ->setCode_type_gac($row->code_type_gac)
                ->setZone($row->zone)
				->setCode_secteur($row->code_secteur)
				->setCode_agence($row->code_agence)
                ->setCode_gac_create($row->code_gac_create)
                ->setCode_gac_chaine($row->code_gac_chaine);
        return true;
    }

    public function find1($membre) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('membre=?', $membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
				    ->setId_canton($row->id_canton)
					->setCode_secteur($row->code_secteur)
				    ->setCode_agence($row->code_agence)
                    ->setGroupe($row->groupe)
                    ->setCode_type_gac($row->code_type_gac)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findgacsource($membre) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('code_membre LIKE ?', $membre);
		$select->where('type_gac LIKE ?','source');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public  function findgacsourcemonde($type_gac,$code_type_gac) {
	   $table = new Application_Model_DbTable_EuGac();
       $select = $table->select();
       $select->where('type_gac LIKE ?', $type_gac);
	   $select->where('code_type_gac LIKE ?',$code_type_gac);
	   $result = $table->fetchAll($select);
       if(count($result) == 0) {
          return false;
       }
       $entries = array();
       foreach($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
	
	}
	
	
	public function findgaczone($code_zone,$type_gac,$code_type_gac)  {
	     $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('type_gac LIKE ?', $type_gac);
		$select->where('code_type_gac LIKE ?',$code_type_gac);
		$select->where('code_zone = ?',$code_zone);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
           return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
	
	}
	
	public function findgacpays($id_pays,$type_gac,$code_type_gac) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('type_gac LIKE ?', $type_gac);
		$select->where('code_type_gac LIKE ?',$code_type_gac);
		$select->where('id_pays = ?',$id_pays);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
          return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findgacregion($id_region,$type_gac,$code_type_gac) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('type_gac LIKE ?', $type_gac);
		$select->where('code_type_gac LIKE ?',$code_type_gac);
		$select->where('id_region = ?',$id_region);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
          return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findgacsecteur($id_prefecture,$type_gac,$code_type_gac) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('type_gac LIKE ?', $type_gac);
		$select->where('code_type_gac LIKE ?',$code_type_gac);
		$select->where('id_prefecture = ?',$id_prefecture);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
           return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findgacagence($id_canton,$type_gac,$code_type_gac) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('type_gac LIKE ?', $type_gac);
		$select->where('code_type_gac LIKE ?',$code_type_gac);
		$select->where('id_canton = ?',$id_canton);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
          return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	public function findtypegac($id_pays,$type_gac,$code_type_gac) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('type_gac LIKE ?', $type_gac);
		$select->where('code_type_gac LIKE ?',$code_type_gac);
		$select->where('id_pays = ?',$id_pays);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
                  ->setNom_gac($row->nom_gac)
                  ->setCode_zone($row->code_zone)
                  ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setType_gac($row->type_gac)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur($row->code_secteur)
				  ->setCode_agence($row->code_agence)
                  ->setGroupe($row->groupe)
                  ->setCode_type_gac($row->code_type_gac)
                  ->setZone($row->zone)
                  ->setCode_gac_create($row->code_gac_create)
                  ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function findByMembre($membre) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('code_membre=?', $membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
				    ->setId_canton($row->id_canton)
					->setCode_secteur($row->code_secteur)
				    ->setCode_agence($row->code_agence)
                    ->setGroupe($row->groupe)
                    ->setCode_type_gac($row->code_type_gac)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findGacByMembre($membre) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('code_membre=?', $membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            $entry = new Application_Model_EuGac();
             $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
				    ->setId_canton($row->id_canton)
					->setCode_secteur($row->code_secteur)
				    ->setCode_agence($row->code_agence)
                    ->setGroupe($row->groupe)
                    ->setCode_type_gac($row->code_type_gac)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);

            return $entry;
        }
    }

    public function find2($nom) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('nom_gac=?', $nom);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
					->setCode_secteur($row->code_secteur)
				->setCode_agence($row->code_agence)
                    ->setGroupe($row->groupe)
                    ->setCode_type_gac($row->code_type_gac)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByZone($code_zone) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('code_zone=?', $code_zone);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
                    ->setGroupe($row->groupe)
					->setId_region($row->id_region)
                    ->setCode_type_gac($row->code_type_gac)
					->setCode_secteur($row->code_secteur)
				    ->setCode_agence($row->code_agence)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByGacAndDiv($code_gac_acteur, $code_type_gac) {
        $table = new Application_Model_DbTable_EuGac();
        $select = $table->select();
        $select->where('code_gac_create = ?', $code_gac_acteur);
        $select->where('code_type_gac = ?', $code_type_gac);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
					->setCode_secteur($row->code_secteur)
				    ->setCode_agence($row->code_agence)
                    ->setGroupe($row->groupe)
                    ->setCode_type_gac($row->code_type_gac)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getLastGacByZone($code_zone) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_gac) as code'))
                ->where('zone = ?', $code_zone);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGac();
            $entry->setCode_gac($row->code_gac)
                    ->setCode_membre($row->code_membre)
                    ->setNom_gac($row->nom_gac)
                    ->setCode_zone($row->code_zone)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
					->setType_gac($row->type_gac)
					->setId_pays($row->id_pays)
					->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
					->setCode_secteur($row->code_secteur)
				->setCode_agence($row->code_agence)
                    ->setGroupe($row->groupe)
                    ->setCode_type_gac($row->code_type_gac)
                    ->setZone($row->zone)
                    ->setCode_gac_create($row->code_gac_create)
                    ->setCode_gac_chaine($row->code_gac_chaine);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuGac $gac) {
        $data = array(
            'code_gac' => $gac->getCode_gac(),
            'code_membre' => $gac->getCode_membre(),
            'nom_gac' => $gac->getNom_gac(),
            'code_zone' => $gac->getCode_zone(),
            'code_membre_gestionnaire' => $gac->getCode_membre_gestionnaire(),
            'date_creation' => $gac->getDate_creation(),
            'id_utilisateur' => $gac->getId_utilisateur(),
			'type_gac' => $gac->getType_gac(),
			'id_pays' => $gac->getId_pays(),
			'id_region' => $gac->getId_region(),
			'id_prefecture' => $gac->getId_prefecture(),
			'id_canton' => $gac->getId_canton(),
			'code_secteur' => $gac->getCode_secteur(),
			'code_agence' => $gac->getCode_agence(),
            'groupe' => $gac->getGroupe(),
            'code_type_gac' => $gac->getCode_type_gac(),
            'zone' => $gac->getZone(),
            'code_gac_create' => $gac->getCode_gac_create(),
            'code_gac_chaine' => $gac->getCode_gac_chaine()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGac $gac) {
        $data = array(
            'code_gac' => $gac->getCode_gac(),
            'code_membre' => $gac->getCode_membre(),
            'nom_gac' => $gac->getNom_gac(),
            'code_zone' => $gac->getCode_zone(),
            'code_membre_gestionnaire' => $gac->getCode_membre_gestionnaire(),
            'date_creation' => $gac->getDate_creation(),
            'id_utilisateur' => $gac->getId_utilisateur(),
			'type_gac' => $gac->getType_gac(),
			'id_pays' => $gac->getId_pays(),
			'id_region' => $gac->getId_region(),
			'id_prefecture' => $gac->getId_prefecture(),
			'id_canton' => $gac->getId_canton(),
			'code_secteur' => $gac->getCode_secteur(),
			'code_agence' => $gac->getCode_agence(),
            'groupe' => $gac->getGroupe(),
            'code_type_gac' => $gac->getCode_type_gac(),
            'zone' => $gac->getZone(),
            'code_gac_create' => $gac->getCode_gac_create(),
            'code_gac_chaine' => $gac->getCode_gac_chaine()
        );
        $this->getDbTable()->update($data, array('code_gac = ?' => $gac->getCode_gac()));
    }

    public function delete($code_gac) {
        $this->getDbTable()->delete(array('code_gac = ?' => $code_gac));
    }

}

?>
