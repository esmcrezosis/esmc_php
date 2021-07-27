<?php

class Application_Model_EuPrefectureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPrefecture');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPrefecture $prefecture) {
        $data = array(
            'id_prefecture' => $prefecture->getId_prefecture(),
            'nom_prefecture' => $prefecture->getNom_prefecture(),
            'id_region' => $prefecture->getId_region()
        );
        $this->getDbTable()->insert($data);
    }
	
    public function update(Application_Model_EuPrefecture $prefecture) {
        $data = array(
          'id_prefecture' => $prefecture->getId_prefecture(),
          'nom_prefecture' => $prefecture->getNom_prefecture(),
          'id_region' => $prefecture->getId_region()   
        );

        $this->getDbTable()->update($data, array('id_prefecture = ?' => $prefecture->getId_prefecture()));
    }
	
	
    public function find($id_prefecture, Application_Model_EuPrefecture $prefecture) {
        $result = $this->getDbTable()->find($id_prefecture);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $prefecture->setId_prefecture($row->id_prefecture)
                   ->setNom_prefecture($row->nom_prefecture)
                   ->setId_region($row->id_region);
               
    }
	
	
	public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_prefecture) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPrefecture();
            $entry->setId_prefecture($row->id_prefecture);
            $entry->setNom_prefecture($row->nom_prefecture);
            $entry->setId_region($row->id_region);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function delete($id_prefecture) {
        $this->getDbTable()->delete(array('id_prefecture = ?' => $id_prefecture));
    }
	
}


