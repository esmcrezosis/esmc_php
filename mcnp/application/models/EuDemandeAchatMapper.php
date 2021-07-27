 <?php

class Application_Model_EuDemandeAchatMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDemandeAchat');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_demande_achat, Application_Model_EuDemandeAchat $dachat) {
        $result = $this->getDbTable()->find($id_demande_achat);
        if(0 == count($result)) {
           return false;
        }
		
        $row = $result->current();
        $dachat->setId_demande_achat($row->id_demande_achat)
		       ->setLibelle_demande_achat($row->libelle_demande_achat)
               ->setMontant_demande_achat($row->montant_demande_achat)
               ->setReference_demande_achat($row->reference_demande_achat)
			   ->setType_demande_achat($row->type_demande_achat)
               ->setCode_membre($row->code_membre)
               ->setValider_down($row->valider_down)
               ->setValider_up($row->valider_up)
               ->setDate_demande($row->date_demande)
			   //->setAllocation_budgetaire($row->allocation_budgetaire)
			   //->setCredit_deja_consomme($row->credit_deja_consomme)
			   //->setDisponibilite_demande($row->disponibilite_demande)
			   ->setRejet($row->rejet)
			   ->setLivrer($row->livrer)
			   ;
	}
	
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemandeAchat();
            $entry->setId_demande_achat($row->id_demande_achat)
			      ->setLibelle_demande_achat($row->libelle_demande_achat)
                  ->setMontant_demande_achat($row->montant_demande_achat)
                  ->setReference_demande_achat($row->reference_demande_achat)
				  ->setType_demande_achat($row->type_demande_achat)
                  ->setCode_membre($row->code_membre)
                  ->setValider_down($row->valider_down)
                  ->setValider_up($row->valider_up)
                  ->setDate_demande($row->date_demande)/*
			      ->setAllocation_budgetaire($row->allocation_budgetaire)
			      ->setCredit_deja_consomme($row->credit_deja_consomme)
			      ->setDisponibilite_demande($row->disponibilite_demande)*/
				  ->setRejet($row->rejet)
				  ->setLivrer($row->livrer)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function fetchAllByRejet() {
	    $select = $this->getDbTable()->select();
		$select->where("rejet = ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuDemandeAchat();
		   $entry->setId_demande_achat($row->id_demande_achat)
		         ->setLibelle_demande_achat($row->libelle_demande_achat)
                 ->setMontant_demande_achat($row->montant_demande_achat)
                 ->setReference_demande_achat($row->reference_demande_achat)
				 ->setType_demande_achat($row->type_demande_achat)
                 ->setCode_membre($row->code_membre)
                 ->setValider_down($row->valider_down)
                 ->setValider_up($row->valider_up)
                 ->setDate_demande($row->date_demande)
                 /*
			     ->setAllocation_budgetaire($row->allocation_budgetaire)
			     ->setCredit_deja_consomme($row->credit_deja_consomme)
			     ->setDisponibilite_demande($row->disponibilite_demande)*/
				 ->setRejet($row->rejet)
				 ->setLivrer($row->livrer);
           $entries[] = $entry;
		  
	    }
		return $entries;
	}
	
	
	
	
	public function fetchAllByValiderDown($valider) {
	    $select = $this->getDbTable()->select();
	    $select->where("valider_down = ? ", $valider);
		$select->where("rejet <> ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuDemandeAchat();
		   $entry->setId_demande_achat($row->id_demande_achat)
		         ->setLibelle_demande_achat($row->libelle_demande_achat)
                 ->setMontant_demande_achat($row->montant_demande_achat)
                 ->setReference_demande_achat($row->reference_demande_achat)
				 ->setType_demande_achat($row->type_demande_achat)
                 ->setCode_membre($row->code_membre)
                 ->setValider_down($row->valider_down)
                 ->setValider_up($row->valider_up)
                 ->setDate_demande($row->date_demande)/*
			     ->setAllocation_budgetaire($row->allocation_budgetaire)
			     ->setCredit_deja_consomme($row->credit_deja_consomme)
			     ->setDisponibilite_demande($row->disponibilite_demande)*/
				 ->setRejet($row->rejet)
				 ->setLivrer($row->livrer);
           $entries[] = $entry;
		  
	    }
		return $entries;
	}
	
	
	public function fetchAllByValiderUp($valider) {
	    $select = $this->getDbTable()->select();
		$select->where("valider_down = ? ",3);
	    $select->where("valider_up = ? ", $valider);
		$select->where("rejet <> ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	        $entry = new Application_Model_EuDemandeAchat();
		    $entry->setId_demande_achat($row->id_demande_achat)
		         ->setLibelle_demande_achat($row->libelle_demande_achat)
                 ->setMontant_demande_achat($row->montant_demande_achat)
                 ->setReference_demande_achat($row->reference_demande_achat)
				 ->setType_demande_achat($row->type_demande_achat)
                 ->setCode_membre($row->code_membre)
                 ->setValider_down($row->valider_down)
                 ->setValider_up($row->valider_up)
                 ->setDate_demande($row->date_demande)/*
			     ->setAllocation_budgetaire($row->allocation_budgetaire)
			     ->setCredit_deja_consomme($row->credit_deja_consomme)
			     ->setDisponibilite_demande($row->disponibilite_demande)*/
				 ->setRejet($row->rejet)
				 ->setLivrer($row->livrer);
           $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	
	public function fetchAllByDemandeValider() {
	    $select = $this->getDbTable()->select();
		$select->where("valider_down = ? ",3);
	    $select->where("valider_up = ? ",3);
		$select->where("rejet <> ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	        $entry = new Application_Model_EuDemandeAchat();
		    $entry->setId_demande_achat($row->id_demande_achat)
		         ->setLibelle_demande_achat($row->libelle_demande_achat)
                 ->setMontant_demande_achat($row->montant_demande_achat)
                 ->setReference_demande_achat($row->reference_demande_achat)
				 ->setType_demande_achat($row->type_demande_achat)
                 ->setCode_membre($row->code_membre)
                 ->setValider_down($row->valider_down)
                 ->setValider_up($row->valider_up)
                 ->setDate_demande($row->date_demande)/*
			     ->setAllocation_budgetaire($row->allocation_budgetaire)
			     ->setCredit_deja_consomme($row->credit_deja_consomme)
			     ->setDisponibilite_demande($row->disponibilite_demande)*/
				 ->setRejet($row->rejet)
				 ->setLivrer($row->livrer);
            $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	
    public function save(Application_Model_EuDemandeAchat $dachat) {
        $data = array(
			'id_demande_achat' => $dachat->getId_demande_achat(),
			'libelle_demande_achat' => $dachat->getLibelle_demande_achat(),
            'montant_demande_achat' => $dachat->getMontant_demande_achat(),
            'reference_demande_achat' => $dachat->getReference_demande_achat(),
			'type_demande_achat' => $dachat->getType_demande_achat(),
            'code_membre' => $dachat->getCode_membre(),
            'valider_down' => $dachat->getValider_down(),
            'valider_up' => $dachat->getValider_up(),
            'date_demande' => $dachat->getDate_demande(),
		    'allocation_budgetaire' => $dachat->getAllocation_budgetaire(),
			'credit_deja_consomme' => $dachat->getCredit_deja_consomme(),
			'rejet' => $dachat->getRejet(),
			'livrer' => $dachat->getLivrer(),
		    'disponibilite_demande' => $dachat->getDisponibilite_demande()
        );
        $this->getDbTable()->insert($data);
    }
    
	
	
    public function update(Application_Model_EuDemandeAchat $dachat) {
        $data = array(
          'id_demande_achat' => $dachat->getId_demande_achat(),
		  'libelle_demande_achat' => $dachat->getLibelle_demande_achat(),
          'montant_demande_achat' => $dachat->getMontant_demande_achat(),
          'reference_demande_achat' => $dachat->getReference_demande_achat(),
		  'type_demande_achat' => $dachat->getType_demande_achat(),
          'code_membre' => $dachat->getCode_membre(),
          'valider_down' => $dachat->getValider_down(),
          'valider_up' => $dachat->getValider_up(),
          'date_demande' => $dachat->getDate_demande(),
		  'allocation_budgetaire' => $dachat->getAllocation_budgetaire(),
	      'credit_deja_consomme' => $dachat->getCredit_deja_consomme(),
		  'rejet' => $dachat->getRejet(),
		  'livrer' => $dachat->getLivrer(),
		  'disponibilite_demande' => $dachat->getDisponibilite_demande()
        );
        $this->getDbTable()->update($data, array('id_demande_achat = ?' => $dachat->getId_demande_achat()));
    }
	
	

    public function delete($id_demande_achat) {
        $this->getDbTable()->delete(array('id_demande_achat = ?' => $id_demande_achat));
    }

    ///////////////////////////////////////////////////////////////

}

?>
