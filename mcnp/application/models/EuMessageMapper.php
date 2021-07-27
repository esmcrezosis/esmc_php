<?php
 
class Application_Model_EuMessageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMessage');
        }
        return $this->_dbTable;
    }

    public function find($id_message, Application_Model_EuMessage $message) {
        $result = $this->getDbTable()->find($id_message);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $message->setId_message($row->id_message)
                ->setTitre_message($row->titre_message)
                ->setDate_message($row->date_message)
                ->setDescription_message($row->description_message)
                ->setCode_membre_expediteur($row->code_membre_expediteur)
                ->setId_message_envoi($row->id_message_envoi)
                ->setAlerte($row->alerte)
                ->setAdmin($row->admin)
                ->setEtat($row->etat);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMessage();
            $entry->setId_message($row->id_message)
	                ->setTitre_message($row->titre_message)
                    ->setDate_message($row->date_message)
                    ->setDescription_message($row->description_message)
	                ->setCode_membre_expediteur($row->code_membre_expediteur)
					->setId_message_envoi($row->id_message_envoi)
					->setAlerte($row->alerte)
                    ->setAdmin($row->admin)
                	->setEtat($row->etat);
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

    public function save(Application_Model_EuMessage $message) {
        $data = array(
            'id_message' => $message->getId_message(),
            'titre_message' => $message->getTitre_message(),
            'date_message' => $message->getDate_message(),
            'description_message' => $message->getDescription_message(),
            'code_membre_expediteur' => $message->getCode_membre_expediteur(),
            'id_message_envoi' => $message->getId_message_envoi(),
            'alerte' => $message->getAlerte(),
            'admin' => $message->getAdmin(),
            'etat' => $message->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMessage $message) {
        $data = array(
            'id_message' => $message->getId_message(),
            'titre_message' => $message->getTitre_message(),
            'date_message' => $message->getDate_message(),
            'description_message' => $message->getDescription_message(),
            'code_membre_expediteur' => $message->getCode_membre_expediteur(),
            'id_message_envoi' => $message->getId_message_envoi(),
            'alerte' => $message->getAlerte(),
            'admin' => $message->getAdmin(),
            'etat' => $message->getEtat()
        );
        $this->getDbTable()->update($data, array('id_message = ?' => $message->getId_message()));
    }

    public function delete($id_message) {
        $this->getDbTable()->delete(array('id_message = ?' => $id_message));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		//$select->where("etat = ? ", 1);
		$select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMessage();
            $entry->setId_message($row->id_message)
	                ->setTitre_message($row->titre_message)
                    ->setDate_message($row->date_message)
                    ->setDescription_message($row->description_message)
	                ->setCode_membre_expediteur($row->code_membre_expediteur)
					->setId_message_envoi($row->id_message_envoi)
					->setAlerte($row->alerte)
                    ->setAdmin($row->admin)
                	->setEtat($row->etat);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllExpediteur($code_membre_expediteur) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_expediteur = ? ", $code_membre_expediteur);
		//$select->where("etat = ? ", 1);
		$select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMessage();
            $entry->setId_message($row->id_message)
	                ->setTitre_message($row->titre_message)
                    ->setDate_message($row->date_message)
                    ->setDescription_message($row->description_message)
	                ->setCode_membre_expediteur($row->code_membre_expediteur)
					->setId_message_envoi($row->id_message_envoi)
					->setAlerte($row->alerte)
                    ->setAdmin($row->admin)
                	->setEtat($row->etat);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllDestinataire($code_membre_destinataire) {
        $select = $this->getDbTable()->select();
        $select->where("id_message IN (SELECT id_message FROM eu_destinataire_message WHERE code_membre_destinataire = ? )", $code_membre_destinataire);
        //$select->where("etat = ? ", 1);
        $select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMessage();
            $entry->setId_message($row->id_message)
                    ->setTitre_message($row->titre_message)
                    ->setDate_message($row->date_message)
                    ->setDescription_message($row->description_message)
                    ->setCode_membre_expediteur($row->code_membre_expediteur)
                    ->setId_message_envoi($row->id_message_envoi)
                    ->setAlerte($row->alerte)
                    ->setAdmin($row->admin)
                    ->setEtat($row->etat);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllReponse($id_message_envoi) {
        $select = $this->getDbTable()->select();
        $select->where("id_message_envoi = ? ", $id_message_envoi);
        //$select->where("etat = ? ", 1);
        $select->order("id_message DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMessage();
            $entry->setId_message($row->id_message)
                    ->setTitre_message($row->titre_message)
                    ->setDate_message($row->date_message)
                    ->setDescription_message($row->description_message)
                    ->setCode_membre_expediteur($row->code_membre_expediteur)
                    ->setId_message_envoi($row->id_message_envoi)
                    ->setAlerte($row->alerte)
                    ->setAdmin($row->admin)
                    ->setEtat($row->etat);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
