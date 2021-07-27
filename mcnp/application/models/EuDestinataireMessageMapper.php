<?php
 
class Application_Model_EuDestinataireMessageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDestinataireMessage');
        }
        return $this->_dbTable;
    }

    public function find($id_destinataire_message, Application_Model_EuDestinataireMessage $destinataire_message) {
        $result = $this->getDbTable()->find($id_destinataire_message);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $destinataire_message->setId_destinataire_message($row->id_destinataire_message)
                              ->setId_message($row->id_message)
                              ->setEtat($row->etat)
                              ->setCode_membre_destinataire($row->code_membre_destinataire);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDestinataireMessage();
            $entry->setId_destinataire_message($row->id_destinataire_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setCode_membre_destinataire($row->code_membre_destinataire);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_destinataire_message) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDestinataireMessage $destinataire_message) {
        $data = array(
          'id_destinataire_message' => $destinataire_message->getId_destinataire_message(),
          'id_message' => $destinataire_message->getId_message(),
          'etat' => $destinataire_message->getEtat(),
          'code_membre_destinataire' => $destinataire_message->getCode_membre_destinataire()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDestinataireMessage $destinataire_message) {
        $data = array(
          'id_destinataire_message' => $destinataire_message->getId_destinataire_message(),
          'id_message' => $destinataire_message->getId_message(),
          'etat' => $destinataire_message->getEtat(),
          'code_membre_destinataire' => $destinataire_message->getCode_membre_destinataire()
        );
        $this->getDbTable()->update($data, array('id_destinataire_message = ?' => $destinataire_message->getId_destinataire_message()));
    }

    public function delete($id_destinataire_message) {
        $this->getDbTable()->delete(array('id_destinataire_message = ?' => $id_destinataire_message));
    }
	
	public function fetchAllByMessage($id_message) {
        $select = $this->getDbTable()->select();
		$select->where("id_message = ?", $id_message);
		$select->order(array("id_destinataire_message DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDestinataireMessage();
            $entry->setId_destinataire_message($row->id_destinataire_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setCode_membre_destinataire($row->code_membre_destinataire);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByMessageEtat($id_message, $etat) {
        $select = $this->getDbTable()->select();
        $select->where("id_message = ?", $id_message);
        $select->where("etat = ?", $etat);
        $select->order(array("id_destinataire_message DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDestinataireMessage();
            $entry->setId_destinataire_message($row->id_destinataire_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setCode_membre_destinataire($row->code_membre_destinataire);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByDestinataire($code_membre_destinataire) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_destinataire = ?", $code_membre_destinataire);
        $select->order(array("id_destinataire_message DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDestinataireMessage();
            $entry->setId_destinataire_message($row->id_destinataire_message)
                  ->setId_message($row->id_message)
                  ->setEtat($row->etat)
                  ->setCode_membre_destinataire($row->code_membre_destinataire);
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
