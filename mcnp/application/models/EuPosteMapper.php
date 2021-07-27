<?php
 
class Application_Model_EuPosteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPoste');
        }
        return $this->_dbTable;
    }

    public function find($poste_id, Application_Model_EuPoste $poste) {
        $result = $this->getDbTable()->find($poste_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $poste->setPoste_id($row->poste_id)
                ->setPoste_tache($row->poste_tache)
                ->setPoste_utilisateur($row->poste_utilisateur)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("poste_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPoste();
            $entry->setPoste_id($row->poste_id)
	                ->setPoste_tache($row->poste_tache)
					->setPoste_utilisateur($row->poste_utilisateur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(poste_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuPoste $poste) {
        $data = array(
            'poste_id' => $poste->getPoste_id(),
            'poste_tache' => $poste->getPoste_tache(),
            'poste_utilisateur' => $poste->getPoste_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPoste $poste) {
        $data = array(
            'poste_id' => $poste->getPoste_id(),
            'poste_tache' => $poste->getPoste_tache(),
            'poste_utilisateur' => $poste->getPoste_utilisateur()
        );
        $this->getDbTable()->update($data, array('poste_id = ?' => $poste->getPoste_id()));
    }

    public function delete($poste_id) {
        $this->getDbTable()->delete(array('poste_id = ?' => $poste_id));
    }


    public function fetchAllByTache($poste_tache) {
        $select = $this->getDbTable()->select();
		$select->where("poste_tache = ? ", $poste_tache);
		$select->order("poste_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPoste();
            $entry->setPoste_id($row->poste_id)
	                ->setPoste_tache($row->poste_tache)
					->setPoste_utilisateur($row->poste_utilisateur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


	
    public function fetchAllByUtilisateur($utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("poste_utilisateur = ? ", $utilisateur);
		$select->order("poste_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPoste();
            $entry->setPoste_id($row->poste_id)
	                ->setPoste_tache($row->poste_tache)
					->setPoste_utilisateur($row->poste_utilisateur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	

	


}


?>
