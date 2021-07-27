<?php
 
class Application_Model_EuMstiersListebcMapper {

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
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuMstiersListebc');
        }
        return $this->_dbTable;
    }

	
    public function find($id_mstiers_listebc, Application_Model_EuMstiersListebc $mstierslistebc) {
        $result = $this->getDbTable()->find($id_mstiers_listebc);
        if(count($result) == 0) {
          return false;
        }
		
        $row = $result->current();
        $mstierslistebc->setId_mstiers_listebc($row->id_mstiers_listebc)
                       ->setCode_membre_apporteur($row->code_membre_apporteur)
                       ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                       ->setType_souscription($row->type_souscription)
                       ->setCode_bnp($row->code_bnp)
					   ->setType_liste($row->type_liste)
					   ->setUtilisateur($row->utilisateur)
		               ->setDate_listebc($row->date_listebc)
                       ->setStatut($row->statut)
					   ->setBon_conso($row->bon_conso)
				       ->setFrais_solvabilite($row->frais_solvabilite)
				       ->setPeripherique($row->peripherique)
				       ->setConnectivite($row->connectivite)
				       ->setAssurance($row->assurance)
				       ->setDeposit($row->deposit)
					   ->setCompte_bancaire($row->compte_bancaire)
					   ->setType_kit($row->type_kit)
					   ->setBon_neutre_id($row->bon_neutre_id)
					   ->setNom_membre($row->nom_membre)
					   ->setPrenom_membre($row->prenom_membre)
					   ;
        return true;
    }
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMstiersListebc();
            $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setType_souscription($row->type_souscription)
                  ->setCode_bnp($row->code_bnp)
				  ->setType_liste($row->type_liste)
				  ->setUtilisateur($row->utilisateur)
		          ->setDate_listebc($row->date_listebc)
                  ->setStatut($row->statut)
				  ->setBon_conso($row->bon_conso)
				  ->setFrais_solvabilite($row->frais_solvabilite)
				  ->setPeripherique($row->peripherique)
				  ->setConnectivite($row->connectivite)
				  ->setAssurance($row->assurance)
				  ->setDeposit($row->deposit)
				  ->setCompte_bancaire($row->compte_bancaire)
				  ->setType_kit($row->type_kit)
				  ->setBon_neutre_id($row->bon_neutre_id)
				  ->setNom_membre($row->nom_membre)
				  ->setPrenom_membre($row->prenom_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mstiers_listebc) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function findcountbenef($apporteur) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(),array('COUNT(id_mstiers_listebc) as count'));
		$select->where('type_kit like ?',"KITSU");
		$select->where('type_liste like ?',"AvecListe");
	    $select->where('code_membre_apporteur like ?',$apporteur); 
        $select->where('statut = ?',0);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
	public function findcountbenef1($apporteur) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(),array('COUNT(id_mstiers_listebc) as count'));
		$select->where('type_kit like ?',"KITTECH");
		$select->where('type_liste like ?',"AvecListe");
	    $select->where('code_membre_apporteur like ?',$apporteur); 
        $select->where('statut = ?',0);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	public function fetchByBanBeneficiaire($bon_neutre_id) {
	    $tabela = new Application_Model_DbTable_EuMstiersListebc();
	    $select = $tabela->select();
	    $select->where('bon_neutre_id = ?',$bon_neutre_id);
	    $select->where('frais_solvabilite = ?',1);
		$result = $this->getDbTable()->fetchAll($select);
		if(count($result) == 0) {
           return NULL;
        }
		$row = $result->current();
		$entry = new Application_Model_EuMstiersListebc();
        $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
              ->setCode_membre_apporteur($row->code_membre_apporteur)
              ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
              ->setType_souscription($row->type_souscription)
              ->setCode_bnp($row->code_bnp)
		      ->setDate_listebc($row->date_listebc)
			  ->setType_liste($row->type_liste)
			  ->setUtilisateur($row->utilisateur)
              ->setStatut($row->statut)
			  ->setBon_conso($row->bon_conso)
			  ->setFrais_solvabilite($row->frais_solvabilite)
			  ->setPeripherique($row->peripherique)
			  ->setConnectivite($row->connectivite)
			  ->setAssurance($row->assurance)
			  ->setDeposit($row->deposit)
			  ->setCompte_bancaire($row->compte_bancaire)
			  ->setType_kit($row->type_kit)
			  ->setBon_neutre_id($row->bon_neutre_id)
			  ->setNom_membre($row->nom_membre)
			  ->setPrenom_membre($row->prenom_membre);
		return $entry;
	}
	
	
	
	
	public function fetchAllByMembre($membre) {
	    $tabela = new Application_Model_DbTable_EuMstiersListebc();
	    $select = $tabela->select();
	    $select->where('code_membre_apporteur = ?',$membre);   
	    $result = $tabela->fetchAll($select);
        if(count($result) == 0) {
            return NULL;
        }
	    $entries = array();
        foreach($result as $row) {
            $entry = new Application_Model_EuMstiersListebc();
            $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setType_souscription($row->type_souscription)
                  ->setCode_bnp($row->code_bnp)
		          ->setDate_listebc($row->date_listebc)
				  ->setType_liste($row->type_liste)
				  ->setUtilisateur($row->utilisateur)
                  ->setStatut($row->statut)
				  ->setBon_conso($row->bon_conso)
				  ->setFrais_solvabilite($row->frais_solvabilite)
				  ->setPeripherique($row->peripherique)
				  ->setConnectivite($row->connectivite)
				  ->setAssurance($row->assurance)
				  ->setDeposit($row->deposit)
				  ->setCompte_bancaire($row->compte_bancaire)
				  ->setType_kit($row->type_kit)
				  ->setBon_neutre_id($row->bon_neutre_id)
				  ->setNom_membre($row->nom_membre)
				  ->setPrenom_membre($row->prenom_membre);
		   $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	
	
    public function save(Application_Model_EuMstiersListebc $mstierslistebc) {
        $data = array(
          'id_mstiers_listebc' => $mstierslistebc->getId_mstiers_listebc(),
          'code_membre_apporteur' => $mstierslistebc->getCode_membre_apporteur(),
          'code_membre_beneficiaire' => $mstierslistebc->getCode_membre_beneficiaire(),
	      'type_souscription' => $mstierslistebc->getType_souscription(),
	      'code_bnp' => $mstierslistebc->getCode_bnp(),
          'statut' => $mstierslistebc->getStatut(),
		  'type_liste' => $mstierslistebc->getType_liste(),
		  'utilisateur' => $mstierslistebc->getUtilisateur(),
	      'date_listebc' => $mstierslistebc->getDate_listebc(),
		  'bon_conso' => $mstierslistebc->getBon_conso(),
		  'frais_solvabilite' => $mstierslistebc->getFrais_solvabilite(),
		  'peripherique' => $mstierslistebc->getPeripherique(),
		  'connectivite' => $mstierslistebc->getConnectivite(),
		  'assurance' => $mstierslistebc->getAssurance(),
		  'compte_bancaire' => $mstierslistebc->getCompte_bancaire(),
		  'type_kit' => $mstierslistebc->getType_kit(),
		  'deposit' => $mstierslistebc->getDeposit(),
		  'bon_neutre_id' => $mstierslistebc->getBon_neutre_id(),
		  'nom_membre' => $mstierslistebc->getNom_membre(),
		  'prenom_membre' => $mstierslistebc->getPrenom_membre()
        );
        $this->getDbTable()->insert($data);
    }
	
	

    public function update(Application_Model_EuMstiers $mstierslistebc) {
        $data = array(
          'id_mstiers_listebc' => $mstierslistebc->getId_mstiers_listebc(),
          'code_membre_apporteur' => $mstierslistebc->getCode_membre_apporteur(),
          'code_membre_beneficiaire' => $mstierslistebc->getCode_membre_beneficiaire(),
	      'type_souscription' => $mstierslistebc->getType_souscription(),
	      'code_bnp' => $mstierslistebc->getCode_bnp(),
		  'type_liste' => $mstierslistebc->getType_liste(),
		  'utilisateur' => $mstierslistebc->getUtilisateur(),
          'statut' => $mstierslistebc->getStatut(),
	      'date_listebc' => $mstierslistebc->getDate_listebc(),
		  'bon_conso' => $mstierslistebc->getBon_conso(),
		  'frais_solvabilite' => $mstierslistebc->getFrais_solvabilite(),
		  'peripherique' => $mstierslistebc->getPeripherique(),
		  'connectivite' => $mstierslistebc->getConnectivite(),
		  'assurance' => $mstierslistebc->getAssurance(),
		  'compte_bancaire' => $mstierslistebc->getCompte_bancaire(),
		  'type_kit' => $mstierslistebc->getType_kit(),
		  'deposit' => $mstierslistebc->getDeposit(),
		  'bon_neutre_id' => $mstierslistebc->getBon_neutre_id(),
		  'nom_membre' => $mstierslistebc->getNom_membre(),
		  'prenom_membre' => $mstierslistebc->getPrenom_membre()
        );
        $this->getDbTable()->update($data, array('id_mstiers_listebc = ?' => $mstiers->getId_mstiers_listebc()));
    }

	
	
    public function delete($id_mstiers_listebc) {
        $this->getDbTable()->delete(array('id_mstiers_listebc = ?' => $id_mstiers_listebc));
    }


	
	public function fetchAllByMembrebeneficiaireTypeliste($code_membre_beneficiaire, $type_liste) {
	    $tabela = new Application_Model_DbTable_EuMstiersListebc();
	    $select = $tabela->select();
	    $select->where('code_membre_beneficiaire = ?', $code_membre_beneficiaire);   
	    $select->where('type_liste LIKE ?', $type_liste);   
        $result = $tabela->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuMstiersListebc();
        $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
              ->setCode_membre_apporteur($row->code_membre_apporteur)
              ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
              ->setType_souscription($row->type_souscription)
              ->setCode_bnp($row->code_bnp)
		      ->setDate_listebc($row->date_listebc)
		      ->setType_liste($row->type_liste)
		      ->setUtilisateur($row->utilisateur)
              ->setStatut($row->statut)
			  ->setBon_conso($row->bon_conso)
			  ->setFrais_solvabilite($row->frais_solvabilite)
			  ->setPeripherique($row->peripherique)
			  ->setConnectivite($row->connectivite)
			  ->setAssurance($row->assurance)
			  ->setDeposit($row->deposit)
			  ->setCompte_bancaire($row->compte_bancaire)
			  ->setType_kit($row->type_kit)
			  ->setBon_neutre_id($row->bon_neutre_id)
			  ->setNom_membre($row->nom_membre)
			  ->setPrenom_membre($row->prenom_membre);
        $entries = $entry;
        return $entries;
    }

}


?>
