<?php

class Application_Model_EuTypeIntegrateurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeIntegrateur');
        }
        return $this->_dbTable;
    }

    public function find($id_type_integrateur, Application_Model_EuTypeIntegrateur $integrateur) {
        $result = $this->getDbTable()->find($id_type_integrateur);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $integrateur->setId_type_integrateur($row->id_type_integrateur)
                ->setLibelle_type_integrateur($row->libelle_type_integrateur)
				->setType_param_ban($row->type_param_ban)
			    ->setMontant_param($row->montant_param);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                    ->setLibelle_type_integrateur($row->libelle_type_integrateur)
					->setType_param_ban($row->type_param_ban)
					->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeIntegrateur $integrateur) {
        $data = array(
            'id_type_integrateur' => $integrateur->getId_type_integrateur(),
            'libelle_type_integrateur' => $integrateur->getLibelle_type_integrateur(),
			'type_param_ban' => $integrateur->getType_param_ban(),
			'montant_param' => $integrateur->getMontant_param()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeIntegrateur $integrateur) {
        $data = array(
            'id_type_integrateur' => $integrateur->getId_type_integrateur(),
            'libelle_type_integrateur' => $integrateur->getLibelle_type_integrateur(),
			'type_param_ban' => $integrateur->getType_param_ban(),
			'montant_param' => $integrateur->getMontant_param()
        );
        $this->getDbTable()->update($data, array('id_type_integrateur = ?' => $integrateur->getId_type_integrateur()));
    }

    public function delete($id_type_integrateur) {
        $this->getDbTable()->delete(array('id_type_integrateur = ?' => $id_type_integrateur));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_integrateur) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAllByType($id_type_integrateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_type_integrateur = ? ", $id_type_integrateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                    ->setLibelle_type_integrateur($row->libelle_type_integrateur)
					->setType_param_ban($row->type_param_ban)
				    ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function fetchAllIntegrateur() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_integrateur in (?) ", array(1,2));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                  ->setLibelle_type_integrateur($row->libelle_type_integrateur)
			      ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function fetchAllSurveillant() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_integrateur in (?) ", array(15,16,17,18,22,29,30));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                  ->setLibelle_type_integrateur($row->libelle_type_integrateur)
			      ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function fetchAllTravailleur() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_integrateur in (?) ", array(19,20));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                  ->setLibelle_type_integrateur($row->libelle_type_integrateur)
			      ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function fetchAllODD() {
	    $select = $this->getDbTable()->select();
		$select->where("id_type_integrateur in (?) ", array(21,24));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                  ->setLibelle_type_integrateur($row->libelle_type_integrateur)
			      ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	
	
	
	
	
    public function fetchAllByTypeParamBan($type_param_ban) {
        $select = $this->getDbTable()->select();
        $select->where("type_param_ban = ? ", $type_param_ban);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeIntegrateur();
            $entry->setId_type_integrateur($row->id_type_integrateur)
                  ->setLibelle_type_integrateur($row->libelle_type_integrateur)
                  ->setType_param_ban($row->type_param_ban)
				  ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
    }


}
?>

