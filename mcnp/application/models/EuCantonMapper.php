<?php

class Application_Model_EuCantonMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuCanton');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCanton $canton) {
        $data = array(
            'id_canton' => $canton->getId_canton(),
            'nom_canton' => $canton->getNom_canton(),
            'id_ville' => $canton->getId_ville(),
            'id_prefecture' => $canton->getId_prefecture()
        );
        $this->getDbTable()->insert($data);
    }
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_canton) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
    public function update(Application_Model_EuCanton $canton) {
        $data = array(
          'id_canton' => $canton->getId_canton(),
          'nom_canton' => $canton->getNom_canton(),
          'id_ville' => $canton->getId_ville(),
          'id_prefecture' => $canton->getId_prefecture()
        );

        $this->getDbTable()->update($data, array('id_canton = ?' => $canton->getId_canton()));
    }
	
    public function find($id_canton, Application_Model_EuCanton $canton) {
        $result = $this->getDbTable()->find($id_canton);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $canton->setId_canton($row->id_canton)
               ->setNom_canton($row->nom_canton)
               ->setId_ville($row->id_ville)
               ->setId_prefecture($row->id_prefecture);
		return true;	   
    }

	public function findAllCanton() {
        $select = $this->getDbTable()->select();
        $select->order('nom_canton asc');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return false;
        }
        $entries = array();
        foreach ($result as $row) {
          $entry = new Application_Model_EuCanton();
          $entry->setId_canton($row->id_canton);
          $entry->setNom_canton($row->nom_canton);
          $entry->setId_ville($row->id_ville);
          $entry->setId_prefecture($row->id_prefecture);
          $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCanton();
            $entry->setId_canton($row->id_canton);
            $entry->setNom_canton($row->nom_canton);
            $entry->setId_ville($row->id_ville);
            $entry->setId_prefecture($row->id_prefecture);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function delete($id_canton) {
        $this->getDbTable()->delete(array('id_canton = ?' => $id_canton));
    }
	
}


