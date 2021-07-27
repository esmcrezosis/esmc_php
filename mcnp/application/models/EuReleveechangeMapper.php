<?php
 
class Application_Model_EuReleveechangeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuReleveechange');
        }
        return $this->_dbTable;
    }

    public function find($releveechange_id, Application_Model_EuReleveechange $releveechange) {
        $result = $this->getDbTable()->find($releveechange_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $releveechange->setReleveechange_id($row->releveechange_id)
                ->setReleveechange_releve($row->releveechange_releve)
                ->setReleveechange_echange($row->releveechange_echange)
                ->setReleveechange_produit($row->releveechange_produit)
                ->setReleveechange_montant($row->releveechange_montant)
                ->setReleveechange_date($row->releveechange_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
	                ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(releveechange_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuReleveechange $releveechange) {
        $data = array(
            'releveechange_id' => $releveechange->getReleveechange_id(),
            'releveechange_releve' => $releveechange->getReleveechange_releve(),
            'releveechange_echange' => $releveechange->getReleveechange_echange(),
            'releveechange_produit' => $releveechange->getReleveechange_produit(),
            'releveechange_montant' => $releveechange->getReleveechange_montant(),
            'releveechange_date' => $releveechange->getReleveechange_date(),
            'publier' => $releveechange->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuReleveechange $releveechange) {
        $data = array(
            'releveechange_id' => $releveechange->getReleveechange_id(),
            'releveechange_releve' => $releveechange->getReleveechange_releve(),
            'releveechange_echange' => $releveechange->getReleveechange_echange(),
            'releveechange_produit' => $releveechange->getReleveechange_produit(),
            'releveechange_montant' => $releveechange->getReleveechange_montant(),
            'releveechange_date' => $releveechange->getReleveechange_date(),
            'publier' => $releveechange->getPublier()
        );
        $this->getDbTable()->update($data, array('releveechange_id = ?' => $releveechange->getReleveechange_id()));
    }

    public function delete($releveechange_id) {
        $this->getDbTable()->delete(array('releveechange_id = ?' => $releveechange_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
	                ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
	                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByReleve1($releve) {
        $select = $this->getDbTable()->select();
		$select->where("releveechange_releve = ? ", $releve);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
	                ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
	                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByReleve0($releve) {
        $select = $this->getDbTable()->select();
		$select->where("releveechange_releve = ? ", $releve);
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
	                ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
	                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllByReleve($releve, $publier = "") {
        $select = $this->getDbTable()->select();
		$select->where("releveechange_releve = ? ", $releve);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
	                ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
	                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAllByReleveProduit1($releve, $produit) {
        $select = $this->getDbTable()->select();
		$select->where("releveechange_releve = ? ", $releve);
		$select->where("releveechange_produit = ? ", $produit);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
		            ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
	                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByReleveProduit($releve, $produit, $publier) {
        $select = $this->getDbTable()->select();
		$select->where("releveechange_releve = ? ", $releve);
		$select->where("releveechange_produit = ? ", $produit);
		if($publier != ""){
		$select->where("publier = ? ", $publier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuReleveechange();
            $entry->setReleveechange_id($row->releveechange_id)
	                ->setReleveechange_releve($row->releveechange_releve)
		            ->setReleveechange_echange($row->releveechange_echange)
                    ->setReleveechange_produit($row->releveechange_produit)
	                ->setReleveechange_montant($row->releveechange_montant)
	                ->setReleveechange_date($row->releveechange_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
