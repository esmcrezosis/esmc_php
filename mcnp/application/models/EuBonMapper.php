<?php
 
class Application_Model_EuBonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBon');
        }
        return $this->_dbTable;
    }

    public function find($bon_id, Application_Model_EuBon $bon) {
        $result = $this->getDbTable()->find($bon_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon->setBon_id($row->bon_id)
                ->setBon_numero($row->bon_numero)
                ->setBon_type($row->bon_type)
                ->setBon_montant($row->bon_montant)
                ->setBon_montant_salaire($row->bon_montant_salaire)
                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
                ->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
                ->setBon_date($row->bon_date)
                ->setBon_code_barre($row->bon_code_barre)
                ->setBon_proposition($row->bon_proposition);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("bon_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBon $bon) {
        $data = array(
            'bon_id' => $bon->getBon_id(),
            'bon_numero' => $bon->getBon_numero(),
            'bon_type' => $bon->getBon_type(),
            'bon_montant' => $bon->getBon_montant(),
            'bon_montant_salaire' => $bon->getBon_montant_salaire(),
            'bon_code_membre_emetteur' => $bon->getBon_code_membre_emetteur(),
            'bon_code_membre_distributeur' => $bon->getBon_code_membre_distributeur(),
            'bon_date' => $bon->getBon_date(),
            'bon_code_barre' => $bon->getBon_code_barre(),
            'bon_proposition' => $bon->getBon_proposition()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBon $bon) {
        $data = array(
            'bon_id' => $bon->getBon_id(),
            'bon_numero' => $bon->getBon_numero(),
            'bon_type' => $bon->getBon_type(),
            'bon_montant' => $bon->getBon_montant(),
            'bon_montant_salaire' => $bon->getBon_montant_salaire(),
            'bon_code_membre_emetteur' => $bon->getBon_code_membre_emetteur(),
            'bon_code_membre_distributeur' => $bon->getBon_code_membre_distributeur(),
            'bon_date' => $bon->getBon_date(),
            'bon_code_barre' => $bon->getBon_code_barre(),
            'bon_proposition' => $bon->getBon_proposition()
        );
        $this->getDbTable()->update($data, array('bon_id = ?' => $bon->getBon_id()));
    }

    public function delete($bon_id) {
        $this->getDbTable()->delete(array('bon_id = ?' => $bon_id));
    }


    public function fetchAllByType($bon_type) {
        $select = $this->getDbTable()->select();
		$select->where("bon_type = ? ", $bon_type);
		$select->order("bon_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembre2($code_membre = "", $bon_type = "") {
        $select = $this->getDbTable()->select();
		if($code_membre != ""){
		$select->where("bon_code_membre_emetteur LIKE '%".$code_membre."%' ");
			}
		if($bon_type != ""){
		$select->where("bon_type LIKE '".$bon_type."' ");
			}
		$select->where("(bon_code_membre_distributeur IS NOT NULL");
		$select->orwhere("bon_code_membre_distributeur != '')");
		$select->order("bon_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByMembre($code_membre = "", $bon_type = "") {
        $select = $this->getDbTable()->select();
		if($code_membre != ""){
        $select->where("bon_code_membre_emetteur LIKE '%".$code_membre."%' ");
            }
        if($bon_type != ""){
        $select->where("bon_type LIKE '".$bon_type."' ");
            }
		//$select->where("(bon_code_membre_distributeur IS NULL");
		//$select->orwhere("bon_code_membre_distributeur = '')");
		$select->order("bon_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByDistributeur($code_membre = "", $bon_type = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("bon_code_membre_distributeur LIKE '%".$code_membre."%' ");
            }
        if($bon_type != ""){
        $select->where("bon_type LIKE '%".$bon_type."%' ");
            }
		$select->order("bon_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
            $entries[] = $entry;
        }
        return $entries;
    }
	


    public function fetchAllByMembreBA($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("bon_type LIKE 'BA' ");
		$select->where("bon_code_membre_emetteur LIKE '%".$code_membre."%' ");
		$select->order("bon_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
    public function fetchAllByNumero($bon_numero) {
        $select = $this->getDbTable()->select();
		$select->where("bon_numero LIKE '%".$bon_numero."%' ");
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuBon();
            $entry->setBon_id($row->bon_id)
	                ->setBon_numero($row->bon_numero)
                    ->setBon_type($row->bon_type)
                    ->setBon_montant($row->bon_montant)
	                ->setBon_montant_salaire($row->bon_montant_salaire)
	                ->setBon_code_membre_emetteur($row->bon_code_membre_emetteur)
					->setBon_code_membre_distributeur($row->bon_code_membre_distributeur)
					->setBon_date($row->bon_date)
	                ->setBon_code_barre($row->bon_code_barre)
                	->setBon_proposition($row->bon_proposition);
			$entries = $entry;
        return $entries;
    }
	
	

}


?>
