<?php

class Application_Model_EuMembreDoublonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMembreDoublon');
        }
        return $this->_dbTable;
    }

    public function find($membre_doublon_id, Application_Model_EuMembreDoublon $membre_doublon) {
        $result = $this->getDbTable()->find($membre_doublon_id);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $membre_doublon->setMembre_doublon_id($row->membre_doublon_id)
                ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
				->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
				->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
				;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreDoublon();
            $entry->setMembre_doublon_id($row->membre_doublon_id)
                    ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
				->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
				->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
				;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuMembreDoublon $membre_doublon) {
        $data = array(
            'membre_doublon_id' => $membre_doublon->getMembre_doublon_id(),
            'membre_doublon_code_membre1' => $membre_doublon->getMembre_doublon_code_membre1(),
            'membre_doublon_code_membre2' => $membre_doublon->getMembre_doublon_code_membre2(),
            'membre_doublon_etat' => $membre_doublon->getMembre_doublon_etat(),
            'membre_doublon_date' => $membre_doublon->getMembre_doublon_date(),
            'membreasso_id' => $membre_doublon->getMembreasso_id()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembreDoublon $membre_doublon) {
        $data = array(
            'membre_doublon_id' => $membre_doublon->getMembre_doublon_id(),
            'membre_doublon_code_membre1' => $membre_doublon->getMembre_doublon_code_membre1(),
            'membre_doublon_code_membre2' => $membre_doublon->getMembre_doublon_code_membre2(),
            'membre_doublon_etat' => $membre_doublon->getMembre_doublon_etat(),
            'membre_doublon_date' => $membre_doublon->getMembre_doublon_date(),
            'membreasso_id' => $membre_doublon->getMembreasso_id()
        );
        $this->getDbTable()->update($data, array('membre_doublon_id = ?' => $membre_doublon->getMembre_doublon_id()));
    }

    public function delete($membre_doublon_id) {
        $this->getDbTable()->delete(array('membre_doublon_id = ?' => $membre_doublon_id));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(membre_doublon_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAllByMembre1($membre_doublon_code_membre1) {
        $select = $this->getDbTable()->select();
		$select->where("membre_doublon_code_membre1 = ? ", $membre_doublon_code_membre1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreDoublon();
            $entry->setMembre_doublon_id($row->membre_doublon_id)
                    ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
				->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
				->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByMembre2($membre_doublon_code_membre2) {
        $select = $this->getDbTable()->select();
		$select->where("membre_doublon_code_membre2 = ? ", $membre_doublon_code_membre2);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreDoublon();
            $entry->setMembre_doublon_id($row->membre_doublon_id)
                    ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
				->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
				->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	

	public function fetchAllByMembre1Membre2($membre_doublon_code_membre1, $membre_doublon_code_membre2) {
        $select = $this->getDbTable()->select();
		$select->where("membre_doublon_code_membre1 = ? ", $membre_doublon_code_membre1);
		$select->where("membre_doublon_code_membre2 = ? ", $membre_doublon_code_membre2);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
            $entry = new Application_Model_EuMembreDoublon();
            $entry->setMembre_doublon_id($row->membre_doublon_id)
                    ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
				->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
				->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
				;		
         return $entry;
    }


    public function fetchAllByEtat($membre_doublon_etat) {
        $select = $this->getDbTable()->select();
		$select->where("membre_doublon_etat = ? ", $membre_doublon_etat);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreDoublon();
            $entry->setMembre_doublon_id($row->membre_doublon_id)
                    ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
				->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
				->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByAll() {
        $select = $this->getDbTable()->select();
        //$select->where("membre_doublon_etat = ? ", $membre_doublon_etat);
        $select->order(array('membre_doublon_id DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreDoublon();
            $entry->setMembre_doublon_id($row->membre_doublon_id)
                    ->setMembre_doublon_code_membre1($row->membre_doublon_code_membre1)
                ->setMembre_doublon_code_membre2($row->membre_doublon_code_membre2)
                ->setMembre_doublon_etat($row->membre_doublon_etat)
                ->setMembreasso_id($row->membreasso_id)
                ->setMembre_doublon_date($row->membre_doublon_date)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

}
?>

