<?php

class Application_Model_EuTypeCommissionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeCommission');
        }
        return $this->_dbTable;
    }

    public function find($id_type_commission, Application_Model_EuTypeCommission $commission) {
        $result = $this->getDbTable()->find($id_type_commission);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $commission->setId_type_commission($row->id_type_commission)
                ->setLibelle_type_commission($row->libelle_type_commission);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCommission();
            $entry->setId_type_commission($row->id_type_commission)
                    ->setLibelle_type_commission($row->libelle_type_commission);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeCommission $commission) {
        $data = array(
            'id_type_commission' => $commission->getId_type_commission(),
            'libelle_type_commission' => $commission->getLibelle_type_commission()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeCommission $commission) {
        $data = array(
            'id_type_commission' => $commission->getId_type_commission(),
            'libelle_type_commission' => $commission->getLibelle_type_commission()
        );
        $this->getDbTable()->update($data, array('id_type_commission = ?' => $commission->getId_type_commission()));
    }

    public function delete($id_type_commission) {
        $this->getDbTable()->delete(array('id_type_commission = ?' => $id_type_commission));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_commission) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAllByType($id_type_commission) {
        $select = $this->getDbTable()->select();
		$select->where("id_type_commission = ? ", $id_type_commission);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCommission();
            $entry->setId_type_commission($row->id_type_commission)
                    ->setLibelle_type_commission($row->libelle_type_commission);
            $entries[] = $entry;
        }
        return $entries;
    }
	


}
?>

