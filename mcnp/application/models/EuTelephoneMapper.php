<?php

class Application_Model_EuTelephoneMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTelephone');
        }
        return $this->_dbTable;
    }

    public function find($id_telephone, Application_Model_EuTelephone $telephone) {
        $result = $this->getDbTable()->find($id_telephone);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $telephone->setId_telephone($row->id_telephone)
                ->setNumero_telephone($row->numero_telephone)
                ->setCompagnie_telephone($row->compagnie_telephone)
                ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				->setId_mstiers_listecm($row->id_mstiers_listecm);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTelephone();
            $entry->setId_telephone($row->id_telephone)
                  ->setNumero_telephone($row->numero_telephone)
                  ->setCompagnie_telephone($row->compagnie_telephone)
                  ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				  ->setId_mstiers_listecm($row->id_mstiers_listecm);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTelephone $telephone) {
        $data = array(
            'id_telephone' => $telephone->getId_telephone(),
            'numero_telephone' => $telephone->getNumero_telephone(),
            'compagnie_telephone' => $telephone->getCompagnie_telephone(),
            'code_membre' => $telephone->getCode_membre(),
            'principal' => $telephone->getPrincipal(),
			'id_mstiers_listecm' => $telephone->getId_mstiers_listecm()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTelephone $telephone) {
        $data = array(
            'id_telephone' => $telephone->getId_telephone(),
            'numero_telephone' => $telephone->getNumero_telephone(),
            'compagnie_telephone' => $telephone->getCompagnie_telephone(),
            'code_membre' => $telephone->getCode_membre(),
            'principal' => $telephone->getPrincipal(),
			'id_mstiers_listecm' => $telephone->getId_mstiers_listecm()
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

    public function fetchAllByCompagnie($compagnie_telephone = "") {
        $select = $this->getDbTable()->select();
        if($compagnie_telephone != ""){
        $select->where("compagnie_telephone = ? ", $compagnie_telephone); 
        }
		$resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTelephone();
            $entry->setId_telephone($row->id_telephone)
                  ->setNumero_telephone($row->numero_telephone)
                  ->setCompagnie_telephone($row->compagnie_telephone)
                  ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				  ->setId_mstiers_listecm($row->id_mstiers_listecm);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre); 
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTelephone();
            $entry->setId_telephone($row->id_telephone)
                  ->setNumero_telephone($row->numero_telephone)
                  ->setCompagnie_telephone($row->compagnie_telephone)
                  ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				  ->setId_mstiers_listecm($row->id_mstiers_listecm);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function fetchAllByInscrit($id) {
        $select = $this->getDbTable()->select();
        $select->where("id_mstiers_listecm = ? ", $id); 
        $resultSet = $this->getDbTable()->fetchAll($select);
		if(count($resultSet) == 0) {
           return false;
       }
       $entries = array();
       foreach($resultSet as $row) {
            $entry = new Application_Model_EuTelephone();
            $entry->setId_telephone($row->id_telephone)
                  ->setNumero_telephone($row->numero_telephone)
                  ->setCompagnie_telephone($row->compagnie_telephone)
                  ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				  ->setId_mstiers_listecm($row->id_mstiers_listecm);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findByCodeMembreCompagnie($code_membre = "", $compagnie_telephone = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre); 
        }
        if($compagnie_telephone != ""){
        $select->where("compagnie_telephone = ? ", $compagnie_telephone); 
        }
        //$select->where("principal = ? ", 1); 
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuTelephone();
        $entry->setId_telephone($row->id_telephone)
                    ->setNumero_telephone($row->numero_telephone)
                ->setCompagnie_telephone($row->compagnie_telephone)
                ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				->setId_mstiers_listecm($row->id_mstiers_listecm)
                ;
        return $entry;
    }
    
    public function findByCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre); 
        }
        $select->order(array("id_telephone DESC"));
        $select->limit(1);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuTelephone();
        $entry->setId_telephone($row->id_telephone)
                    ->setNumero_telephone($row->numero_telephone)
                ->setCompagnie_telephone($row->compagnie_telephone)
                ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
				->setId_mstiers_listecm($row->id_mstiers_listecm)
                ;
        return $entry;
    }

    public function fetchAllByAutre($id_telephone = 0, $code_membre = "") {
        $select = $this->getDbTable()->select();
        $select->where("id_telephone != ? ", $id_telephone); 
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre); 
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTelephone();
            $entry->setId_telephone($row->id_telephone)
                  ->setNumero_telephone($row->numero_telephone)
                  ->setCompagnie_telephone($row->compagnie_telephone)
                  ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
                  ->setId_mstiers_listecm($row->id_mstiers_listecm);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findByCodeMembrePrincipal($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre); 
        }
        $select->where("principal = ? ", 1); 
        $select->order(array("id_telephone DESC"));
        $select->limit(1);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuTelephone();
        $entry->setId_telephone($row->id_telephone)
                    ->setNumero_telephone($row->numero_telephone)
                ->setCompagnie_telephone($row->compagnie_telephone)
                ->setCode_membre($row->code_membre)
                ->setPrincipal($row->principal)
                ->setId_mstiers_listecm($row->id_mstiers_listecm)
                ;
        return $entry;
    }



}
?>

