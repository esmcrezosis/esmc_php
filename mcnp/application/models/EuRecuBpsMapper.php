<?php
 
class Application_Model_EuRecuBpsMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRecuBps');
        }
        return $this->_dbTable;
    }

    public function find($recu_bps_id, Application_Model_EuRecuBps $recu_bps) {
        $result = $this->getDbTable()->find($recu_bps_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $recu_bps->setRecu_bps_id($row->recu_bps_id)
                ->setRecu_bps_libelle($row->recu_bps_libelle)
	                ->setZppe_id($row->zppe_id)
                ->setRecu_bps_prk($row->recu_bps_prk)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("recu_bps_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecuBps();
            $entry->setRecu_bps_id($row->recu_bps_id)
	                ->setRecu_bps_libelle($row->recu_bps_libelle)
	                ->setZppe_id($row->zppe_id)
                ->setRecu_bps_prk($row->recu_bps_prk)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(recu_bps_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRecuBps $recu_bps) {
        $data = array(
            'recu_bps_id' => $recu_bps->getRecu_bps_id(),
            'recu_bps_libelle' => $recu_bps->getRecu_bps_libelle(),
            'recu_bps_prk' => $recu_bps->getRecu_bps_prk(),
            'zppe_id' => $recu_bps->getZppe_id()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRecuBps $recu_bps) {
        $data = array(
            'recu_bps_id' => $recu_bps->getRecu_bps_id(),
            'recu_bps_libelle' => $recu_bps->getRecu_bps_libelle(),
            'recu_bps_prk' => $recu_bps->getRecu_bps_prk(),
            'zppe_id' => $recu_bps->getZppe_id()
        );
        $this->getDbTable()->update($data, array('recu_bps_id = ?' => $recu_bps->getRecu_bps_id()));
    }

    public function delete($recu_bps_id) {
        $this->getDbTable()->delete(array('recu_bps_id = ?' => $recu_bps_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->order("recu_bps_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecuBps();
            $entry->setRecu_bps_id($row->recu_bps_id)
	                ->setRecu_bps_libelle($row->recu_bps_libelle)
	                ->setZppe_id($row->zppe_id)
                ->setRecu_bps_prk($row->recu_bps_prk)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("zppe_id = ? ", $type);
		$select->order("recu_bps_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecuBps();
            $entry->setRecu_bps_id($row->recu_bps_id)
	                ->setRecu_bps_libelle($row->recu_bps_libelle)
	                ->setZppe_id($row->zppe_id)
                ->setRecu_bps_prk($row->recu_bps_prk)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("recu_bps_id != ? ", $id);
		$select->order("recu_bps_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecuBps();
            $entry->setRecu_bps_id($row->recu_bps_id)
	                ->setRecu_bps_libelle($row->recu_bps_libelle)
	                ->setZppe_id($row->zppe_id)
                ->setRecu_bps_prk($row->recu_bps_prk)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
