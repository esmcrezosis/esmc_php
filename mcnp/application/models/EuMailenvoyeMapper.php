<?php
 
class Application_Model_EuMailenvoyeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMailenvoye');
        }
        return $this->_dbTable;
    }

    public function find($mailenvoye_id, Application_Model_EuMailenvoye $mailenvoye) {
        $result = $this->getDbTable()->find($mailenvoye_id);
        if (count($result) == 0) {
           return false;
        }
        $row = $result->current();
        $mailenvoye->setMailenvoye_id($row->mailenvoye_id)
                   ->setMailenvoye_emetteur($row->mailenvoye_emetteur)
                   ->setMailenvoye_recepteur($row->mailenvoye_recepteur)
                   ->setMailenvoye_objet($row->mailenvoye_objet)
                   ->setMailenvoye_contenu($row->mailenvoye_contenu)
				   ->setMailenvoye_date($row->mailenvoye_date);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMailenvoye();
            $entry->setMailenvoye_id($row->mailenvoye_id)
                  ->setMailenvoye_emetteur($row->mailenvoye_emetteur)
                  ->setMailenvoye_recepteur($row->mailenvoye_recepteur)
                  ->setMailenvoye_objet($row->mailenvoye_objet)
                  ->setMailenvoye_contenu($row->mailenvoye_contenu)
				  ->setMailenvoye_date($row->mailenvoye_date);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(mailenvoye_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuMailenvoye $mailenvoye) {
	    
        $data = array(
        'mailenvoye_id' => $mailenvoye->getMailenvoye_id(),
        'mailenvoye_emetteur' => $mailenvoye->getMailenvoye_emetteur(),
        'mailenvoye_recepteur' => $mailenvoye->getMailenvoye_recepteur(),
        'mailenvoye_objet' => $mailenvoye->getMailenvoye_objet(),
		'mailenvoye_contenu' => $mailenvoye->getMailenvoye_contenu(),
        'mailenvoye_date' => $mailenvoye->getMailenvoye_date()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMailenvoye $mailenvoye) {
        $data = array(
          'mailenvoye_id' => $mailenvoye->getMailenvoye_id(),
          'mailenvoye_emetteur' => $mailenvoye->getMailenvoye_emetteur(),
          'mailenvoye_recepteur' => $mailenvoye->getMailenvoye_recepteur(),
          'mailenvoye_objet' => $mailenvoye->getMailenvoye_objet(),
		  'mailenvoye_contenu' => $mailenvoye->getMailenvoye_contenu(),
          'mailenvoye_date' => $mailenvoye->getMailenvoye_date()
        );
        $this->getDbTable()->update($data, array('mailenvoye_id = ?' => $mailenvoye->getMailenvoyer_id()));
    }

    public function delete($mailenvoye_id) {
        $this->getDbTable()->delete(array('mailenvoye_id = ?' => $mailenvoye_id));
    }

}


?>
