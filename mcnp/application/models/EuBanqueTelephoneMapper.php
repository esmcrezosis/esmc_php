<?php

class Application_Model_EuBanqueTelephoneMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBanqueTelephone');
        }
        return $this->_dbTable;
    }

    public function find($id_telephone, Application_Model_EuBanqueTelephone $telephone) {
        $result = $this->getDbTable()->find($id_telephone);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $telephone->setId_telephone($row->id_telephone)
                ->setTelephone($row->telephone)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanqueTelephone();
            $entry->setId_telephone($row->id_telephone)
                    ->setTelephone($row->telephone)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuBanqueTelephone $telephone) {
        $data = array(
            'id_telephone' => $telephone->getId_telephone(),
            'telephone' => $telephone->getTelephone(),
            'status' => $telephone->getStatus(),
            'code_banque' => $telephone->getCode_banque(),
            'id_banque_user' => $telephone->getId_banque_user()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanqueTelephone $telephone) {
        $data = array(
            'id_telephone' => $telephone->getId_telephone(),
            'telephone' => $telephone->getTelephone(),
            'status' => $telephone->getStatus(),
            'code_banque' => $telephone->getCode_banque(),
            'id_banque_user' => $telephone->getId_banque_user()
        );
        $this->getDbTable()->update($data, array('id_telephone = ?' => $telephone->getId_telephone()));
    }

    public function delete($id_telephone) {
        $this->getDbTable()->delete(array('id_telephone = ?' => $id_telephone));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_telephone) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
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
            $entry = new Application_Model_EuBanqueTelephone();
            $entry->setId_telephone($row->id_telephone)
                    ->setTelephone($row->telephone)
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
            $entry = new Application_Model_EuBanqueTelephone();
            $entry->setId_telephone($row->id_telephone)
                    ->setTelephone($row->telephone)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_banque_user($row->id_banque_user)
                ;
            $entries = $entry;
        return $entries;
    }





    



}
?>

