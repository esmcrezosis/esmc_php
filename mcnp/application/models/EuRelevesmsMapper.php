<?php
 
class Application_Model_EuRelevesmsMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevesms');
        }
        return $this->_dbTable;
    }

    public function find($relevesms_id, Application_Model_EuRelevesms $relevesms) {
        $result = $this->getDbTable()->find($relevesms_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevesms->setRelevesms_id($row->relevesms_id)
                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
                ->setRelevesms_banque($row->relevesms_banque)
                ->setRelevesms_fichier($row->relevesms_fichier)
                ->setRelevesms_date($row->relevesms_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("relevesms_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
	                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
	                ->setRelevesms_banque($row->relevesms_banque)
					->setRelevesms_fichier($row->relevesms_fichier)
					->setRelevesms_date($row->relevesms_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevesms_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevesms $relevesms) {
        $data = array(
            'relevesms_id' => $relevesms->getRelevesms_id(),
            'relevesms_utilisateur' => $relevesms->getRelevesms_utilisateur(),
            'relevesms_banque' => $relevesms->getRelevesms_banque(),
            'relevesms_fichier' => $relevesms->getRelevesms_fichier(),
            'relevesms_date' => $relevesms->getRelevesms_date(),
            'publier' => $relevesms->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevesms $relevesms) {
        $data = array(
            'relevesms_id' => $relevesms->getRelevesms_id(),
            'relevesms_utilisateur' => $relevesms->getRelevesms_utilisateur(),
            'relevesms_banque' => $relevesms->getRelevesms_banque(),
            'relevesms_fichier' => $relevesms->getRelevesms_fichier(),
            'relevesms_date' => $relevesms->getRelevesms_date(),
            'publier' => $relevesms->getPublier()
        );
        $this->getDbTable()->update($data, array('relevesms_id = ?' => $relevesms->getRelevesms_id()));
    }

    public function delete($relevesms_id) {
        $this->getDbTable()->delete(array('relevesms_id = ?' => $relevesms_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("relevesms_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
	                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
	                ->setRelevesms_banque($row->relevesms_banque)
					->setRelevesms_fichier($row->relevesms_fichier)
					->setRelevesms_date($row->relevesms_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("relevesms_banque = ? ", $type);
		$select->where("publier = ? ", 1);
		$select->order("relevesms_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
	                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
	                ->setRelevesms_banque($row->relevesms_banque)
					->setRelevesms_fichier($row->relevesms_fichier)
					->setRelevesms_date($row->relevesms_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("relevesms_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("relevesms_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
	                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
	                ->setRelevesms_banque($row->relevesms_banque)
					->setRelevesms_fichier($row->relevesms_fichier)
					->setRelevesms_date($row->relevesms_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByNew($type) {
        $select = $this->getDbTable()->select();
		$select->where("relevesms_banque = ? ", $type);
		//$select->where("publier = ? ", 1);
		$select->order("relevesms_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
	                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
	                ->setRelevesms_banque($row->relevesms_banque)
					->setRelevesms_fichier($row->relevesms_fichier)
					->setRelevesms_date($row->relevesms_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAllByDateFlooz($relevesms_date, $flooz) {
        $select = $this->getDbTable()->select();
		$select->where("relevesms_date LIKE '%".$relevesms_date."%'");
		$select->where("relevesms_banque = ? ", $flooz);
		//$select->where("publier = ? ", 1);
		$select->order("relevesms_date DESC");
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
	                ->setRelevesms_utilisateur($row->relevesms_utilisateur)
	                ->setRelevesms_banque($row->relevesms_banque)
					->setRelevesms_fichier($row->relevesms_fichier)
					->setRelevesms_date($row->relevesms_date)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }


    
    public function fetchAllByDateWari($relevesms_date, $wari) {
        $select = $this->getDbTable()->select();
        $select->where("relevesms_date LIKE '%".$relevesms_date."%'");
        $select->where("relevesms_banque = ? ", $wari);
        //$select->where("publier = ? ", 1);
        $select->order("relevesms_date DESC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesms();
            $entry->setRelevesms_id($row->relevesms_id)
                    ->setRelevesms_utilisateur($row->relevesms_utilisateur)
                    ->setRelevesms_banque($row->relevesms_banque)
                    ->setRelevesms_fichier($row->relevesms_fichier)
                    ->setRelevesms_date($row->relevesms_date)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }

	
}


?>
