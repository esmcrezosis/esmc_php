<?php
 
class Application_Model_EuFichierMessageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFichierMessage');
        }
        return $this->_dbTable;
    }

    public function find($id_fichier_message, Application_Model_EuFichierMessage $fichier_message) {
        $result = $this->getDbTable()->find($id_fichier_message);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $fichier_message->setId_fichier_message($row->id_fichier_message)
                              ->setId_message($row->id_message)
                              ->setEtat($row->etat)
                              ->setFichier_message($row->fichier_message);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierMessage();
            $entry->setId_fichier_message($row->id_fichier_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setFichier_message($row->fichier_message);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fichier_message) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFichierMessage $fichier_message) {
        $data = array(
          'id_fichier_message' => $fichier_message->getId_fichier_message(),
          'id_message' => $fichier_message->getId_message(),
          'etat' => $fichier_message->getEtat(),
          'fichier_message' => $fichier_message->getFichier_message()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFichierMessage $fichier_message) {
        $data = array(
          'id_fichier_message' => $fichier_message->getId_fichier_message(),
          'id_message' => $fichier_message->getId_message(),
          'etat' => $fichier_message->getEtat(),
          'fichier_message' => $fichier_message->getFichier_message()
        );
        $this->getDbTable()->update($data, array('id_fichier_message = ?' => $fichier_message->getId_fichier_message()));
    }

    public function delete($id_fichier_message) {
        $this->getDbTable()->delete(array('id_fichier_message = ?' => $id_fichier_message));
    }
	
	public function fetchAllByMessage($id_message) {
        $select = $this->getDbTable()->select();
		$select->where("id_message = ?", $id_message);
		$select->order(array("id_fichier_message DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierMessage();
            $entry->setId_fichier_message($row->id_fichier_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setFichier_message($row->fichier_message);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByMessageEtat($id_message, $etat) {
        $select = $this->getDbTable()->select();
        $select->where("id_message = ?", $id_message);
        $select->where("etat = ?", $etat);
        $select->order(array("id_fichier_message DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFichierMessage();
            $entry->setId_fichier_message($row->id_fichier_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setFichier_message($row->fichier_message);
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
