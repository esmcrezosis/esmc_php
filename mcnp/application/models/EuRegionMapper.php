<?php

class Application_Model_EuRegionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRegion');
        }
        return $this->_dbTable;
    }

	
	
    public function save(Application_Model_EuRegion $region) {
        $data = array(
         'id_region' => $region->getId_region(),
         'nom_region' => $region->getNom_region(),
         'id_pays' => $region->getId_pays(),
	     'id_utilisateur' => $region->getId_utilisateur()	
        );
        $this->getDbTable()->insert($data);
    }
	
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_region) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
    public function update(Application_Model_EuRegion $region) {
        $data = array(
         'id_region' => $region->getId_region(),
         'nom_region' => $region->getNom_region(),
         'id_pays' => $region->getId_pays(),
	     'id_utilisateur' => $region->getId_utilisateur()   
        );
        $this->getDbTable()->update($data, array('id_region = ?' => $region->getId_region()));
    }
	
	
	
    public function find($id_region, Application_Model_EuRegion $region) {
        $result = $this->getDbTable()->find($id_region);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $region->setId_region($row->id_region)
               ->setNom_region($row->nom_region)
               ->setId_pays($row->id_pays)
			   ->setId_utilisateur($row->id_utilisateur); 
        return true;			   
    }

	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRegion();
            $entry->setId_region($row->id_region);
            $entry->setNom_region($row->nom_region);
            $entry->setId_pays($row->id_pays);
			$entry->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
    public function delete($id_region) {
        $this->getDbTable()->delete(array('id_region = ?' => $id_region));
    }
	
	
	
}


