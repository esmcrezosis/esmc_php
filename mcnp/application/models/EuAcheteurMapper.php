<?php
 
class Application_Model_EuAcheteurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAcheteur');
        }
        return $this->_dbTable;
    }

    public function find($acheteur_id, Application_Model_EuAcheteur $acheteur) {
        $result = $this->getDbTable()->find($acheteur_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $acheteur->setAcheteur_id($row->acheteur_id)
                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(acheteur_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAcheteur $acheteur) {
        $data = array(
            'acheteur_id' => $acheteur->getAcheteur_id(),
            'acheteur_nom' => $acheteur->getAcheteur_nom(),
            'acheteur_prenom' => $acheteur->getAcheteur_prenom(),
            'acheteur_numero' => $acheteur->getAcheteur_numero(),
            'acheteur_banque' => $acheteur->getAcheteur_banque(),
            'acheteur_date' => $acheteur->getAcheteur_date(),
            'type_transfert' => $acheteur->getType_transfert(),
            'acheteur_cel' => $acheteur->getAcheteur_cel(),
            'mont_transfert' => $acheteur->getMont_transfert(),
            'acheteur_code_membre' => $acheteur->getAcheteur_code_membre(),
            'acheteur_raison_sociale' => $acheteur->getAcheteur_raison_sociale(),
            'acheteur_type' => $acheteur->getAcheteur_type(),
            'code_agence' => $acheteur->getCode_agence(),
            'publier' => $acheteur->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAcheteur $acheteur) {
        $data = array(
            'acheteur_nom' => $acheteur->getAcheteur_nom(),
            'acheteur_prenom' => $acheteur->getAcheteur_prenom(),
            'acheteur_numero' => $acheteur->getAcheteur_numero(),
            'acheteur_banque' => $acheteur->getAcheteur_banque(),
            'acheteur_date' => $acheteur->getAcheteur_date(),
            'type_transfert' => $acheteur->getType_transfert(),
            'acheteur_cel' => $acheteur->getAcheteur_cel(),
            'mont_transfert' => $acheteur->getMont_transfert(),
            'acheteur_code_membre' => $acheteur->getAcheteur_code_membre(),
            'acheteur_raison_sociale' => $acheteur->getAcheteur_raison_sociale(),
            'acheteur_type' => $acheteur->getAcheteur_type(),
            'code_agence' => $acheteur->getCode_agence(),
            'publier' => $acheteur->getPublier()
        );
        $this->getDbTable()->update($data, array('acheteur_id = ?' => $acheteur->getAcheteur_id()));
    }

    public function delete($acheteur_id) {
        $this->getDbTable()->delete(array('acheteur_id = ?' => $acheteur_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll20() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll30($type, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("acheteur_type = ? ", $type);
		if($code_agence != ""){
		$select->where("code_agence = ? ", $code_agence);
			}
		$select->where("publier = ? ", 0);
		$select->order("acheteur_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll31($type, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("acheteur_type = ? ", $type);
		if($code_agence != ""){
		$select->where("code_agence = ? ", $code_agence);
			}
		$select->where("publier = ? ", 1);
		$select->order("acheteur_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByTypeTransfert0($type, $type_transfert, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("acheteur_type = ? ", $type);
		$select->where("type_transfert = ? ", $type_transfert);
		if($code_agence != ""){
		$select->where("code_agence = ? ", $code_agence);
			}
		$select->where("publier = ? ", 0);
		$select->order("acheteur_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByTypeTransfert1($type, $type_transfert, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("acheteur_type = ? ", $type);
		$select->where("type_transfert = ? ", $type_transfert);
		if($code_agence != ""){
		$select->where("code_agence = ? ", $code_agence);
			}
		$select->where("publier = ? ", 1);
		$select->order("acheteur_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByNumero($numero, $banque) {
        $select = $this->getDbTable()->select();
		$select->where("acheteur_numero = ? ", $numero);
		$select->where("acheteur_banque = ? ", $banque);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAcheteur();
            $entry->setAcheteur_id($row->acheteur_id)
	                ->setAcheteur_nom($row->acheteur_nom)
                ->setAcheteur_prenom($row->acheteur_prenom)
                ->setAcheteur_numero($row->acheteur_numero)
                ->setAcheteur_banque($row->acheteur_banque)
                ->setAcheteur_date($row->acheteur_date)
                ->setType_transfert($row->type_transfert)
                ->setAcheteur_cel($row->acheteur_cel)
                ->setMont_transfert($row->mont_transfert)
                ->setAcheteur_code_membre($row->acheteur_code_membre)
                ->setAcheteur_raison_sociale($row->acheteur_raison_sociale)
                ->setAcheteur_type($row->acheteur_type)
                ->setCode_agence($row->code_agence)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
