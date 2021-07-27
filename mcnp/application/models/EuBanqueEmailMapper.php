<?php

class Application_Model_EuBanqueEmailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBanqueEmail');
        }
        return $this->_dbTable;
    }

    public function find($id_email, Application_Model_EuBanqueEmail $email) {
        $result = $this->getDbTable()->find($id_email);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $email->setId_email($row->id_email)
                ->setEmail($row->email)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanqueEmail();
            $entry->setId_email($row->id_email)
                    ->setEmail($row->email)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuBanqueEmail $email) {
        $data = array(
            'id_email' => $email->getId_email(),
            'email' => $email->getEmail(),
            'status' => $email->getStatus(),
            'code_banque' => $email->getCode_banque(),
            'id_banque_user' => $email->getId_banque_user()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanqueEmail $email) {
        $data = array(
            'id_email' => $email->getId_email(),
            'email' => $email->getEmail(),
            'status' => $email->getStatus(),
            'code_banque' => $email->getCode_banque(),
            'id_banque_user' => $email->getId_banque_user()
        );
        $this->getDbTable()->update($data, array('id_email = ?' => $email->getId_email()));
    }

    public function delete($id_email) {
        $this->getDbTable()->delete(array('id_email = ?' => $id_email));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_email) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

	
    public function fetchAllByCodeBanque($code_banque = "", $status = 0) {
        $select = $this->getDbTable()->select();
        if($code_banque != ""){
        $select->where("code_banque = ? ", $code_banque); 
        }
        if($status > 0){
        $select->where("status = ? ", $status); 
        }
        if($status == -1){
        $select->where("status = ? ", 0); 
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanqueEmail();
            $entry->setId_email($row->id_email)
                    ->setEmail($row->email)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    
    
    public function fetchAllByCodeBanqueUser($code_banque = "", $status = 0, $id_banque_user = 0) {
        $select = $this->getDbTable()->select();
        if($code_banque != ""){
        $select->where("code_banque = ? ", $code_banque); 
        }
        if($status > 0){
        $select->where("status = ? ", $status); 
        }
        if($status == -1){
        $select->where("status = ? ", 0); 
        }
        if($id_banque_user > 0){
        $select->where("id_banque_user = ? ", $id_banque_user); 
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanqueEmail();
            $entry->setId_email($row->id_email)
                    ->setEmail($row->email)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByUserBanqueOne($id_banque_user = 0)
    {
        $select = $this->getDbTable()->select();
        if($id_banque_user > 0){
        $select->where("id_banque_user = ? ", $id_banque_user); 
        }
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBanqueEmail();
            $entry->setId_email($row->id_email)
                    ->setEmail($row->email)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
            $entries = $entry;
        return $entries;
    }



}
?>

