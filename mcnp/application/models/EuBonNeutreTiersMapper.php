<?php
 
class Application_Model_EuBonNeutreTiersMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonNeutreTiers');
        }
        return $this->_dbTable;
    }

    public function find($bon_neutre_tiers_id, Application_Model_EuBonNeutreTiers $bon_neutre_tiers) {
        $result = $this->getDbTable()->find($bon_neutre_tiers_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_neutre_tiers->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_tiers_apporteur($row->bon_neutre_tiers_apporteur)
                ->setBon_neutre_tiers_montant($row->bon_neutre_tiers_montant)
                ->setBon_neutre_tiers_beneficiaire($row->bon_neutre_tiers_beneficiaire)
                ->setBon_neutre_tiers_date($row->bon_neutre_tiers_date)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("bon_neutre_tiers_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreTiers();
            $entry->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
	                ->setBon_neutre_tiers_apporteur($row->bon_neutre_tiers_apporteur)
                    ->setBon_neutre_tiers_montant($row->bon_neutre_tiers_montant)
                    ->setBon_neutre_tiers_beneficiaire($row->bon_neutre_tiers_beneficiaire)
                ->setBon_neutre_tiers_date($row->bon_neutre_tiers_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_neutre_tiers_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBonNeutreTiers $bon_neutre_tiers) {
        $data = array(
            'bon_neutre_tiers_id' => $bon_neutre_tiers->getBon_neutre_tiers_id(),
            'bon_neutre_tiers_apporteur' => $bon_neutre_tiers->getBon_neutre_tiers_apporteur(),
            'bon_neutre_tiers_montant' => $bon_neutre_tiers->getBon_neutre_tiers_montant(),
            'bon_neutre_tiers_beneficiaire' => $bon_neutre_tiers->getBon_neutre_tiers_beneficiaire(),
            'bon_neutre_tiers_date' => $bon_neutre_tiers->getBon_neutre_tiers_date()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonNeutreTiers $bon_neutre_tiers) {
        $data = array(
            'bon_neutre_tiers_id' => $bon_neutre_tiers->getBon_neutre_tiers_id(),
            'bon_neutre_tiers_apporteur' => $bon_neutre_tiers->getBon_neutre_tiers_apporteur(),
            'bon_neutre_tiers_montant' => $bon_neutre_tiers->getBon_neutre_tiers_montant(),
            'bon_neutre_tiers_beneficiaire' => $bon_neutre_tiers->getBon_neutre_tiers_beneficiaire(),
            'bon_neutre_tiers_date' => $bon_neutre_tiers->getBon_neutre_tiers_date()
        );
        $this->getDbTable()->update($data, array('bon_neutre_tiers_id = ?' => $bon_neutre_tiers->getBon_neutre_tiers_id()));
    }

    public function delete($bon_neutre_tiers_id) {
        $this->getDbTable()->delete(array('bon_neutre_tiers_id = ?' => $bon_neutre_tiers_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->order("bon_neutre_tiers_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreTiers();
            $entry->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
	                ->setBon_neutre_tiers_apporteur($row->bon_neutre_tiers_apporteur)
                    ->setBon_neutre_tiers_montant($row->bon_neutre_tiers_montant)
                    ->setBon_neutre_tiers_beneficiaire($row->bon_neutre_tiers_beneficiaire)
                ->setBon_neutre_tiers_date($row->bon_neutre_tiers_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByBeneficiaire($bon_neutre_tiers_beneficiaire) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_tiers_beneficiaire = ? ", $bon_neutre_tiers_beneficiaire);
		$select->order("bon_neutre_tiers_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreTiers();
            $entry->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
	                ->setBon_neutre_tiers_apporteur($row->bon_neutre_tiers_apporteur)
                    ->setBon_neutre_tiers_montant($row->bon_neutre_tiers_montant)
                    ->setBon_neutre_tiers_beneficiaire($row->bon_neutre_tiers_beneficiaire)
                ->setBon_neutre_tiers_date($row->bon_neutre_tiers_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByApporteur($bon_neutre_tiers_apporteur) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_tiers_apporteur = ? ", $bon_neutre_tiers_apporteur);
		$select->order("bon_neutre_tiers_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreTiers();
            $entry->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
	                ->setBon_neutre_tiers_apporteur($row->bon_neutre_tiers_apporteur)
                    ->setBon_neutre_tiers_montant($row->bon_neutre_tiers_montant)
                    ->setBon_neutre_tiers_beneficiaire($row->bon_neutre_tiers_beneficiaire)
                ->setBon_neutre_tiers_date($row->bon_neutre_tiers_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByBonNeutre($bon_neutre_id) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_tiers_id IN (SELECT bon_neutre_tiers_id FROM eu_bon_neutre WHERE bon_neutre_id = ? )", $bon_neutre_id);
		$select->order("bon_neutre_tiers_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreTiers();
            $entry->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
	                ->setBon_neutre_tiers_apporteur($row->bon_neutre_tiers_apporteur)
                    ->setBon_neutre_tiers_montant($row->bon_neutre_tiers_montant)
                    ->setBon_neutre_tiers_beneficiaire($row->bon_neutre_tiers_beneficiaire)
                ->setBon_neutre_tiers_date($row->bon_neutre_tiers_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
