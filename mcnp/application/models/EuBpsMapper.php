<?php
 
class Application_Model_EuBpsMapper {
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
            $this->setDbTable('Application_Model_DbTable_EuBps');
        }
        return $this->_dbTable;
    }
	

    public function find($id_bps,Application_Model_EuBps $bps) {
        $result = $this->getDbTable()->find($id_bps);
        if (count($result) == 0) {
           return false;
        }
        $row = $result->current();
        $bps->setId_bps($row->id_bps)
            ->setDesignation($row->designation)
            ->setType_souscription($row->type_souscription)
            ->setValeur_parametre($row->valeur_parametre);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBps();
            $entry->setId_bps($row->id_bps)
                  ->setDesignation($row->designation)
                  ->setType_souscription($row->type_souscription)
                  ->setValeur_parametre($row->valeur_parametre);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_bps) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuBps $bps) { 
        $data = array(
          'id_bps' => $bps->getId_bps(),
          'designation' => $bps->getDesignation(),
          'type_souscription' => $bps->getType_souscription(),
          'valeur_parametre' => $bps->getValeur_parametre()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBps $bps) {
        $data = array(
        'id_bps' => $bps->getId_bps(),
        'designation' => $bps->getDesignation(),
        'type_souscription' => $bps->getType_souscription(),
        'valeur_parametre' => $bps->getValeur_parametre()
        );
        $this->getDbTable()->update($data, array('id_bps = ?' => $bps->getId_bps()));
    }

    public function delete($id_bps) {
        $this->getDbTable()->delete(array('id_bps = ?' => $id_bps));
    }

}


?>
