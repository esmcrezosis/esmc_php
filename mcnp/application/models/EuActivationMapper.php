<?php
 
class Application_Model_EuActivationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuActivation');
        }
        return $this->_dbTable;
    }

    public function find($id_activation, Application_Model_EuActivation $activation) {
        $result = $this->getDbTable()->find($id_activation);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $activation->setId_activation($row->id_activation)
                   ->setId_depot($row->id_depot)
                   ->setDate_activation($row->date_activation)
                   ->setCode_activation($row->code_activation)
                   ->setCode_membre($row->code_membre)
				   ->setMembreasso_id($row->membreasso_id);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActivation();
            $entry->setId_activation($row->id_activation)
                  ->setId_depot($row->id_depot)
                  ->setDate_activation($row->date_activation)
                  ->setCode_activation($row->code_activation)
                  ->setCode_membre($row->code_membre)
				  ->setMembreasso_id($row->membreasso_id);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_activation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuActivation $activation) {
	    
        $data = array(
        'id_activation' => $activation->getId_activation(),
        'id_depot' => $activation->getId_depot(),
        'date_activation' => $activation->getDate_activation(),
        'code_activation' => $activation->getCode_activation(),
        'code_membre' => $activation->getCode_membre(),
		'membreasso_id' => $activation->getMembreasso_id()
		
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuActivation $activation) {
        $data = array(
        'id_activation' => $activation->getId_activation(),
        'id_depot' => $activation->getId_depot(),
        'date_activation' => $activation->getDate_activation(),
        'code_activation' => $activation->getCode_activation(),
        'code_membre' => $activation->getCode_membre(),
		'membreasso_id' => $activation->getMembreasso_id()
        );
        $this->getDbTable()->update($data, array('id_activation = ?' => $activation->getId_activation()));
    }

    public function delete($id_activation) {
        $this->getDbTable()->delete(array('id_activation = ?' => $id_activation));
    }



    public function fetchAllByMembreasso($membreasso_id = 0) {
        $select = $this->getDbTable()->select();
        if($membreasso_id > 0){
        $select->where("membreasso_id = ? ", $membreasso_id);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActivation();
            $entry->setId_activation($row->id_activation)
                  ->setId_depot($row->id_depot)
                  ->setDate_activation($row->date_activation)
                  ->setCode_activation($row->code_activation)
                  ->setCode_membre($row->code_membre)
                  ->setMembreasso_id($row->membreasso_id);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByAssociation($association_id = 0) {
        $select = $this->getDbTable()->select();
        if($association_id > 0){
        $select->where("membreasso_id IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association_id);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActivation();
            $entry->setId_activation($row->id_activation)
                  ->setId_depot($row->id_depot)
                  ->setDate_activation($row->date_activation)
                  ->setCode_activation($row->code_activation)
                  ->setCode_membre($row->code_membre)
                  ->setMembreasso_id($row->membreasso_id);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);
            }
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
            $entry = new Application_Model_EuActivation();
            $entry->setId_activation($row->id_activation)
                  ->setId_depot($row->id_depot)
                  ->setDate_activation($row->date_activation)
                  ->setCode_activation($row->code_activation)
                  ->setCode_membre($row->code_membre)
                  ->setMembreasso_id($row->membreasso_id);
         return $entry;
    }
  

}


?>
