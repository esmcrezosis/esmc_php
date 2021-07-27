<?php

class Application_Model_EuContactMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuContact');
        }
        return $this->_dbTable;
    }

    public function find($contact_id, Application_Model_EuContact $contact) {
        $result = $this->getDbTable()->find($contact_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $contact->setContact_id($row->contact_id)
                ->setContact_nom($row->contact_nom)
                ->setContact_email($row->contact_email)
                ->setContact_message($row->contact_message)
                ->setContact_sujet($row->contact_sujet)
                ->setContact_date($row->contact_date)
                ->setTraiter($row->traiter)
                ->setContact_type($row->contact_type);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContact();
            $entry->setContact_id($row->contact_id)
	                ->setContact_nom($row->contact_nom)
                    ->setContact_email($row->contact_email)
                    ->setContact_message($row->contact_message)
                    ->setContact_sujet($row->contact_sujet)
					->setContact_date($row->contact_date)
					->setTraiter($row->traiter)
                	->setContact_type($row->contact_type);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll2() {
        $select = $this->getDbTable()->select();
        $select->order(array('contact_id DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContact();
            $entry->setContact_id($row->contact_id)
                    ->setContact_nom($row->contact_nom)
                    ->setContact_email($row->contact_email)
                    ->setContact_message($row->contact_message)
                    ->setContact_sujet($row->contact_sujet)
                    ->setContact_date($row->contact_date)
                    ->setTraiter($row->traiter)
                    ->setContact_type($row->contact_type);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(contact_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuContact $contact) {
        $data = array(
            'contact_id' => $contact->getContact_id(),
            'contact_nom' => $contact->getContact_nom(),
            'contact_email' => $contact->getContact_email(),
            'contact_message' => $contact->getContact_message(),
            'contact_sujet' => $contact->getContact_sujet(),
            'contact_date' => $contact->getContact_date(),
            'traiter' => $contact->getTraiter(),
            'contact_type' => $contact->getContact_type()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuContact $contact) {
        $data = array(
            'contact_id' => $contact->getContact_id(),
            'contact_nom' => $contact->getContact_nom(),
            'contact_email' => $contact->getContact_email(),
            'contact_message' => $contact->getContact_message(),
            'contact_sujet' => $contact->getContact_sujet(),
            'contact_date' => $contact->getContact_date(),
            'traiter' => $contact->getTraiter(),
            'contact_type' => $contact->getContact_type()
        );
        $this->getDbTable()->update($data, array('contact_id = ?' => $contact->getContact_id()));
    }

    public function delete($contact_id) {
        $this->getDbTable()->delete(array('contact_id = ?' => $contact_id));
    }




}


?>
