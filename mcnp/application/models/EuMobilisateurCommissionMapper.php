    <?php

 
class Application_Model_EuMobilisateurCommissionMapper  {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if(is_string($dbTable)) {
           $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuMobilisateurCommission');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuMobilisateurCommission $mobilisateur_commission) {
      $data = array(
	    'id_mobilisateur_commission' => $mobilisateur_commission->getId_mobilisateur_commission(),
        'code_membre' => $mobilisateur_commission->getCode_membre(),
        'id_mstiers' => $mobilisateur_commission->getId_mstiers(),
	    'datecreat' => $mobilisateur_commission->getDatecreat(),
        'montant_mstiers' => $mobilisateur_commission->getMontant_mstiers(),
        'montant_commission' => $mobilisateur_commission->getMontant_commission(),
        'montant_ban' => $mobilisateur_commission->getMontant_ban(),
        'montant_bai' => $mobilisateur_commission->getMontant_bai(),
        'montant_opi' => $mobilisateur_commission->getMontant_opi(),
        'membreasso_id' => $mobilisateur_commission->getMembreasso_id(),
        'payer' => $mobilisateur_commission->getPayer()
      );
      $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuMobilisateurCommission $mobilisateur_commission) {
        $data = array(
		  'id_mobilisateur_commission' => $mobilisateur_commission->getId_mobilisateur_commission(),
          'code_membre' => $mobilisateur_commission->getCode_membre(),
          'id_mstiers' => $mobilisateur_commission->getId_mstiers(),
	      'datecreat' => $mobilisateur_commission->getDatecreat(),
        'montant_mstiers' => $mobilisateur_commission->getMontant_mstiers(),
        'montant_commission' => $mobilisateur_commission->getMontant_commission(),
        'montant_ban' => $mobilisateur_commission->getMontant_ban(),
        'montant_bai' => $mobilisateur_commission->getMontant_bai(),
        'montant_opi' => $mobilisateur_commission->getMontant_opi(),
        'membreasso_id' => $mobilisateur_commission->getMembreasso_id(),
        'payer' => $mobilisateur_commission->getPayer()
        );
        $this->getDbTable()->update($data, array('id_mobilisateur_commission = ?' => $mobilisateur_commission->getId_mobilisateur_commission()));
    }
	
	

    public function find($id_mobilisateur_commission, Application_Model_EuMobilisateurCommission $mobilisateur_commission) {
        $result = $this->getDbTable()->find($id_mobilisateur_commission);
        if(0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $mobilisateur_commission->setId_mobilisateur_commission($row->id_mobilisateur_commission)
		        ->setCode_membre($row->code_membre)
                ->setId_mstiers($row->id_mstiers)
				->setDatecreat($row->datecreat)
				->setMontant_mstiers($row->montant_mstiers)
				->setMontant_commission($row->montant_commission)
				->setMontant_ban($row->montant_ban)
				->setMontant_bai($row->montant_bai)
				->setMontant_opi($row->montant_opi)
				->setMembreasso_id($row->membreasso_id)
                ->setPayer($row->payer)
                ;
        return true;
    }
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuMobilisateurCommission();
            $entry->setId_mobilisateur_commission($row->id_mobilisateur_commission)
			      ->setCode_membre($row->code_membre)
                  ->setId_mstiers($row->id_mstiers)
				  ->setDatecreat($row->datecreat)
                ->setMontant_mstiers($row->montant_mstiers)
                ->setMontant_commission($row->montant_commission)
                ->setMontant_ban($row->montant_ban)
                ->setMontant_bai($row->montant_bai)
                ->setMontant_opi($row->montant_opi)
                ->setMembreasso_id($row->membreasso_id)
                ->setPayer($row->payer)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function delete($id_mobilisateur_commission) {
      $this->getDbTable()->delete(array('id_mobilisateur_commission = ?' => $id_mobilisateur_commission));
    }
        
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mobilisateur_commission) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }


}

?>
