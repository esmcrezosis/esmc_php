<?php
 
class Application_Model_EuReleveescompteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuReleveescompte');
        }
        return $this->_dbTable;
    }

    public function find($releveescompte_id, Application_Model_EuReleveescompte $releveescompte) {
        $result = $this->getDbTable()->find($releveescompte_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $releveescompte->setReleveescompte_id($row->releveescompte_id)
                ->setReleveescompte_releve($row->releveescompte_releve)
                ->setReleveescompte_escompte($row->releveescompte_escompte)
                ->setReleveescompte_produit($row->releveescompte_produit)
                ->setReleveescompte_montant($row->releveescompte_montant)
                ->setReleveescompte_date($row->releveescompte_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
	                ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(releveescompte_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuReleveescompte $releveescompte) {
        $data = array(
            'releveescompte_id' => $releveescompte->getReleveescompte_id(),
            'releveescompte_releve' => $releveescompte->getReleveescompte_releve(),
            'releveescompte_escompte' => $releveescompte->getReleveescompte_escompte(),
            'releveescompte_produit' => $releveescompte->getReleveescompte_produit(),
            'releveescompte_montant' => $releveescompte->getReleveescompte_montant(),
            'releveescompte_date' => $releveescompte->getReleveescompte_date(),
            'publier' => $releveescompte->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuReleveescompte $releveescompte) {
        $data = array(
            'releveescompte_id' => $releveescompte->getReleveescompte_id(),
            'releveescompte_releve' => $releveescompte->getReleveescompte_releve(),
            'releveescompte_escompte' => $releveescompte->getReleveescompte_escompte(),
            'releveescompte_produit' => $releveescompte->getReleveescompte_produit(),
            'releveescompte_montant' => $releveescompte->getReleveescompte_montant(),
            'releveescompte_date' => $releveescompte->getReleveescompte_date(),
            'publier' => $releveescompte->getPublier()
        );
        $this->getDbTable()->update($data, array('releveescompte_id = ?' => $releveescompte->getReleveescompte_id()));
    }

    public function delete($releveescompte_id) {
        $this->getDbTable()->delete(array('releveescompte_id = ?' => $releveescompte_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
	                ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
	                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByReleve1($releve) {
        $select = $this->getDbTable()->select();
		$select->where("releveescompte_releve = ? ", $releve);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
	                ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
	                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByReleve0($releve) {
        $select = $this->getDbTable()->select();
		$select->where("releveescompte_releve = ? ", $releve);
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
	                ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
	                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllByReleve($releve, $publier = "") {
        $select = $this->getDbTable()->select();
		$select->where("releveescompte_releve = ? ", $releve);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
	                ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
	                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAllByReleveProduit1($releve, $produit) {
        $select = $this->getDbTable()->select();
		$select->where("releveescompte_releve = ? ", $releve);
		$select->where("releveescompte_produit = ? ", $produit);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
		            ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
	                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByReleveProduit($releve, $produit, $publier) {
        $select = $this->getDbTable()->select();
		$select->where("releveescompte_releve = ? ", $releve);
		$select->where("releveescompte_produit = ? ", $produit);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveescompte();
            $entry->setReleveescompte_id($row->releveescompte_id)
	                ->setReleveescompte_releve($row->releveescompte_releve)
		            ->setReleveescompte_escompte($row->releveescompte_escompte)
                    ->setReleveescompte_produit($row->releveescompte_produit)
	                ->setReleveescompte_montant($row->releveescompte_montant)
	                ->setReleveescompte_date($row->releveescompte_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
