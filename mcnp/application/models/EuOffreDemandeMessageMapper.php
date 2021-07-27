<?php

class Application_Model_EuOffreDemandeMessageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuOffreDemandeMessage');
        }
        return $this->_dbTable;
    }

    public function find($id_message, Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $result = $this->getDbTable()->find($id_message);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_message->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeMessage();
            $entry->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_message) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $data = array(
            'id_message' => $offre_demande_message->getId_message(),
            'id_offre' => $offre_demande_message->getId_offre(),
            'id_demande' => $offre_demande_message->getId_demande(),
            'date_message' => $offre_demande_message->getDate_message(),
            'type_message' => $offre_demande_message->getType_message(),
            'code_membre' => $offre_demande_message->getCode_membre(),
            'code_compte' => $offre_demande_message->getCode_compte(),
            'id_credit' => $offre_demande_message->getId_credit(),
            'message' => $offre_demande_message->getMessage()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $data = array(
            'id_message' => $offre_demande_message->getId_message(),
            'id_offre' => $offre_demande_message->getId_offre(),
            'id_demande' => $offre_demande_message->getId_demande(),
            'date_message' => $offre_demande_message->getDate_message(),
            'type_message' => $offre_demande_message->getType_message(),
            'code_membre' => $offre_demande_message->getCode_membre(),
            'code_compte' => $offre_demande_message->getCode_compte(),
            'id_credit' => $offre_demande_message->getId_credit(),
            'message' => $offre_demande_message->getMessage()
        );
        $this->getDbTable()->update($data, array('id_message = ?' => $offre_demande_message->getId_message()));
    }

    public function delete($id_message) {
        $this->getDbTable()->delete(array('id_message = ?' => $id_message));
    }


    public function fetchAllByOffreDemande($id_offre, $id_demande) {
        $select = $this->getDbTable()->select();
		$select->where("id_offre = ? ", $id_offre);
		$select->where("id_demande = ? ", $id_demande);
		$select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeMessage();
            $entry->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function fetchAllByOffre($id_offre, Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $select = $this->getDbTable()->select();
		$select->where("id_offre = ? ", $id_offre);
		$select->order("id_message DESC");
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_message->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
    }
    public function fetchAllByDemande($id_demande, Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $select = $this->getDbTable()->select();
		$select->where("id_demande = ? ", $id_demande);
		$select->order("id_message DESC");
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_message->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
    }
    


    public function fetchAllByOffre2($id_offre) {
        $select = $this->getDbTable()->select();
		$select->where("id_offre = ? ", $id_offre);
		$select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeMessage();
            $entry->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByDemande2($id_demande) {
        $select = $this->getDbTable()->select();
		$select->where("id_demande = ? ", $id_demande);
		$select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeMessage();
            $entry->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByMembreTypeOffre($code_membre, $type, $offre, Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->where("type_message = ? ", $type);
		$select->where("id_offre = ? ", $offre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_message->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
    }

    
    public function fetchAllByMembreTypeDemande($code_membre, $type, $demande, Application_Model_EuOffreDemandeMessage $offre_demande_message) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->where("type_message = ? ", $type);
		$select->where("id_demande = ? ", $demande);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_message->setId_message($row->id_message)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_message($row->date_message)
                 ->setType_message($row->type_message)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setId_credit($row->id_credit)
                 ->setMessage($row->message);
    }
	
}

?>
