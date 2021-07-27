<?php

class Application_Model_EuBalanceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBalance');
        }
        return $this->_dbTable;
    }
	
	
    public function find($id_balance, Application_Model_EuBalance $balance) {
        $result = $this->getDbTable()->find($id_balance);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $balance->setId_balance($row->id_balance)
                ->setSolde_debiteur1($row->solde_debiteur1)
                ->setSolde_crediteur1($row->solde_crediteur1)
                ->setMontant_versement($row->montant_versement)
                ->setMontant_transfertrecu($row->montant_transfertrecu)
				->setMontant_cheque($row->montant_cheque)
				->setMontant_opi($row->montant_opi)
				->setMontant_transfertemis($row->montant_transfertemis)
				->setSolde_debiteur2($row->solde_debiteur2)
                ->setSolde_crediteur2($row->solde_crediteur2)
				->setMontant_dat($row->montant_dat)
                ->setMontant_decouvert($row->montant_decouvert)
				->setSolde_disponible1($row->solde_disponible1)
                ->setSolde_disponible2($row->solde_disponible2)
				->setDate_balance($row->date_balance)
				->setDate_balance_effective($row->date_balance_effective)
                ->setCode_banque($row->code_banque)
				->setDate_creation($row->date_creation)
				->setType_compte($row->type_compte);
    }

	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBalance();
            $entry->setId_balance($row->id_balance)
                  ->setSolde_debiteur1($row->solde_debiteur1)
                  ->setSolde_crediteur1($row->solde_crediteur1)
                  ->setMontant_versement($row->montant_versement)
                  ->setMontant_transfertrecu($row->montant_transfertrecu)
				  ->setMontant_cheque($row->montant_cheque)
				  ->setMontant_opi($row->montant_opi)
				  ->setMontant_transfertemis($row->montant_transfertemis)
				  ->setSolde_debiteur2($row->solde_debiteur2)
                  ->setSolde_crediteur2($row->solde_crediteur2)
				  ->setMontant_dat($row->montant_dat)
                  ->setMontant_decouvert($row->montant_decouvert)
				  ->setSolde_disponible1($row->solde_disponible1)
                  ->setSolde_disponible2($row->solde_disponible2)
				  ->setDate_balance($row->date_balance)
				  ->setDate_balance_effective($row->date_balance_effective)
                  ->setCode_banque($row->code_banque)
				  ->setDate_creation($row->date_creation)
				  ->setType_compte($row->type_compte);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function findByBanque($code_banque,$type_compte) {
		$select = $this->getDbTable()->select();
		$select->where('code_banque like ?',$code_banque);
		$select->where('type_compte like ?',$type_compte);
		$resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return NULL;
        }
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBalance();
            $entry->setId_balance($row->id_balance)
                  ->setSolde_debiteur1($row->solde_debiteur1)
                  ->setSolde_crediteur1($row->solde_crediteur1)
                  ->setMontant_versement($row->montant_versement)
                  ->setMontant_transfertrecu($row->montant_transfertrecu)
				  ->setMontant_cheque($row->montant_cheque)
				  ->setMontant_opi($row->montant_opi)
				  ->setMontant_transfertemis($row->montant_transfertemis)
				  ->setSolde_debiteur2($row->solde_debiteur2)
                  ->setSolde_crediteur2($row->solde_crediteur2)
				  ->setMontant_dat($row->montant_dat)
                  ->setMontant_decouvert($row->montant_decouvert)
				  ->setSolde_disponible1($row->solde_disponible1)
                  ->setSolde_disponible2($row->solde_disponible2)
				  ->setDate_balance($row->date_balance)
				  ->setDate_balance_effective($row->date_balance_effective)
                  ->setCode_banque($row->code_banque)
				  ->setDate_creation($row->date_creation)
				  ->setType_compte($row->type_compte);
            $entries[] = $entry;
        }
        return $entries;
	
	}
	
	
	
	public function findBalanceByDate($date_balance,$code_banque,$type_compte) {
	    $date_balance = new Zend_Date($date_balance);
		$select = $this->getDbTable()->select();
		$select->where('date_balance = ?',$date_balance->toString('yyyy-MM-dd'));
		$select->where('code_banque like ?',$code_banque);
		$select->where('type_compte like ?',$type_compte);
		$resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
           return NULL;
        }
		$row = $resultSet->current();
        $entry = new Application_Model_EuBalance();
		$entry->setId_balance($row->id_balance)
              ->setSolde_debiteur1($row->solde_debiteur1)
              ->setSolde_crediteur1($row->solde_crediteur1)
              ->setMontant_versement($row->montant_versement)
              ->setMontant_transfertrecu($row->montant_transfertrecu)
			  ->setMontant_cheque($row->montant_cheque)
			  ->setMontant_opi($row->montant_opi)
			  ->setMontant_transfertemis($row->montant_transfertemis)
			  ->setSolde_debiteur2($row->solde_debiteur2)
              ->setSolde_crediteur2($row->solde_crediteur2)
			  ->setMontant_dat($row->montant_dat)
              ->setMontant_decouvert($row->montant_decouvert)
			  ->setSolde_disponible1($row->solde_disponible1)
              ->setSolde_disponible2($row->solde_disponible2)
			  ->setDate_balance($row->date_balance)
			  ->setDate_balance_effective($row->date_balance_effective)
              ->setCode_banque($row->code_banque)
			  ->setDate_creation($row->date_creation)
			  ->setType_compte($row->type_compte);
	    return $entry;
	}

	
    public function findConuter() {
       $select = $this->getDbTable()->select();
       $select->from($this->getDbTable(), array('COUNT(id_balance) as count'));
       $result = $this->getDbTable()->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }

	
    public function save(Application_Model_EuBalance $balance) {
        $data = array(
          'id_balance' => $balance->getId_balance(),
          'solde_debiteur1' => $balance->getSolde_debiteur1(),
          'solde_crediteur1' => $balance->getSolde_crediteur1(),
          'montant_versement' => $balance->getMontant_versement(),
          'montant_transfertrecu' => $balance->getMontant_transfertrecu(),
		  'montant_cheque' => $balance->getMontant_cheque(),
		  'montant_opi' => $balance->getMontant_opi(),
		  'montant_transfertemis' => $balance->getMontant_transfertemis(),
		  'solde_debiteur2' => $balance->getSolde_debiteur2(),
          'solde_crediteur2' => $balance->getSolde_crediteur2(),
		  'montant_dat' => $balance->getMontant_dat(),
          'montant_decouvert' => $balance->getMontant_decouvert(),
		  'solde_disponible1' => $balance->getSolde_disponible1(),
          'solde_disponible2' => $balance->getSolde_disponible2(),
		  'date_balance' => $balance->getDate_balance(),
		  'date_balance_effective' => $balance->getDate_balance_effective(),
		  'code_banque' => $balance->getCode_banque(),
		  'date_creation' => $balance->getDate_creation(),
		  'type_compte' => $balance->getType_compte()
        );
        $this->getDbTable()->insert($data);
    }

	
    public function update(Application_Model_EuBalance $balance) {
        $data = array(
          'id_balance' => $balance->getId_balance(),
          'solde_debiteur1' => $balance->getSolde_debiteur1(),
          'solde_crediteur1' => $balance->getSolde_crediteur1(),
          'montant_versement' => $balance->getMontant_versement(),
          'montant_transfertrecu' => $balance->getMontant_transfertrecu(),
		  'montant_cheque' => $balance->getMontant_cheque(),
		  'montant_opi' => $balance->getMontant_opi(),
		  'montant_transfertemis' => $balance->getMontant_transfertemis(),
		  'solde_debiteur2' => $balance->getSolde_debiteur2(),
          'solde_crediteur2' => $balance->getSolde_crediteur2(),
		  'montant_dat' => $balance->getMontant_dat(),
          'montant_decouvert' => $balance->getMontant_decouvert(),
		  'solde_disponible1' => $balance->getSolde_disponible1(),
          'solde_disponible2' => $balance->getSolde_disponible2(),
		  'date_balance' => $balance->getDate_balance(),
		  'date_balance_effective' => $balance->getDate_balance_effective(),
		  'code_banque' => $balance->getCode_banque(),
		  'date_creation' => $balance->getDate_creation(),
		  'type_compte' => $balance->getType_compte()
        );
        $this->getDbTable()->update($data, array('id_balance = ?' => $balance->getId_balance()));
    }

	
    public function delete($id_balance) {
      $this->getDbTable()->delete(array('id_balance = ?' => $id_balance));
    }

}
