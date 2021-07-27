<?php
 
class Application_Model_EuBonDetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonDetail');
        }
        return $this->_dbTable;
    }

    public function find($bon_detail_id, Application_Model_EuBonDetail $bon_detail) {
        $result = $this->getDbTable()->find($bon_detail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_detail->setBon_detail_id($row->bon_detail_id)
                ->setBon_detail_libelle($row->bon_detail_libelle)
                ->setBon_detail_quantite($row->bon_detail_quantite)
                ->setBon_detail_reference($row->bon_detail_reference)
                ->setBon_id($row->bon_id)
                ->setBon_detail_prix_unitaire($row->bon_detail_prix_unitaire)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("bon_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonDetail();
            $entry->setBon_detail_id($row->bon_detail_id)
	                ->setBon_detail_libelle($row->bon_detail_libelle)
                    ->setBon_detail_quantite($row->bon_detail_quantite)
                    ->setBon_detail_reference($row->bon_detail_reference)
	                ->setBon_id($row->bon_id)
					->setBon_detail_prix_unitaire($row->bon_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_detail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBonDetail $bon_detail) {
        $data = array(
            'bon_detail_id' => $bon_detail->getBon_detail_id(),
            'bon_detail_libelle' => $bon_detail->getBon_detail_libelle(),
            'bon_detail_quantite' => $bon_detail->getBon_detail_quantite(),
            'bon_detail_reference' => $bon_detail->getBon_detail_reference(),
            'bon_id' => $bon_detail->getBon_id(),
            'bon_detail_prix_unitaire' => $bon_detail->getBon_detail_prix_unitaire()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonDetail $bon_detail) {
        $data = array(
            'bon_detail_id' => $bon_detail->getBon_detail_id(),
            'bon_detail_libelle' => $bon_detail->getBon_detail_libelle(),
            'bon_detail_quantite' => $bon_detail->getBon_detail_quantite(),
            'bon_detail_reference' => $bon_detail->getBon_detail_reference(),
            'bon_id' => $bon_detail->getBon_id(),
            'bon_detail_prix_unitaire' => $bon_detail->getBon_detail_prix_unitaire()
        );
        $this->getDbTable()->update($data, array('bon_detail_id = ?' => $bon_detail->getBon_detail_id()));
    }

    public function delete($bon_detail_id) {
        $this->getDbTable()->delete(array('bon_detail_id = ?' => $bon_detail_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->order("bon_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonDetail();
            $entry->setBon_detail_id($row->bon_detail_id)
	                ->setBon_detail_libelle($row->bon_detail_libelle)
                    ->setBon_detail_quantite($row->bon_detail_quantite)
                    ->setBon_detail_reference($row->bon_detail_reference)
	                ->setBon_id($row->bon_id)
					->setBon_detail_prix_unitaire($row->bon_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("bon_id = ? ", $type);
		$select->order("bon_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonDetail();
            $entry->setBon_detail_id($row->bon_detail_id)
	                ->setBon_detail_libelle($row->bon_detail_libelle)
                    ->setBon_detail_quantite($row->bon_detail_quantite)
                    ->setBon_detail_reference($row->bon_detail_reference)
	                ->setBon_id($row->bon_id)
					->setBon_detail_prix_unitaire($row->bon_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("bon_detail_id != ? ", $id);
		$select->order("bon_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonDetail();
            $entry->setBon_detail_id($row->bon_detail_id)
	                ->setBon_detail_libelle($row->bon_detail_libelle)
                    ->setBon_detail_quantite($row->bon_detail_quantite)
                    ->setBon_detail_reference($row->bon_detail_reference)
	                ->setBon_id($row->bon_id)
					->setBon_detail_prix_unitaire($row->bon_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
