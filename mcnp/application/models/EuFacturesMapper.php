<?php
 
class Application_Model_EuFacturesMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFactures');
        }
        return $this->_dbTable;
    }

    public function find($facture_id, Application_Model_EuFactures $facture) {
        $result = $this->getDbTable()->find($facture_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $facture->setFacture_id($row->facture_id)
                ->setFacture_numero($row->facture_numero)
                ->setFacture_montant($row->facture_montant)
                ->setFacture_code_membre($row->facture_code_membre)
                ->setFacture_utilisateur($row->facture_utilisateur)
                ->setFacture_date($row->facture_date)
                	->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("facture_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFactures();
            $entry->setFacture_id($row->facture_id)
	                ->setFacture_numero($row->facture_numero)
                    ->setFacture_montant($row->facture_montant)
	                ->setFacture_code_membre($row->facture_code_membre)
					->setFacture_utilisateur($row->facture_utilisateur)
					->setFacture_date($row->facture_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(facture_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFactures $facture) {
        $data = array(
            'facture_id' => $facture->getFacture_id(),
            'facture_numero' => $facture->getFacture_numero(),
            'facture_montant' => $facture->getFacture_montant(),
            'facture_code_membre' => $facture->getFacture_code_membre(),
            'facture_utilisateur' => $facture->getFacture_utilisateur(),
            'facture_date' => $facture->getFacture_date(),
            'publier' => $facture->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFactures $facture) {
        $data = array(
            'facture_id' => $facture->getFacture_id(),
            'facture_numero' => $facture->getFacture_numero(),
            'facture_montant' => $facture->getFacture_montant(),
            'facture_code_membre' => $facture->getFacture_code_membre(),
            'facture_utilisateur' => $facture->getFacture_utilisateur(),
            'facture_date' => $facture->getFacture_date(),
            'publier' => $facture->getPublier()
        );
        $this->getDbTable()->update($data, array('facture_id = ?' => $facture->getFacture_id()));
    }

    public function delete($facture_id) {
        $this->getDbTable()->delete(array('facture_id = ?' => $facture_id));
    }




    public function fetchAllByMembre0($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("facture_code_membre = ? ", $code_membre);
		$select->order("facture_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFactures();
            $entry->setFacture_id($row->facture_id)
	                ->setFacture_numero($row->facture_numero)
                    ->setFacture_montant($row->facture_montant)
	                ->setFacture_code_membre($row->facture_code_membre)
					->setFacture_utilisateur($row->facture_utilisateur)
					->setFacture_date($row->facture_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByUtilisateur($utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("facture_utilisateur = ? ", $utilisateur);
		$select->order("facture_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFactures();
            $entry->setFacture_id($row->facture_id)
	                ->setFacture_numero($row->facture_numero)
                    ->setFacture_montant($row->facture_montant)
	                ->setFacture_code_membre($row->facture_code_membre)
					->setFacture_utilisateur($row->facture_utilisateur)
					->setFacture_date($row->facture_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	

	




    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(facture_id) as count'));
		$select->where("facture_numero LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(facture_id) as count'));
		//$select->where("facture_numero = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }

    public function fetchAllByMembre($membre) {
        $select = $this->getDbTable()->select();
		$select->where("facture_code_membre = ? ", $membre);
		$select->where("publier = ? ", 1);
		$select->order("facture_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFactures();
            $entry->setFacture_id($row->facture_id)
	                ->setFacture_numero($row->facture_numero)
                    ->setFacture_montant($row->facture_montant)
	                ->setFacture_code_membre($row->facture_code_membre)
					->setFacture_utilisateur($row->facture_utilisateur)
					->setFacture_date($row->facture_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	


}


?>
