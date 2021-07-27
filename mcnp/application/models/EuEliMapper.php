 <?php

class Application_Model_EuEliMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuEli');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_eli, Application_Model_EuEli $eli) {
       $result = $this->getDbTable()->find($id_eli);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $eli->setId_eli($row->id_eli)
           ->setCode_membre($row->code_membre)
           ->setNumero_eli($row->numero_eli)
           ->setLibelle_eli($row->libelle_eli)
           ->setDate_eli($row->date_eli)
           ->setBai($row->bai)
           ->setMontant_bai($row->montant_bai)
		   ->setBan($row->ban)
		   ->setMontant_ban($row->montant_ban)
		   ->setOpi($row->opi)
		   ->setMontant_opi($row->montant_opi)
		   ->setMontant_eli($row->montant_eli)
		   ->setMontant_vente($row->montant_vente)
		   ->setValider($row->valider)
		   ->setRejeter($row->rejeter)
		   ->setPayer($row->payer)
		   ->setUtilisateur($row->utilisateur)
		   ->setId_canton($row->id_canton)
		   ->setCode_tegc($row->code_tegc)
		   ->setId_tdr($row->id_tdr)
		   ->setPropose($row->propose)
		   ->setType_eli($row->type_eli)
		   ;
		   
	    return true;
	}
	
	
	public function findByNumero($numero_eli) {
	   $table = new Application_Model_DbTable_EuEli;
       $select = $table->select();
       $select->where('numero_eli = ?', $numero_eli);
       $result = $table->fetchAll($select);
	
	   if(count($result) == 0) {
          return false;
       }
	   $row = $result->current();
	   $entry = new Application_Model_EuEli();
       $entry->setId_eli($row->id_eli)
             ->setCode_membre($row->code_membre)
             ->setNumero_eli($row->numero_eli)
             ->setLibelle_eli($row->libelle_eli)
             ->setDate_eli($row->date_eli)
             ->setBai($row->bai)
             ->setMontant_bai($row->montant_bai)
		     ->setBan($row->ban)
		     ->setMontant_ban($row->montant_ban)
		     ->setOpi($row->opi)
		     ->setMontant_opi($row->montant_opi)
		     ->setMontant_eli($row->montant_eli)
			 ->setMontant_vente($row->montant_vente)
		     ->setValider($row->valider)
			 ->setRejeter($row->rejeter)
		     ->setPayer($row->payer)
			 ->setUtilisateur($row->utilisateur)
			 ->setId_canton($row->id_canton)
			 ->setCode_tegc($row->code_tegc)
		     ->setId_tdr($row->id_tdr)
		     ->setPropose($row->propose)
			 ->setType_eli($row->type_eli)
		   ;
	   return $entry;
	}
	
	
	public function findByMembre($code_membre) {
	   $select = $this->getDbTable()->select();
       $select->where('code_membre like ?', $code_membre);
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	     $entry = new Application_Model_EuEli();
         $entry->setId_eli($row->id_eli)
               ->setCode_membre($row->code_membre)
               ->setNumero_eli($row->numero_eli)
               ->setLibelle_eli($row->libelle_eli)
               ->setDate_eli($row->date_eli)
               ->setBai($row->bai)
               ->setMontant_bai($row->montant_bai)
		       ->setBan($row->ban)
		       ->setMontant_ban($row->montant_ban)
		       ->setOpi($row->opi)
		       ->setMontant_opi($row->montant_opi)
		       ->setMontant_eli($row->montant_eli)
			   ->setMontant_vente($row->montant_vente)
		       ->setValider($row->valider)
			   ->setRejeter($row->rejeter)
		       ->setPayer($row->payer)
			   ->setUtilisateur($row->utilisateur)
			   ->setId_canton($row->id_canton)
			   ->setCode_tegc($row->code_tegc)
		       ->setId_tdr($row->id_tdr)
		       ->setPropose($row->propose)
			   ->setType_eli($row->type_eli)
		   ; 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	
	
	
	public function fetchAllByValidation($valider) {
	    $select = $this->getDbTable()->select();
	    $select->where("valider = ? ", $valider);
		$select->where("rejeter <> ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuEli();
           $entry->setId_eli($row->id_eli)
                 ->setCode_membre($row->code_membre)
                 ->setNumero_eli($row->numero_eli)
                 ->setLibelle_eli($row->libelle_eli)
                 ->setDate_eli($row->date_eli)
                 ->setBai($row->bai)
                 ->setMontant_bai($row->montant_bai)
		         ->setBan($row->ban)
		         ->setMontant_ban($row->montant_ban)
		         ->setOpi($row->opi)
		         ->setMontant_opi($row->montant_opi)
		         ->setMontant_eli($row->montant_eli)
				 ->setMontant_vente($row->montant_vente)
		         ->setValider($row->valider)
				 ->setRejeter($row->rejeter)
		         ->setPayer($row->payer)
				 ->setUtilisateur($row->utilisateur)
				 ->setId_canton($row->id_canton)
				 ->setCode_tegc($row->code_tegc)
		         ->setId_tdr($row->id_tdr)
		         ->setPropose($row->propose)
		         ->setType_eli($row->type_eli)
		   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	public function fetchAllByValider() {
	    $select = $this->getDbTable()->select();
	    $select->where("valider = ? ", 4);
		//$select->where("rejeter <> ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuEli();
           $entry->setId_eli($row->id_eli)
                 ->setCode_membre($row->code_membre)
                 ->setNumero_eli($row->numero_eli)
                 ->setLibelle_eli($row->libelle_eli)
                 ->setDate_eli($row->date_eli)
                 ->setBai($row->bai)
                 ->setMontant_bai($row->montant_bai)
		         ->setBan($row->ban)
		         ->setMontant_ban($row->montant_ban)
		         ->setOpi($row->opi)
		         ->setMontant_opi($row->montant_opi)
		         ->setMontant_eli($row->montant_eli)
				 ->setMontant_vente($row->montant_vente)
		         ->setValider($row->valider)
				 ->setRejeter($row->rejeter)
		         ->setPayer($row->payer)
				 ->setUtilisateur($row->utilisateur)
				 ->setId_canton($row->id_canton)
				 ->setCode_tegc($row->code_tegc)
		         ->setId_tdr($row->id_tdr)
		         ->setPropose($row->propose)
				 ->setType_eli($row->type_eli)
		   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	public function fetchAllByContracter() {
	    $select = $this->getDbTable()->select();
	    $select->where("valider = ? ", 4);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuEli();
           $entry->setId_eli($row->id_eli)
                 ->setCode_membre($row->code_membre)
                 ->setNumero_eli($row->numero_eli)
                 ->setLibelle_eli($row->libelle_eli)
                 ->setDate_eli($row->date_eli)
                 ->setBai($row->bai)
                 ->setMontant_bai($row->montant_bai)
		         ->setBan($row->ban)
		         ->setMontant_ban($row->montant_ban)
		         ->setOpi($row->opi)
		         ->setMontant_opi($row->montant_opi)
		         ->setMontant_eli($row->montant_eli)
				 ->setMontant_vente($row->montant_vente)
		         ->setValider($row->valider)
				 ->setRejeter($row->rejeter)
		         ->setPayer($row->payer)
				 ->setUtilisateur($row->utilisateur)
				 ->setId_canton($row->id_canton)
				 ->setCode_tegc($row->code_tegc)
		         ->setId_tdr($row->id_tdr)
		         ->setPropose($row->propose)
				 ->setType_eli($row->type_eli)
		   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	
	public function fetchAllByRejeter() {
	    $select = $this->getDbTable()->select();
		$select->where("rejeter = ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuEli();
           $entry->setId_eli($row->id_eli)
                 ->setCode_membre($row->code_membre)
                 ->setNumero_eli($row->numero_eli)
                 ->setLibelle_eli($row->libelle_eli)
                 ->setDate_eli($row->date_eli)
                 ->setBai($row->bai)
                 ->setMontant_bai($row->montant_bai)
		         ->setBan($row->ban)
		         ->setMontant_ban($row->montant_ban)
		         ->setOpi($row->opi)
		         ->setMontant_opi($row->montant_opi)
		         ->setMontant_eli($row->montant_eli)
				 ->setMontant_vente($row->montant_vente)
		         ->setValider($row->valider)
				 ->setRejeter($row->rejeter)
		         ->setPayer($row->payer)
				 ->setUtilisateur($row->utilisateur)
				 ->setId_canton($row->id_canton)
				 ->setCode_tegc($row->code_tegc)
		         ->setId_tdr($row->id_tdr)
		         ->setPropose($row->propose)
				 ->setType_eli($row->type_eli)
		   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuEli();
            $entry->setId_eli($row->id_eli)
                  ->setCode_membre($row->code_membre)
                  ->setNumero_eli($row->numero_eli)
                  ->setLibelle_eli($row->libelle_eli)
                  ->setDate_eli($row->date_eli)
                  ->setBai($row->bai)
                  ->setMontant_bai($row->montant_bai)
		          ->setBan($row->ban)
		          ->setMontant_ban($row->montant_ban)
		          ->setOpi($row->opi)
		          ->setMontant_opi($row->montant_opi)
		          ->setMontant_eli($row->montant_eli)
				  ->setMontant_vente($row->montant_vente)
		          ->setValider($row->valider)
				  ->setRejeter($row->rejeter)
		          ->setPayer($row->payer)
				  ->setUtilisateur($row->utilisateur)
				  ->setId_canton($row->id_canton)
				  ->setCode_tegc($row->code_tegc)
		          ->setId_tdr($row->id_tdr)
		          ->setPropose($row->propose)
				  ->setType_eli($row->type_eli)
		   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function save(Application_Model_EuEli $eli) {
        $data = array(
			'id_eli' => $eli->getId_eli(),
            'code_membre' => $eli->getCode_membre(),
            'numero_eli' => $eli->getNumero_eli(),
            'libelle_eli' => $eli->getLibelle_eli(),
            'date_eli' => $eli->getDate_eli(),
            'bai' => $eli->getBai(),
            'montant_bai' => $eli->getMontant_bai(),
		    'ban' => $eli->getBan(),
			'montant_ban' => $eli->getMontant_ban(),
			'opi' => $eli->getOpi(),
			'montant_opi' => $eli->getMontant_opi(),
			'montant_eli' => $eli->getMontant_eli(),
			'montant_vente' => $eli->getMontant_vente(),
			'payer' => $eli->getPayer(),
			'utilisateur' => $eli->getUtilisateur(),
			'id_canton' => $eli->getId_canton(),
			'code_tegc' => $eli->getCode_tegc(),
			'rejeter' => $eli->getRejeter(),
			'type_eli' => $eli->getType_eli(),
		    'valider' => $eli->getValider()
        );
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuEli $eli) {
        $data = array(
          'id_eli' => $eli->getId_eli(),
          'code_membre' => $eli->getCode_membre(),
          'numero_eli' => $eli->getNumero_eli(),
          'libelle_eli' => $eli->getLibelle_eli(),
          'date_eli' => $eli->getDate_eli(),
          'bai' => $eli->getBai(),
          'montant_bai' => $eli->getMontant_bai(),
		  'ban' => $eli->getBan(),
		  'montant_ban' => $eli->getMontant_ban(),
		  'opi' => $eli->getOpi(),
		  'montant_opi' => $eli->getMontant_opi(),
		  'montant_eli' => $eli->getMontant_eli(),
		  'montant_vente' => $eli->getMontant_vente(),
		  'payer' => $eli->getPayer(),
		  'utilisateur' => $eli->getUtilisateur(),
		  'id_canton' => $eli->getId_canton(),
		  'code_tegc' => $eli->getCode_tegc(),
		  'rejeter' => $eli->getRejeter(),
		  'type_eli' => $eli->getType_eli(),
		  'valider' => $eli->getValider()
        );
        $this->getDbTable()->update($data, array('id_eli = ?' => $eli->getId_eli()));
    }
	

    public function delete($id_eli) {
        $this->getDbTable()->delete(array('id_eli = ?' => $id_eli));
    }

    ///////////////////////////////////////////////////////////////


	
	public function findByMembrePropose($code_membre) {
	   $select = $this->getDbTable()->select();
       $select->where("id_tdr IN (SELECT id_tdr FROM eu_tdr WHERE code_membre like '".$code_membre."')");
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	     $entry = new Application_Model_EuEli();
         $entry->setId_eli($row->id_eli)
               ->setCode_membre($row->code_membre)
               ->setNumero_eli($row->numero_eli)
               ->setLibelle_eli($row->libelle_eli)
               ->setDate_eli($row->date_eli)
               ->setBai($row->bai)
               ->setMontant_bai($row->montant_bai)
		       ->setBan($row->ban)
		       ->setMontant_ban($row->montant_ban)
		       ->setOpi($row->opi)
		       ->setMontant_opi($row->montant_opi)
		       ->setMontant_eli($row->montant_eli)
			   ->setMontant_vente($row->montant_vente)
		       ->setValider($row->valider)
			   ->setRejeter($row->rejeter)
		       ->setPayer($row->payer)
			   ->setUtilisateur($row->utilisateur)
			   ->setId_canton($row->id_canton)
			   ->setCode_tegc($row->code_tegc)
		       ->setId_tdr($row->id_tdr)
		       ->setPropose($row->propose)
			   ->setType_eli($row->type_eli)
		   ; 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	
	
	public function findByPropose($propose) {
	   $select = $this->getDbTable()->select();
       $select->where("propose = ?", $propose);
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	     $entry = new Application_Model_EuEli();
         $entry->setId_eli($row->id_eli)
               ->setCode_membre($row->code_membre)
               ->setNumero_eli($row->numero_eli)
               ->setLibelle_eli($row->libelle_eli)
               ->setDate_eli($row->date_eli)
               ->setBai($row->bai)
               ->setMontant_bai($row->montant_bai)
		       ->setBan($row->ban)
		       ->setMontant_ban($row->montant_ban)
		       ->setOpi($row->opi)
		       ->setMontant_opi($row->montant_opi)
		       ->setMontant_eli($row->montant_eli)
			   ->setMontant_vente($row->montant_vente)
		       ->setValider($row->valider)
			   ->setRejeter($row->rejeter)
		       ->setPayer($row->payer)
			   ->setUtilisateur($row->utilisateur)
			   ->setId_canton($row->id_canton)
			   ->setCode_tegc($row->code_tegc)
		       ->setId_tdr($row->id_tdr)
		       ->setPropose($row->propose)
		       ->setType_eli($row->type_eli)
		   ; 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	


}

?>
