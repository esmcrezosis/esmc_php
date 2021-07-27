<?php
 
class Application_Model_EuQuittanceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQuittance');
        }
        return $this->_dbTable;
    }

    public function find($quittance_id, Application_Model_EuQuittance $quittance) {
        $result = $this->getDbTable()->find($quittance_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $quittance->setQuittance_id($row->quittance_id)
                ->setQuittance_nom($row->quittance_nom)
                ->setQuittance_code($row->quittance_code)
                ->setQuittance_numero($row->quittance_numero)
                ->setQuittance_banque($row->quittance_banque)
                ->setQuittance_date($row->quittance_date)
                ->setQuittance_type($row->quittance_type)
                ->setQuittance_cel($row->quittance_cel)
                ->setQuittance_candidat($row->quittance_candidat)
                ->setQuittance_code_membre($row->quittance_code_membre)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuittance();
            $entry->setQuittance_id($row->quittance_id)
	                ->setQuittance_nom($row->quittance_nom)
                ->setQuittance_code($row->quittance_code)
                ->setQuittance_numero($row->quittance_numero)
                ->setQuittance_banque($row->quittance_banque)
                ->setQuittance_date($row->quittance_date)
                ->setQuittance_type($row->quittance_type)
                ->setQuittance_cel($row->quittance_cel)
                ->setQuittance_candidat($row->quittance_candidat)
                ->setQuittance_code_membre($row->quittance_code_membre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(quittance_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuQuittance $quittance) {
        $data = array(
            'quittance_id' => $quittance->getQuittance_id(),
            'quittance_nom' => $quittance->getQuittance_nom(),
            'quittance_code' => $quittance->getQuittance_code(),
            'quittance_numero' => $quittance->getQuittance_numero(),
            'quittance_banque' => $quittance->getQuittance_banque(),
            'quittance_date' => $quittance->getQuittance_date(),
            'quittance_type' => $quittance->getQuittance_type(),
            'quittance_cel' => $quittance->getQuittance_cel(),
            'quittance_candidat' => $quittance->getQuittance_candidat(),
            'quittance_code_membre' => $quittance->getQuittance_code_membre(),
            'publier' => $quittance->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuQuittance $quittance) {
        $data = array(
            'quittance_nom' => $quittance->getQuittance_nom(),
            'quittance_code' => $quittance->getQuittance_code(),
            'quittance_numero' => $quittance->getQuittance_numero(),
            'quittance_banque' => $quittance->getQuittance_banque(),
            'quittance_date' => $quittance->getQuittance_date(),
            'quittance_type' => $quittance->getQuittance_type(),
            'quittance_cel' => $quittance->getQuittance_cel(),
            'quittance_candidat' => $quittance->getQuittance_candidat(),
            'quittance_code_membre' => $quittance->getQuittance_code_membre(),
            'publier' => $quittance->getPublier()
        );
        $this->getDbTable()->update($data, array('quittance_id = ?' => $quittance->getQuittance_id()));
    }

    public function delete($quittance_id) {
        $this->getDbTable()->delete(array('quittance_id = ?' => $quittance_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuittance();
            $entry->setQuittance_id($row->quittance_id)
	                ->setQuittance_nom($row->quittance_nom)
                ->setQuittance_code($row->quittance_code)
                ->setQuittance_numero($row->quittance_numero)
                ->setQuittance_banque($row->quittance_banque)
                ->setQuittance_date($row->quittance_date)
                ->setQuittance_type($row->quittance_type)
                ->setQuittance_cel($row->quittance_cel)
                ->setQuittance_candidat($row->quittance_candidat)
                ->setQuittance_code_membre($row->quittance_code_membre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(quittance_id) as count'));
		$select->where("quittance_code LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(quittance_id) as count'));
		//$select->where("quittance_code = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }

    public function fetchAllByCandidat($candidat) {
        $select = $this->getDbTable()->select();
		if($candidat > 0){
		$select->where("quittance_candidat != ? ", 0);
			}else{
		$select->where("quittance_candidat = ? ", 0);
				}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuittance();
            $entry->setQuittance_id($row->quittance_id)
	                ->setQuittance_nom($row->quittance_nom)
                ->setQuittance_code($row->quittance_code)
                ->setQuittance_numero($row->quittance_numero)
                ->setQuittance_banque($row->quittance_banque)
                ->setQuittance_date($row->quittance_date)
                ->setQuittance_type($row->quittance_type)
                ->setQuittance_cel($row->quittance_cel)
                ->setQuittance_candidat($row->quittance_candidat)
                ->setQuittance_code_membre($row->quittance_code_membre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



}


?>
