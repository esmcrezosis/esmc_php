<?php
 
class Application_Model_EuMstiersListecmMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuMstiersListecm');
        }
        return $this->_dbTable;
    }

	
    public function find($id_mstiers_listecm, Application_Model_EuMstiersListecm $mstierslistecm)  {
        $result = $this->getDbTable()->find($id_mstiers_listecm);
        if(count($result) == 0) {
          return false;
        }
		
        $row = $result->current();
        $mstierslistecm->setId_mstiers_listecm($row->id_mstiers_listecm)
                       ->setCode_membre_apporteur($row->code_membre_apporteur)
                       ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                       ->setNom_membre($row->nom_membre)
                       ->setPrenom_membre($row->prenom_membre)
		       ->setDate_nais_membre($row->date_nais_membre)
		       ->setLieu_nais_membre($row->lieu_nais_membre)
		       ->setMere_membre($row->mere_membre)
		       ->setPere_membre($row->pere_membre)
		       ->setNbr_enf_membre($row->nbr_enf_membre)
		       ->setPortable_membre($row->portable_membre)
		       ->setBp_membre($row->bp_membre)
		       ->setCodesecret($row->codesecret)
		       ->setEmail_membre($row->email_membre)
		       ->setProfession_membre($row->profession_membre)
		       ->setFormation($row->formation)
		       ->setQuartier_membre($row->quartier_membre)
		       ->setSexe_membre($row->sexe_membre)
		       ->setSitfam_membre($row->sitfam_membre)
		       ->setVille_membre($row->ville_membre)
		       ->setId_pays($row->id_pays)
		       ->setId_canton($row->id_canton)
		       ->setId_religion_membre($row->id_religion_membre)
		       ->setCode_agence($row->code_agence)
		       ->setDate_listecm($row->date_listecm)
		       ->setCode_caps($row->code_caps)
		       ->setUtilisateur($row->utilisateur)
		       ->setCode_zone($row->code_zone)
                       ->setStatut($row->statut)
                       ->setType_liste($row->type_liste)
                       ->setDoublon($row->doublon);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMstiersListecm();
            $entry->setId_mstiers_listecm($row->id_mstiers_listecm)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setNom_membre($row->nom_membre)
                  ->setPrenom_membre($row->prenom_membre)
		  ->setDate_nais_membre($row->date_nais_membre)
		  ->setLieu_nais_membre($row->lieu_nais_membre)
		  ->setMere_membre($row->mere_membre)
		  ->setPere_membre($row->pere_membre)
		  ->setNbr_enf_membre($row->nbr_enf_membre)
		  ->setPortable_membre($row->portable_membre)
		  ->setBp_membre($row->bp_membre)
		  ->setCodesecret($row->codesecret)
		  ->setEmail_membre($row->email_membre)
		  ->setProfession_membre($row->profession_membre)
		  ->setFormation($row->formation)
		  ->setQuartier_membre($row->quartier_membre)
		  ->setSexe_membre($row->sexe_membre)
		  ->setSitfam_membre($row->sitfam_membre)
		  ->setVille_membre($row->ville_membre)
		  ->setId_pays($row->id_pays)
		  ->setId_canton($row->id_canton)
		  ->setId_religion_membre($row->id_religion_membre)
		  ->setCode_agence($row->code_agence)
		  ->setDate_listecm($row->date_listecm)
		  ->setCode_caps($row->code_caps)
		  ->setUtilisateur($row->utilisateur)
		  ->setCode_zone($row->code_zone)
                  ->setStatut($row->statut)
                  ->setType_liste($row->type_liste)
                  ->setDoublon($row->doublon);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mstiers_listecm) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

   public function findcountbenef($apporteur) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(),array('COUNT(id_mstiers_listecm) as count'));
	$select->where('code_membre_apporteur like ?',$apporteur); 
        $select->where('statut = ?',0);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
	public function fetchAllBeneficiaireAvecListe()  {
	    $tabela = new Application_Model_DbTable_EuMstiersListecm();
	    $select = $tabela->select();
        $select->where('type_liste like ?',"AvecListe");
	    $select->where('statut = ?',0);
        $select->where('doublon = ?',0);
		$select->where('code_agence is not null');
        $select->order('date_listecm asc');
	    $result = $tabela->fetchAll($select);
	    if(count($result) == 0) {
            return NULL;
        }
	    $entries = array();
        foreach($result as $row) {
            $entry = new Application_Model_EuMstiersListecm();
            $entry->setId_mstiers_listecm($row->id_mstiers_listecm)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setNom_membre($row->nom_membre)
                  ->setPrenom_membre($row->prenom_membre)
		          ->setDate_nais_membre($row->date_nais_membre)
		          ->setLieu_nais_membre($row->lieu_nais_membre)
		          ->setMere_membre($row->mere_membre)
		          ->setPere_membre($row->pere_membre)
		          ->setNbr_enf_membre($row->nbr_enf_membre)
		          ->setPortable_membre($row->portable_membre)
		          ->setBp_membre($row->bp_membre)
		          ->setCodesecret($row->codesecret)
		          ->setEmail_membre($row->email_membre)
		          ->setProfession_membre($row->profession_membre)
		          ->setFormation($row->formation)
		          ->setQuartier_membre($row->quartier_membre)
		          ->setSexe_membre($row->sexe_membre)
		          ->setSitfam_membre($row->sitfam_membre)
		          ->setVille_membre($row->ville_membre)
		          ->setId_pays($row->id_pays)
		          ->setId_canton($row->id_canton)
		          ->setId_religion_membre($row->id_religion_membre)
		          ->setCode_agence($row->code_agence)
		          ->setDate_listecm($row->date_listecm)
		          ->setCode_caps($row->code_caps)
		          ->setUtilisateur($row->utilisateur)
		          ->setCode_zone($row->code_zone)
                  ->setStatut($row->statut)
                  ->setType_liste($row->type_liste)
                  ->setDoublon($row->doublon);
		    $entries[] = $entry;
	    }
		return $entries; 
	}
	
	
	
	
	public function fetchAllBeneficiaireSansListe()  {
	    $tabela = new Application_Model_DbTable_EuMstiersListecm();
	    $select = $tabela->select();
	    //$select->where('code_membre_apporteur is null');
	    //$select->where('code_membre_beneficiaire is null');

        $select->where('type_liste like ?',"SansListe");
	    $select->where('statut = ?',0);
        $select->where('doublon = ?',0);
	    $select->where('code_agence is not null');
        $select->order('date_listecm asc');
	    $result = $tabela->fetchAll($select);
	    if(count($result) == 0) {
            return NULL;
        }
	    $entries = array();
        foreach($result as $row) {
            $entry = new Application_Model_EuMstiersListecm();
            $entry->setId_mstiers_listecm($row->id_mstiers_listecm)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setNom_membre($row->nom_membre)
                  ->setPrenom_membre($row->prenom_membre)
		          ->setDate_nais_membre($row->date_nais_membre)
		          ->setLieu_nais_membre($row->lieu_nais_membre)
		          ->setMere_membre($row->mere_membre)
		          ->setPere_membre($row->pere_membre)
		          ->setNbr_enf_membre($row->nbr_enf_membre)
		          ->setPortable_membre($row->portable_membre)
		          ->setBp_membre($row->bp_membre)
		          ->setCodesecret($row->codesecret)
		          ->setEmail_membre($row->email_membre)
		          ->setProfession_membre($row->profession_membre)
		          ->setFormation($row->formation)
		          ->setQuartier_membre($row->quartier_membre)
		          ->setSexe_membre($row->sexe_membre)
		          ->setSitfam_membre($row->sitfam_membre)
		          ->setVille_membre($row->ville_membre)
		          ->setId_pays($row->id_pays)
		          ->setId_canton($row->id_canton)
		          ->setId_religion_membre($row->id_religion_membre)
		          ->setCode_agence($row->code_agence)
		          ->setDate_listecm($row->date_listecm)
		          ->setCode_caps($row->code_caps)
		          ->setUtilisateur($row->utilisateur)
		          ->setCode_zone($row->code_zone)
                  ->setStatut($row->statut)
                  ->setType_liste($row->type_liste)
                  ->setDoublon($row->doublon);
		   $entries[] = $entry;
	    }
		return $entries; 
	}
	
	
	public function fetchAllByMembre($membre) {
	   $tabela = new Application_Model_DbTable_EuMstiersListecm();
	   $select = $tabela->select();
	   $select->where('code_membre_apporteur = ?',$membre);
       $select->where('code_membre_beneficiaire is null');	   
	   $result = $tabela->fetchAll($select);
       if(count($result) == 0) {
          return NULL;
       }
	   $entries = array();
       foreach($result as $row) {
          $entry = new Application_Model_EuMstiersListecm();
          $entry->setId_mstiers_listecm($row->id_mstiers_listecm)
                ->setCode_membre_apporteur($row->code_membre_apporteur)
                ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                ->setNom_membre($row->nom_membre)
                ->setPrenom_membre($row->prenom_membre)
				->setDate_nais_membre($row->date_nais_membre)
				->setLieu_nais_membre($row->lieu_nais_membre)
				->setMere_membre($row->mere_membre)
				->setPere_membre($row->pere_membre)
			    ->setNbr_enf_membre($row->nbr_enf_membre)
				->setPortable_membre($row->portable_membre)
				->setBp_membre($row->bp_membre)
				->setCodesecret($row->codesecret)
				->setEmail_membre($row->email_membre)
				->setProfession_membre($row->profession_membre)
				->setFormation($row->formation)
				->setQuartier_membre($row->quartier_membre)
				->setSexe_membre($row->sexe_membre)
				->setSitfam_membre($row->sitfam_membre)
				->setVille_membre($row->ville_membre)
				->setId_pays($row->id_pays)
				->setId_canton($row->id_canton)
				->setId_religion_membre($row->id_religion_membre)
				->setCode_agence($row->code_agence)
				->setDate_listecm($row->date_listecm)
				->setCode_caps($row->code_caps)
				->setUtilisateur($row->utilisateur)
				->setCode_zone($row->code_zone)
                                ->setStatut($row->statut)
                                ->setType_liste($row->type_liste)
                                ->setDoublon($row->doublon);
		   $entries[] = $entry;
	    }
		return $entries;
	}
	
	
    public function save(Application_Model_EuMstiersListecm $mstierslistecm) {
        $data = array(
            'id_mstiers_listecm' => $mstierslistecm->getId_mstiers_listecm(),
            'code_membre_apporteur' => $mstierslistecm->getCode_membre_apporteur(),
            'code_membre_beneficiaire' => $mstierslistecm->getCode_membre_beneficiaire(),
	    'nom_membre' => strtoupper($mstierslistecm->getNom_membre()),
	    'prenom_membre' => strtoupper($mstierslistecm->getPrenom_membre()),
	    'date_nais_membre' => $mstierslistecm->getDate_nais_membre(),
	    'lieu_nais_membre' => strtoupper($mstierslistecm->getLieu_nais_membre()),
	    'mere_membre' => strtoupper($mstierslistecm->getMere_membre()),
            'pere_membre' => strtoupper($mstierslistecm->getPere_membre()),
	    'nbr_enf_membre' => $mstierslistecm->getNbr_enf_membre(),
	    'portable_membre' => $mstierslistecm->getPortable_membre(),
	    'bp_membre' => $mstierslistecm->getBp_membre(),
	    'codesecret' => $mstierslistecm->getCodesecret(),
	    'email_membre' => $mstierslistecm->getEmail_membre(),
	    'formation' => $mstierslistecm->getFormation(),
	    'quartier_membre' => strtoupper($mstierslistecm->getQuartier_membre()),
	    'sexe_membre' => $mstierslistecm->getSexe_membre(),
	    'sitfam_membre' => $mstierslistecm->getSitfam_membre(),
	    'ville_membre' => strtoupper($mstierslistecm->getVille_membre()),
	    'id_pays' => $mstierslistecm->getId_pays(),
	    'id_canton' => $mstierslistecm->getId_canton(),
	    'id_religion_membre' => $mstierslistecm->getId_religion_membre(),
	    'code_agence' => $mstierslistecm->getCode_agence(),
	    'date_listecm' => $mstierslistecm->getDate_listecm(),
	    'code_caps' => $mstierslistecm->getCode_caps(),
	    'utilisateur' => $mstierslistecm->getUtilisateur(),
	    'code_zone'  =>  $mstierslistecm->getCode_zone(),
            'statut'  =>  $mstierslistecm->getStatut(),
            'doublon'  =>  $mstierslistecm->getDoublon(),
            'type_liste'  =>  $mstierslistecm->getType_liste(),
	    'profession_membre'  =>  strtoupper($mstierslistecm->getProfession_membre())
        );
        $this->getDbTable()->insert($data);
    }
	
	

    public function update(Application_Model_EuMstiersListecm $mstierslistecm) {
        $data = array(
            'id_mstiers_listecm' => $mstierslistecm->getId_mstiers_listecm(),
            'code_membre_apporteur' => $mstierslistecm->getCode_membre_apporteur(),
            'code_membre_beneficiaire' => $mstierslistecm->getCode_membre_beneficiaire(),
	    'nom_membre' => strtoupper($mstierslistecm->getNom_membre()),
	    'prenom_membre' => strtoupper($mstierslistecm->getPrenom_membre()),
	    'date_nais_membre' => $mstierslistecm->getDate_nais_membre(),
	    'lieu_nais_membre' => strtoupper($mstierslistecm->getLieu_nais_membre()),
	    'mere_membre' => strtoupper($mstierslistecm->getMere_membre()),
            'pere_membre' => strtoupper($mstierslistecm->getPere_membre()),
	    'nbr_enf_membre' => $mstierslistecm->getNbr_enf_membre(),
	    'portable_membre' => $mstierslistecm->getPortable_membre(),
	    'bp_membre' => $mstierslistecm->getBp_membre(),
	    'codesecret' => $mstierslistecm->getCodesecret(),
	    'email_membre' => $mstierslistecm->getEmail_membre(),
	    'formation' => $mstierslistecm->getFormation(),
	    'quartier_membre' => strtoupper($mstierslistecm->getQuartier_membre()),
	    'sexe_membre' => $mstierslistecm->getSexe_membre(),
	    'sitfam_membre' => $mstierslistecm->getSitfam_membre(),
	    'ville_membre' => strtoupper($mstierslistecm->getVille_membre()),
	    'id_pays' => $mstierslistecm->getId_pays(),
	    'id_canton' => $mstierslistecm->getId_canton(),
	    'id_religion_membre' => $mstierslistecm->getId_religion_membre(),
	    'code_agence' => $mstierslistecm->getCode_agence(),
	    'date_listecm' => $mstierslistecm->getDate_listecm(),
	    'code_caps' => $mstierslistecm->getCode_caps(),
	    'utilisateur' => $mstierslistecm->getUtilisateur(),
	    'code_zone'  =>  $mstierslistecm->getCode_zone(),
            'statut'  =>  $mstierslistecm->getStatut(),
            'doublon'  =>  $mstierslistecm->getDoublon(),
            'type_liste'  =>  $mstierslistecm->getType_liste(),
	    'profession_membre'  =>  strtoupper($mstierslistecm->getProfession_membre())
			
        );
        $this->getDbTable()->update($data, array('id_mstiers_listecm = ?' => $mstierslistecm->getId_mstiers_listecm()));
    }

    public function delete($id_mstiers_listecm) {
        $this->getDbTable()->delete(array('id_mstiers_listecm = ?' => $id_mstiers_listecm));
    }


    

}


?>
