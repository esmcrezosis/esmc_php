
<?php
class Application_Model_EuUniteMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuUnite');
        }
        return $this->_dbTable;
    }
	
	
	
	public function find($id_unite, Application_Model_EuUnite $unite) {
       $result = $this->getDbTable()->find($code_unite);
       if (0 == count($result)) {
           return;
       }
       $row = $result->current();
       $unite->setCode_unite($row->code_unite)
               ->setLib_unite($row->lib_unite)
			   ->setDes_unite($row->des_unite)
	    ;
    }
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuUnite();
           $entry->setCode_unite($row->code_unite)
                 ->setLib_unite($row->lib_unite)
				 ->setDes_unite($row->des_unite);
           $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuUnite $unite) {
        $data = array(
            'code_unite' => $unite->getCode_unite(),
            'lib_unite' => $unite->getLib_unite(),
			'des_unite' => $unite->getDes_unite()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUnite $unite) {
        $data = array(
            'code_unite' => $unite->getCode_unite(),
            'lib_unite' => $unite->getLib_unite(),
			'des_unite' => $unite->getDes_unite()
        );
        $this->getDbTable()->update($data, array('code_unite = ?' => $unite->getCode_unite()));
    }

    public function delete($code_unite) {
       $this->getDbTable()->delete(array('code_unite = ?' => $code_unite));
    }
	
	
	
	
	
	
}	
	
	
	
	
?>	
	
	
	
	
	
	
	
	
	