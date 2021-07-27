<?php
 
class Application_Model_EuRelevebancairedetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRelevebancairedetail');
        }
        return $this->_dbTable;
    }

    public function find($relevebancairedetail_id, Application_Model_EuRelevebancairedetail $relevebancairedetail) {
        $result = $this->getDbTable()->find($relevebancairedetail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $relevebancairedetail->setRelevebancairedetail_id($row->relevebancairedetail_id)
                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("relevebancairedetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(relevebancairedetail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRelevebancairedetail $relevebancairedetail) {
        $data = array(
            'relevebancairedetail_id' => $relevebancairedetail->getRelevebancairedetail_id(),
            'relevebancairedetail_relevebancaire' => $relevebancairedetail->getRelevebancairedetail_relevebancaire(),
            'relevebancairedetail_libelle' => $relevebancairedetail->getRelevebancairedetail_libelle(),
            'relevebancairedetail_numero' => $relevebancairedetail->getRelevebancairedetail_numero(),
            'relevebancairedetail_date' => $relevebancairedetail->getRelevebancairedetail_date(),
            'relevebancairedetail_montant' => $relevebancairedetail->getRelevebancairedetail_montant(),
            'relevebancairedetail_date_valeur' => $relevebancairedetail->getRelevebancairedetail_date_valeur(),
            'publier' => $relevebancairedetail->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRelevebancairedetail $relevebancairedetail) {
        $data = array(
            'relevebancairedetail_id' => $relevebancairedetail->getRelevebancairedetail_id(),
            'relevebancairedetail_relevebancaire' => $relevebancairedetail->getRelevebancairedetail_relevebancaire(),
            'relevebancairedetail_libelle' => $relevebancairedetail->getRelevebancairedetail_libelle(),
            'relevebancairedetail_numero' => $relevebancairedetail->getRelevebancairedetail_numero(),
            'relevebancairedetail_date' => $relevebancairedetail->getRelevebancairedetail_date(),
            'relevebancairedetail_montant' => $relevebancairedetail->getRelevebancairedetail_montant(),
            'relevebancairedetail_date_valeur' => $relevebancairedetail->getRelevebancairedetail_date_valeur(),
            'publier' => $relevebancairedetail->getPublier()
        );
        $this->getDbTable()->update($data, array('relevebancairedetail_id = ?' => $relevebancairedetail->getRelevebancairedetail_id()));
    }

    public function delete($relevebancairedetail_id) {
        $this->getDbTable()->delete(array('relevebancairedetail_id = ?' => $relevebancairedetail_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("relevebancairedetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($relevebancaire) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancairedetail_relevebancaire = ? ", $relevebancaire);
		$select->where("publier = ? ", 1);
		$select->order("relevebancairedetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancairedetail_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("relevebancairedetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByNew($relevebancaire) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancairedetail_relevebancaire = ? ", $relevebancaire);
		//$select->where("publier = ? ", 1);
		$select->order("relevebancairedetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByBanqueNumeroDate($relevebancaire_banque = "", $relevebancairedetail_numero = "", $relevebancairedetail_date = "") {
        $select = $this->getDbTable()->select();
		if($relevebancaire_banque != ""){
		$select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
		}
		if($relevebancairedetail_numero != "" && $relevebancairedetail_numero != NULL){
		$select->where("relevebancairedetail_numero = ? ", $relevebancairedetail_numero);
		}
		if($relevebancairedetail_date != ""){
		$select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%' ");
		}
		$select->where("publier = ? ", 0);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }
	
	
	
    public function fetchAllByCode($relevebancaire_banque) {
        $select = $this->getDbTable()->select();
		$select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
		//$select->where("publier = ? ", 1);
		$select->order("relevebancairedetail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAllByBanqueNumero($relevebancaire_banque = "", $relevebancairedetail_numero = "") {
        $select = $this->getDbTable()->select();
		if($relevebancaire_banque != ""){
		$select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
		}
		if($relevebancairedetail_numero != ""){
		$select->where("relevebancairedetail_numero = ? ", $relevebancairedetail_numero);
		}
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }
	
	



    public function fetchAll10() {
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_relevebancaire', 'eu_relevebancaire.relevebancaire_id = eu_relevebancairedetail.relevebancairedetail_relevebancaire');
		$select->where("eu_relevebancairedetail.publier = ? ", 0);
		$select->order(array("eu_relevebancaire.relevebancaire_banque ASC", "eu_relevebancairedetail.relevebancairedetail_numero ASC", "eu_relevebancairedetail.relevebancairedetail_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
	                ->setRelevebancairedetail_relevebancaire($row->relevebancaire_banque)
	                ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
					->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
					->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByBanqueNumeroDate2($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_numero, ' ', '')) LIKE '".strtolower(str_replace(" ", "", $relevebancairedetail_numero))."' ");
        $select->where("LOWER(relevebancairedetail_numero) LIKE '".strtolower(str_replace("'", " ", $relevebancairedetail_numero))."' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%' ");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
    
    /*

    public function fetchAllByBanqueNumeroDate3($relevebancaire_banque, $relevebancairedetail_libelle, $relevebancairedetail_date, $relevebancairedetail_montant) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("REPLACE(relevebancairedetail_montant, 'ÿ', '') = ? ", $relevebancairedetail_montant);
        $select->where("publier = ? ", 0);
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	
	public function fetchAllByBanqueNumeroDate4($relevebancaire_banque, $relevebancairedetail_libelle, $relevebancairedetail_numero, $relevebancairedetail_date, $relevebancairedetail_montant) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle))."%' ");
        $select->where("relevebancairedetail_libelle LIKE '%".$relevebancairedetail_numero."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("REPLACE(relevebancairedetail_montant, 'ÿ', '') = ? ", $relevebancairedetail_montant);
        $select->where("publier = ? ", 0);
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	*/
	
public function fetchAllByBanqueNumeroDate5($relevebancaire_banque, $relevebancairedetail_libelle, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[0]))."%' ");
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[1]))."%' )");
        if($relevebancairedetail_libelle[2] != ""){
        $select->orwhere("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[2]))."%' )");
        }
        if($relevebancairedetail_libelle[3] != ""){
        $select->orwhere("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[3]))."%' )");
        }
        if($relevebancairedetail_libelle[4] != ""){
        $select->orwhere("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[4]))."%' )");
        }
////////////////////////////////////
        $select->where("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[0]))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[1]))."%' )");
        if($relevebancairedetail_libelle[2] != ""){
        $select->orwhere("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[2]))."%' )");
        }
        if($relevebancairedetail_libelle[3] != ""){
        $select->orwhere("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[3]))."%' )");
        }
        if($relevebancairedetail_libelle[4] != ""){
        $select->orwhere("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[4]))."%' )");
        }        
////////////////////////////////////
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id DESC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }

    public function fetchAllByBanqueNumeroDate6($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_numero))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_numero))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }





    public function fetchAllByBanqueNumeroDate21($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_numero, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "", $relevebancairedetail_numero)));
        $select->where("LOWER(relevebancairedetail_numero) LIKE ? ", strtolower(str_replace("'", " ", $relevebancairedetail_numero)));
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%' ");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
    
    
    public function fetchAllByBanqueNumeroDate51($relevebancaire_banque, $relevebancairedetail_libelle, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        /*foreach ($relevebancairedetail_libelle as $value) {
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $value))."%' ");
        }*/
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }

    public function fetchAllByBanqueNumeroDate61($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_numero))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_numero))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }










    
    
    public function fetchAllByBanqueNumeroDate52($relevesms_banque, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevesms_id FROM eu_relevebancaire WHERE relevesms_banque = ?) ", $relevesms_banque);
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }





    public function fetchAllByBanqueNumeroDate21_($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_date, $relevebancairedetail_id) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_id != '".$relevebancairedetail_id."' ");
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_numero, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_numero))."%' ");
        $select->where("LOWER(relevebancairedetail_numero) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_numero))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%' ");
        //$select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
    
    
    public function fetchAllByBanqueNumeroDate51_($relevebancaire_banque, $relevebancairedetail_libelle, $relevebancairedetail_date, $relevebancairedetail_id) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_id != '".$relevebancairedetail_id."' ");
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        /*foreach ($relevebancairedetail_libelle as $value) {
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $value))."%' ");
        }*/
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        //$select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }




    public function fetchAllByBanqueNumeroDate61_($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_date, $relevebancairedetail_id) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_id != '".$relevebancairedetail_id."' ");
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_numero))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_numero))."%' ");
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        //$select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }



   
    public function fetchAllByBanqueNumeroDate52_($relevebancaire_banque, $relevebancairedetail_date, $relevebancairedetail_id) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_id != '".$relevebancairedetail_id."' ");
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%'");
        //$select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByBanqueNumeroDate7($relevebancaire_banque, $relevebancairedetail_numero, $relevebancairedetail_libelle, $relevebancairedetail_date) {
        $select = $this->getDbTable()->select();
        $select->where("relevebancairedetail_relevebancaire IN (SELECT relevebancaire_id FROM eu_relevebancaire WHERE relevebancaire_banque = ?) ", $relevebancaire_banque);
        $select->where("LOWER(REPLACE(relevebancairedetail_numero, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "", $relevebancairedetail_numero)));
        $select->where("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[0]))."%' ");
        $select->where("LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[1]))."%' )");
        if($relevebancairedetail_libelle[2] != ""){
        $select->orwhere("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[2]))."%' )");
        }
        if($relevebancairedetail_libelle[3] != ""){
        $select->orwhere("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[3]))."%' )");
        }
        if($relevebancairedetail_libelle[4] != ""){
        $select->orwhere("(LOWER(REPLACE(relevebancairedetail_libelle, ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $relevebancairedetail_libelle[4]))."%' )");
        }
        $select->where("LOWER(relevebancairedetail_numero) LIKE ? ", strtolower(str_replace("'", " ", $relevebancairedetail_numero)));
        $select->where("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[0]))."%' ");
        $select->where("LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[1]))."%' )");
        if($relevebancairedetail_libelle[2] != ""){
        $select->orwhere("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[2]))."%' )");
        }
        if($relevebancairedetail_libelle[3] != ""){
        $select->orwhere("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[3]))."%' )");
        }
        if($relevebancairedetail_libelle[4] != ""){
        $select->orwhere("(LOWER(relevebancairedetail_libelle) LIKE '%".strtolower(str_replace("'", " ", $relevebancairedetail_libelle[4]))."%' )");
        }
        $select->where("relevebancairedetail_date LIKE '".$relevebancairedetail_date."%' ");
        $select->where("publier = ? ", 0);
        $select->order("relevebancairedetail_id ASC");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRelevebancairedetail();
            $entry->setRelevebancairedetail_id($row->relevebancairedetail_id)
                    ->setRelevebancairedetail_relevebancaire($row->relevebancairedetail_relevebancaire)
                    ->setRelevebancairedetail_libelle($row->relevebancairedetail_libelle)
                    ->setRelevebancairedetail_numero($row->relevebancairedetail_numero)
                    ->setRelevebancairedetail_date($row->relevebancairedetail_date)
                    ->setRelevebancairedetail_montant($row->relevebancairedetail_montant)
                    ->setRelevebancairedetail_date_valeur($row->relevebancairedetail_date_valeur)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
    


}


?>
