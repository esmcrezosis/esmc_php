<?php
 
class Application_Model_EuBanMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBan');
        }
        return $this->_dbTable;
    }

    public function find($id_ban, Application_Model_EuBan $ban) {
        $result = $this->getDbTable()->find($id_ban);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $ban->setId_ban($row->id_ban)
                ->setMont_vendu($row->mont_vendu)
                ->setDate_emission($row->date_emission)
                ->setMont_emis($row->mont_emis)
                ->setCode_membre($row->code_membre)
                ->setSolde($row->solde);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBan();
            $entry->setId_ban($row->id_ban)
	                ->setMont_vendu($row->mont_vendu)
                    ->setDate_emission($row->date_emission)
                    ->setMont_emis($row->mont_emis)
	                ->setCode_membre($row->code_membre)
                	->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_ban) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBan $ban) {
        $data = array(
            'id_ban' => $ban->getId_ban(),
            'mont_vendu' => $ban->getMont_vendu(),
            'date_emission' => $ban->getDate_emission(),
            'mont_emis' => $ban->getMont_emis(),
            'code_membre' => $ban->getCode_membre(),
            'solde' => $ban->getSolde()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBan $ban) {
        $data = array(
            'id_ban' => $ban->getId_ban(),
            'mont_vendu' => $ban->getMont_vendu(),
            'date_emission' => $ban->getDate_emission(),
            'mont_emis' => $ban->getMont_emis(),
            'code_membre' => $ban->getCode_membre(),
            'solde' => $ban->getSolde()
        );
        $this->getDbTable()->update($data, array('id_ban = ?' => $ban->getId_ban()));
    }

    public function delete($id_ban) {
        $this->getDbTable()->delete(array('id_ban = ?' => $id_ban));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		//$select->where("solde > ? ", 0);
		$select->order("id_ban DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBan();
            $entry->setId_ban($row->id_ban)
	                ->setMont_vendu($row->mont_vendu)
                    ->setDate_emission($row->date_emission)
                    ->setMont_emis($row->mont_emis)
	                ->setCode_membre($row->code_membre)
                	->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllMembre($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->order("id_ban DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBan();
            $entry->setId_ban($row->id_ban)
	                ->setMont_vendu($row->mont_vendu)
                    ->setDate_emission($row->date_emission)
                    ->setMont_emis($row->mont_emis)
	                ->setCode_membre($row->code_membre)
                	->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllMembre0($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre = ? ", $code_membre);
        $select->where("solde > ? ", 0);
        $select->order("id_ban DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBan();
            $entry->setId_ban($row->id_ban)
                    ->setMont_vendu($row->mont_vendu)
                    ->setDate_emission($row->date_emission)
                    ->setMont_emis($row->mont_emis)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllOneMembre() {
        $select = $this->getDbTable()->select();
        $select->order("id_ban DESC");
        $select->limit(1);
           $results = $this->getDbTable()->fetchAll($select);
           if (count($results) > 0) {
              $row = $results->current();
              $entry = new Application_Model_EuBan();
            $entry->setId_ban($row->id_ban)
                    ->setMont_vendu($row->mont_vendu)
                    ->setDate_emission($row->date_emission)
                    ->setMont_emis($row->mont_emis)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde);
              return $entry; 
           } else {
              return false;
           }
    
    }


    public function fetchAllOneMembre2($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre = ? ", $code_membre);
        $select->order("id_ban DESC");
        $select->limit(1);
           $results = $this->getDbTable()->fetchAll($select);
           if (count($results) > 0) {
              $row = $results->current();
              $entry = new Application_Model_EuBan();
            $entry->setId_ban($row->id_ban)
                    ->setMont_vendu($row->mont_vendu)
                    ->setDate_emission($row->date_emission)
                    ->setMont_emis($row->mont_emis)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde);
              return $entry; 
           } else {
              return false;
           }
    
    }


    public function getSumByBan($code_membre) {
    $table = new Application_Model_DbTable_EuBan();
        $select = $table->select();
        $select->from($table,array('SUM(solde) as somme'));
        $select->where("code_membre = ? ", $code_membre);
        $select->where("solde > ? ", 0);
        $result = $this->getDbTable()->fetchAll($select);
        
        if(count($result) == 0) {
           return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }


	
}


?>
