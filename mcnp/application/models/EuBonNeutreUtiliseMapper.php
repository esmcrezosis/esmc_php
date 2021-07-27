<?php
 
class Application_Model_EuBonNeutreUtiliseMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonNeutreUtilise');
        }
        return $this->_dbTable;
    }

    public function find($bon_neutre_utilise_id, Application_Model_EuBonNeutreUtilise $bon_neutre_utilise) {
        $result = $this->getDbTable()->find($bon_neutre_utilise_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_neutre_utilise->setBon_neutre_utilise_id($row->bon_neutre_utilise_id)
                ->setBon_neutre_utilise_libelle($row->bon_neutre_utilise_libelle)
                ->setBon_neutre_utilise_montant($row->bon_neutre_utilise_montant)
                ->setBon_neutre_utilise_type($row->bon_neutre_utilise_type)
                ->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_utilise_date($row->bon_neutre_utilise_date)
                ->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setUsertable($row->usertable)
                ->setUser_id($row->user_id)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $select->order("bon_neutre_utilise_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreUtilise();
            $entry->setBon_neutre_utilise_id($row->bon_neutre_utilise_id)
                    ->setBon_neutre_utilise_libelle($row->bon_neutre_utilise_libelle)
                    ->setBon_neutre_utilise_montant($row->bon_neutre_utilise_montant)
                    ->setBon_neutre_utilise_type($row->bon_neutre_utilise_type)
                    ->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_utilise_date($row->bon_neutre_utilise_date)
                ->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setUsertable($row->usertable)
                ->setUser_id($row->user_id)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_neutre_utilise_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBonNeutreUtilise $bon_neutre_utilise) {
        $data = array(
            'bon_neutre_utilise_id' => $bon_neutre_utilise->getBon_neutre_utilise_id(),
            'bon_neutre_utilise_libelle' => $bon_neutre_utilise->getBon_neutre_utilise_libelle(),
            'bon_neutre_utilise_montant' => $bon_neutre_utilise->getBon_neutre_utilise_montant(),
            'bon_neutre_utilise_type' => $bon_neutre_utilise->getBon_neutre_utilise_type(),
            'bon_neutre_utilise_date' => $bon_neutre_utilise->getBon_neutre_utilise_date(),
            'bon_neutre_detail_id' => $bon_neutre_utilise->getBon_neutre_detail_id(),
            'bon_neutre_id' => $bon_neutre_utilise->getBon_neutre_id(),
            'usertable' => $bon_neutre_utilise->getUsertable(),
            'user_id' => $bon_neutre_utilise->getUser_id()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonNeutreUtilise $bon_neutre_utilise) {
        $data = array(
            'bon_neutre_utilise_id' => $bon_neutre_utilise->getBon_neutre_utilise_id(),
            'bon_neutre_utilise_libelle' => $bon_neutre_utilise->getBon_neutre_utilise_libelle(),
            'bon_neutre_utilise_montant' => $bon_neutre_utilise->getBon_neutre_utilise_montant(),
            'bon_neutre_utilise_type' => $bon_neutre_utilise->getBon_neutre_utilise_type(),
            'bon_neutre_utilise_date' => $bon_neutre_utilise->getBon_neutre_utilise_date(),
            'bon_neutre_detail_id' => $bon_neutre_utilise->getBon_neutre_detail_id(),
            'bon_neutre_id' => $bon_neutre_utilise->getBon_neutre_id(),
            'usertable' => $bon_neutre_utilise->getUsertable(),
            'user_id' => $bon_neutre_utilise->getUser_id()
        );
        $this->getDbTable()->update($data, array('bon_neutre_utilise_id = ?' => $bon_neutre_utilise->getBon_neutre_utilise_id()));
    }

    public function delete($bon_neutre_utilise_id) {
        $this->getDbTable()->delete(array('bon_neutre_utilise_id = ?' => $bon_neutre_utilise_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
        $select->order("bon_neutre_utilise_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreUtilise();
            $entry->setBon_neutre_utilise_id($row->bon_neutre_utilise_id)
                    ->setBon_neutre_utilise_libelle($row->bon_neutre_utilise_libelle)
                    ->setBon_neutre_utilise_montant($row->bon_neutre_utilise_montant)
                    ->setBon_neutre_utilise_type($row->bon_neutre_utilise_type)
                    ->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_utilise_date($row->bon_neutre_utilise_date)
                ->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setUsertable($row->usertable)
                ->setUser_id($row->user_id)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByType($bon_neutre_utilise_type) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_utilise_type = ? ", $bon_neutre_utilise_type);
        $select->order("bon_neutre_utilise_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreUtilise();
            $entry->setBon_neutre_utilise_id($row->bon_neutre_utilise_id)
                    ->setBon_neutre_utilise_libelle($row->bon_neutre_utilise_libelle)
                    ->setBon_neutre_utilise_montant($row->bon_neutre_utilise_montant)
                    ->setBon_neutre_utilise_type($row->bon_neutre_utilise_type)
                    ->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_utilise_date($row->bon_neutre_utilise_date)
                ->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setUsertable($row->usertable)
                ->setUser_id($row->user_id)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByBonNeutre($bon_neutre_id) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_id = ? ", $bon_neutre_id);
        $select->order("bon_neutre_utilise_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreUtilise();
            $entry->setBon_neutre_utilise_id($row->bon_neutre_utilise_id)
                    ->setBon_neutre_utilise_libelle($row->bon_neutre_utilise_libelle)
                    ->setBon_neutre_utilise_montant($row->bon_neutre_utilise_montant)
                    ->setBon_neutre_utilise_type($row->bon_neutre_utilise_type)
                    ->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_utilise_date($row->bon_neutre_utilise_date)
                ->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setUsertable($row->usertable)
                ->setUser_id($row->user_id)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
}


?>
