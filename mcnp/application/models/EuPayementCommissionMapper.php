<?php
 
class Application_Model_EuPayementCommissionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPayementCommission');
        }
        return $this->_dbTable;
    }

    public function find($payement_commission_id, Application_Model_EuPayementCommission $payement_commission) {
        $result = $this->getDbTable()->find($payement_commission_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $payement_commission->setPayement_commission_id($row->payement_commission_id)
                ->setPayement_commission_montant($row->payement_commission_montant)
                ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                ->setPayement_commission_demande($row->payement_commission_demande)
                ->setPayement_commission_payer($row->payement_commission_payer)
                ->setPayement_commission_date_payer($row->payement_commission_date_payer)
                ->setPayement_commission_date_debut($row->payement_commission_date_debut)
                ->setPayement_commission_date_fin($row->payement_commission_date_fin)
                ->setMembreasso_id($row->membreasso_id)
                ->setId_type_commission($row->id_type_commission)
                ->setId_mode_payement($row->id_mode_payement)
                ->setPayement_commission_type($row->payement_commission_type)
				;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		//$select->order("payement_commission_date_debut DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPayementCommission();
            $entry->setPayement_commission_id($row->payement_commission_id)
	                ->setPayement_commission_montant($row->payement_commission_montant)
                    ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                    ->setPayement_commission_demande($row->payement_commission_demande)
	                ->setPayement_commission_payer($row->payement_commission_payer)
					->setPayement_commission_date_payer($row->payement_commission_date_payer)
					->setPayement_commission_date_debut($row->payement_commission_date_debut)
					->setPayement_commission_date_fin($row->payement_commission_date_fin)
					->setMembreasso_id($row->membreasso_id)
					->setId_type_commission($row->id_type_commission)
					->setId_mode_payement($row->id_mode_payement)
					->setPayement_commission_type($row->payement_commission_type)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(payement_commission_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuPayementCommission $payement_commission) {
        $data = array(
            'payement_commission_id' => $payement_commission->getPayement_commission_id(),
            'payement_commission_montant' => $payement_commission->getPayement_commission_montant(),
            'payement_commission_date_demande' => $payement_commission->getPayement_commission_date_demande(),
            'payement_commission_demande' => $payement_commission->getPayement_commission_demande(),
            'payement_commission_payer' => $payement_commission->getPayement_commission_payer(),
            'payement_commission_date_payer' => $payement_commission->getPayement_commission_date_payer(),
            'payement_commission_date_debut' => $payement_commission->getPayement_commission_date_debut(),
            'payement_commission_date_fin' => $payement_commission->getPayement_commission_date_fin(),
            'membreasso_id' => $payement_commission->getMembreasso_id(),
            'id_type_commission' => $payement_commission->getId_type_commission(),
            'id_mode_payement' => $payement_commission->getId_mode_payement(),
            'payement_commission_type' => $payement_commission->getPayement_commission_type()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPayementCommission $payement_commission) {
        $data = array(
            'payement_commission_id' => $payement_commission->getPayement_commission_id(),
            'payement_commission_montant' => $payement_commission->getPayement_commission_montant(),
            'payement_commission_date_demande' => $payement_commission->getPayement_commission_date_demande(),
            'payement_commission_demande' => $payement_commission->getPayement_commission_demande(),
            'payement_commission_payer' => $payement_commission->getPayement_commission_payer(),
            'payement_commission_date_payer' => $payement_commission->getPayement_commission_date_payer(),
            'payement_commission_date_debut' => $payement_commission->getPayement_commission_date_debut(),
            'payement_commission_date_fin' => $payement_commission->getPayement_commission_date_fin(),
            'membreasso_id' => $payement_commission->getMembreasso_id(),
            'id_type_commission' => $payement_commission->getId_type_commission(),
            'id_mode_payement' => $payement_commission->getId_mode_payement(),
            'payement_commission_type' => $payement_commission->getPayement_commission_type()
        );
        $this->getDbTable()->update($data, array('payement_commission_id = ?' => $payement_commission->getPayement_commission_id()));
    }

    public function delete($payement_commission_id) {
        $this->getDbTable()->delete(array('payement_commission_id = ?' => $payement_commission_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		//$select->order("payement_commission_date_debut DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPayementCommission();
            $entry->setPayement_commission_id($row->payement_commission_id)
	                ->setPayement_commission_montant($row->payement_commission_montant)
                    ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                    ->setPayement_commission_demande($row->payement_commission_demande)
	                ->setPayement_commission_payer($row->payement_commission_payer)
					->setPayement_commission_date_payer($row->payement_commission_date_payer)
					->setPayement_commission_date_debut($row->payement_commission_date_debut)
					->setPayement_commission_date_fin($row->payement_commission_date_fin)
					->setMembreasso_id($row->membreasso_id)
					->setId_type_commission($row->id_type_commission)
					->setId_mode_payement($row->id_mode_payement)
					->setPayement_commission_type($row->payement_commission_type)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembreasso($membreasso_id, $date_debut, $date_fin) {
        $select = $this->getDbTable()->select();
		$select->where('membreasso_id = ? ', $membreasso_id);
		$select->where('payement_commission_date_debut = ? ', $date_debut);
		$select->where('payement_commission_date_fin = ? ', $date_fin);
		$select->order("payement_commission_date_debut DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPayementCommission();
            $entry->setPayement_commission_id($row->payement_commission_id)
	                ->setPayement_commission_montant($row->payement_commission_montant)
                    ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                    ->setPayement_commission_demande($row->payement_commission_demande)
	                ->setPayement_commission_payer($row->payement_commission_payer)
					->setPayement_commission_date_payer($row->payement_commission_date_payer)
					->setPayement_commission_date_debut($row->payement_commission_date_debut)
					->setPayement_commission_date_fin($row->payement_commission_date_fin)
					->setMembreasso_id($row->membreasso_id)
					->setId_type_commission($row->id_type_commission)
					->setId_mode_payement($row->id_mode_payement)
					->setPayement_commission_type($row->payement_commission_type)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function fetchAllByPeriode($date_debut, $date_fin) {
        $select = $this->getDbTable()->select();
		$select->where('payement_commission_date_debut = ? ', $date_debut);
		$select->where('payement_commission_date_fin = ? ', $date_fin);
		$select->where('payement_commission_payer = ? ', 0);
		$select->order("payement_commission_date_debut DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPayementCommission();
            $entry->setPayement_commission_id($row->payement_commission_id)
	                ->setPayement_commission_montant($row->payement_commission_montant)
                    ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                    ->setPayement_commission_demande($row->payement_commission_demande)
	                ->setPayement_commission_payer($row->payement_commission_payer)
					->setPayement_commission_date_payer($row->payement_commission_date_payer)
					->setPayement_commission_date_debut($row->payement_commission_date_debut)
					->setPayement_commission_date_fin($row->payement_commission_date_fin)
					->setMembreasso_id($row->membreasso_id)
					->setId_type_commission($row->id_type_commission)
					->setId_mode_payement($row->id_mode_payement)
					->setPayement_commission_type($row->payement_commission_type)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByPeriode2($date_debut, $date_fin) {
        $select = $this->getDbTable()->select();
		$select->where('payement_commission_date_debut = ? ', $date_debut);
		$select->where('payement_commission_date_fin = ? ', $date_fin);
		$select->where('payement_commission_payer = ? ', 1);
		$select->order("payement_commission_date_debut DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPayementCommission();
            $entry->setPayement_commission_id($row->payement_commission_id)
	                ->setPayement_commission_montant($row->payement_commission_montant)
                    ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                    ->setPayement_commission_demande($row->payement_commission_demande)
	                ->setPayement_commission_payer($row->payement_commission_payer)
					->setPayement_commission_date_payer($row->payement_commission_date_payer)
					->setPayement_commission_date_debut($row->payement_commission_date_debut)
					->setPayement_commission_date_fin($row->payement_commission_date_fin)
					->setMembreasso_id($row->membreasso_id)
					->setId_type_commission($row->id_type_commission)
					->setId_mode_payement($row->id_mode_payement)
					->setPayement_commission_type($row->payement_commission_type)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByPayer() {
        $select = $this->getDbTable()->select();
		$select->where('payement_commission_payer = ? ', 1);
		$select->order("payement_commission_date_debut DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPayementCommission();
            $entry->setPayement_commission_id($row->payement_commission_id)
	                ->setPayement_commission_montant($row->payement_commission_montant)
                    ->setPayement_commission_date_demande($row->payement_commission_date_demande)
                    ->setPayement_commission_demande($row->payement_commission_demande)
	                ->setPayement_commission_payer($row->payement_commission_payer)
					->setPayement_commission_date_payer($row->payement_commission_date_payer)
					->setPayement_commission_date_debut($row->payement_commission_date_debut)
					->setPayement_commission_date_fin($row->payement_commission_date_fin)
					->setMembreasso_id($row->membreasso_id)
					->setId_type_commission($row->id_type_commission)
					->setId_mode_payement($row->id_mode_payement)
					->setPayement_commission_type($row->payement_commission_type)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
