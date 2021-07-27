<?php

class Application_Model_EuPvacquisitionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPvacquisition');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPvacquisition $pv) {
        $data = array(
          'id_pvacquisition' => $pv->getId_pvacquisition(),
	      'designation_pvacquisition' => $pv->getDesignation_pvacquisition(),
	      'date_pvacquisition' => $pv->getDate_pvacquisition(),
          'document_pv' => $pv->getDocument_pv(),
          'valider' => $pv->getValider(),
          'rejeter' => $pv->getRejeter(),
		  'classer' => $pv->getClasser()
		  
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPvacquisition $pv) {
        $data = array(
          'id_pvacquisition' => $pv->getId_pvacquisition(),
	      'designation_pvacquisition' => $pv->getDesignation_pvacquisition(),
	      'date_pvacquisition' => $pv->getDate_pvacquisition(),
          'document_pv' => $pv->getDocument_pv(),
          'valider' => $pv->getValider(),
          'rejeter' => $pv->getRejeter(),
		  'classer' => $pv->getClasser()
        );
        $this->getDbTable()->update($data, array('id_pvacquisition = ?' => $pv->getId_pvacquisition()));
    }
	
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_pvacquisition) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function find($id_pvacquisition, Application_Model_EuPvacquisition $pv) {
        $result = $this->getDbTable()->find($id_pvacquisition);
        if(count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $pv->setId_pvacquisition($row->id_pvacquisition)
		   ->setDesignation_pvacquisition($row->designation_pvacquisition)
		   ->setDate_pvacquisition($row->date_pvacquisition)
           ->setDocument_pv($row->document_pv)
           ->setValider($row->valider)
           ->setRejeter($row->rejeter)
		   ->setClasser($row->classer);
        return true;
    }
    

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuPvacquisition();
            $entry->setId_pvacquisition($row->id_pvacquisition)
		          ->setDesignation_pvacquisition($row->designation_pvacquisition)
		          ->setDate_pvacquisition($row->date_pvacquisition)
                  ->setDocument_pv($row->document_pv)
                  ->setValider($row->valider)
                  ->setRejeter($row->rejeter)
				  ->setClasser($row->classer);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function delete($id_pvacquisition) {
        $this->getDbTable()->delete(array('id_pvacquisition = ?' => $id_pvacquisition));
    }
	
}

