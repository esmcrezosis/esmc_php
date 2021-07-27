<?php
 
class Application_Model_EuRecuMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRecu');
        }
        return $this->_dbTable;
    }

    public function find($recu_id, Application_Model_EuRecu $recu) {
        $result = $this->getDbTable()->find($recu_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $recu->setRecu_id($row->recu_id)
                ->setRecu_numero($row->recu_numero)
                ->setRecu_bps($row->recu_bps)
                ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
                ->setRecu_code_membre($row->recu_code_membre)
                ->setRecu_utilisateur($row->recu_utilisateur)
                ->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("recu_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecu();
            $entry->setRecu_id($row->recu_id)
	                ->setRecu_numero($row->recu_numero)
                    ->setRecu_bps($row->recu_bps)
                    ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
	                ->setRecu_code_membre($row->recu_code_membre)
					->setRecu_utilisateur($row->recu_utilisateur)
					->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(recu_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRecu $recu) {
        $data = array(
            'recu_id' => $recu->getRecu_id(),
            'recu_numero' => $recu->getRecu_numero(),
            'recu_bps' => $recu->getRecu_bps(),
            'recu_montant' => $recu->getRecu_montant(),
            'recu_montant_credit' => $recu->getRecu_montant_credit(),
            'recu_code_membre' => $recu->getRecu_code_membre(),
            'recu_utilisateur' => $recu->getRecu_utilisateur(),
            'recu_date' => $recu->getRecu_date(),
            'recu_date_debut' => $recu->getRecu_date_debut(),
            'recu_date_fin' => $recu->getRecu_date_fin(),
            'recu_facture' => $recu->getRecu_facture(),
            'publier' => $recu->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRecu $recu) {
        $data = array(
            'recu_id' => $recu->getRecu_id(),
            'recu_numero' => $recu->getRecu_numero(),
            'recu_bps' => $recu->getRecu_bps(),
            'recu_montant' => $recu->getRecu_montant(),
            'recu_montant_credit' => $recu->getRecu_montant_credit(),
            'recu_code_membre' => $recu->getRecu_code_membre(),
            'recu_utilisateur' => $recu->getRecu_utilisateur(),
            'recu_date' => $recu->getRecu_date(),
            'recu_date_debut' => $recu->getRecu_date_debut(),
            'recu_date_fin' => $recu->getRecu_date_fin(),
            'recu_facture' => $recu->getRecu_facture(),
            'publier' => $recu->getPublier()
        );
        $this->getDbTable()->update($data, array('recu_id = ?' => $recu->getRecu_id()));
    }

    public function delete($recu_id) {
        $this->getDbTable()->delete(array('recu_id = ?' => $recu_id));
    }


    public function fetchAllByBps($recu_bps) {
        $select = $this->getDbTable()->select();
		$select->where("recu_bps = ? ", $recu_bps);
		$select->order("recu_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecu();
            $entry->setRecu_id($row->recu_id)
	                ->setRecu_numero($row->recu_numero)
                    ->setRecu_bps($row->recu_bps)
                    ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
	                ->setRecu_code_membre($row->recu_code_membre)
					->setRecu_utilisateur($row->recu_utilisateur)
					->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembre0($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("recu_code_membre = ? ", $code_membre);
		$select->order("recu_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecu();
            $entry->setRecu_id($row->recu_id)
	                ->setRecu_numero($row->recu_numero)
                    ->setRecu_bps($row->recu_bps)
                    ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
	                ->setRecu_code_membre($row->recu_code_membre)
					->setRecu_utilisateur($row->recu_utilisateur)
					->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByUtilisateur($utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("recu_utilisateur = ? ", $utilisateur);
		$select->order("recu_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecu();
            $entry->setRecu_id($row->recu_id)
	                ->setRecu_numero($row->recu_numero)
                    ->setRecu_bps($row->recu_bps)
                    ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
	                ->setRecu_code_membre($row->recu_code_membre)
					->setRecu_utilisateur($row->recu_utilisateur)
					->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	

	




    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(recu_id) as count'));
		$select->where("recu_numero LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(recu_id) as count'));
		//$select->where("recu_numero = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }


    public function fetchAllByMembre($membre) {
        $select = $this->getDbTable()->select();
		$select->where("recu_code_membre = ? ", $membre);
		$select->where("publier = ? ", 1);
		$select->order("recu_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecu();
            $entry->setRecu_id($row->recu_id)
	                ->setRecu_numero($row->recu_numero)
                    ->setRecu_bps($row->recu_bps)
                    ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
	                ->setRecu_code_membre($row->recu_code_membre)
					->setRecu_utilisateur($row->recu_utilisateur)
					->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllByZppe($zppe) {
        $select = $this->getDbTable()->select();
		$select->where("recu_bps IN (SELECT recu_bps_id FROM eu_recu_bps WHERE zppe_id = ?)", $zppe);
		$select->where("publier = ? ", 1);
		$select->order("recu_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecu();
            $entry->setRecu_id($row->recu_id)
	                ->setRecu_numero($row->recu_numero)
                    ->setRecu_bps($row->recu_bps)
                    ->setRecu_montant($row->recu_montant)
                ->setRecu_montant_credit($row->recu_montant_credit)
	                ->setRecu_code_membre($row->recu_code_membre)
					->setRecu_utilisateur($row->recu_utilisateur)
					->setRecu_date($row->recu_date)
                ->setRecu_date_debut($row->recu_date_debut)
                ->setRecu_date_fin($row->recu_date_fin)
                ->setRecu_facture($row->recu_facture)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	

}


?>
