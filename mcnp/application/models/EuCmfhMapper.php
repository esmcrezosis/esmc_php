<?php

class Application_Model_EuCmfhMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCmfh');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_cmfh, Application_Model_EuCmfh $cmfh) {
        $result = $this->getDbTable()->find($id_cmfh);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $cmfh->setId_cmfh($row->id_cmfh)
             ->setDate_creation($row->date_creation)
             ->setId_type_candidat($row->id_type_candidat)
             ->setCode_membre($row->code_membre)
             ->setCode_zone_create($row->code_zone_create)
             ->setId_pays($row->id_pays)
             ->setId_region($row->id_region)
             ->setId_prefecture($row->id_prefecture)
             ->setId_canton($row->id_canton);
    }

	
    public function fetchAll()  {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCmfh();
            $entry->setId_cmfh($row->id_cmfh)
                  ->setDate_creation($row->date_creation)
                  ->setId_type_candidat($row->id_type_candidat)
                  ->setCode_membre($row->code_membre)
                  ->setCode_zone_create($row->code_zone_create)
                  ->setId_pays($row->id_pays)
                  ->setId_region($row->id_region)
                  ->setId_prefecture($row->id_prefecture)
                  ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findByCmfhAndCandidat($code_membre,$id_candidat)  {
	$table = new Application_Model_DbTable_EuCmfh();
	$select = $table->select();
	$select->where('code_membre = ?', $code_membre);
	$select->where('id_type_candidat = ?', $id_candidat);
	$resultSet = $table->fetchAll($select);
        if(0 == count($resultSet)) {
           return false;
        }
	$row = $resultSet->current();
        $entry = new Application_Model_EuCmfh();
        $entry->setId_cmfh($row->id_cmfh)
              ->setDate_creation($row->date_creation)
              ->setId_type_candidat($row->id_type_candidat)
              ->setCode_membre($row->code_membre)
              ->setCode_zone_create($row->code_zone_create)
              ->setId_pays($row->id_pays)
              ->setId_region($row->id_region)
              ->setId_prefecture($row->id_prefecture)
              ->setId_canton($row->id_canton);
        return $entry;
     }



	
    public function findByCmfh($code_membre) {
		$table = new Application_Model_DbTable_EuCmfh();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!="") {
           $select->where('code_membre = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if(0 == count($resultSet)) {
           return false;
        }
        $row = $resultSet->current();
        
        $entry = new Application_Model_EuCmfh();
        $entry->setId_cmfh($row->id_cmfh)
              ->setDate_creation($row->date_creation)
              ->setId_type_candidat($row->id_type_candidat)
              ->setCode_membre($row->code_membre)
              ->setCode_zone_create($row->code_zone_create)
              ->setId_pays($row->id_pays)
              ->setId_region($row->id_region)
              ->setId_prefecture($row->id_prefecture)
              ->setId_canton($row->id_canton);
       
        return $entry;
    }
	
	
	
	

    public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('COUNT(id_cmfh) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function save(Application_Model_EuCmfh $cmfh) {
        $data = array(
            'id_cmfh' => $cmfh->getId_cmfh(),
            'date_creation' => $cmfh->getDate_creation(),
            'code_membre' => $cmfh->getCode_membre(),
            'id_type_candidat' => $cmfh->getId_type_candidat(),
            'code_zone_create' => $cmfh->getCode_zone_create(),
            'id_pays' => $cmfh->getId_pays(),
            'id_region' => $cmfh->getId_region(),
            'id_prefecture' => $cmfh->getId_prefecture(),
            'id_canton' => $cmfh->getId_canton()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCmfh $cmfh) {
        $data = array(
            'id_cmfh' => $cmfh->getId_cmfh(),
            'date_creation' => $cmfh->getDate_creation(),
            'code_membre' => $cmfh->getCode_membre(),
            'id_type_candidat' => $cmfh->getId_type_candidat(),
            'code_zone_create' => $cmfh->getCode_zone_create(),
            'id_pays' => $cmfh->getId_pays(),
            'id_region' => $cmfh->getId_region(),
            'id_prefecture' => $cmfh->getId_prefecture(),
            'id_canton' => $cmfh->getId_canton()
        );
        $this->getDbTable()->update($data, array('id_cmfh = ?' => $cmfh->getId_cmfh()));
    }

    public function delete($id_cmfh) {
        $this->getDbTable()->delete(array('id_cmfh = ?' => $id_cmfh));
    }

}
