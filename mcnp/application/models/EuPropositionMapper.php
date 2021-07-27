<?php

class Application_Model_EuPropositionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProposition');
        }
        return $this->_dbTable;
    }

    public function find($id_proposition, Application_Model_EuProposition $proposition) {
        $result = $this->getDbTable()->find($id_proposition);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $proposition->setId_proposition($row->id_proposition)
                ->setId_appel_offre($row->id_appel_offre)
                ->setId_utilisateur($row->id_utilisateur)
                ->setDate_creation($row->date_creation)
                ->setDisponible($row->disponible)
				->setMontant_proposition($row->montant_proposition)
				->setChoix_proposition($row->choix_proposition)
				->setMontant_salaire($row->montant_salaire)
				->setAutre_budget($row->autre_budget)
				->setPreselection($row->preselection)
                ->setCode_membre_morale($row->code_membre_morale);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_proposition) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuProposition $proposition) {
        $data = array(
            'id_proposition' => $proposition->getId_proposition(),
            'id_appel_offre' => $proposition->getId_appel_offre(),
            'id_utilisateur' => $proposition->getId_utilisateur(),
            'date_creation' => $proposition->getDate_creation(),
            'disponible' => $proposition->getDisponible(),
            'montant_proposition' => $proposition->getMontant_proposition(),
            'choix_proposition' => $proposition->getChoix_proposition(),
            'montant_salaire' => $proposition->getMontant_salaire(),
            'autre_budget' => $proposition->getAutre_budget(),
            'preselection' => $proposition->getPreselection(),
            'code_membre_morale' => $proposition->getCode_membre_morale()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProposition $proposition) {
        $data = array(
            'id_proposition' => $proposition->getId_proposition(),
            'id_appel_offre' => $proposition->getId_appel_offre(),
            'id_utilisateur' => $proposition->getId_utilisateur(),
            'date_creation' => $proposition->getDate_creation(),
            'disponible' => $proposition->getDisponible(),
            'montant_proposition' => $proposition->getMontant_proposition(),
            'choix_proposition' => $proposition->getChoix_proposition(),
            'montant_salaire' => $proposition->getMontant_salaire(),
            'autre_budget' => $proposition->getAutre_budget(),
            'preselection' => $proposition->getPreselection(),
            'code_membre_morale' => $proposition->getCode_membre_morale()
        );
        $this->getDbTable()->update($data, array('id_proposition = ?' => $proposition->getId_proposition()));
    }

    public function delete($id_proposition) {
        $this->getDbTable()->delete(array('id_proposition = ?' => $id_proposition));
    }


    public function findpropbydao($numero_dao) {
	       $table = new Application_Model_DbTable_EuProposition();
           $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
		          ->join('eu_appel_offre','eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre')
                  ->where('eu_proposition.disponible = ?',1)
				  ->where('eu_appel_offre.type_appel_offre LIKE ?','kit')
				  ->where('eu_proposition.choix_proposition = ?',1)
				  ->where('eu_appel_offre.numero_offre LIKE ?',$numero_dao)
                  ;
			$result = $table->fetchAll($select);
			if (0 == count($result)) {
                return NULL;
            }
			$row = $result->current();
			$proposition = new Application_Model_EuProposition();
			$proposition->setId_proposition($row->id_proposition)
                        ->setId_appel_offre($row->id_appel_offre)
                        ->setId_utilisateur($row->id_utilisateur)
                        ->setDate_creation($row->date_creation)
                        ->setDisponible($row->disponible)
				        ->setMontant_proposition($row->montant_proposition)
				        ->setChoix_proposition($row->choix_proposition)
				        ->setMontant_salaire($row->montant_salaire)
				        ->setAutre_budget($row->autre_budget)
				        ->setPreselection($row->preselection)
                        ->setCode_membre_morale($row->code_membre_morale);
			 return $proposition;			
	}




    public function fetchAll2($code_membre_morale) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale = ? ", $code_membre_morale);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3($code_membre_morale) {
        $select = $this->getDbTable()->select();
		$select->where("choix_proposition = ? ", 1);
		$select->where("code_membre_morale = ? ", $code_membre_morale);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll7($code_membre_morale) {
        $select = $this->getDbTable()->select();
		$select->where("preselection = ? ", 1);
		$select->where("code_membre_morale = ? ", $code_membre_morale);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id_appel_offre) {
        $select = $this->getDbTable()->select();
		$select->where("id_appel_offre = ? ", $id_appel_offre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll5($id_appel_offre) {
        $select = $this->getDbTable()->select();
		$select->where("id_appel_offre = ? ", $id_appel_offre);
		$select->where("preselection = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll6($id_appel_offre) {
        $select = $this->getDbTable()->select();
		$select->where("id_appel_offre = ? ", $id_appel_offre);
		$select->where("choix_proposition != ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll8($id_appel_offre) {
        $select = $this->getDbTable()->select();
		$select->where("id_appel_offre = ? ", $id_appel_offre);
		$select->where("choix_proposition != ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProposition();
            $entry->setId_proposition($row->id_proposition)
                    ->setId_appel_offre($row->id_appel_offre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDate_creation($row->date_creation)
                	->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setChoix_proposition($row->choix_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setAutre_budget($row->autre_budget)
					->setPreselection($row->preselection)
                    ->setCode_membre_morale($row->code_membre_morale);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
}


?>
