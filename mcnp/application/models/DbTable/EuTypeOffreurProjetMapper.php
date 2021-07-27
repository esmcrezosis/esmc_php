<?php

class Application_Model_EuTypeOffreurProjetMapper {
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
            $this->setDbTable('Application_Model_DbTable_EuTypeOffreurProjet');
        }
        return $this->_dbTable;
    }

    public function find($id_type_offreur_projet, Application_Model_EuTypeOffreurProjet $offreur_projet) {
        $result = $this->getDbTable()->find($id_type_offreur_projet);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $offreur_projet->setId_type_offreur_projet($row->id_type_offreur_projet)
                       ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
				       ->setType_param_ban($row->type_param_ban)
				       ->setMontant_param($row->montant_param);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeOffreurProjet();
            $entry->setId_type_offreur_projet($row->id_type_offreur_projet)
                  ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
				  ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeOffreurProjet $offreur_projet) {
        $data = array(
            'id_type_offreur_projet' => $offreur_projet->getId_type_offreur_projet(),
            'libelle_type_offreur_projet' => $offreur_projet->getLibelle_type_offreur_projet(),
            'type_param_ban' => $offreur_projet->getType_param_ban(),
			'montant_param' => $offreur_projet->getMontant_param()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeOffreurProjet $offreur_projet) {
        $data = array(
            'id_type_offreur_projet' => $offreur_projet->getId_type_offreur_projet(),
            'libelle_type_offreur_projet' => $offreur_projet->getLibelle_type_offreur_projet(),
            'type_param_ban' => $offreur_projet->getType_param_ban(),
			'montant_param' => $offreur_projet->getMontant_param()
        );
        $this->getDbTable()->update($data, array('id_type_offreur_projet = ?' => $offreur_projet->getId_type_offreur_projet()));
    }

    public function delete($id_type_offreur_projet) {
        $this->getDbTable()->delete(array('id_type_offreur_projet = ?' => $id_type_offreur_projet));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_offreur_projet) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAllByType($id_type_offreur_projet) {
        $select = $this->getDbTable()->select();
		$select->where("id_type_offreur_projet = ? ", $id_type_offreur_projet);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeOffreurProjet();
            $entry->setId_type_offreur_projet($row->id_type_offreur_projet)
                  ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
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
            $entry = new Application_Model_EuTypeOffreurProjet();
            $entry->setId_type_offreur_projet($row->id_type_offreur_projet)
                  ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
				  ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByVendeur()  {
		$select = $this->getDbTable()->select();
                $select->where("id_type_offreur_projet IN (?) ", array(1,2,3));
		$resultSet = $this->getDbTable()->fetchAll($select);
		
        $entries = array();
		foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeOffreurProjet();
            $entry->setId_type_offreur_projet($row->id_type_offreur_projet)
                  ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
				  ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
		
	}
	
	public function fetchAllByTransformateur()  {
		$select = $this->getDbTable()->select();
                $select->where("id_type_offreur_projet IN (?) ", array(4,5,6));
		$resultSet = $this->getDbTable()->fetchAll($select);
		
        $entries = array();
		foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeOffreurProjet();
            $entry->setId_type_offreur_projet($row->id_type_offreur_projet)
                  ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
				  ->setType_param_ban($row->type_param_ban)
				  ->setMontant_param($row->montant_param);
            $entries[] = $entry;
        }
        return $entries;
		
	}
	
	
	public function fetchAllByProducteur()  {
		$select = $this->getDbTable()->select();
		$resultSet = $this->getDbTable()->fetchAll($select);
		$select->where("id_type_offreur_projet IN (?) ", array(7,8,9));
                $entries = array();
		foreach ($resultSet as $row) {
                   $entry = new Application_Model_EuTypeOffreurProjet();
                   $entry->setId_type_offreur_projet($row->id_type_offreur_projet)
                         ->setLibelle_type_offreur_projet($row->libelle_type_offreur_projet)
		         ->setType_param_ban($row->type_param_ban)
		         ->setMontant_param($row->montant_param);
                   $entries[] = $entry;
                 }
                 return $entries;	
	}
	


}
?>

