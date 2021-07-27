<?php
 
class Application_Model_EuFichierBanqueMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFichierBanque');
        }
        return $this->_dbTable;
    }

    public function find($fichier_id, Application_Model_EuFichierBanque $fichier) {
        $result = $this->getDbTable()->find($fichier_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $fichier->setFichier_id($row->fichier_id)
                ->setFichier_libelle($row->fichier_libelle)
                ->setFichier_url($row->fichier_url)
                ->setFichier_banque($row->fichier_banque)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierBanque();
            $entry->setFichier_id($row->fichier_id)
	                ->setFichier_libelle($row->fichier_libelle)
                    ->setFichier_url($row->fichier_url)
	                ->setFichier_banque($row->fichier_banque)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(fichier_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFichierBanque $fichier) {
        $data = array(
            'fichier_id' => $fichier->getFichier_id(),
            'fichier_libelle' => $fichier->getFichier_libelle(),
            'fichier_url' => $fichier->getFichier_url(),
            'fichier_banque' => $fichier->getFichier_banque(),
            'publier' => $fichier->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFichierBanque $fichier) {
        $data = array(
            'fichier_id' => $fichier->getFichier_id(),
            'fichier_libelle' => $fichier->getFichier_libelle(),
            'fichier_url' => $fichier->getFichier_url(),
            'fichier_banque' => $fichier->getFichier_banque(),
            'publier' => $fichier->getPublier()
        );
        $this->getDbTable()->update($data, array('fichier_id = ?' => $fichier->getFichier_id()));
    }

    public function delete($fichier_id) {
        $this->getDbTable()->delete(array('fichier_id = ?' => $fichier_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("fichier_libelle ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierBanque();
            $entry->setFichier_id($row->fichier_id)
	                ->setFichier_libelle($row->fichier_libelle)
                    ->setFichier_url($row->fichier_url)
	                ->setFichier_banque($row->fichier_banque)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByBanque($fichier_banque = "") {
        $select = $this->getDbTable()->select();
        if($fichier_banque != ""){
		$select->where("fichier_banque = ? ", $fichier_banque);
    }
		$select->order("fichier_libelle ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierBanque();
            $entry->setFichier_id($row->fichier_id)
	                ->setFichier_libelle($row->fichier_libelle)
                    ->setFichier_url($row->fichier_url)
	                ->setFichier_banque($row->fichier_banque)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByBanque2($fichier_banque = "") {
        $select = $this->getDbTable()->select();
        if($fichier_banque != ""){
        $select->where("fichier_banque = ? ", $fichier_banque);
    }
        $select->where("publier = ? ", 1);
        $select->order("fichier_libelle ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierBanque();
            $entry->setFichier_id($row->fichier_id)
                    ->setFichier_libelle($row->fichier_libelle)
                    ->setFichier_url($row->fichier_url)
                    ->setFichier_banque($row->fichier_banque)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
