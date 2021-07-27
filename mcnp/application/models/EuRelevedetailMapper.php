<?php
 
class Application_Model_EuRelevedetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevedetail');
        }
        return $this->_dbTable;
    }

    public function find($relevedetail_id, Application_Model_EuRelevedetail $relevedetail) {
        $result = $this->getDbTable()->find($relevedetail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevedetail->setRelevedetail_id($row->relevedetail_id)
                ->setRelevedetail_releve($row->relevedetail_releve)
                ->setRelevedetail_credit($row->relevedetail_credit)
                ->setRelevedetail_produit($row->relevedetail_produit)
                ->setRelevedetail_montant($row->relevedetail_montant)
                ->setRelevedetail_date($row->relevedetail_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
	                ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevedetail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevedetail $relevedetail) {
        $data = array(
            'relevedetail_id' => $relevedetail->getRelevedetail_id(),
            'relevedetail_releve' => $relevedetail->getRelevedetail_releve(),
            'relevedetail_credit' => $relevedetail->getRelevedetail_credit(),
            'relevedetail_produit' => $relevedetail->getRelevedetail_produit(),
            'relevedetail_montant' => $relevedetail->getRelevedetail_montant(),
            'relevedetail_date' => $relevedetail->getRelevedetail_date(),
            'publier' => $relevedetail->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevedetail $relevedetail) {
        $data = array(
            'relevedetail_id' => $relevedetail->getRelevedetail_id(),
            'relevedetail_releve' => $relevedetail->getRelevedetail_releve(),
            'relevedetail_credit' => $relevedetail->getRelevedetail_credit(),
            'relevedetail_produit' => $relevedetail->getRelevedetail_produit(),
            'relevedetail_montant' => $relevedetail->getRelevedetail_montant(),
            'relevedetail_date' => $relevedetail->getRelevedetail_date(),
            'publier' => $relevedetail->getPublier()
        );
        $this->getDbTable()->update($data, array('relevedetail_id = ?' => $relevedetail->getRelevedetail_id()));
    }

    public function delete($relevedetail_id) {
        $this->getDbTable()->delete(array('relevedetail_id = ?' => $relevedetail_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
	                ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
	                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByReleve1($releve) {
        $select = $this->getDbTable()->select();
		$select->where("relevedetail_releve = ? ", $releve);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
	                ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
	                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByReleve0($releve) {
        $select = $this->getDbTable()->select();
		$select->where("relevedetail_releve = ? ", $releve);
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
	                ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
	                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllByReleve($releve, $publier = "") {
        $select = $this->getDbTable()->select();
		$select->where("relevedetail_releve = ? ", $releve);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
	                ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
	                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAllByReleveProduit1($releve, $produit) {
        $select = $this->getDbTable()->select();
		$select->where("relevedetail_releve = ? ", $releve);
		$select->where("relevedetail_produit = ? ", $produit);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
		            ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
	                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByReleveProduit($releve, $produit, $publier) {
        $select = $this->getDbTable()->select();
		$select->where("relevedetail_releve = ? ", $releve);
		$select->where("relevedetail_produit = ? ", $produit);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevedetail();
            $entry->setRelevedetail_id($row->relevedetail_id)
	                ->setRelevedetail_releve($row->relevedetail_releve)
		            ->setRelevedetail_credit($row->relevedetail_credit)
                    ->setRelevedetail_produit($row->relevedetail_produit)
	                ->setRelevedetail_montant($row->relevedetail_montant)
	                ->setRelevedetail_date($row->relevedetail_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
