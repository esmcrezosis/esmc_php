
<?php
class Application_Model_EuAppelNnMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuAppelNn');
        }
        return $this->_dbTable;
    }
	
	public function findByAppel($id_proposition) {
        $select = $this->getDbTable()->select();
        $select->where('id_proposition LIKE ?', $id_proposition);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
           $row = $results->current();
           $nn = new Application_Model_EuAppelNn();
           $nn->setId_appel_nn($row->id_appel_nn)
			  ->setId_proposition($row->id_proposition)
			  ->setDesignation_appel($row->designation_appel)
			  ->setDate_appel($row->date_appel)
			  ->setDate_fin($row->date_fin)
			  ->setCode_compte($row->code_compte)
			  ->setMontant_nn($row->montant_nn)
			  ->setDisponible($row->disponible)
			  ->setCode_membre_morale($row->code_membre_morale)
			  ->setid_utilisateur($row->id_utilisateur);
            return $nn;
        } else {
            return NULL;
        }
    }
	
	public function find($id_appel_nn, Application_Model_EuAppelNn $appel_nn) {
       $result = $this->getDbTable()->find($id_appel_nn);
       if (0 == count($result)) {
           return false;
       }
       $row = $result->current();
       $appel_nn->setId_appel_nn($row->id_appel_nn)
                ->setId_proposition($row->id_proposition)
			    ->setDesignation_appel($row->designation_appel)
			    ->setDate_appel($row->date_appel)
				->setDate_fin($row->date_fin)
			    ->setCode_compte($row->code_compte)
			    ->setMontant_nn($row->montant_nn)
			    ->setDisponible($row->disponible)
			    ->setCode_membre_morale($row->code_membre_morale)
			    ->setid_utilisateur($row->id_utilisateur);
		return true;
    }
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuAppelNn();
           $entry->setId_appel_nn($row->id_appel_nn)
                 ->setId_proposition($row->id_proposition)
			     ->setDesignation_appel($row->designation_appel)
			     ->setDate_appel($row->date_appel)
				 ->setDate_fin($row->date_fin)
			     ->setCode_compte($row->code_compte)
			     ->setMontant_nn($row->montant_nn)
			     ->setDisponible($row->disponible)
			     ->setCode_membre_morale($row->code_membre_morale)
			     ->setid_utilisateur($row->id_utilisateur);
           $entries[] = $entry;
        }
        return $entries;
    }
    
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_appel_nn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuAppelNn $appelnn) {
        $data = array(
         'id_appel_nn' => $appelnn->getId_appel_nn(),
         'id_proposition' => $appelnn->getId_proposition(),
		 'designation_appel' => $appelnn->getDesignation_appel(),
		 'date_appel' => $appelnn->getDate_appel(),
		 'date_fin' => $appelnn->getDate_fin(),
		 'code_compte' => $appelnn->getCode_compte(),
		 'montant_nn' => $appelnn->getMontant_nn(),
		 'disponible' => $appelnn->getDisponible(),
		 'code_membre_morale' => $appelnn->getCode_membre_morale(),
		 'id_utilisateur' => $appelnn->getId_utilisateur(),
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAppelNn $appelnn) {
        $data = array(
         'id_appel_nn' => $appelnn->getId_appel_nn(),
         'id_proposition' => $appelnn->getId_proposition(),
		 'designation_appel' => $appelnn->getDesignation_appel(),
		 'date_appel' => $appelnn->getDate_appel(),
		 'date_fin' => $appelnn->getDate_fin(),
		 'code_compte' => $appelnn->getCode_compte(),
		 'montant_nn' => $appelnn->getMontant_nn(),
		 'disponible' => $appelnn->getDisponible(),
		 'code_membre_morale' => $appelnn->getCode_membre_morale(),
		 'id_utilisateur' => $appelnn->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_appel_nn = ?' => $appelnn->getId_appel_nn()));
    }

	
    public function delete($id_appel_nn) {
           $this->getDbTable()->delete(array('id_appel_nn = ?' => $id_appel_nn));
    }
	
	
	
	public function fetchAll2() {
			  $date_id = new Zend_Date(Zend_Date::ISO_8601);

        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_proposition', 'eu_proposition.id_proposition = eu_appel_nn.id_proposition');
		$select->where("eu_proposition.disponible = ? ", 1);
		$select->where("(eu_appel_nn.date_fin - 3) > ? ", $date_id->toString('yyyy-MM-dd'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuAppelNn();
           $entry->setId_appel_nn($row->id_appel_nn)
                 ->setId_proposition($row->id_proposition)
			     ->setDesignation_appel($row->designation_appel)
			     ->setDate_appel($row->date_appel)
				 ->setDate_fin($row->date_fin)
			     ->setCode_compte($row->code_compte)
			     ->setMontant_nn($row->montant_nn)
			     ->setDisponible($row->disponible)
			     ->setCode_membre_morale($row->code_membre_morale)
			     ->setid_utilisateur($row->id_utilisateur);
           $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAll3() {
			  $date_id = new Zend_Date(Zend_Date::ISO_8601);

        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_proposition', 'eu_proposition.id_proposition = eu_appel_nn.id_proposition');
		$select->where("eu_proposition.disponible = ? ", 1);
		$select->where("eu_appel_nn.date_fin > ? ", $date_id->toString('yyyy-MM-dd'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuAppelNn();
           $entry->setId_appel_nn($row->id_appel_nn)
                 ->setId_proposition($row->id_proposition)
			     ->setDesignation_appel($row->designation_appel)
			     ->setDate_appel($row->date_appel)
				 ->setDate_fin($row->date_fin)
			     ->setCode_compte($row->code_compte)
			     ->setMontant_nn($row->montant_nn)
			     ->setDisponible($row->disponible)
			     ->setCode_membre_morale($row->code_membre_morale)
			     ->setid_utilisateur($row->id_utilisateur);
           $entries[] = $entry;
        }
        return $entries;
    }
}		
?>	
	
	
	
	
	
	
	
	
	