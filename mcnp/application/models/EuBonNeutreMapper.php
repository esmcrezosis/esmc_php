<?php
 
class Application_Model_EuBonNeutreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonNeutre');
        }
        return $this->_dbTable;
    }

    public function find($bon_neutre_id, Application_Model_EuBonNeutre $bon_neutre) {
        $result = $this->getDbTable()->find($bon_neutre_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_neutre->setBon_neutre_id($row->bon_neutre_id)
                ->setBon_neutre_code($row->bon_neutre_code)
                ->setBon_neutre_type($row->bon_neutre_type)
                ->setBon_neutre_montant($row->bon_neutre_montant)
                ->setBon_neutre_montant_utilise($row->bon_neutre_montant_utilise)
                ->setBon_neutre_code_membre($row->bon_neutre_code_membre)
                ->setBon_neutre_montant_solde($row->bon_neutre_montant_solde)
                ->setBon_neutre_date($row->bon_neutre_date)
                ->setBon_neutre_nom($row->bon_neutre_nom)
                ->setBon_neutre_prenom($row->bon_neutre_prenom)
                ->setBon_neutre_mobile($row->bon_neutre_mobile)
                ->setBon_neutre_email($row->bon_neutre_email)
                ->setBon_neutre_codebarre($row->bon_neutre_codebarre)
                ->setBon_neutre_raison($row->bon_neutre_raison)
				;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("bon_neutre_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutre();
            $entry->setBon_neutre_id($row->bon_neutre_id)
	                ->setBon_neutre_code($row->bon_neutre_code)
                    ->setBon_neutre_type($row->bon_neutre_type)
                    ->setBon_neutre_montant($row->bon_neutre_montant)
	                ->setBon_neutre_montant_utilise($row->bon_neutre_montant_utilise)
	                ->setBon_neutre_code_membre($row->bon_neutre_code_membre)
					->setBon_neutre_montant_solde($row->bon_neutre_montant_solde)
					->setBon_neutre_date($row->bon_neutre_date)
                ->setBon_neutre_nom($row->bon_neutre_nom)
                ->setBon_neutre_prenom($row->bon_neutre_prenom)
                ->setBon_neutre_mobile($row->bon_neutre_mobile)
                ->setBon_neutre_email($row->bon_neutre_email)
                ->setBon_neutre_codebarre($row->bon_neutre_codebarre)
                ->setBon_neutre_raison($row->bon_neutre_raison)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_neutre_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBonNeutre $bon_neutre) {
        $data = array(
            'bon_neutre_id' => $bon_neutre->getBon_neutre_id(),
            'bon_neutre_code' => $bon_neutre->getBon_neutre_code(),
            'bon_neutre_type' => $bon_neutre->getBon_neutre_type(),
            'bon_neutre_montant' => $bon_neutre->getBon_neutre_montant(),
            'bon_neutre_montant_utilise' => $bon_neutre->getBon_neutre_montant_utilise(),
            'bon_neutre_code_membre' => $bon_neutre->getBon_neutre_code_membre(),
            'bon_neutre_montant_solde' => $bon_neutre->getBon_neutre_montant_solde(),
            'bon_neutre_date' => $bon_neutre->getBon_neutre_date(),
            'bon_neutre_nom' => $bon_neutre->getBon_neutre_nom(),
            'bon_neutre_prenom' => $bon_neutre->getBon_neutre_prenom(),
            'bon_neutre_mobile' => $bon_neutre->getBon_neutre_mobile(),
            'bon_neutre_email' => $bon_neutre->getBon_neutre_email(),
            'bon_neutre_codebarre' => $bon_neutre->getBon_neutre_codebarre(),
            'bon_neutre_raison' => $bon_neutre->getBon_neutre_raison()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonNeutre $bon_neutre) {
        $data = array(
            'bon_neutre_id' => $bon_neutre->getBon_neutre_id(),
            'bon_neutre_code' => $bon_neutre->getBon_neutre_code(),
            'bon_neutre_type' => $bon_neutre->getBon_neutre_type(),
            'bon_neutre_montant' => $bon_neutre->getBon_neutre_montant(),
            'bon_neutre_montant_utilise' => $bon_neutre->getBon_neutre_montant_utilise(),
            'bon_neutre_code_membre' => $bon_neutre->getBon_neutre_code_membre(),
            'bon_neutre_montant_solde' => $bon_neutre->getBon_neutre_montant_solde(),
            'bon_neutre_date' => $bon_neutre->getBon_neutre_date(),
            'bon_neutre_nom' => $bon_neutre->getBon_neutre_nom(),
            'bon_neutre_prenom' => $bon_neutre->getBon_neutre_prenom(),
            'bon_neutre_mobile' => $bon_neutre->getBon_neutre_mobile(),
            'bon_neutre_email' => $bon_neutre->getBon_neutre_email(),
            'bon_neutre_codebarre' => $bon_neutre->getBon_neutre_codebarre(),
            'bon_neutre_raison' => $bon_neutre->getBon_neutre_raison()
        );
        $this->getDbTable()->update($data, array('bon_neutre_id = ?' => $bon_neutre->getBon_neutre_id()));
    }

    public function delete($bon_neutre_id) {
        $this->getDbTable()->delete(array('bon_neutre_id = ?' => $bon_neutre_id));
    }


    public function fetchAllByType($bon_neutre_type) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_type = ? ", $bon_neutre_type);
		$select->order("bon_neutre_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutre();
            $entry->setBon_neutre_id($row->bon_neutre_id)
	                ->setBon_neutre_code($row->bon_neutre_code)
                    ->setBon_neutre_type($row->bon_neutre_type)
                    ->setBon_neutre_montant($row->bon_neutre_montant)
	                ->setBon_neutre_montant_utilise($row->bon_neutre_montant_utilise)
	                ->setBon_neutre_code_membre($row->bon_neutre_code_membre)
					->setBon_neutre_montant_solde($row->bon_neutre_montant_solde)
					->setBon_neutre_date($row->bon_neutre_date)
                ->setBon_neutre_nom($row->bon_neutre_nom)
                ->setBon_neutre_prenom($row->bon_neutre_prenom)
                ->setBon_neutre_mobile($row->bon_neutre_mobile)
                ->setBon_neutre_email($row->bon_neutre_email)
                ->setBon_neutre_codebarre($row->bon_neutre_codebarre)
                ->setBon_neutre_raison($row->bon_neutre_raison)
				;
            $entries[] = $entry;
        }
        return $entries;
    }


	

    

	
	
    public function fetchAllByCode($bon_neutre_code) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_code = ? ", $bon_neutre_code);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBonNeutre();
            $entry->setBon_neutre_id($row->bon_neutre_id)
	                ->setBon_neutre_code($row->bon_neutre_code)
                    ->setBon_neutre_type($row->bon_neutre_type)
                    ->setBon_neutre_montant($row->bon_neutre_montant)
	                ->setBon_neutre_montant_utilise($row->bon_neutre_montant_utilise)
	                ->setBon_neutre_code_membre($row->bon_neutre_code_membre)
					->setBon_neutre_montant_solde($row->bon_neutre_montant_solde)
					->setBon_neutre_date($row->bon_neutre_date)
                ->setBon_neutre_nom($row->bon_neutre_nom)
                ->setBon_neutre_prenom($row->bon_neutre_prenom)
                ->setBon_neutre_mobile($row->bon_neutre_mobile)
                ->setBon_neutre_email($row->bon_neutre_email)
                ->setBon_neutre_codebarre($row->bon_neutre_codebarre)
                ->setBon_neutre_raison($row->bon_neutre_raison)
				;
			$entries = $entry;
        return $entries;
    }
	
	
	
    public function fetchAllByMembre($bon_neutre_code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("bon_neutre_code_membre = ? ", $bon_neutre_code_membre);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBonNeutre();
            $entry->setBon_neutre_id($row->bon_neutre_id)
	                ->setBon_neutre_code($row->bon_neutre_code)
                    ->setBon_neutre_type($row->bon_neutre_type)
                    ->setBon_neutre_montant($row->bon_neutre_montant)
	                ->setBon_neutre_montant_utilise($row->bon_neutre_montant_utilise)
	                ->setBon_neutre_code_membre($row->bon_neutre_code_membre)
					->setBon_neutre_montant_solde($row->bon_neutre_montant_solde)
					->setBon_neutre_date($row->bon_neutre_date)
                ->setBon_neutre_nom($row->bon_neutre_nom)
                ->setBon_neutre_prenom($row->bon_neutre_prenom)
                ->setBon_neutre_mobile($row->bon_neutre_mobile)
                ->setBon_neutre_email($row->bon_neutre_email)
                ->setBon_neutre_codebarre($row->bon_neutre_codebarre)
                ->setBon_neutre_raison($row->bon_neutre_raison)
				;
			$entries = $entry;
        return $entries;
    }
	
	
	
	
    
    
    
    public function fetchAllByMembreBAn($bon_neutre_code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_code_membre = ? ", $bon_neutre_code_membre);
        $select->order("bon_neutre_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutre();
            $entry->setBon_neutre_id($row->bon_neutre_id)
                    ->setBon_neutre_code($row->bon_neutre_code)
                    ->setBon_neutre_type($row->bon_neutre_type)
                    ->setBon_neutre_montant($row->bon_neutre_montant)
                    ->setBon_neutre_montant_utilise($row->bon_neutre_montant_utilise)
                    ->setBon_neutre_code_membre($row->bon_neutre_code_membre)
                    ->setBon_neutre_montant_solde($row->bon_neutre_montant_solde)
                    ->setBon_neutre_date($row->bon_neutre_date)
                ->setBon_neutre_nom($row->bon_neutre_nom)
                ->setBon_neutre_prenom($row->bon_neutre_prenom)
                ->setBon_neutre_mobile($row->bon_neutre_mobile)
                ->setBon_neutre_email($row->bon_neutre_email)
                ->setBon_neutre_raison($row->bon_neutre_raison)
                ->setBon_neutre_codebarre($row->bon_neutre_codebarre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    
    
    
    

    
	

}


?>
