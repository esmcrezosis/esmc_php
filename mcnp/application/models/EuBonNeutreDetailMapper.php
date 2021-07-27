<?php
 
class Application_Model_EuBonNeutreDetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonNeutreDetail');
        }
        return $this->_dbTable;
    }
	
	

    public function find($bon_neutre_detail_id, Application_Model_EuBonNeutreDetail $bon_neutre_detail) {
        $result = $this->getDbTable()->find($bon_neutre_detail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_neutre_detail->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                ->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
                ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
                ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
				;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
	    $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	              ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                  ->setBon_neutre_id($row->bon_neutre_id)
                  ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
	              ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
		          ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
		          ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                  ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_neutre_detail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	

    public function save(Application_Model_EuBonNeutreDetail $bon_neutre_detail) {
        $data = array(
            'bon_neutre_detail_id' => $bon_neutre_detail->getBon_neutre_detail_id(),
            'bon_neutre_detail_code' => $bon_neutre_detail->getBon_neutre_detail_code(),
            'bon_neutre_id' => $bon_neutre_detail->getBon_neutre_id(),
            'bon_neutre_detail_montant' => $bon_neutre_detail->getBon_neutre_detail_montant(),
            'bon_neutre_detail_montant_utilise' => $bon_neutre_detail->getBon_neutre_detail_montant_utilise(),
            'bon_neutre_detail_montant_solde' => $bon_neutre_detail->getBon_neutre_detail_montant_solde(),
            'bon_neutre_detail_date' => $bon_neutre_detail->getBon_neutre_detail_date(),
            'bon_neutre_detail_numero' => $bon_neutre_detail->getBon_neutre_detail_numero(),
            'bon_neutre_detail_date_numero' => $bon_neutre_detail->getBon_neutre_detail_date_numero(),
            'bon_neutre_detail_banque' => $bon_neutre_detail->getBon_neutre_detail_banque(),
            'bon_neutre_detail_vignette' => $bon_neutre_detail->getBon_neutre_detail_vignette(),
            'id_canton' => $bon_neutre_detail->getId_canton(),
            'bon_neutre_tiers_id' => $bon_neutre_detail->getBon_neutre_tiers_id(),
            'bon_neutre_appro_id' => $bon_neutre_detail->getBon_neutre_appro_id(),
            'bon_neutre_detail_type' => $bon_neutre_detail->getBon_neutre_detail_type(),
            'bon_neutre_detail_commission' => $bon_neutre_detail->getBon_neutre_detail_commission()
        );
        
        $this->getDbTable()->insert($data);
    }
	
	

    public function update(Application_Model_EuBonNeutreDetail $bon_neutre_detail) {
        $data = array(
            'bon_neutre_detail_id' => $bon_neutre_detail->getBon_neutre_detail_id(),
            'bon_neutre_detail_code' => $bon_neutre_detail->getBon_neutre_detail_code(),
            'bon_neutre_id' => $bon_neutre_detail->getBon_neutre_id(),
            'bon_neutre_detail_montant' => $bon_neutre_detail->getBon_neutre_detail_montant(),
            'bon_neutre_detail_montant_utilise' => $bon_neutre_detail->getBon_neutre_detail_montant_utilise(),
            'bon_neutre_detail_montant_solde' => $bon_neutre_detail->getBon_neutre_detail_montant_solde(),
            'bon_neutre_detail_date' => $bon_neutre_detail->getBon_neutre_detail_date(),
            'bon_neutre_detail_numero' => $bon_neutre_detail->getBon_neutre_detail_numero(),
            'bon_neutre_detail_date_numero' => $bon_neutre_detail->getBon_neutre_detail_date_numero(),
            'bon_neutre_detail_banque' => $bon_neutre_detail->getBon_neutre_detail_banque(),
            'bon_neutre_detail_vignette' => $bon_neutre_detail->getBon_neutre_detail_vignette(),
            'id_canton' => $bon_neutre_detail->getId_canton(),
            'bon_neutre_tiers_id' => $bon_neutre_detail->getBon_neutre_tiers_id(),
            'bon_neutre_appro_id' => $bon_neutre_detail->getBon_neutre_appro_id(),
            'bon_neutre_detail_type' => $bon_neutre_detail->getBon_neutre_detail_type(),
            'bon_neutre_detail_commission' => $bon_neutre_detail->getBon_neutre_detail_commission()
        );
        
        $this->getDbTable()->update($data, array('bon_neutre_detail_id = ?' => $bon_neutre_detail->getBon_neutre_detail_id()));
    }
	
	

    public function delete($bon_neutre_detail_id) {
        $this->getDbTable()->delete(array('bon_neutre_detail_id = ?' => $bon_neutre_detail_id));
    }


    public function fetchAllByBonNeutre($bon_neutre_id) {
        $select = $this->getDbTable()->select();
	    $select->where("bon_neutre_id = ? ", $bon_neutre_id);
	    $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	              ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                  ->setBon_neutre_id($row->bon_neutre_id)
                  ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
	              ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
				  ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
				  ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                  ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                   ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function getSumByBonNeutre($bon_neutre_id) {
	$table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
        $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
	    $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $result = $this->getDbTable()->fetchAll($select);
        
        if(count($result) == 0) {
           return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function getSumByBonNeutreCommision($bon_neutre_id, $bon_neutre_detail_commission) {
    $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
        $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
        $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("bon_neutre_detail_commission LIKE '".$bon_neutre_detail_commission."' ");
        $result = $this->getDbTable()->fetchAll($select);
        
        if(count($result) == 0) {
           return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function getSumByBonNeutreDetailBanque($bon_neutre_id, $bon_neutre_detail_banque) {
    $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
        $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
        $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("bon_neutre_detail_type LIKE '".$bon_neutre_detail_banque."' ");
        $result = $this->getDbTable()->fetchAll($select);
        
        if(count($result) == 0) {
           return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function getSumByBonNeutreold($bon_neutre_id) {
        $date_banque = "2018-02-01";
        $date_banque = new Zend_Date($date_banque,Zend_Date::ISO_8601);  
	    $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
        $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
	    $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("REPLACE(bon_neutre_detail_date_numero, ' ', '') < ? ", $date_banque->toString('yyyy-MM-dd'));
        $result = $table->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }
    }
	
	
	public function getSumByBonNeutreBc($bon_neutre_id) {
        $date_banque = "2018-11-01";
        $date_banque = new Zend_Date($date_banque,Zend_Date::ISO_8601);  
	    $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
        $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
	    $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("REPLACE(bon_neutre_detail_date_numero, ' ', '') > ? ", $date_banque->toString('yyyy-MM-dd'));
        $result = $table->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }
    }


    public  function getSumByBonNeutreAppro($bon_neutre_id) {
        $date_banque = "2018-02-01";
	    $date_banque = new Zend_Date($date_banque,Zend_Date::ISO_8601);  
	    $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
	    $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
	    $select->where('bon_neutre_id = ?', $bon_neutre_id);
	    $select->where("bon_neutre_appro_id > ? ", 0);
	    $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("REPLACE(bon_neutre_detail_date, ' ', '') < ? ", $date_banque->toString('yyyy-MM-dd'));
	    $result = $table->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }	
    }
	
	
	
	public  function getSumByBonNeutreApproBc($bon_neutre_id) {
        $date_banque = "2018-11-01";
	    $date_banque = new Zend_Date($date_banque,Zend_Date::ISO_8601);  
	    $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
	    $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
	    $select->where('bon_neutre_id = ?', $bon_neutre_id);
	    $select->where("bon_neutre_appro_id > ? ", 0);
	    $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("REPLACE(bon_neutre_detail_date, ' ', '') > ? ", $date_banque->toString('yyyy-MM-dd'));
	    $result = $table->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }	
    }
	
	
	public function fetchAllByBonNeutreValideBc($bon_neutre_id)  {
		$date_banque = "2018-11-01";
		$date_banque = new Zend_Date($date_banque,Zend_Date::ISO_8601);
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_id = ? ", $bon_neutre_id);
        $select->where("bon_neutre_detail_montant_solde > ? ", 0);
		$select->where("REPLACE(bon_neutre_detail_date, ' ', '') > ? ", $date_banque->toString('yyyy-MM-dd'));
        $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        if(count($resultSet) == 0) {
           return NULL;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                  ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                  ->setBon_neutre_id($row->bon_neutre_id)
                  ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                  ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
                  ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
                  ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                  ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
    
    
    public function fetchAllByBonNeutreValide($bon_neutre_id) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_id = ? ", $bon_neutre_id);
        $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        if(count($resultSet) == 0) {
           return NULL;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                  ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                  ->setBon_neutre_id($row->bon_neutre_id)
                  ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                  ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
                  ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
                  ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAllByBonNeutreValideCommision($bon_neutre_id, $bon_neutre_detail_commission) {
        $select = $this->getDbTable()->select();
	    $select->where("bon_neutre_id = ? ", $bon_neutre_id);
	    $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where("bon_neutre_detail_commission LIKE '".$bon_neutre_detail_commission."' ");
	    $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
	    if(count($resultSet) == 0) {
           return NULL;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	              ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                  ->setBon_neutre_id($row->bon_neutre_id)
                  ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
	              ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
				  ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
				  ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


	
    public function fetchAllByCode($bon_neutre_detail_code) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_detail_code = ? ", $bon_neutre_detail_code);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	                ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                    ->setBon_neutre_id($row->bon_neutre_id)
                    ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
	                ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
					->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
					->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
				;
			$entries = $entry;
        return $entries;
    }
	
	
	
    public function fetchAllByNumero($bon_neutre_detail_numero) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_detail_numero = ? ", $bon_neutre_detail_numero);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBonNeutreDetail();
            $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
	                ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                    ->setBon_neutre_id($row->bon_neutre_id)
                    ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
	                ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
					->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
					->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
				;
			$entries = $entry;
        return $entries;
    }
	
	
	
	


      public function fetchAllByTiers($bon_neutre_tiers_id) {
          $select = $this->getDbTable()->select();
        $select->where("bon_neutre_tiers_id = ? ", $bon_neutre_tiers_id);
        $select->limit(1);
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
              $entry = new Application_Model_EuBonNeutreDetail();
              $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                    ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                      ->setBon_neutre_id($row->bon_neutre_id)
                      ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                    ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
                    ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
                    ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                  ;
            $entries = $entry;
          return $entries;
      }






      public function fetchAllByAppro($bon_neutre_appro_id) {
          $select = $this->getDbTable()->select();
        $select->where("bon_neutre_appro_id = ? ", $bon_neutre_appro_id);
        $select->limit(1);
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
              $entry = new Application_Model_EuBonNeutreDetail();
              $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                    ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                      ->setBon_neutre_id($row->bon_neutre_id)
                      ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                    ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
                    ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
                    ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
                ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                  ;
            $entries = $entry;
          return $entries;
      }







    
    
    public function fetchAllByTableauBord($bon_neutre_detail_montant1 = 0, $bon_neutre_detail_montant2 = 0, $bon_neutre_code_membre = "", $bon_neutre_detail_banque = "", $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $bon_neutre_tiers_id = 0, $bon_neutre_detail_date1 = "", $bon_neutre_detail_date2 = "") {
        $select = $this->getDbTable()->select();
        if($bon_neutre_detail_montant1 > 0 && $bon_neutre_detail_montant2 > 0){
        $select->where("bon_neutre_detail_montant >= ? ", $bon_neutre_detail_montant1);  
        $select->where("bon_neutre_detail_montant <= ? ", $bon_neutre_detail_montant2);  
        }else if($bon_neutre_detail_montant1 > 0){
        $select->where("bon_neutre_detail_montant >= ? ", $bon_neutre_detail_montant1);  
        }else if($bon_neutre_detail_montant2 > 0){
        $select->where("bon_neutre_detail_montant <= ? ", $bon_neutre_detail_montant2);  
        }
        if($bon_neutre_code_membre != ""){
        $select->where("bon_neutre_id IN (SELECT bon_neutre_id FROM eu_bon_neutre WHERE bon_neutre_code_membre LIKE ? )", $bon_neutre_code_membre);  
        }
        if($bon_neutre_detail_banque != ""){
        $select->where("bon_neutre_detail_banque LIKE ? ", $bon_neutre_detail_banque);  
        }
        if($id_canton > 0) {
          $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
            
        if($bon_neutre_tiers_id > 0){
        $select->where("bon_neutre_tiers_id IS NOT NULL");  
        }else{
        $select->where("bon_neutre_tiers_id IS NULL");    
        }
        
        $select->where("(bon_neutre_detail_date) BETWEEN  '".$bon_neutre_detail_date1."' AND '".$bon_neutre_detail_date2."' ");  
        
        $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
              $entry = new Application_Model_EuBonNeutreDetail();
              $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                    ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                      ->setBon_neutre_id($row->bon_neutre_id)
                      ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                    ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
            ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
            ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
          ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }

  


    
    
    public function fetchAllByTableauBordTotal($bon_neutre_detail_montant1 = 0, $bon_neutre_detail_montant2 = 0, $bon_neutre_code_membre = "", $bon_neutre_detail_banque = "", $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $bon_neutre_tiers_id = 0, $bon_neutre_detail_date1 = "", $bon_neutre_detail_date2 = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(bon_neutre_detail_montant) as COUNT', 'SUM(bon_neutre_detail_montant_utilise) as COUNT2', 'SUM(bon_neutre_detail_montant_solde) as COUNT3'));
        if($bon_neutre_detail_montant1 > 0 && $bon_neutre_detail_montant2 > 0){
        $select->where("bon_neutre_detail_montant >= ? ", $bon_neutre_detail_montant1);  
        $select->where("bon_neutre_detail_montant <= ? ", $bon_neutre_detail_montant2);  
        }else if($bon_neutre_detail_montant1 > 0){
        $select->where("bon_neutre_detail_montant >= ? ", $bon_neutre_detail_montant1);  
        }else if($bon_neutre_detail_montant2 > 0){
        $select->where("bon_neutre_detail_montant <= ? ", $bon_neutre_detail_montant2);  
        }
        if($bon_neutre_code_membre != ""){
        $select->where("bon_neutre_id IN (SELECT bon_neutre_id FROM eu_bon_neutre WHERE bon_neutre_code_membre LIKE ? )", $bon_neutre_code_membre);  
        }
        if($bon_neutre_detail_banque != ""){
        $select->where("bon_neutre_detail_banque LIKE ? ", $bon_neutre_detail_banque);  
        }
        if($id_canton > 0) {
          $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
            
        if($bon_neutre_tiers_id > 0){
        $select->where("bon_neutre_tiers_id IS NOT NULL");  
        }else{
        $select->where("bon_neutre_tiers_id IS NULL");    
        }

        $select->where("(bon_neutre_detail_date) BETWEEN  '".$bon_neutre_detail_date1."' AND '".$bon_neutre_detail_date2."' ");  
        
        $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $row = $resultSet->current();
        $entry = array();
    $entry['MONTANT'] = $row['COUNT'];
    $entry['UTILISE'] = $row['COUNT2'];
    $entry['SOLDE'] = $row['COUNT3'];
        return $entry;
    }



    




    public function getSumByBonNeutreBanque($bon_neutre_id) {
        $table = new Application_Model_DbTable_EuBonNeutreDetail();
        $select = $table->select();
        $select->from($table,array('SUM(bon_neutre_detail_montant_solde) as somme'));
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
        $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where('bon_neutre_detail_numero IS NOT NULL');
        $select->where('bon_neutre_detail_date_numero IS NOT NULL');
        $select->where('bon_neutre_detail_banque IS NOT NULL');
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
           return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }
    

    public function fetchAllByBonNeutreBanque($bon_neutre_id) {
        $select = $this->getDbTable()->select();
        $select->where('bon_neutre_id = ?', $bon_neutre_id);
        $select->where("bon_neutre_detail_montant_solde > ? ", 0);
        $select->where('bon_neutre_detail_numero IS NOT NULL');
        $select->where('bon_neutre_detail_date_numero IS NOT NULL');
        $select->where('bon_neutre_detail_banque IS NOT NULL');
        $select->order("bon_neutre_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
              $entry = new Application_Model_EuBonNeutreDetail();
              $entry->setBon_neutre_detail_id($row->bon_neutre_detail_id)
                    ->setBon_neutre_detail_code($row->bon_neutre_detail_code)
                      ->setBon_neutre_id($row->bon_neutre_id)
                      ->setBon_neutre_detail_montant($row->bon_neutre_detail_montant)
                    ->setBon_neutre_detail_montant_utilise($row->bon_neutre_detail_montant_utilise)
            ->setBon_neutre_detail_montant_solde($row->bon_neutre_detail_montant_solde)
            ->setBon_neutre_detail_date($row->bon_neutre_detail_date)
                  ->setBon_neutre_detail_numero($row->bon_neutre_detail_numero)
                  ->setBon_neutre_detail_date_numero($row->bon_neutre_detail_date_numero)
                  ->setBon_neutre_detail_banque($row->bon_neutre_detail_banque)
                  ->setBon_neutre_detail_vignette($row->bon_neutre_detail_vignette)
                  ->setId_canton($row->id_canton)
          ->setBon_neutre_tiers_id($row->bon_neutre_tiers_id)
                ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_detail_type($row->bon_neutre_detail_type)
                  ->setBon_neutre_detail_commission($row->bon_neutre_detail_commission)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
    
    
    public function fetchAllByTableauBordNombre($bon_neutre_detail_montant1 = 0, $bon_neutre_detail_montant2 = 0, $bon_neutre_code_membre = "", $bon_neutre_detail_banque = "", $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $bon_neutre_tiers_id = 0, $bon_neutre_detail_date1 = "", $bon_neutre_detail_date2 = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(bon_neutre_detail_id) as COUNT'));
        if($bon_neutre_detail_montant1 > 0 && $bon_neutre_detail_montant2 > 0){
        $select->where("bon_neutre_detail_montant >= ? ", $bon_neutre_detail_montant1);  
        $select->where("bon_neutre_detail_montant <= ? ", $bon_neutre_detail_montant2);  
        }else if($bon_neutre_detail_montant1 > 0){
        $select->where("bon_neutre_detail_montant >= ? ", $bon_neutre_detail_montant1);  
        }else if($bon_neutre_detail_montant2 > 0){
        $select->where("bon_neutre_detail_montant <= ? ", $bon_neutre_detail_montant2);  
        }
        if($bon_neutre_code_membre != ""){
        $select->where("bon_neutre_id IN (SELECT bon_neutre_id FROM eu_bon_neutre WHERE bon_neutre_code_membre LIKE ? )", $bon_neutre_code_membre);  
        }
        if($bon_neutre_detail_banque != ""){
        $select->where("bon_neutre_detail_banque LIKE ? ", $bon_neutre_detail_banque);  
        }
        if($id_canton > 0) {
          $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
          $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
            
        if($bon_neutre_tiers_id > 0){
        $select->where("bon_neutre_tiers_id IS NOT NULL");  
        }else{
        $select->where("bon_neutre_tiers_id IS NULL");    
        }
        
        $select->where("(bon_neutre_detail_date) BETWEEN  '".$bon_neutre_detail_date1."' AND '".$bon_neutre_detail_date2."' ");  
        
        $select->order("bon_neutre_detail_id DESC");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

  



}


?>
