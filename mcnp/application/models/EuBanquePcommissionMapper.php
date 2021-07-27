<?php

class Application_Model_EuBanquePcommissionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBanquePcommission');
        }
        return $this->_dbTable;
    }

    public function find($id_pcommission, Application_Model_EuBanquePcommission $pcommission) {
        $result = $this->getDbTable()->find($id_pcommission);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $pcommission->setId_pcommission($row->id_pcommission)
                ->setPcommission($row->pcommission)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_type_acteur($row->id_type_acteur)
                ;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanquePcommission();
            $entry->setId_pcommission($row->id_pcommission)
                    ->setPcommission($row->pcommission)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_type_acteur($row->id_type_acteur)
                ;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuBanquePcommission $pcommission) {
        $data = array(
            'id_pcommission' => $pcommission->getId_pcommission(),
            'pcommission' => $pcommission->getPcommission(),
            'status' => $pcommission->getStatus(),
            'id_type_acteur' => $pcommission->getId_type_acteur(),
            'code_banque' => $pcommission->getCode_banque()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanquePcommission $pcommission) {
        $data = array(
            'id_pcommission' => $pcommission->getId_pcommission(),
            'pcommission' => $pcommission->getPcommission(),
            'status' => $pcommission->getStatus(),
            'id_type_acteur' => $pcommission->getId_type_acteur(),
            'code_banque' => $pcommission->getCode_banque()
        );
        $this->getDbTable()->update($data, array('id_pcommission = ?' => $pcommission->getId_pcommission()));
    }

    public function delete($id_pcommission) {
        $this->getDbTable()->delete(array('id_pcommission = ?' => $id_pcommission));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_pcommission) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

	
    public function fetchAllByCodeBanqueTypeActeur($code_banque = "", $id_type_acteur = 0, $status = 0) {
        $select = $this->getDbTable()->select();
        if($code_banque != ""){
        $select->where("code_banque = ? ", $code_banque); 
        }
        if($id_type_acteur > 0){
        $select->where("id_type_acteur = ? ", $id_type_acteur); 
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
            $entry = new Application_Model_EuBanquePcommission();
            $entry->setId_pcommission($row->id_pcommission)
                    ->setPcommission($row->pcommission)
                ->setStatus($row->status)
                ->setCode_banque($row->code_banque)
                ->setId_type_acteur($row->id_type_acteur)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }





    



}
?>

