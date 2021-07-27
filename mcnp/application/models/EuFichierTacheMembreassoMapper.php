<?php
 
class Application_Model_EuFichierTacheMembreassoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFichierTacheMembreasso');
        }
        return $this->_dbTable;
    }

    public function find($id_fichier_tache_membreasso, Application_Model_EuFichierTacheMembreasso $fichier_tache_membreasso) {
        $result = $this->getDbTable()->find($id_fichier_tache_membreasso);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $fichier_tache_membreasso->setId_fichier_tache_membreasso($row->id_fichier_tache_membreasso)
                              ->setId_tache_membreasso($row->id_tache_membreasso)
                              ->setEtat($row->etat)
                              ->setFichier_tache_membreasso($row->fichier_tache_membreasso);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierTacheMembreasso();
            $entry->setId_fichier_tache_membreasso($row->id_fichier_tache_membreasso)
                  ->setId_tache_membreasso($row->id_tache_membreasso)
                  ->setEtat($row->etat)
                  ->setFichier_tache_membreasso($row->fichier_tache_membreasso);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fichier_tache_membreasso) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFichierTacheMembreasso $fichier_tache_membreasso) {
        $data = array(
          'id_fichier_tache_membreasso' => $fichier_tache_membreasso->getId_fichier_tache_membreasso(),
          'id_tache_membreasso' => $fichier_tache_membreasso->getId_tache_membreasso(),
          'etat' => $fichier_tache_membreasso->getEtat(),
          'fichier_tache_membreasso' => $fichier_tache_membreasso->getFichier_tache_membreasso()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFichierTacheMembreasso $fichier_tache_membreasso) {
        $data = array(
          'id_fichier_tache_membreasso' => $fichier_tache_membreasso->getId_fichier_tache_membreasso(),
          'id_tache_membreasso' => $fichier_tache_membreasso->getId_tache_membreasso(),
          'etat' => $fichier_tache_membreasso->getEtat(),
          'fichier_tache_membreasso' => $fichier_tache_membreasso->getFichier_tache_membreasso()
        );
        $this->getDbTable()->update($data, array('id_fichier_tache_membreasso = ?' => $fichier_tache_membreasso->getId_fichier_tache_membreasso()));
    }

    public function delete($id_fichier_tache_membreasso) {
        $this->getDbTable()->delete(array('id_fichier_tache_membreasso = ?' => $id_fichier_tache_membreasso));
    }
	
	public function fetchAllByTacheMembreasso($id_tache_membreasso) {
        $select = $this->getDbTable()->select();
		$select->where("id_tache_membreasso = ?", $id_tache_membreasso);
		$select->order(array("id_fichier_tache_membreasso DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierTacheMembreasso();
            $entry->setId_fichier_tache_membreasso($row->id_fichier_tache_membreasso)
                  ->setId_tache_membreasso($row->id_tache_membreasso)
                  ->setEtat($row->etat)
                  ->setFichier_tache_membreasso($row->fichier_tache_membreasso);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByTacheMembreassoEtat($id_tache_membreasso, $etat) {
        $select = $this->getDbTable()->select();
        $select->where("id_tache_membreasso = ?", $id_tache_membreasso);
        $select->where("etat = ?", $etat);
        $select->order(array("id_fichier_tache_membreasso DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierTacheMembreasso();
            $entry->setId_fichier_tache_membreasso($row->id_fichier_tache_membreasso)
                  ->setId_tache_membreasso($row->id_tache_membreasso)
                  ->setEtat($row->etat)
                  ->setFichier_tache_membreasso($row->fichier_tache_membreasso);
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
