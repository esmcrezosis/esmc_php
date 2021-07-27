<?php
 
class Application_Model_EuRecubancaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRecubancaire');
        }
        return $this->_dbTable;
    }

    public function find($recubancaire_id, Application_Model_EuRecubancaire $recubancaire) {
        $result = $this->getDbTable()->find($recubancaire_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $recubancaire->setRecubancaire_id($row->recubancaire_id)
                ->setRecubancaire_numero($row->recubancaire_numero)
                ->setRecubancaire_date_numero($row->recubancaire_date_numero)
                ->setRecubancaire_type($row->recubancaire_type)
                ->setRecubancaire_banque($row->recubancaire_banque)
                ->setRecubancaire_montant($row->recubancaire_montant)
                ->setRecubancaire_vignette($row->recubancaire_vignette)
                ->setRecubancaire_souscription($row->recubancaire_souscription)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecubancaire();
            $entry->setRecubancaire_id($row->recubancaire_id)
                ->setRecubancaire_numero($row->recubancaire_numero)
                ->setRecubancaire_date_numero($row->recubancaire_date_numero)
                ->setRecubancaire_type($row->recubancaire_type)
                ->setRecubancaire_banque($row->recubancaire_banque)
                ->setRecubancaire_montant($row->recubancaire_montant)
                ->setRecubancaire_vignette($row->recubancaire_vignette)
                ->setRecubancaire_souscription($row->recubancaire_souscription)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(recubancaire_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuRecubancaire $recubancaire) {
        $data = array(
            'recubancaire_id' => $recubancaire->getRecubancaire_id(),
            'recubancaire_numero' => $recubancaire->getRecubancaire_numero(),
            'recubancaire_date_numero' => $recubancaire->getRecubancaire_date_numero(),
            'recubancaire_type' => $recubancaire->getRecubancaire_type(),
            'recubancaire_banque' => $recubancaire->getRecubancaire_banque(),
            'recubancaire_montant' => $recubancaire->getRecubancaire_montant(),
            'recubancaire_vignette' => $recubancaire->getRecubancaire_vignette(),
            'recubancaire_souscription' => $recubancaire->getRecubancaire_souscription(),
            'publier' => $recubancaire->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRecubancaire $recubancaire) {
        $data = array(
            'recubancaire_numero' => $recubancaire->getRecubancaire_numero(),
            'recubancaire_date_numero' => $recubancaire->getRecubancaire_date_numero(),
            'recubancaire_type' => $recubancaire->getRecubancaire_type(),
            'recubancaire_banque' => $recubancaire->getRecubancaire_banque(),
            'recubancaire_montant' => $recubancaire->getRecubancaire_montant(),
            'recubancaire_vignette' => $recubancaire->getRecubancaire_vignette(),
            'recubancaire_souscription' => $recubancaire->getRecubancaire_souscription(),
            'publier' => $recubancaire->getPublier()
        );
        $this->getDbTable()->update($data, array('recubancaire_id = ?' => $recubancaire->getRecubancaire_id()));
    }

    public function delete($recubancaire_id) {
        $this->getDbTable()->delete(array('recubancaire_id = ?' => $recubancaire_id));
    }
	
	
    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecubancaire();
            $entry->setRecubancaire_id($row->recubancaire_id)
                ->setRecubancaire_numero($row->recubancaire_numero)
                ->setRecubancaire_date_numero($row->recubancaire_date_numero)
                ->setRecubancaire_type($row->recubancaire_type)
                ->setRecubancaire_banque($row->recubancaire_banque)
                ->setRecubancaire_montant($row->recubancaire_montant)
                ->setRecubancaire_vignette($row->recubancaire_vignette)
                ->setRecubancaire_souscription($row->recubancaire_souscription)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllBySouscription($recubancaire_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("recubancaire_souscription = ? ", $recubancaire_souscription);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecubancaire();
            $entry->setRecubancaire_id($row->recubancaire_id)
                ->setRecubancaire_numero($row->recubancaire_numero)
                ->setRecubancaire_date_numero($row->recubancaire_date_numero)
                ->setRecubancaire_type($row->recubancaire_type)
                ->setRecubancaire_banque($row->recubancaire_banque)
                ->setRecubancaire_montant($row->recubancaire_montant)
                ->setRecubancaire_vignette($row->recubancaire_vignette)
                ->setRecubancaire_souscription($row->recubancaire_souscription)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllBySouscriptionOne($recubancaire_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("recubancaire_souscription = ? ", $recubancaire_souscription);
		$select->where("publier = ? ", 1);
		$select->order(array("recubancaire_id ASC"));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRecubancaire();
            $entry->setRecubancaire_id($row->recubancaire_id)
                ->setRecubancaire_numero($row->recubancaire_numero)
                ->setRecubancaire_date_numero($row->recubancaire_date_numero)
                ->setRecubancaire_type($row->recubancaire_type)
                ->setRecubancaire_banque($row->recubancaire_banque)
                ->setRecubancaire_montant($row->recubancaire_montant)
                ->setRecubancaire_vignette($row->recubancaire_vignette)
                ->setRecubancaire_souscription($row->recubancaire_souscription)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }




    public function fetchAllByTypeNumeroDate($recubancaire_type, $recubancaire_numero, $recubancaire_date_numero) {
        $select = $this->getDbTable()->select();
		$select->where("recubancaire_type = ? ", $recubancaire_type);
		$select->where("recubancaire_numero = ? ", $recubancaire_numero);
		$select->where("recubancaire_date_numero = ? ", $recubancaire_date_numero);
		$select->where("publier = ? ", 1);
		$select->order(array("recubancaire_id ASC"));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuRecubancaire();
            $entry->setRecubancaire_id($row->recubancaire_id)
                ->setRecubancaire_numero($row->recubancaire_numero)
                ->setRecubancaire_date_numero($row->recubancaire_date_numero)
                ->setRecubancaire_type($row->recubancaire_type)
                ->setRecubancaire_banque($row->recubancaire_banque)
                ->setRecubancaire_montant($row->recubancaire_montant)
                ->setRecubancaire_vignette($row->recubancaire_vignette)
                ->setRecubancaire_souscription($row->recubancaire_souscription)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }


    public function findCumul($recubancaire_souscription) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(recubancaire_montant) as SOMME'));
		$select->where("recubancaire_souscription = ? ", $recubancaire_souscription);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['SOMME'];
    }

    public function fetchByNumero($recubancaire_numero) {
        $select = $this->getDbTable()->select();
		$select->where("recubancaire_numero = ? ", $recubancaire_numero);
		$select->where("publier = ? ", 1);
		$select->order(array("recubancaire_id ASC"));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return FALSE;
        }
        $row = $result;
        $entry = new Application_Model_EuRecubancaire();
        $entry->setRecubancaire_id($row->recubancaire_id)
              ->setRecubancaire_numero($row->recubancaire_numero)
              ->setRecubancaire_date_numero($row->recubancaire_date_numero)
              ->setRecubancaire_type($row->recubancaire_type)
              ->setRecubancaire_banque($row->recubancaire_banque)
              ->setRecubancaire_montant($row->recubancaire_montant)
              ->setRecubancaire_vignette($row->recubancaire_vignette)
              ->setRecubancaire_souscription($row->recubancaire_souscription)
              ->setPublier($row->publier);
        return $entry;
    }

}


?>
