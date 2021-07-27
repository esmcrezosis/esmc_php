<?php
 
class Application_Model_EuRelevecreditcMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevecreditc');
        }
        return $this->_dbTable;
    }

    public function find($relevecreditc_id, Application_Model_EuRelevecreditc $relevecreditc) {
        $result = $this->getDbTable()->find($relevecreditc_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevecreditc->setRelevecreditc_id($row->relevecreditc_id)
                ->setRelevecreditc_releve($row->relevecreditc_releve)
                ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                ->setRelevecreditc_produit($row->relevecreditc_produit)
                ->setRelevecreditc_montant($row->relevecreditc_montant)
                ->setRelevecreditc_date($row->relevecreditc_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
	                ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevecreditc_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevecreditc $relevecreditc) {
        $data = array(
            'relevecreditc_id' => $relevecreditc->getRelevecreditc_id(),
            'relevecreditc_releve' => $relevecreditc->getRelevecreditc_releve(),
            'relevecreditc_creditc' => $relevecreditc->getRelevecreditc_creditc(),
            'relevecreditc_produit' => $relevecreditc->getRelevecreditc_produit(),
            'relevecreditc_montant' => $relevecreditc->getRelevecreditc_montant(),
            'relevecreditc_date' => $relevecreditc->getRelevecreditc_date(),
            'publier' => $relevecreditc->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevecreditc $relevecreditc) {
        $data = array(
            'relevecreditc_id' => $relevecreditc->getRelevecreditc_id(),
            'relevecreditc_releve' => $relevecreditc->getRelevecreditc_releve(),
            'relevecreditc_creditc' => $relevecreditc->getRelevecreditc_creditc(),
            'relevecreditc_produit' => $relevecreditc->getRelevecreditc_produit(),
            'relevecreditc_montant' => $relevecreditc->getRelevecreditc_montant(),
            'relevecreditc_date' => $relevecreditc->getRelevecreditc_date(),
            'publier' => $relevecreditc->getPublier()
        );
        $this->getDbTable()->update($data, array('relevecreditc_id = ?' => $relevecreditc->getRelevecreditc_id()));
    }

    public function delete($relevecreditc_id) {
        $this->getDbTable()->delete(array('relevecreditc_id = ?' => $relevecreditc_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
	                ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
	                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByReleve1($releve) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditc_releve = ? ", $releve);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
	                ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
	                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByReleve0($releve) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditc_releve = ? ", $releve);
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
	                ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
	                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllByReleve($releve, $publier = "") {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditc_releve = ? ", $releve);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
	                ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
	                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAllByReleveProduit1($releve, $produit) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditc_releve = ? ", $releve);
		$select->where("relevecreditc_produit = ? ", $produit);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
		            ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
	                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByReleveProduit($releve, $produit, $publier) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditc_releve = ? ", $releve);
		$select->where("relevecreditc_produit = ? ", $produit);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditc();
            $entry->setRelevecreditc_id($row->relevecreditc_id)
	                ->setRelevecreditc_releve($row->relevecreditc_releve)
		            ->setRelevecreditc_creditc($row->relevecreditc_creditc)
                    ->setRelevecreditc_produit($row->relevecreditc_produit)
	                ->setRelevecreditc_montant($row->relevecreditc_montant)
	                ->setRelevecreditc_date($row->relevecreditc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
