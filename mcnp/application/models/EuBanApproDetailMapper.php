<?php
 
class Application_Model_EuBanApproDetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBanApproDetail');
        }
        return $this->_dbTable;
    }

    public function find($ban_appro_detail_id, Application_Model_EuBanApproDetail $ban_appro_detail) {
        $result = $this->getDbTable()->find($ban_appro_detail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $ban_appro_detail->setBan_appro_detail_id($row->ban_appro_detail_id)
                ->setAssociation_id($row->association_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setMembreasso_id($row->membreasso_id)
                ->setBan_appro_detail_montant($row->ban_appro_detail_montant)
                ->setBan_appro_detail_commission($row->ban_appro_detail_commission)
                ->setBan_appro_detail_date($row->ban_appro_detail_date)
                ->setPayer($row->payer);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("ban_appro_detail_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanApproDetail();
            $entry->setBan_appro_detail_id($row->ban_appro_detail_id)
	                ->setAssociation_id($row->association_id)
                    ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setMembreasso_id($row->membreasso_id)
	                ->setBan_appro_detail_montant($row->ban_appro_detail_montant)
					->setBan_appro_detail_commission($row->ban_appro_detail_commission)
					->setBan_appro_detail_date($row->ban_appro_detail_date)
                	->setPayer($row->payer);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(ban_appro_detail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBanApproDetail $ban_appro_detail) {
        $data = array(
            'ban_appro_detail_id' => $ban_appro_detail->getBan_appro_detail_id(),
            'association_id' => $ban_appro_detail->getAssociation_id(),
            'bon_neutre_appro_id' => $ban_appro_detail->getBon_neutre_appro_id(),
            'membreasso_id' => $ban_appro_detail->getMembreasso_id(),
            'ban_appro_detail_montant' => $ban_appro_detail->getBan_appro_detail_montant(),
            'ban_appro_detail_commission' => $ban_appro_detail->getBan_appro_detail_commission(),
            'ban_appro_detail_date' => $ban_appro_detail->getBan_appro_detail_date(),
            'payer' => $ban_appro_detail->getPayer()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanApproDetail $ban_appro_detail) {
        $data = array(
            'ban_appro_detail_id' => $ban_appro_detail->getBan_appro_detail_id(),
            'association_id' => $ban_appro_detail->getAssociation_id(),
            'bon_neutre_appro_id' => $ban_appro_detail->getBon_neutre_appro_id(),
            'membreasso_id' => $ban_appro_detail->getMembreasso_id(),
            'ban_appro_detail_montant' => $ban_appro_detail->getBan_appro_detail_montant(),
            'ban_appro_detail_commission' => $ban_appro_detail->getBan_appro_detail_commission(),
            'ban_appro_detail_date' => $ban_appro_detail->getBan_appro_detail_date(),
            'payer' => $ban_appro_detail->getPayer()
        );
        $this->getDbTable()->update($data, array('ban_appro_detail_id = ?' => $ban_appro_detail->getBan_appro_detail_id()));
    }

    public function delete($ban_appro_detail_id) {
        $this->getDbTable()->delete(array('ban_appro_detail_id = ?' => $ban_appro_detail_id));
    }


    public function fetchAllByAssociation($association_id = 0) {
        $select = $this->getDbTable()->select();
        if($association_id > 0){
		$select->where("association_id = ? ", $association_id);
    }
		$select->order("ban_appro_detail_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanApproDetail();
            $entry->setBan_appro_detail_id($row->ban_appro_detail_id)
	                ->setAssociation_id($row->association_id)
                    ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setMembreasso_id($row->membreasso_id)
	                ->setBan_appro_detail_montant($row->ban_appro_detail_montant)
					->setBan_appro_detail_commission($row->ban_appro_detail_commission)
					->setBan_appro_detail_date($row->ban_appro_detail_date)
                	->setPayer($row->payer);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByMembreasso($membreasso_id = 0) {
        $select = $this->getDbTable()->select();
        if($membreasso_id > 0){
        $select->where("membreasso_id = ? ", $membreasso_id);
    }
        $select->order("ban_appro_detail_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanApproDetail();
            $entry->setBan_appro_detail_id($row->ban_appro_detail_id)
                    ->setAssociation_id($row->association_id)
                    ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setMembreasso_id($row->membreasso_id)
                    ->setBan_appro_detail_montant($row->ban_appro_detail_montant)
                    ->setBan_appro_detail_commission($row->ban_appro_detail_commission)
                    ->setBan_appro_detail_date($row->ban_appro_detail_date)
                    ->setPayer($row->payer);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
}


?>
