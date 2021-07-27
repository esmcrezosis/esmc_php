<?php
 
class Application_Model_EuMembretierscodeMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuMembretierscode');
        }
        return $this->_dbTable;
    }

    public function find($membretierscode_id, Application_Model_EuMembretierscode $membretierscode) {
        $result = $this->getDbTable()->find($membretierscode_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $membretierscode->setMembretierscode_id($row->membretierscode_id)
                ->setMembretierscode_membretiers($row->membretierscode_membretiers)
                ->setMembretierscode_code($row->membretierscode_code)
                ->setMembretierscode_souscription($row->membretierscode_souscription)
                ->setCode_membre($row->code_membre)
                ->setPublier($row->publier)
				->setAllocation_cmfh_id($row->allocation_cmfh_id);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
	                ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	                ->setMembretierscode_code($row->membretierscode_code)
                    ->setMembretierscode_souscription($row->membretierscode_souscription)
                    ->setCode_membre($row->code_membre)
                	->setPublier($row->publier)
					->setAllocation_cmfh_id($row->allocation_cmfh_id);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(membretierscode_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuMembretierscode $membretierscode) {
        $data = array(
            'membretierscode_id' => $membretierscode->getMembretierscode_id(),
            'membretierscode_membretiers' => $membretierscode->getMembretierscode_membretiers(),
            'membretierscode_code' => $membretierscode->getMembretierscode_code(),
            'membretierscode_souscription' => $membretierscode->getMembretierscode_souscription(),
            'code_membre' => $membretierscode->getCode_membre(),
            'publier' => $membretierscode->getPublier(),
			'allocation_cmfh_id' => $membretierscode->getAllocation_cmfh_id()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembretierscode $membretierscode) {
        $data = array(
            'membretierscode_membretiers' => $membretierscode->getMembretierscode_membretiers(),
            'membretierscode_code' => $membretierscode->getMembretierscode_code(),
            'membretierscode_souscription' => $membretierscode->getMembretierscode_souscription(),
            'code_membre' => $membretierscode->getCode_membre(),
            'publier' => $membretierscode->getPublier(),
			'allocation_cmfh_id' => $membretierscode->getAllocation_cmfh_id()
        );
        $this->getDbTable()->update($data, array('membretierscode_id = ?' => $membretierscode->getMembretierscode_id()));
    }

    public function delete($membretierscode_id) {
        $this->getDbTable()->delete(array('membretierscode_id = ?' => $membretierscode_id));
    }
	
    public function fetchAll1() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
	              ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	              ->setMembretierscode_code($row->membretierscode_code)
                  ->setMembretierscode_souscription($row->membretierscode_souscription)
                  ->setCode_membre($row->code_membre)
                  ->setPublier($row->publier)
				  ->setAllocation_cmfh_id($row->allocation_cmfh_id)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
	              ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	              ->setMembretierscode_code($row->membretierscode_code)
                  ->setMembretierscode_souscription($row->membretierscode_souscription)
                  ->setCode_membre($row->code_membre)
                  ->setPublier($row->publier)
				  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		//$select->where("publier = ? ", 1);
		$select->order(array("membretierscode_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
	              ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	              ->setMembretierscode_code($row->membretierscode_code)
                  ->setMembretierscode_souscription($row->membretierscode_souscription)
                  ->setCode_membre($row->code_membre)
                  ->setPublier($row->publier)
				  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllBySouscription($membretierscode_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("membretierscode_souscription = ? ", $membretierscode_souscription);
		$select->order(array("membretierscode_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
	              ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	              ->setMembretierscode_code($row->membretierscode_code)
                  ->setMembretierscode_souscription($row->membretierscode_souscription)
                  ->setCode_membre($row->code_membre)
                  ->setPublier($row->publier)
				  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	public function findBySouscription($id_souscription) {
	   $select = $this->getDbTable()->select();
       $select->where('membretierscode_souscription = ?', $id_souscription)
			  ->where('publier = ?', 0);
       $results = $this->getDbTable()->fetchAll($select);
	   $entries = array();
       if (count($results) > 0) {
            foreach ($results as $row) {
               $entry = new Application_Model_EuMembretierscode();
               $entry->setMembretierscode_id($row->membretierscode_id)
                     ->setMembretierscode_membretiers($row->membretierscode_membretiers)
                     ->setMembretierscode_code($row->membretierscode_code)
                     ->setMembretierscode_souscription($row->membretierscode_souscription)
                     ->setCode_membre($row->code_membre)
                     ->setPublier($row->publier)
					 ->setAllocation_cmfh_id($row->allocation_cmfh_id);
			    $entries[] = $entry;			   
			}
            return $entries;
        } else {
            return NULL;
        }
	
	}
	
	
	public function findByCode($code) {
        $select = $this->getDbTable()->select();
        $select->where('membretierscode_code = ?', $code)
			   ->where('publier = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $membretiers = new Application_Model_EuMembretierscode();
            $membretiers->setMembretierscode_id($row->membretierscode_id)
                        ->setMembretierscode_membretiers($row->membretierscode_membretiers)
                        ->setMembretierscode_code($row->membretierscode_code)
                        ->setMembretierscode_souscription($row->membretierscode_souscription)
                        ->setCode_membre($row->code_membre)
                        ->setPublier($row->publier)
						->setAllocation_cmfh_id($row->allocation_cmfh_id);
            return $membretiers;
        } else {
            return NULL;
        }
    }
	
	
	
	

    public function fetchAllBySouscriptionMembretiers($membretierscode_souscription, $membretierscode_membretiers) {
        $select = $this->getDbTable()->select();
		$select->where("membretierscode_souscription = ? ", $membretierscode_souscription);
		$select->where("membretierscode_membretiers = ? ", $membretierscode_membretiers);
		//$select->order(array("membretierscode_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        $row = $resultSet->current();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
	              ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	              ->setMembretierscode_code($row->membretierscode_code)
                  ->setMembretierscode_souscription($row->membretierscode_souscription)
                  ->setCode_membre($row->code_membre)
                  ->setPublier($row->publier)
				  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
            //$entries[] = $entry;
        //}
        return $entry;
    }





    public function fetchAllByCodeMembre($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where('code_membre = ?', $code_membre);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuMembretierscode();
        $entry->setMembretierscode_id($row->membretierscode_id)
	          ->setMembretierscode_membretiers($row->membretierscode_membretiers)
	          ->setMembretierscode_code($row->membretierscode_code)
              ->setMembretierscode_souscription($row->membretierscode_souscription)
              ->setCode_membre($row->code_membre)
              ->setPublier($row->publier)
			  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
			$entries = $entry;
        return $entries;
    }






public function fetchAllByCodeActivation0($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("membretierscode_souscription IN (SELECT souscription_id FROM eu_depot_vente WHERE code_membre LIKE '%".$code_membre."%')");
        $select->where("publier = ? ", 0);
        $select->order(array("membretierscode_id ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
                    ->setMembretierscode_membretiers($row->membretierscode_membretiers)
                    ->setMembretierscode_code($row->membretierscode_code)
                ->setMembretierscode_souscription($row->membretierscode_souscription)
                ->setCode_membre($row->code_membre)
                    ->setPublier($row->publier)
                  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
            $entries[] = $entry;
        }
        return $entries;
    }


public function fetchAllByCodeActivation1($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("membretierscode_souscription IN (SELECT souscription_id FROM eu_depot_vente WHERE code_membre LIKE '%".$code_membre."%')");
        $select->where("publier = ? ", 1);
        $select->order(array("membretierscode_id ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretierscode();
            $entry->setMembretierscode_id($row->membretierscode_id)
                    ->setMembretierscode_membretiers($row->membretierscode_membretiers)
                    ->setMembretierscode_code($row->membretierscode_code)
                ->setMembretierscode_souscription($row->membretierscode_souscription)
                ->setCode_membre($row->code_membre)
                    ->setPublier($row->publier)
                  ->setAllocation_cmfh_id($row->allocation_cmfh_id);
            $entries[] = $entry;
        }
        return $entries;
    }
    





	
}


?>
