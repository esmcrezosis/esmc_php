<?php
class Application_Model_EuTypeMfMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuTypeMf');
        }
        return $this->_dbTable;
    }
	
	
	
	public function find($code_type_mf, Application_Model_EuTypeMf $typemf) {
       $result = $this->getDbTable()->find($code_type_mf);
       if (0 == count($result)) {
           return;
       }
        $row = $result->current();
        $typemf->setCode_type_mf($row->code_type_mf)
               ->setNom_acteur($row->lib_type_mf)
	    ;
    }
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuTypeMf();
           $entry->setCode_type_mf($row->code_type_mf)
                   ->setLib_type_mf($row->lib_type_mf);
           $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuTypeMf $typemf) {
        $data = array(
            'code_type_mf' => $typemf->getCode_type_mf(),
            'lib_type_mf' => $typemf->getLib_type_mf()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeMf $typemf) {
        $data = array(
            'code_type_mf' => $typemf->getCode_type_mf(),
            'lib_type_mf' => $typemf->getLib_type_mf()
        );
        $this->getDbTable()->update($data, array('code_type_mf = ?' => $typemf->getCode_type_mf()));
    }

    public function delete($code_type_mf) {
       $this->getDbTable()->delete(array('code_type_mf = ?' => $code_type_mf));
    }
	
	
	
	
	
	
}	
	
	
	
	
?>	
	
	
	
	
	
	
	
	
	