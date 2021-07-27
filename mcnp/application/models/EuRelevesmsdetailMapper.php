<?php
 
class Application_Model_EuRelevesmsdetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevesmsdetail');
        }
        return $this->_dbTable;
    }

    public function find($relevesmsdetail_id, Application_Model_EuRelevesmsdetail $relevesmsdetail) {
        $result = $this->getDbTable()->find($relevesmsdetail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevesmsdetail->setRelevesmsdetail_id($row->relevesmsdetail_id)
                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("relevesmsdetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevesmsdetail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevesmsdetail $relevesmsdetail) {
        $data = array(
            'relevesmsdetail_id' => $relevesmsdetail->getRelevesmsdetail_id(),
            'relevesmsdetail_relevesms' => $relevesmsdetail->getRelevesmsdetail_relevesms(),
            'relevesmsdetail_libelle' => $relevesmsdetail->getRelevesmsdetail_libelle(),
            'relevesmsdetail_numero' => $relevesmsdetail->getRelevesmsdetail_numero(),
            'relevesmsdetail_date' => $relevesmsdetail->getRelevesmsdetail_date(),
            'relevesmsdetail_montant' => $relevesmsdetail->getRelevesmsdetail_montant(),
            'relevesmsdetail_date_valeur' => $relevesmsdetail->getRelevesmsdetail_date_valeur(),
            'publier' => $relevesmsdetail->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevesmsdetail $relevesmsdetail) {
        $data = array(
            'relevesmsdetail_id' => $relevesmsdetail->getRelevesmsdetail_id(),
            'relevesmsdetail_relevesms' => $relevesmsdetail->getRelevesmsdetail_relevesms(),
            'relevesmsdetail_libelle' => $relevesmsdetail->getRelevesmsdetail_libelle(),
            'relevesmsdetail_numero' => $relevesmsdetail->getRelevesmsdetail_numero(),
            'relevesmsdetail_date' => $relevesmsdetail->getRelevesmsdetail_date(),
            'relevesmsdetail_montant' => $relevesmsdetail->getRelevesmsdetail_montant(),
            'relevesmsdetail_date_valeur' => $relevesmsdetail->getRelevesmsdetail_date_valeur(),
            'publier' => $relevesmsdetail->getPublier()
        );
        $this->getDbTable()->update($data, array('relevesmsdetail_id = ?' => $relevesmsdetail->getRelevesmsdetail_id()));
    }

    public function delete($relevesmsdetail_id) {
        $this->getDbTable()->delete(array('relevesmsdetail_id = ?' => $relevesmsdetail_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("relevesmsdetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($relevesms) {
        $select = $this->getDbTable()->select();
		$select->where("relevesmsdetail_relevesms = ? ", $relevesms);
		$select->where("publier = ? ", 1);
		$select->order("relevesmsdetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("relevesmsdetail_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("relevesmsdetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByNew($relevesms) {
        $select = $this->getDbTable()->select();
		$select->where("relevesmsdetail_relevesms = ? ", $relevesms);
		//$select->where("publier = ? ", 1);
		$select->order("relevesmsdetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByBanqueNumeroDate($relevesms_banque = "", $relevesmsdetail_numero = "", $relevesmsdetail_date = "") {
        $select = $this->getDbTable()->select();
		if($relevesms_banque != ""){
		$select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
		}
		if($relevesmsdetail_numero != "" && $relevesmsdetail_numero != NULL){
		$select->where("relevesmsdetail_numero = ? ", $relevesmsdetail_numero);
		}
		if($relevesmsdetail_date != ""){
		$select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%' ");
		}
		$select->where("publier = ? ", 0);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }
	
	
	
    public function fetchAllByCode($relevesms_banque) {
        $select = $this->getDbTable()->select();
		$select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
		//$select->where("publier = ? ", 1);
		$select->order("relevesmsdetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByBanqueNumero($relevesms_banque = "", $relevesmsdetail_numero = "") {
        $select = $this->getDbTable()->select();
		if($relevesms_banque != ""){
		$select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
		}
		if($relevesmsdetail_numero != ""){
		$select->where("relevesmsdetail_numero = ? ", $relevesmsdetail_numero);
		}
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }
	
	



    public function fetchAll10() {
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_relevesms', 'eu_relevesms.relevesms_id = eu_relevesmsdetail.relevesmsdetail_relevesms');
		$select->where("eu_relevesmsdetail.publier = ? ", 0);
		$select->order(array("eu_relevesms.relevesms_banque ASC", "eu_relevesmsdetail.relevesmsdetail_numero ASC", "eu_relevesmsdetail.relevesmsdetail_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
	                ->setRelevesmsdetail_relevesms($row->relevesms_banque)
	                ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
					->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
					->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByBanqueNumeroDate2($relevesms_banque, $relevesmsdetail_numero, $relevesmsdetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("LOWER(REPLACE(relevesmsdetail_numero, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "", $relevesmsdetail_numero)));
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%' ");
        $select->where("publier = ? ", 0);
        $select->order("relevesmsdetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
    
    /*

    public function fetchAllByBanqueNumeroDate3($relevesms_banque, $relevesmsdetail_libelle, $relevesmsdetail_date, $relevesmsdetail_montant) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_libelle))."%' ");
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%'");
        $select->where("REPLACE(relevesmsdetail_montant, 'ÿ', '') = ? ", $relevesmsdetail_montant);
        $select->where("publier = ? ", 0);
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	
	public function fetchAllByBanqueNumeroDate4($relevesms_banque, $relevesmsdetail_libelle, $relevesmsdetail_numero, $relevesmsdetail_date, $relevesmsdetail_montant) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_libelle))."%' ");
        $select->where("relevesmsdetail_libelle LIKE '%".$relevesmsdetail_numero."%' ");
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%'");
        $select->where("REPLACE(relevesmsdetail_montant, 'ÿ', '') = ? ", $relevesmsdetail_montant);
        $select->where("publier = ? ", 0);
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	*/
	
    public function fetchAllByBanqueNumeroDate5($relevesms_banque, $relevesmsdetail_libelle, $relevesmsdetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("(LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_libelle[0]))."%' ");
        $select->where("LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_libelle[1]))."%' )");
        if($relevesmsdetail_libelle[2] != ""){
        $select->orwhere("(LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_libelle[2]))."%' )");
        }
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevesmsdetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }

    public function fetchAllByBanqueNumeroDate6($relevesms_banque, $relevesmsdetail_numero, $relevesmsdetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_numero))."%' ");
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevesmsdetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }









    public function fetchAllByBanqueNumeroDate21($relevesms_banque, $relevesmsdetail_numero, $relevesmsdetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("LOWER(REPLACE(relevesmsdetail_numero, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "", $relevesmsdetail_numero)));
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%' ");
        $select->where("publier = ? ", 0);
        $select->order("relevesmsdetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
    
    
    public function fetchAllByBanqueNumeroDate52($relevesms_banque, $relevesmsdetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevesmsdetail_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByBanqueNumeroDate61($relevesms_banque, $relevesmsdetail_numero, $relevesmsdetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevesmsdetail_relevesms IN (SELECT relevesms_id FROM eu_relevesms WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("LOWER(REPLACE(relevesmsdetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevesmsdetail_numero))."%' ");
        $select->where("relevesmsdetail_date LIKE '".$relevesmsdetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevesmsdetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevesmsdetail();
            $entry->setRelevesmsdetail_id($row->relevesmsdetail_id)
                    ->setRelevesmsdetail_relevesms($row->relevesmsdetail_relevesms)
                    ->setRelevesmsdetail_libelle($row->relevesmsdetail_libelle)
                    ->setRelevesmsdetail_numero($row->relevesmsdetail_numero)
                    ->setRelevesmsdetail_date($row->relevesmsdetail_date)
                    ->setRelevesmsdetail_montant($row->relevesmsdetail_montant)
                    ->setRelevesmsdetail_date_valeur($row->relevesmsdetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }





}


?>
