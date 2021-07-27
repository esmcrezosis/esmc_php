<?php

class Application_Model_EuLicenceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLicence');
        }
        return $this->_dbTable;
    }

    public function find($id_licence, Application_Model_EuLicence $licence) {
        $result = $this->getDbTable()->find($id_licence);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $licence->setId_licence($row->id_licence)
                ->setNum_licence($row->num_licence)
                ->setLibelle_licence($row->libelle_licence)
                ->setDesc_licence($row->desc_licence)
                ->setDate_licence($row->date_licence)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setId_utilisateur($row->id_utilisateur);
    }
	
	public function findlicence($num_licence) {
	   $select = $this->getDbTable()->select();
	   $select->where('num_licence LIKE ?', $num_licence)
               ->where('code_membre_morale IS NULL');
           $results = $this->getDbTable()->fetchAll($select);
		   if (count($results) > 0) {
		      $row = $results->current();
              $licence = new Application_Model_EuLicence();
              $licence->setId_licence($row->id_licence)
                      ->setNum_licence($row->num_licence)
                      ->setLibelle_licence($row->libelle_licence)
                      ->setDesc_licence($row->desc_licence)
                      ->setDate_licence($row->date_licence)
                      ->setId_utilisateur($row->id_utilisateur)
					  ->setCode_membre_morale($row->code_membre_morale);
              return $licence; 
		   } else {
              return false;
           }
	}
	
	public function findlicencebymembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where('code_membre_morale LIKE ?', $code_membre);
           $results = $this->getDbTable()->fetchAll($select);
		   if (count($results) > 0) {
		      $row = $results->current();
              $licence = new Application_Model_EuLicence();
              $licence->setId_licence($row->id_licence)
                      ->setNum_licence($row->num_licence)
                      ->setLibelle_licence($row->libelle_licence)
                      ->setDesc_licence($row->desc_licence)
                      ->setDate_licence($row->date_licence)
                      ->setId_utilisateur($row->id_utilisateur)
					  ->setCode_membre_morale($row->code_membre_morale);
              return $licence; 
		   } else {
              return false;
           }
	}
	
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLicence();
            $entry->setId_licence($row->id_licence)
                    ->setNum_licence($row->num_licence)
					->setLibelle_licence($row->libelle_licence)
                    ->setDesc_licence($row->desc_licence)
                    ->setDate_licence($row->date_licence)
                	->setCode_membre_morale($row->code_membre_morale)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_licence) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuLicence $licence) {
        $data = array(
            'id_licence' => $licence->getId_licence(),
            'num_licence' => $licence->getNum_licence(),
            'libelle_licence' => $licence->getLibelle_licence(),
            'desc_licence' => $licence->getDesc_licence(),
            'date_licence' => $licence->getDate_licence(),
            'code_membre_morale' => $licence->getCode_membre_morale(),
            'id_utilisateur' => $licence->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuLicence $licence) {
        $data = array(
            'id_licence' => $licence->getId_licence(),
            'num_licence' => $licence->getNum_licence(),
            'libelle_licence' => $licence->getLibelle_licence(),
            'desc_licence' => $licence->getDesc_licence(),
            'date_licence' => $licence->getDate_licence(),
            'code_membre_morale' => $licence->getCode_membre_morale(),
            'id_utilisateur' => $licence->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_licence = ?' => $licence->getId_licence()));
    }

    public function delete($id_licence) {
        $this->getDbTable()->delete(array('id_licence = ?' => $id_licence));
    }


    public function fetchAll2($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLicence();
            $entry->setId_licence($row->id_licence)
                    ->setNum_licence($row->num_licence)
					->setLibelle_licence($row->libelle_licence)
                    ->setDesc_licence($row->desc_licence)
                    ->setDate_licence($row->date_licence)
                	->setCode_membre_morale($row->code_membre_morale)
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
            $entry = new Application_Model_EuLicence();
            $entry->setId_licence($row->id_licence)
                    ->setNum_licence($row->num_licence)
					->setLibelle_licence($row->libelle_licence)
                    ->setDesc_licence($row->desc_licence)
                    ->setDate_licence($row->date_licence)
                	->setCode_membre_morale($row->code_membre_morale)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_licence) as count'));
		$select->where("num_licence LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_licence) as count'));
		//$select->where("num_licence = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }

}


?>
