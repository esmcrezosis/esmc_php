 <?php

class Application_Model_EuBpsSouscriptionMapper  {

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
            $this->setDbTable('Application_Model_DbTable_EuBpsSouscription');
        }
        return $this->_dbTable;
    }

    
    public function find($id_bps_souscription, Application_Model_EuBpsSouscription $bpssouscription) {
        $result = $this->getDbTable()->find($id_bps_souscription);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $bpssouscription->setId_bps_souscription($row->id_bps_souscription)
                        ->setBps_demande($row->bps_demande)
                        ->setMontant_bps_souscription($row->montant_bps_souscription)
                        ->setDate_bps_souscription($row->date_bps_souscription)
                        ->setId_mstiers($row->id_mstiers)
						->setDelai_bps_souscription($row->delai_bps_souscription)
						->setCode_smcipn($row->code_smcipn)
						->setAllouer($row->allouer);
	}
	
	
    public function findByMembre($membre) {
        $table = new Application_Model_DbTable_EuBpsSouscription();
        $select = $table->select();
        $select->where('code_membre_souscripteur like ?', $membre);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach($result as $row) {
            $entry = new Application_Model_EuBpsSouscription();
            $entry->setId_bps_souscription($row->id_bps_souscription)
                  ->setBps_demande($row->bps_demande)
                  ->setMontant_bps_souscription($row->montant_bps_souscription)
                  ->setDate_bps_souscription($row->date_bps_souscription)
                  ->setId_mstiers($row->id_mstiers)
				  ->setDelai_bps_souscription($row->delai_bps_souscription)
				  ->setCode_smcipn($row->code_smcipn)
				  ->setAllouer($row->allouer);

            $entries[] = $entry;
        }
        return $entries;
    }
    
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuBpsSouscription();
            $entry->setId_bps_souscription($row->id_bps_souscription)
                  ->setBps_demande($row->bps_demande)
                  ->setMontant_bps_souscription($row->montant_bps_souscription)
                  ->setDate_bps_souscription($row->date_bps_souscription)
                  ->setId_mstiers($row->id_mstiers)
				  ->setDelai_bps_souscription($row->delai_bps_souscription)
				  ->setCode_smcipn($row->code_smcipn)
				  ->setAllouer($row->allouer);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_bps_souscription) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuBpsSouscription $bpssouscription) {
        $data = array(
            'id_bps_souscription' => $bpssouscription->getId_bps_souscription(),
            'bps_demande' => $bpssouscription->getBps_demande(),
            'montant_bps_souscription' => $bpssouscription->getMontant_bps_souscription(),
            'date_bps_souscription' => $bpssouscription->getDate_bps_souscription(),
            'id_mstiers' => $bpssouscription->getId_mstiers(),
			'delai_bps_souscription' => $bpssouscription->getDelai_bps_souscription(),
			'code_smcipn' => $bpssouscription->getCode_smcipn(),
			'allouer' => $bpssouscription->getAllouer()
			
        );
        $this->getDbTable()->insert($data);
    }

	
    public function update(Application_Model_EuBpsSouscription $bpssouscription) {
        $data = array(
            'id_bps_souscription' => $bpssouscription->getId_bps_souscription(),
            'bps_demande' => $bpssouscription->getBps_demande(),
            'montant_bps_souscription' => $bpssouscription->getMontant_bps_souscription(),
            'date_bps_souscription' => $bpssouscription->getDate_bps_souscription(),
            'id_mstiers' => $bpssouscription->getId_mstiers(),
			'delai_bps_souscription' => $bpssouscription->getDelai_bps_souscription(),
			'code_smcipn' => $bpssouscription->getCode_smcipn(),
			'allouer' => $bpssouscription->getAllouer()
        );
        $this->getDbTable()->update($data, array('id_bps_souscription = ?' => $bpssouscription->getId_bps_souscription()));
    }
	

    public function delete($id_bps_souscription) {
        $this->getDbTable()->delete(array('id_bps_souscription = ?' => $id_bps_souscription));
    }


}

?>
