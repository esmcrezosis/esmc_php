<?php
 
class Application_Model_EuRelevecreditnoncMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevecreditnonc');
        }
        return $this->_dbTable;
    }

    public function find($relevecreditnonc_id, Application_Model_EuRelevecreditnonc $relevecreditnonc) {
        $result = $this->getDbTable()->find($relevecreditnonc_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevecreditnonc->setRelevecreditnonc_id($row->relevecreditnonc_id)
                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
                ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
	                ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevecreditnonc_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevecreditnonc $relevecreditnonc) {
        $data = array(
            'relevecreditnonc_id' => $relevecreditnonc->getRelevecreditnonc_id(),
            'relevecreditnonc_releve' => $relevecreditnonc->getRelevecreditnonc_releve(),
            'relevecreditnonc_creditnonc' => $relevecreditnonc->getRelevecreditnonc_creditnonc(),
            'relevecreditnonc_produit' => $relevecreditnonc->getRelevecreditnonc_produit(),
            'relevecreditnonc_montant' => $relevecreditnonc->getRelevecreditnonc_montant(),
            'relevecreditnonc_date' => $relevecreditnonc->getRelevecreditnonc_date(),
            'publier' => $relevecreditnonc->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevecreditnonc $relevecreditnonc) {
        $data = array(
            'relevecreditnonc_id' => $relevecreditnonc->getRelevecreditnonc_id(),
            'relevecreditnonc_releve' => $relevecreditnonc->getRelevecreditnonc_releve(),
            'relevecreditnonc_creditnonc' => $relevecreditnonc->getRelevecreditnonc_creditnonc(),
            'relevecreditnonc_produit' => $relevecreditnonc->getRelevecreditnonc_produit(),
            'relevecreditnonc_montant' => $relevecreditnonc->getRelevecreditnonc_montant(),
            'relevecreditnonc_date' => $relevecreditnonc->getRelevecreditnonc_date(),
            'publier' => $relevecreditnonc->getPublier()
        );
        $this->getDbTable()->update($data, array('relevecreditnonc_id = ?' => $relevecreditnonc->getRelevecreditnonc_id()));
    }

    public function delete($relevecreditnonc_id) {
        $this->getDbTable()->delete(array('relevecreditnonc_id = ?' => $relevecreditnonc_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
	                ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
	                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByReleve1($releve) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditnonc_releve = ? ", $releve);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
	                ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
	                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByReleve0($releve) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditnonc_releve = ? ", $releve);
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
	                ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
	                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllByReleve($releve, $publier = "") {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditnonc_releve = ? ", $releve);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
	                ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
	                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAllByReleveProduit1($releve, $produit) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditnonc_releve = ? ", $releve);
		$select->where("relevecreditnonc_produit = ? ", $produit);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
		            ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
	                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByReleveProduit($releve, $produit, $publier) {
        $select = $this->getDbTable()->select();
		$select->where("relevecreditnonc_releve = ? ", $releve);
		$select->where("relevecreditnonc_produit = ? ", $produit);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevecreditnonc();
            $entry->setRelevecreditnonc_id($row->relevecreditnonc_id)
	                ->setRelevecreditnonc_releve($row->relevecreditnonc_releve)
		            ->setRelevecreditnonc_creditnonc($row->relevecreditnonc_creditnonc)
                    ->setRelevecreditnonc_produit($row->relevecreditnonc_produit)
	                ->setRelevecreditnonc_montant($row->relevecreditnonc_montant)
	                ->setRelevecreditnonc_date($row->relevecreditnonc_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
