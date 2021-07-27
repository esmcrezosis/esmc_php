<?php
class Application_Model_EuTypeNnMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuTypeNn');
        }
        return $this->_dbTable;
    }
	
	
	
	public function find($code_type_nn, Application_Model_EuTypeNn $typenn) {
       $result = $this->getDbTable()->find($code_type_nn);
       if (0 == count($result)) {
           return;
       }
        $row = $result->current();
        $typenn->setCode_type_nn($row->code_type_nn)
               ->setLib_type_nn($row->lib_type_nn)
               ->setDesc_type_nn($row->desc_type_nn)
	    ;
    }
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuTypeNn();
           $entry->setCode_type_nn($row->code_type_nn)
                   ->setLib_type_nn($row->lib_type_nn)
               		->setDesc_type_nn($row->desc_type_nn);
           $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuTypeNn $typenn) {
        $data = array(
            'code_type_nn' => $typenn->getCode_type_nn(),
            'lib_type_nn' => $typenn->getLib_type_nn(),
            'desc_type_nn' => $typenn->getDesc_type_nn()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeNn $typenn) {
        $data = array(
            'code_type_nn' => $typenn->getCode_type_nn(),
            'lib_type_nn' => $typenn->getLib_type_nn(),
            'desc_type_nn' => $typenn->getDesc_type_nn()
        );
        $this->getDbTable()->update($data, array('code_type_nn = ?' => $typenn->getCode_type_nn()));
    }

    public function delete($code_type_nn) {
       $this->getDbTable()->delete(array('code_type_nn = ?' => $code_type_nn));
    }
	
	
	
	
	
	
}	
	
	
	
	
?>	
	
	
	
	
	
	
	
	
	