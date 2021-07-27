<?php

class Application_Model_EuObjetHorsMapper
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
            $this->setDbTable('Application_Model_DbTable_EuObjetHors');
        }
        return $this->_dbTable;
    }
    
    public function find($id_objet_hors, Application_Model_EuObjetHors $objethors) {
        $result = $this->getDbTable()->find($id_objet_hors);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $objethors->setId_objet_hors($row->id_objet_hors)
                  ->setId_besoin($row->id_besoin)
                  ->setDesign_objet_hors($row->design_objet_hors)
                  ->setQte_objet_hors($row->qte_objet_hors);
    }
    
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuObjetHors();
            $entry->setId_objet_hors($row->id_objet_hors);
            $entry->setId_besoin($row->id_besoin);
            $entry->setDesign_objet_hors($row->design_objet_hors);
            $entry->setQte_objet_hors($row->qte_objet_hors);
            $entries[] = $entry;
        }
        return $entries;
  }

  
    public function save(Application_Model_EuObjetHors $objethors) {
        $data = array(
            'id_objet_hors' => $objethors->getId_objet_hors(),
            'id_besoin' => $objethors->getId_besoin(),
            'design_objet_hors' => $objethors->getDesign_objet_hors(),
            'qte_objet_hors' => $objethors->getQte_objet_hors()
        );

        $this->getDbTable()->insert($data);
    }
    
    
     public function update(Application_Model_EuObjetHors $objethors) {
        $data = array(
            'id_objet_hors' => $objethors->getId_objet_hors(),
            'id_besoin' => $objethors->getId_besoin(),
            'design_objet_hors' => $objethors->getDesign_objet_hors(),
            'qte_objet_hors' => $objethors->getQte_objet_hors()
        );

        $this->getDbTable()->update($data, array('id_objet_hors = ?' => $objethors->getId_objet_hors()));
    }
    
    
     public function delete($id_objet_hors) {
        $this->getDbTable()->delete(array('id_objet_hors = ?' => $id_objet_hors));
    }
}


