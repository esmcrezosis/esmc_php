<?php

class Application_Model_EuProcurationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProcuration');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuProcuration $procuration) {
        $data = array(
            'id_procuration' => $procuration->getId_procuration(),
            'code_membre_mandant' => $procuration->getCode_membre_mandant(),
            'code_membre_mandataire' => $procuration->getCode_membre_mandataire(),
            'date_procuration' => $procuration->getDate_procuration(),
            'activer' => $procuration->getActiver()
        );
        $this->getDbTable()->insert($data);
    }
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_procuration) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function update(Application_Model_EuProcuration $procuration) {
        $data = array(
            'id_procuration' => $procuration->getId_procuration(),
            'code_membre_mandant' => $procuration->getCode_membre_mandant(),
            'code_membre_mandataire' => $procuration->getCode_membre_mandataire(),
            'date_procuration' => $procuration->getDate_procuration(),
			'activer' => $procuration->getActiver()
        );
        $this->getDbTable()->update($data, array('id_procuration = ?' => $procuration->getId_procuration()));
    }
	
    public function find($id_procuration, Application_Model_EuProcuration $procuration) {
        $result = $this->getDbTable()->find($id_procuration);
		
        if(0 == count($result)) {
           return;
        }
		
        $row = $result->current();
        $procuration->setId_procuration($row->id_procuration)
                    ->setCode_membre_mandant($row->code_membre_mandant)
                    ->setCode_membre_mandataire($row->code_membre_mandataire)
                    ->setDate_procuration($row->date_procuration)
			        ->setActiver($row->activer);   
     }

     public function fetchAll()  {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuProcuration();
          $entry->setId_procuration($row->id_procuration);
          $entry->setCode_membre_mandant($row->code_membre_mandant);
          $entry->setCode_membre_mandataire($row->code_membre_mandataire);
          $entry->setDate_procuration($row->date_procuration);
	      $entry->setActiver($row->activer);
          $entries[] = $entry;
        }
        return $entries;
     }
	 
	 
	 public function fetchByProcuration($code_membre_mandant,$code_membre_mandataire)   {
		$table = new Application_Model_DbTable_EuProcuration();
        $select = $table->select();
        $select->where('code_membre_mandant LIKE ?', $code_membre_mandant)
               ->where('code_membre_mandataire LIKE ?', $code_membre_mandataire);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
          return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuProcuration();
        $entry->setId_procuration($row->id_procuration)
		      ->setCode_membre_mandant($row->code_membre_mandant)
			  ->setCode_membre_mandataire($row->code_mandataire)
              ->setDate_procuration($row->date_procuration)
			  ->setActiver($row->activer);
        return $entry; 
	 }
	 
	 public function fetchAllProcurationDesactiver($id_procuration) {
		$table = new Application_Model_DbTable_EuProcuration();
        $select = $table->select();
        $select->where('id_procuration <> ?', $id_procuration);		
		 
		$resultSet = $table->fetchAll($select);
        if(count($result) == 0) {
          return NULL;
        }
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuProcuration();
          $entry->setId_procuration($row->id_procuration);
          $entry->setCode_membre_mandant($row->code_membre_mandant);
          $entry->setCode_membre_mandataire($row->code_membre_mandataire);
          $entry->setDate_procuration($row->date_procuration);
	      $entry->setActiver($row->activer);
          $entries[] = $entry;
        }
        return $entries;
	 }
	
     public function delete($id_procuration) {
        $this->getDbTable()->delete(array('id_procuration = ?' => $id_procuration));
     }
	
}


