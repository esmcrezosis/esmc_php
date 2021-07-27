<?php

class Application_Model_EuParametresMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuParametres');
        }
        return $this->_dbTable;
    }

    public function findConuterfs() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('COUNT(code_param) as count'))
                  ->where('code_param = ?','FS');
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];	   	
    }
    
    public function findConuterpck() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('COUNT(code_param) as count'))
                  ->where('code_param = ?','pck');
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];	   	
    }
    
    public function findConuterprk() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('COUNT(code_param) as count'))
                  ->where('code_param = ?','prk');
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];	   	
    }
    
    public function findConuterquota() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('COUNT(code_param) as count'))
                  ->where('code_param = ?','quota');
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];	   	
    }
    
    public function findConutersqmax() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('COUNT(code_param) as count'))
                  ->where('code_param = ?','sqmaxui');
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];	   	
    }
	
	public function findConuterperiode() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('COUNT(code_param) as count'))
                  ->where('code_param = ?','periode');
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
                    return $row['count'];	   	
    }
    
    public function find($code_param, $lib_param, Application_Model_EuParametres $param) {
        $result = $this->getDbTable()->find($code_param, $lib_param);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $param->setCode_param($row->code_param)
                    ->setLib_param($row->lib_param)
                    ->setMontant($row->montant);
            return true;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuParametres();
            $entry->setCode_param($row->code_param)
                    ->setLib_param($row->lib_param)
                    ->setMontant($row->montant);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuParametres $param) {
        $data = array(
            'code_param' => $param->getCode_param(),
            'lib_param' => $param->getLib_param(),
            'montant' => $param->getMontant()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuParametres $param) {
        $data = array(
            'code_param' => $param->getCode_param(),
            'lib_param' => $param->getLib_param(),
            'montant' => $param->getMontant()
        );

        $this->getDbTable()->update($data, array('code_param = ?' => $param->getCode_param(), 'lib_param = ?' => $param->getLib_param()));
    }

    public function delete($code_param, $lib_param) {
        $this->getDbTable()->delete(array('code_param = ?' => $code_param, 'lib_param = ?' => $lib_param));
    }

}

