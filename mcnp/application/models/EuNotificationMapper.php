<?php

class Application_Model_EuNotificationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuNotification');
        }
        return $this->_dbTable;
    }
	
	

    public function save(Application_Model_EuNotification $notification) {
        $data = array(
          'id_notification' => $notification->getId_notification(),
          'to' => $notification->getTo(),
          'titre' => $notification->getTitre(),
          'message' => $notification->getMessage(),
          'message_id' => $notification->getMessage_id(),
          'error' => $notification->getError(),
          'statut' => $notification->getStatut(),
		  'date_notification' => $notification->getDate_notification()
        );

        $this->getDbTable()->insert($data);
    }
	
	
	public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_notification) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function update(Application_Model_EuNotification $notification) {
        $data = array(
          'id_notification' => $notification->getId_notification(),
          'to' => $notification->getTo(),
          'titre' => $notification->getTitre(),
          'message' => $notification->getMessage(),
          'message_id' => $notification->getMessage_id(),
          'error' => $notification->getError(),
          'statut' => $notification->getStatut(),
		  'date_notification' => $notification->getDate_notification()
        );

        $this->getDbTable()->update($data, array('id_notification = ?' => $notification->getId_notification()));
    }

    public function find($id_notification, Application_Model_EuNotification $notification) {
        $result = $this->getDbTable()->find($id_notification);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $notification->setId_notification($row->id_notification)
                   ->setTo($row->to)
                   ->setTitre($row->titre)
                   ->setMessage($row->message)
                   ->setMessage_id($row->message_id)
                   ->setError($row->error)
                   ->setStatut($row->statut)
				   ->setDate_notification($row->date_notification)
				   ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuNotification();
            $entry->setId_notification($row->id_notification)
                  ->setTo($row->to)
                  ->setTitre($row->titre)
                  ->setMessage($row->message)
                  ->setMessage_id($row->message_id)
                  ->setError($row->error)
                  ->setStatut($row->statut)
				  ->setDate_notification($row->date_notification);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_notification) {
        $this->getDbTable()->delete(array('id_notification = ?' => $id_notification));
    }


    public function fetchAllByOne()
    {
        $select = $this->getDbTable()->select();
    $select->where("statut = ? ", 1);
    $select->order(array("RAND()"));
    $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuNotification();
            $entry->setId_notification($row->id_notification)
                  ->setTo($row->to)
                  ->setTitre($row->titre)
                  ->setMessage($row->message)
                  ->setMessage_id($row->message_id)
                  ->setError($row->error)
                  ->setStatut($row->statut)
          ->setDate_notification($row->date_notification);
      $entries = $entry;
        return $entries;
    }



  
    
    public function fetchAllByHome() {//$limit
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order(array("date_notification DESC"));
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuNotification();
            $entry->setId_notification($row->id_notification)
                  ->setTo($row->to)
                  ->setTitre($row->titre)
                  ->setMessage($row->message)
                  ->setMessage_id($row->message_id)
                  ->setError($row->error)
                  ->setStatut($row->statut)
          ->setDate_notification($row->date_notification);
            $entries[] = $entry;
        }
        return $entries;
    }



}

