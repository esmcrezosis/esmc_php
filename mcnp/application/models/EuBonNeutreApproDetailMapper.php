<?php
 
class Application_Model_EuBonNeutreApproDetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonNeutreApproDetail');
        }
        return $this->_dbTable;
    }

    public function find($bon_neutre_detail_id, Application_Model_EuBonNeutreApproDetail $bon_neutre_appro_detail) {
        $result = $this->getDbTable()->find($bon_neutre_detail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_neutre_appro_detail->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_appro_detail_montant($row->bon_neutre_appro_detail_montant)
                ->setBon_neutre_appro_detail_banque($row->bon_neutre_appro_detail_banque)
                ->setBon_neutre_appro_detail_date($row->bon_neutre_appro_detail_date)
                ->setBon_neutre_appro_detail_mont_utilise($row->bon_neutre_appro_detail_mont_utilise)
                ->setBon_neutre_appro_detail_solde($row->bon_neutre_appro_detail_solde)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreApproDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_detail_montant($row->bon_neutre_appro_detail_montant)
                    ->setBon_neutre_appro_detail_banque($row->bon_neutre_appro_detail_banque)
                    ->setBon_neutre_appro_detail_date($row->bon_neutre_appro_detail_date)
					->setBon_neutre_appro_detail_mont_utilise($row->bon_neutre_appro_detail_mont_utilise)
                	->setBon_neutre_appro_detail_solde($row->bon_neutre_appro_detail_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_neutre_detail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBonNeutreApproDetail $bon_neutre_appro_detail) {
        $data = array(
            'bon_neutre_detail_id' => $bon_neutre_appro_detail->getBon_neutre_detail_id(),
            'bon_neutre_appro_id' => $bon_neutre_appro_detail->getBon_neutre_appro_id(),
            'bon_neutre_appro_detail_montant' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_montant(),
            'bon_neutre_appro_detail_banque' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_banque(),
            'bon_neutre_appro_detail_date' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_date(),
            'bon_neutre_appro_detail_mont_utilise' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_mont_utilise(),
            'bon_neutre_appro_detail_solde' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_solde()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonNeutreApproDetail $bon_neutre_appro_detail) {
        $data = array(
            'bon_neutre_detail_id' => $bon_neutre_appro_detail->getBon_neutre_detail_id(),
            'bon_neutre_appro_id' => $bon_neutre_appro_detail->getBon_neutre_appro_id(),
            'bon_neutre_appro_detail_montant' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_montant(),
            'bon_neutre_appro_detail_banque' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_banque(),
            'bon_neutre_appro_detail_date' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_date(),
            'bon_neutre_appro_detail_mont_utilise' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_mont_utilise(),
            'bon_neutre_appro_detail_solde' => $bon_neutre_appro_detail->getBon_neutre_appro_detail_solde()
        );
        $this->getDbTable()->update($data,array('bon_neutre_appro_id = ?' => $bon_neutre_appro_detail->getBon_neutre_appro_id(),'bon_neutre_detail_id = ?' => $bon_neutre_appro_detail->getBon_neutre_detail_id()));
    }

    public function delete($bon_neutre_detail_id) {
        $this->getDbTable()->delete(array('bon_neutre_detail_id = ?' => $bon_neutre_detail_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreApproDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_detail_montant($row->bon_neutre_appro_detail_montant)
                    ->setBon_neutre_appro_detail_banque($row->bon_neutre_appro_detail_banque)
                    ->setBon_neutre_appro_detail_date($row->bon_neutre_appro_detail_date)
					->setBon_neutre_appro_detail_mont_utilise($row->bon_neutre_appro_detail_mont_utilise)
                	->setBon_neutre_appro_detail_solde($row->bon_neutre_appro_detail_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByBanque($bon_neutre_appro_id) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_appro_id = ? ", $bon_neutre_appro_id);
		$result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBonNeutreApproDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                    ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_detail_montant($row->bon_neutre_appro_detail_montant)
                    ->setBon_neutre_appro_detail_banque($row->bon_neutre_appro_detail_banque)
                    ->setBon_neutre_appro_detail_date($row->bon_neutre_appro_detail_date)
                    ->setBon_neutre_appro_detail_mont_utilise($row->bon_neutre_appro_detail_mont_utilise)
                	->setBon_neutre_appro_detail_solde($row->bon_neutre_appro_detail_solde)
                ;
            $entries = $entry;
        return $entries;
    }

    
	   

public function findByApproDetail($bon_neutre_appro_id, $bon_neutre_detail_id, Application_Model_EuBonNeutreApproDetail $bon_neutre_appro_detail) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_appro_id = ? ", $bon_neutre_appro_id);
        $select->where("bon_neutre_detail_id = ? ", $bon_neutre_detail_id);
        $result = $this->getDbTable()->fetchRow($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result;
        $bon_neutre_appro_detail->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_appro_detail_montant($row->bon_neutre_appro_detail_montant)
                ->setBon_neutre_appro_detail_banque($row->bon_neutre_appro_detail_banque)
                ->setBon_neutre_appro_detail_date($row->bon_neutre_appro_detail_date)
                ->setBon_neutre_appro_detail_mont_utilise($row->bon_neutre_appro_detail_mont_utilise)
                ->setBon_neutre_appro_detail_solde($row->bon_neutre_appro_detail_solde)
                ;
        return true;
    }

    public function fetchAllByAppro($bon_neutre_appro_id) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_appro_id = ? ", $bon_neutre_appro_id);
        $select->order("bon_neutre_detail_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreApproDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                    ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_detail_montant($row->bon_neutre_appro_detail_montant)
                    ->setBon_neutre_appro_detail_banque($row->bon_neutre_appro_detail_banque)
                    ->setBon_neutre_appro_detail_date($row->bon_neutre_appro_detail_date)
                    ->setBon_neutre_appro_detail_mont_utilise($row->bon_neutre_appro_detail_mont_utilise)
                    ->setBon_neutre_appro_detail_solde($row->bon_neutre_appro_detail_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
