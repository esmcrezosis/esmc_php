<?php

class Application_Model_EuPointageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPointage');
        }
        return $this->_dbTable;
    }


    public function find($id_pointage, Application_Model_EuPointage $pointage) {
        $result = $this->getDbTable()->find($id_pointage);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $pointage->setId_pointage($row->id_pointage)
                 ->setDate_heure_debut($row->date_heure_debut)
                 ->setDate_heure_fin($row->date_heure_fin)
                 ->setCode_membre_employe($row->code_membre_employe)
                 ->setId_poste_pointage($row->id_poste_pointage)
				 ->setTraiter($row->traiter)
				 ->setDate_pointage($row->date_pointage);
    }
 

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPointage();
            $entry->setId_pointage($row->id_pointage)
                  ->setDate_heure_debut($row->date_heure_debut)
                  ->setDate_heure_fin($row->date_heure_fin)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_poste_pointage($row->id_poste_pointage)
				  ->setTraiter($row->traiter)
				  ->setDate_pointage($row->date_pointage);
            $entries[] = $entry;
        }
        return $entries;
    }
	  

    public function save(Application_Model_EuPointage $pointage) {
        $data = array(
			'id_pointage' => $pointage->getId_pointage(),
            'code_membre_employe' => $pointage->getCode_membre_employe(),
            'date_heure_debut' => $pointage->getDate_heure_debut(),
            'date_heure_fin' => $pointage->getDate_heure_fin(),
            'id_poste_pointage' => $pointage->getId_poste_pointage(),
			'traiter' => $pointage->getTraiter(),
			'date_pointage' => $pointage->getDate_pointage()
			
        );
        $this->getDbTable()->insert($data);
    }
    
	
    public function update(Application_Model_EuPointage $pointage) {
        $data = array(
          'id_pointage' => $pointage->getId_pointage(),
          'code_membre_employe' => $pointage->getCode_membre_employe(),
          'date_heure_debut' => $pointage->getDate_heure_debut(),
          'date_heure_fin' => $pointage->getDate_heure_fin(),
          'id_poste_pointage' => $pointage->getId_poste_pointage(),
		  'traiter' => $pointage->getTraiter(),
		  'date_pointage' => $pointage->getDate_pointage()
        );
        $this->getDbTable()->update($data, array('id_pointage = ?' => $pointage->getId_pointage()));
    }


    public function delete($id_pointage) {
        $this->getDbTable()->delete(array('id_pointage = ?' => $id_pointage));
    }

    public function findConuter() {
        $tabela = new Application_Model_DbTable_EuPointage();
        $select = $tabela->select();
        $select->from('eu_pointage', array('MAX(id_pointage) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->distinct();
        $select->from($this->getDbTable(), array('MONTH(date_heure_fin) as MOIS, YEAR(date_heure_fin) as ANNEE'));
        $select->order(array("date_heure_fin DESC"));
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

   public function fetchAllByEmploye($code_membre_employe) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_employe = ?', $code_membre_employe);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPointage();
            $entry->setId_pointage($row->id_pointage)
                  ->setDate_heure_debut($row->date_heure_debut)
                  ->setDate_heure_fin($row->date_heure_fin)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_poste_pointage($row->id_poste_pointage)
				  ->setTraiter($row->traiter)
				  ->setDate_pointage($row->date_pointage);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function fetchAllEmployer($debut,$fin) {
	   $select = $this->getDbTable()->select();
       $select->distinct();
       $select->from($this->getDbTable(), array('code_membre_employe as employe'));
	   if($debut != "") {
          $select->where("date_heure_fin BETWEEN '".$debut."' AND '".$fin."'");
       }
       $resultSet = $this->getDbTable()->fetchAll($select);
       $entries = array();
       foreach ($resultSet as $row) {
         $entry = array();
         $entry['employe'] = $row['employe'];
         $entries[] = $entry;
       }
       return $entries;
	}
	
	public function fetchAllEmployeByDate($code_membre_employe,$debut,$fin) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_employe = ?', $code_membre_employe);
		$select->where('traiter = ?', 0);
		if($debut != "") {
          $select->where("date_heure_fin BETWEEN '".$debut."' AND '".$fin."'");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPointage();
            $entry->setId_pointage($row->id_pointage)
                  ->setDate_heure_debut($row->date_heure_debut)
                  ->setDate_heure_fin($row->date_heure_fin)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_poste_pointage($row->id_poste_pointage)
				  ->setTraiter($row->traiter)
				  ->setDate_pointage($row->date_pointage);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function fetchAllEmployeurByDate($debut,$fin,$code_membre_employeur)  {
	   $select = $this->getDbTable()->select();
	   $select->where('id_poste_pointage IN (SELECT id_poste_pointage FROM eu_poste_pointage WHERE code_membre_employeur = ?)',$code_membre_employeur);
	   $select->where('traiter = ?', 0);
	   if($debut != "") {
         $select->where("date_heure_fin BETWEEN '".$debut."' AND '".$fin."'");
       }
	   $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   if (0 == count($resultSet)) {
          return NULL;
       }
	   foreach($resultSet as $row) {
         $entry = new Application_Model_EuPointage();
         $entry->setId_pointage($row->id_pointage)
               ->setDate_heure_debut($row->date_heure_debut)
               ->setDate_heure_fin($row->date_heure_fin)
               ->setCode_membre_employe($row->code_membre_employe)
               ->setId_poste_pointage($row->id_poste_pointage)
			   ->setTraiter($row->traiter)
			   ->setDate_pointage($row->date_pointage);
         $entries[] = $entry;
       }
       return $entries;
	}
	
	
	

    public function fetchAllByPoste($id_poste_pointage) {
        $select = $this->getDbTable()->select();
        $select->where('id_poste_pointage = ?', $id_poste_pointage);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPointage();
            $entry->setId_pointage($row->id_pointage)
                  ->setDate_heure_debut($row->date_heure_debut)
                  ->setDate_heure_fin($row->date_heure_fin)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_poste_pointage($row->id_poste_pointage)
				  ->setTraiter($row->traiter)
				  ->setDate_pointage($row->date_pointage);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByEmployeur($code_membre_employeur) {
        $select = $this->getDbTable()->select();
        $select->where('id_poste_pointage IN (SELECT id_poste_pointage FROM eu_poste_pointage WHERE code_membre_employeur = ?)', $code_membre_employeur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuPointage();
          $entry->setId_pointage($row->id_pointage)
                ->setDate_heure_debut($row->date_heure_debut)
                ->setDate_heure_fin($row->date_heure_fin)
                ->setCode_membre_employe($row->code_membre_employe)
                ->setId_poste_pointage($row->id_poste_pointage)
				->setTraiter($row->traiter)
				->setDate_pointage($row->date_pointage);
            $entries[] = $entry;
        }
        return $entries;
    }

    ///////////////////////////////////////////////////////////////

}

?>
