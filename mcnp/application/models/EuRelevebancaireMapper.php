<?php
 
class Application_Model_EuRelevebancaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevebancaire');
        }
        return $this->_dbTable;
    }

    public function find($relevebancaire_id, Application_Model_EuRelevebancaire $relevebancaire) {
        $result = $this->getDbTable()->find($relevebancaire_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevebancaire->setRelevebancaire_id($row->relevebancaire_id)
                ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
                ->setRelevebancaire_banque($row->relevebancaire_banque)
                ->setRelevebancaire_fichier($row->relevebancaire_fichier)
                ->setRelevebancaire_date($row->relevebancaire_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("relevebancaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
	                ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
	                ->setRelevebancaire_banque($row->relevebancaire_banque)
					->setRelevebancaire_fichier($row->relevebancaire_fichier)
					->setRelevebancaire_date($row->relevebancaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevebancaire_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevebancaire $relevebancaire) {
        $data = array(
            'relevebancaire_id' => $relevebancaire->getRelevebancaire_id(),
            'relevebancaire_utilisateur' => $relevebancaire->getRelevebancaire_utilisateur(),
            'relevebancaire_banque' => $relevebancaire->getRelevebancaire_banque(),
            'relevebancaire_fichier' => $relevebancaire->getRelevebancaire_fichier(),
            'relevebancaire_date' => $relevebancaire->getRelevebancaire_date(),
            'publier' => $relevebancaire->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevebancaire $relevebancaire) {
        $data = array(
            'relevebancaire_id' => $relevebancaire->getRelevebancaire_id(),
            'relevebancaire_utilisateur' => $relevebancaire->getRelevebancaire_utilisateur(),
            'relevebancaire_banque' => $relevebancaire->getRelevebancaire_banque(),
            'relevebancaire_fichier' => $relevebancaire->getRelevebancaire_fichier(),
            'relevebancaire_date' => $relevebancaire->getRelevebancaire_date(),
            'publier' => $relevebancaire->getPublier()
        );
        $this->getDbTable()->update($data, array('relevebancaire_id = ?' => $relevebancaire->getRelevebancaire_id()));
    }

    public function delete($relevebancaire_id) {
        $this->getDbTable()->delete(array('relevebancaire_id = ?' => $relevebancaire_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("relevebancaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
	                ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
	                ->setRelevebancaire_banque($row->relevebancaire_banque)
					->setRelevebancaire_fichier($row->relevebancaire_fichier)
					->setRelevebancaire_date($row->relevebancaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancaire_banque = ? ", $type);
		$select->where("publier = ? ", 1);
		$select->order("relevebancaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
	                ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
	                ->setRelevebancaire_banque($row->relevebancaire_banque)
					->setRelevebancaire_fichier($row->relevebancaire_fichier)
					->setRelevebancaire_date($row->relevebancaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancaire_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("relevebancaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
	                ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
	                ->setRelevebancaire_banque($row->relevebancaire_banque)
					->setRelevebancaire_fichier($row->relevebancaire_fichier)
					->setRelevebancaire_date($row->relevebancaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByNew($type) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancaire_banque = ? ", $type);
		//$select->where("publier = ? ", 1);
		$select->order("relevebancaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
	                ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
	                ->setRelevebancaire_banque($row->relevebancaire_banque)
					->setRelevebancaire_fichier($row->relevebancaire_fichier)
					->setRelevebancaire_date($row->relevebancaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByDateFlooz($relevebancaire_date, $flooz) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancaire_date LIKE '%".$relevebancaire_date."%'");
        $select->where("relevebancaire_banque = ? ", $flooz);
        //$select->where("publier = ? ", 1);
        $select->order("relevebancaire_date DESC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
                    ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
                    ->setRelevebancaire_banque($row->relevebancaire_banque)
                    ->setRelevebancaire_fichier($row->relevebancaire_fichier)
                    ->setRelevebancaire_date($row->relevebancaire_date)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }


	
public function fetchAllByDateWari($relevebancaire_date, $wari) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancaire_date LIKE '%".$relevebancaire_date."%'");
        $select->where("relevebancaire_banque = ? ", $wari);
        //$select->where("publier = ? ", 1);
        $select->order("relevebancaire_date DESC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancaire();
            $entry->setRelevebancaire_id($row->relevebancaire_id)
                    ->setRelevebancaire_utilisateur($row->relevebancaire_utilisateur)
                    ->setRelevebancaire_banque($row->relevebancaire_banque)
                    ->setRelevebancaire_fichier($row->relevebancaire_fichier)
                    ->setRelevebancaire_date($row->relevebancaire_date)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }

	
}


?>
