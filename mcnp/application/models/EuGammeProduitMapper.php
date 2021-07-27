<?php

class Application_Model_EuGammeProduitMapper
{
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
            $this->setDbTable('Application_Model_DbTable_EuGammeProduit');
        }
        return $this->_dbTable;
    }
    public function find($code_gamme, Application_Model_EuGammeProduit $gamme) {
        $result = $this->getDbTable()->find($code_gamme);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $gamme->setCode_gamme($row->code_gamme)
              ->setDesign_gamme($row->design_gamme)
              ->setMembre($row->membre);
    }
    
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGammeProduit();
            $entry->setCode_gamme($row->code_gamme);
            $entry->setDesign_gamme($row->design_gamme);
            $entry->setMembre($row->membre);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function save(Application_Model_EuGammeProduit $gamme) {
        $data = array(
            'code_gamme' => $gamme->getCode_gamme(),
            'design_gamme' => $gamme->getDesign_gamme(),
            'membre' => $gamme->getMembre()
        );
        $this->getDbTable()->insert($data);
    }
    
     public function update(Application_Model_EuGammeProduit $gamme) {
        $data = array(
            'code_gamme' => $gamme->getCode_gamme(),
            'design_gamme' => $gamme->getDesign_gamme(),
            'membre' => $gamme->getMembre()
        );

        $this->getDbTable()->update($data, array('code_gamme = ?' => $gamme->getCode_gamme()));
    }
    
     public function delete($code_gamme) {
        $this->getDbTable()->delete(array('code_gamme = ?' => $code_gamme));
    }
}
