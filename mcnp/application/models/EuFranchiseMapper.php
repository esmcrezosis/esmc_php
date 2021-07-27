 <?php

class Application_Model_EuFranchiseMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFranchise');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_franchise, Application_Model_EuFranchise $franchise) {
       $result = $this->getDbTable()->find($id_franchise);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $franchise->setId_franchise($row->id_franchise)
           ->setType_franchise($row->type_franchise)
           ->setCreate_date($row->create_date)
           ->setRepresentant($row->representant)
		   ->setCode_membre_franchise($row->code_membre_franchise)
		   ;
	    return true;
	}
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFranchise();
            $entry->setId_franchise($row->id_franchise)
	           ->setType_franchise($row->type_franchise)
	           ->setCreate_date($row->create_date)
	           ->setRepresentant($row->representant)
			   ->setCode_membre_franchise($row->code_membre_franchise)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByMembreType($code_membre_franchise = "", $type_franchise = "") {
	    $select = $this->getDbTable()->select();
	    if($type_franchise != ""){
	    $select->where("type_franchise = ? ", $type_franchise);	    	
	    }
	    if($code_membre_franchise != ""){
	    $select->where("code_membre_franchise LIKE '".$code_membre_franchise."'");	    	
	    }
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuFranchise();
           $entry->setId_franchise($row->id_franchise)
	           ->setType_franchise($row->type_franchise)
	           ->setCreate_date($row->create_date)
	           ->setRepresentant($row->representant)
			   ->setCode_membre_franchise($row->code_membre_franchise)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuFranchise $franchise) {
        $data = array(
			'id_franchise' => $franchise->getId_franchise(),
			'type_franchise' => $franchise->getType_franchise(),
			'create_date' => $franchise->getCreate_date(),
			'representant' => $franchise->getRepresentant(),
			'code_membre_franchise' => $franchise->getCode_membre_franchise()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuFranchise $franchise) {
        $data = array(
			'id_franchise' => $franchise->getId_franchise(),
			'type_franchise' => $franchise->getType_franchise(),
			'create_date' => $franchise->getCreate_date(),
			'representant' => $franchise->getRepresentant(),
			'code_membre_franchise' => $franchise->getCode_membre_franchise()
        );
        $this->getDbTable()->update($data, array('id_franchise = ?' => $franchise->getId_franchise()));
    }
	

    public function delete($id_franchise) {
        $this->getDbTable()->delete(array('id_franchise = ?' => $id_franchise));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_franchise) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
