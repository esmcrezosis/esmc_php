<?php
 
class Application_Model_EuAlerteMessageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAlerteMessage');
        }
        return $this->_dbTable;
    }

    public function find($id_alerte_message, Application_Model_EuAlerteMessage $alerte_message) {
        $result = $this->getDbTable()->find($id_alerte_message);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $alerte_message->setId_alerte_message($row->id_alerte_message)
                              ->setId_message($row->id_message)
                              ->setId_sms_sent($row->id_sms_sent);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAlerteMessage();
            $entry->setId_alerte_message($row->id_alerte_message)
                  ->setId_message($row->id_message)
                  ->setId_sms_sent($row->id_sms_sent);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_alerte_message) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAlerteMessage $alerte_message) {
        $data = array(
          'id_alerte_message' => $alerte_message->getId_alerte_message(),
          'id_message' => $alerte_message->getId_message(),
          'id_sms_sent' => $alerte_message->getId_sms_sent()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAlerteMessage $alerte_message) {
        $data = array(
          'id_alerte_message' => $alerte_message->getId_alerte_message(),
          'id_message' => $alerte_message->getId_message(),
          'id_sms_sent' => $alerte_message->getId_sms_sent()
        );
        $this->getDbTable()->update($data, array('id_alerte_message = ?' => $alerte_message->getId_alerte_message()));
    }

    public function delete($id_alerte_message) {
        $this->getDbTable()->delete(array('id_alerte_message = ?' => $id_alerte_message));
    }
	
	public function fetchAllByMessage($id_message) {
        $select = $this->getDbTable()->select();
		$select->where("id_message = ?", $id_message);
		$select->order(array("id_alerte_message DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAlerteMessage();
            $entry->setId_alerte_message($row->id_alerte_message)
                  ->setId_message($row->id_message)
                  ->setId_sms_sent($row->id_sms_sent);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    

}


?>
