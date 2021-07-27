<?php
 
class Application_Model_EuSouscriptionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSouscription');
        }
        return $this->_dbTable;
    }

    public function find($souscription_id, Application_Model_EuSouscription $souscription) {
        $result = $this->getDbTable()->find($souscription_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $souscription->setSouscription_id($row->souscription_id)
                ->setSouscription_nom($row->souscription_nom)
                ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
		->setId_canton($row->id_canton)
		->setQuittance_invalide($row->quittance_invalide)
                ->setId_postulat($row->id_postulat);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                  ->setErreur($row->erreur)
                  ->setErreurdescription($row->erreurdescription)
		  ->setId_canton($row->id_canton)
		  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(souscription_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuSouscription $souscription) {
        $data = array(
            'souscription_id' => $souscription->getSouscription_id(),
            'souscription_nom' => $souscription->getSouscription_nom(),
            'souscription_prenom' => $souscription->getSouscription_prenom(),
            'souscription_mobile' => $souscription->getSouscription_mobile(),
            'souscription_membreasso' => $souscription->getSouscription_membreasso(),
            'souscription_email' => $souscription->getSouscription_email(),
            'souscription_raison' => $souscription->getSouscription_raison(),
            'souscription_numero' => $souscription->getSouscription_numero(),
            'souscription_date_numero' => $souscription->getSouscription_date_numero(),
            'souscription_type' => $souscription->getSouscription_type(),
            'souscription_banque' => $souscription->getSouscription_banque(),
            'souscription_date' => $souscription->getSouscription_date(),
            'souscription_personne' => $souscription->getSouscription_personne(),
            'souscription_montant' => $souscription->getSouscription_montant(),
            'souscription_nombre' => $souscription->getSouscription_nombre(),
            'souscription_programme' => $souscription->getSouscription_programme(),
            'souscription_type_candidat' => $souscription->getSouscription_type_candidat(),
            'souscription_filiere' => $souscription->getSouscription_filiere(),
            'souscription_vignette' => $souscription->getSouscription_vignette(),
            'code_type_acteur' => $souscription->getCode_type_acteur(),
            'code_statut' => $souscription->getCode_statut(),
            'code_activite' => $souscription->getCode_activite(),
            'id_metier' => $souscription->getId_metier(),
            'id_competence' => $souscription->getId_competence(),
            'souscription_ville' => $souscription->getSouscription_ville(),
            'souscription_quartier' => $souscription->getSouscription_quartier(),
            'souscription_login' => $souscription->getSouscription_login(),
            'souscription_passe' => $souscription->getSouscription_passe(),
            'souscription_souscription' => $souscription->getSouscription_souscription(),
            'souscription_autonome' => $souscription->getSouscription_autonome(),
            'souscription_ordre' => $souscription->getSouscription_ordre(),
            'souscription_ancien_membre' => $souscription->getSouscription_ancien_membre(),
            'publier' => $souscription->getPublier(),
            'erreur' => $souscription->getErreur(),
            'erreurdescription' => $souscription->getErreurdescription(),
	    'id_canton' => $souscription->getId_canton(),
            'id_postulat' => $souscription->getId_postulat(),
	    'quittance_invalide' => $souscription->getQuittance_invalide()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSouscription $souscription) {
        $data = array(
            'souscription_nom' => $souscription->getSouscription_nom(),
            'souscription_prenom' => $souscription->getSouscription_prenom(),
            'souscription_mobile' => $souscription->getSouscription_mobile(),
            'souscription_membreasso' => $souscription->getSouscription_membreasso(),
            'souscription_email' => $souscription->getSouscription_email(),
            'souscription_raison' => $souscription->getSouscription_raison(),
            'souscription_numero' => $souscription->getSouscription_numero(),
            'souscription_date_numero' => $souscription->getSouscription_date_numero(),
            'souscription_type' => $souscription->getSouscription_type(),
            'souscription_banque' => $souscription->getSouscription_banque(),
            'souscription_date' => $souscription->getSouscription_date(),
            'souscription_personne' => $souscription->getSouscription_personne(),
            'souscription_montant' => $souscription->getSouscription_montant(),
            'souscription_nombre' => $souscription->getSouscription_nombre(),
            'souscription_programme' => $souscription->getSouscription_programme(),
            'souscription_type_candidat' => $souscription->getSouscription_type_candidat(),
            'souscription_filiere' => $souscription->getSouscription_filiere(),
            'souscription_vignette' => $souscription->getSouscription_vignette(),
            'code_type_acteur' => $souscription->getCode_type_acteur(),
            'code_statut' => $souscription->getCode_statut(),
            'code_activite' => $souscription->getCode_activite(),
            'id_metier' => $souscription->getId_metier(),
            'id_competence' => $souscription->getId_competence(),
            'souscription_ville' => $souscription->getSouscription_ville(),
            'souscription_quartier' => $souscription->getSouscription_quartier(),
            'souscription_login' => $souscription->getSouscription_login(),
            'souscription_passe' => $souscription->getSouscription_passe(),
            'souscription_souscription' => $souscription->getSouscription_souscription(),
            'souscription_autonome' => $souscription->getSouscription_autonome(),
            'souscription_ordre' => $souscription->getSouscription_ordre(),
            'souscription_ancien_membre' => $souscription->getSouscription_ancien_membre(),
            'publier' => $souscription->getPublier(),
            'erreur' => $souscription->getErreur(),
            'erreurdescription' => $souscription->getErreurdescription(),
	    'id_canton' => $souscription->getId_canton(),
            'id_postulat' => $souscription->getId_postulat(),
	    'quittance_invalide' => $souscription->getQuittance_invalide()
        );
        $this->getDbTable()->update($data, array('souscription_id = ?' => $souscription->getSouscription_id()));
    }

    public function delete($souscription_id) {
        $this->getDbTable()->delete(array('souscription_id = ?' => $souscription_id));
    }
	
    public function fetchAllByPublier($publier, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		$select->where("erreur != ? ", 1);
		if($code_agence != "") {
		  $select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	            ->setSouscription_nom($row->souscription_nom)
	            ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
		->setId_canton($row->id_canton)
		->setQuittance_invalide($row->quittance_invalide)
                ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAllByPublierReactivation($publier, $code_agence = "", $pp) {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		$select->where("erreur != ? ", 1);
		if($code_agence != ""){
			$select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->where("souscription_numero IS NULL ");
		$select->where("LENGTH(souscription_ancien_membre) = ? ", $pp);
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                  ->setErreur($row->erreur)
                  ->setErreurdescription($row->erreurdescription)
		  ->setId_canton($row->id_canton)
		  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                  ->setErreur($row->erreur)
                  ->setErreurdescription($row->erreurdescription)
		  ->setId_canton($row->id_canton)
		  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		//$select->where("publier = ? ", 1);
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                  ->setErreur($row->erreur)
                  ->setErreurdescription($row->erreurdescription)
		  ->setId_canton($row->id_canton)
		  ->setQuittance_invalide($row->quittance_invalide)
                ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByMembreasso($souscription_membreasso) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_membreasso = ? ", $souscription_membreasso);
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				  ->setId_canton($row->id_canton)
				  ->setQuittance_invalide($row->quittance_invalide)
->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByAssociation($association) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association);
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				  ->setId_canton($row->id_canton)
				  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }
	




    public function fetchAllBySouscriptionSouscription($souscription_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_souscription = ? ", $souscription_souscription);
		$select->where("publier = ? ", 3);
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				  ->setId_canton($row->id_canton)
				  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllBySouscription($souscription_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_souscription = ? ", $souscription_souscription);
		$select->where("publier = ? ", 3);
		$select->order(array("souscription_id ASC"));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                  ->setErreur($row->erreur)
                  ->setErreurdescription($row->erreurdescription)
		  ->setId_canton($row->id_canton)
		  ->setQuittance_invalide($row->quittance_invalide)
                 ->setId_postulat($row->id_postulat);
			$entries = $entry;
        return $entries;
    }


	
	public function findAllSouscriptionPP($nom,$prenom,$programme,$nombre,$montant) {
	       $select = $this->getDbTable()->select();
		   $select->where("LOWER(REPLACE(souscription_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$nom)));
		   $select->where("LOWER(REPLACE(souscription_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$prenom)));
		   $select->where("souscription_programme like ? ", $programme);
		   $select->where("souscription_nombre = ? ", $nombre);
		   $select->where("souscription_montant >= ? ", $montant);
		   $select->where('souscription_ordre is null');
		   $result = $this->getDbTable()->fetchAll($select);
		   
		   if (count($result) == 0) {
               return false;
           }
		   $entries = array();
           foreach ($result as $row) {
		       $entry = new Application_Model_EuSouscription();
			   $entry->setSouscription_id($row->souscription_id)
	                 ->setSouscription_nom($row->souscription_nom)
	                 ->setSouscription_prenom($row->souscription_prenom)
                     ->setSouscription_mobile($row->souscription_mobile)
                     ->setSouscription_membreasso($row->souscription_membreasso)
                     ->setSouscription_email($row->souscription_email)
                     ->setSouscription_raison($row->souscription_raison)
                     ->setSouscription_numero($row->souscription_numero)
                     ->setSouscription_date_numero($row->souscription_date_numero)
                     ->setSouscription_type($row->souscription_type)
                     ->setSouscription_banque($row->souscription_banque)
                     ->setSouscription_date($row->souscription_date)
                     ->setSouscription_personne($row->souscription_personne)
                     ->setSouscription_montant($row->souscription_montant)
                     ->setSouscription_nombre($row->souscription_nombre)
                     ->setSouscription_programme($row->souscription_programme)
                     ->setSouscription_type_candidat($row->souscription_type_candidat)
                     ->setSouscription_filiere($row->souscription_filiere)
                     ->setSouscription_vignette($row->souscription_vignette)
                     ->setCode_type_acteur($row->code_type_acteur)
                     ->setCode_statut($row->code_statut)
                     ->setCode_activite($row->code_activite)
                     ->setId_metier($row->id_metier)
                     ->setId_competence($row->id_competence)
                     ->setSouscription_ville($row->souscription_ville)
                     ->setSouscription_quartier($row->souscription_quartier)
                     ->setSouscription_login($row->souscription_login)
                     ->setSouscription_passe($row->souscription_passe)
                     ->setSouscription_souscription($row->souscription_souscription)
                     ->setSouscription_autonome($row->souscription_autonome)
                     ->setSouscription_ordre($row->souscription_ordre)
                     ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                     ->setPublier($row->publier)
                     ->setErreur($row->erreur)
                     ->setErreurdescription($row->erreurdescription)
				     ->setId_canton($row->id_canton)
					 ->setQuittance_invalide($row->quittance_invalide)
                     ->setId_postulat($row->id_postulat);
                 $entries[] = $entry;      
		   }
		   return $entries;
	}
	
	
	public function findAllSouscriptionPM($raison,$code_type_acteur,$programme,$nombre,$montant) {
	       $select = $this->getDbTable()->select();
		   $select->where("LOWER(REPLACE(souscription_raison, ' ', '')) = ? ", strtolower(str_replace(" ", "",$raison)));
		   $select->where("code_type_acteur like ? ", $code_type_acteur);
		   $select->where("souscription_programme like ? ", $programme);
		   $select->where("souscription_nombre = ? ", $nombre);
		   $select->where("souscription_montant >= ? ", $montant);
		   $select->where('souscription_ordre is null');
		   $result = $this->getDbTable()->fetchAll($select);
		   
		   if (count($result) == 0)  {
               return false;
           }
		   
		   $entries = array();
           foreach ($result as $row) {
		       $entry = new Application_Model_EuSouscription();
			   $entry->setSouscription_id($row->souscription_id)
	                 ->setSouscription_nom($row->souscription_nom)
	                 ->setSouscription_prenom($row->souscription_prenom)
                     ->setSouscription_mobile($row->souscription_mobile)
                     ->setSouscription_membreasso($row->souscription_membreasso)
                     ->setSouscription_email($row->souscription_email)
                     ->setSouscription_raison($row->souscription_raison)
                     ->setSouscription_numero($row->souscription_numero)
                     ->setSouscription_date_numero($row->souscription_date_numero)
                     ->setSouscription_type($row->souscription_type)
                     ->setSouscription_banque($row->souscription_banque)
                     ->setSouscription_date($row->souscription_date)
                     ->setSouscription_personne($row->souscription_personne)
                     ->setSouscription_montant($row->souscription_montant)
                     ->setSouscription_nombre($row->souscription_nombre)
                     ->setSouscription_programme($row->souscription_programme)
                     ->setSouscription_type_candidat($row->souscription_type_candidat)
                     ->setSouscription_filiere($row->souscription_filiere)
                     ->setSouscription_vignette($row->souscription_vignette)
                     ->setCode_type_acteur($row->code_type_acteur)
                     ->setCode_statut($row->code_statut)
                     ->setCode_activite($row->code_activite)
                     ->setId_metier($row->id_metier)
                     ->setId_competence($row->id_competence)
                     ->setSouscription_ville($row->souscription_ville)
                     ->setSouscription_quartier($row->souscription_quartier)
                     ->setSouscription_login($row->souscription_login)
                     ->setSouscription_passe($row->souscription_passe)
                     ->setSouscription_souscription($row->souscription_souscription)
                     ->setSouscription_autonome($row->souscription_autonome)
                     ->setSouscription_ordre($row->souscription_ordre)
                     ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                     ->setPublier($row->publier)
                     ->setErreur($row->erreur)
                     ->setErreurdescription($row->erreurdescription)
				     ->setId_canton($row->id_canton)
					 ->setQuittance_invalide($row->quittance_invalide)
                     ->setId_postulat($row->id_postulat);
                 $entries[] = $entry;      
		   }
		   return $entries;	   
	}
	
	


    public function findConuterOrdre($souscription_personne = "", $souscription_programme = "", $code_type_acteur = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(souscription_ordre) as COUNT'));
		$select->where("souscription_personne = ? ", $souscription_personne);
		$select->where("souscription_programme = ? ", $souscription_programme);
		if($code_type_acteur != ""){
		$select->where("code_type_acteur = ? ", $code_type_acteur);
		}
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }





    public function fetchAllBySouscriptionTypeCandidat($souscription_type_candidat) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
		$select->where("publier = ? ", 3);
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                  ->setErreur($row->erreur)
                  ->setErreurdescription($row->erreurdescription)
		  ->setId_canton($row->id_canton)
		  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }




    public function fetchAllBySouscriptionTypeCandidatRecherche($souscription_type_candidat, $debut, $fin) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
		$select->where("souscription_nombre BETWEEN ".$debut." AND ".$fin."");
		$select->where("publier = ? ", 3);
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				  ->setId_canton($row->id_canton)
				  ->setQuittance_invalide($row->quittance_invalide)
->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }




    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MONTH(souscription_date) as MOIS, YEAR(souscription_date) as ANNEE'));
		$select->distinct();
		$select->where("publier = ? ", 3);
		$select->order(array("souscription_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['MOIS'] = $row['MOIS'];
		$entry['ANNEE'] = $row['ANNEE'];
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findMoisAnneeAssociation($association) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MONTH(souscription_date) as MOIS, YEAR(souscription_date) as ANNEE'));
		$select->distinct();
		$select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association);
		$select->where("publier = ? ", 3);
		$select->order(array("souscription_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['MOIS'] = $row['MOIS'];
		$entry['ANNEE'] = $row['ANNEE'];
            $entries[] = $entry;
        }
        return $entries;
    }

	
	public function fectchByNumeroBanque($souscription_numero) {
	    $select = $this->getDbTable()->select();
		//$select->where("publier = ? ",0);
		//if($souscription_numero != "") {
		   //$select->where("souscription_numero = ? ", $souscription_numero);
		//}
		//$select->where("souscription_numero IS NOT NULL ");
		$select->where("souscription_id IN (SELECT recubancaire_souscription FROM eu_recubancaire WHERE recubancaire_numero = ?)", $souscription_numero);
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
		if (count($resultSet) == 0) {
           return NULL;
        }
		$row = $resultSet->current();
		$entry = new Application_Model_EuSouscription();
        $entry->setSouscription_id($row->souscription_id)
	          ->setSouscription_nom($row->souscription_nom)
	          ->setSouscription_prenom($row->souscription_prenom)
              ->setSouscription_mobile($row->souscription_mobile)
              ->setSouscription_membreasso($row->souscription_membreasso)
              ->setSouscription_email($row->souscription_email)
              ->setSouscription_raison($row->souscription_raison)
              ->setSouscription_numero($row->souscription_numero)
              ->setSouscription_date_numero($row->souscription_date_numero)
              ->setSouscription_type($row->souscription_type)
              ->setSouscription_banque($row->souscription_banque)
              ->setSouscription_date($row->souscription_date)
              ->setSouscription_personne($row->souscription_personne)
              ->setSouscription_montant($row->souscription_montant)
              ->setSouscription_nombre($row->souscription_nombre)
              ->setSouscription_programme($row->souscription_programme)
              ->setSouscription_type_candidat($row->souscription_type_candidat)
              ->setSouscription_filiere($row->souscription_filiere)
              ->setSouscription_vignette($row->souscription_vignette)
              ->setCode_type_acteur($row->code_type_acteur)
              ->setCode_statut($row->code_statut)
              ->setCode_activite($row->code_activite)
              ->setId_metier($row->id_metier)
              ->setId_competence($row->id_competence)
              ->setSouscription_ville($row->souscription_ville)
              ->setSouscription_quartier($row->souscription_quartier)
              ->setSouscription_login($row->souscription_login)
              ->setSouscription_passe($row->souscription_passe)
              ->setSouscription_souscription($row->souscription_souscription)
              ->setSouscription_autonome($row->souscription_autonome)
              ->setSouscription_ordre($row->souscription_ordre)
              ->setSouscription_ancien_membre($row->souscription_ancien_membre)
              ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
			  ->setId_canton($row->id_canton)
			  ->setQuittance_invalide($row->quittance_invalide)
              ->setId_postulat($row->id_postulat);
			
			return $entry;
	}
	
	


    public function fetchAllByPublierRecherche($publier, $code_agence = "", $souscription_numero = "") {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		if($code_agence != "") {
			$select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		if($souscription_numero != "") {
			$select->where("souscription_numero = ? ", $souscription_numero);
		}
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	              ->setSouscription_nom($row->souscription_nom)
	              ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				  ->setId_canton($row->id_canton)
				  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }


	public function findquittanceinvalide($quittance_invalide) {
	       $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('souscription_id as ID'));
		   if($quittance_invalide != "") {
		     $select->where("quittance_invalide = ? ", $quittance_invalide);
		   }
		   $select->where("souscription_programme = ? ", "CMFH");
           $result = $this->getDbTable()->fetchAll($select);
		   if (count($result) == 0) {
               return NULL;
           } else {
              $row = $result->current();
              return $row['ID'];
		   }
	}
	
	


    public function findIdSouscription($ordre) {
		
		$pos2 = stripos($ordre, "PP");
		if ($pos2 !== false) {
			$souscription_personne = "PP";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("PP", "", $ordre);

			}else{
		$pos1 = strripos($ordre, "EI");
		$pos2 = strripos($ordre, "OE");
		$pos3 = strripos($ordre, "OSE");
		$pos4 = strripos($ordre, "PEI");
		$pos5 = strripos($ordre, "POE");
		$pos6 = strripos($ordre, "POSE");
				if($pos1 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("EI", "", $ordre);
				}else if($pos2 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("OE", "", $ordre);
				}else if($pos3 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("OSE", "", $ordre);
				}else if($pos4 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("PEI", "", $ordre);
				}else if($pos5 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("POE", "", $ordre);
				}else if($pos6 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("POSE", "", $ordre);
					
					}else{
						
			$souscription_personne = "";
			$souscription_programme = "CMFH";
			$souscription_ordre = $ordre;
						
						}
				}
		
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('souscription_id as ID'));
		if($souscription_ordre != ""){
		$select->where("souscription_ordre = ? ", $souscription_ordre);}
		if($souscription_personne != "") {
		$select->where("souscription_personne = ? ", $souscription_personne);}
		//if($souscription_programme != "") {
		$select->where("souscription_programme = ? ", "CMFH");//}
        $result = $this->getDbTable()->fetchAll($select);
		if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['ID'];
		}	
    }




    public function findIdSouscriptionOffreur($ordre) {
		
		$pos2 = stripos($ordre, "PP");
		if ($pos2 !== false) {
			$souscription_personne = "PP";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("PP", "", $ordre);

			}else{
		$pos1 = strripos($ordre, "EI");
		$pos2 = strripos($ordre, "OE");
		$pos3 = strripos($ordre, "OSE");
		$pos4 = strripos($ordre, "PEI");
		$pos5 = strripos($ordre, "POE");
		$pos6 = strripos($ordre, "POSE");
				if($pos1 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("EI", "", $ordre);
				}else if($pos2 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("OE", "", $ordre);
				}else if($pos3 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("OSE", "", $ordre);
				}else if($pos4 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("PEI", "", $ordre);
				}else if($pos5 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("POE", "", $ordre);
				}else if($pos6 == 1){
			$souscription_personne = "PM";
			$souscription_programme = "KACM";
			$souscription_ordre = str_ireplace("POSE", "", $ordre);
					
					}else{
						
			$souscription_personne = "";
			$souscription_programme = "CMFH";
			$souscription_ordre = $ordre;
						
						}
				}
		
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('souscription_id as ID'));
		if($souscription_ordre != ""){
		$select->where("souscription_ordre = ? ", $souscription_ordre);}
		if($souscription_personne != "") {
		$select->where("souscription_personne = ? ", $souscription_personne);}
		//if($souscription_programme != "") {
		$select->where("souscription_programme = ? ", "CMFH");//}
        $result = $this->getDbTable()->fetchAll($select);
		if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['ID'];
		}	
    }





    

	
public function fetchAllByPublierErreur($publier = 0, $code_agence = "") {
        $select = $this->getDbTable()->select();
		//if($publier > 0){
        $select->where("publier = ? ", $publier);
        //}
		$select->where("erreur = ? ", 1);
		if($code_agence != "") {
		  $select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	            ->setSouscription_nom($row->souscription_nom)
	            ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				->setId_canton($row->id_canton)
				->setQuittance_invalide($row->quittance_invalide)
                ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }



	
    public function fetchAllByPublierValidation($publier, $code_agence = "", $utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		  $select->where("souscription_id IN (SELECT validation_quittance_souscription FROM eu_validation_quittance WHERE validation_quittance_utilisateur = '".$utilisateur."')");
		if($code_agence != "") {
		  $select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	            ->setSouscription_nom($row->souscription_nom)
	            ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				->setId_canton($row->id_canton)
				->setQuittance_invalide($row->quittance_invalide)
                ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }



	
    public function fetchAllByPremier() {
        $select = $this->getDbTable()->select();
		$select->where("souscription_id >= ?", 4047);
		$select->where("souscription_id <= ?", 4402);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	            ->setSouscription_nom($row->souscription_nom)
	            ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				->setId_canton($row->id_canton)
				->setQuittance_invalide($row->quittance_invalide)
                ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }




    public function fetchAllByPublierAuto($publier, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		$select->where("erreur != ? ", 1);
		$select->where("souscription_id IN (SELECT validation_quittance_souscription FROM eu_validation_quittance WHERE validation_quittance_utilisateur = 3)");
		if($code_agence != "") {
		  $select->where("souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->where("souscription_numero IS NOT NULL ");
		$select->order(array("souscription_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	            ->setSouscription_nom($row->souscription_nom)
	            ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				->setId_canton($row->id_canton)
				->setQuittance_invalide($row->quittance_invalide)
                 ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }




    public function fetchAllByCodeKACMCMFH() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 3);
		$select->where("(souscription_id NOT IN (SELECT souscription_id FROM eu_code_activation)");
		$select->orwhere("souscription_id NOT IN (SELECT souscription_id FROM eu_depot_vente))");
		$select->where("souscription_ancien_membre IS NULL ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
	            ->setSouscription_nom($row->souscription_nom)
	            ->setSouscription_prenom($row->souscription_prenom)
                ->setSouscription_mobile($row->souscription_mobile)
                ->setSouscription_membreasso($row->souscription_membreasso)
                ->setSouscription_email($row->souscription_email)
                ->setSouscription_raison($row->souscription_raison)
                ->setSouscription_numero($row->souscription_numero)
                ->setSouscription_date_numero($row->souscription_date_numero)
                ->setSouscription_type($row->souscription_type)
                ->setSouscription_banque($row->souscription_banque)
                ->setSouscription_date($row->souscription_date)
                ->setSouscription_personne($row->souscription_personne)
                ->setSouscription_montant($row->souscription_montant)
                ->setSouscription_nombre($row->souscription_nombre)
                ->setSouscription_programme($row->souscription_programme)
                ->setSouscription_type_candidat($row->souscription_type_candidat)
                ->setSouscription_filiere($row->souscription_filiere)
                ->setSouscription_vignette($row->souscription_vignette)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setSouscription_ville($row->souscription_ville)
                ->setSouscription_quartier($row->souscription_quartier)
                ->setSouscription_login($row->souscription_login)
                ->setSouscription_passe($row->souscription_passe)
                ->setSouscription_souscription($row->souscription_souscription)
                ->setSouscription_autonome($row->souscription_autonome)
                ->setSouscription_ordre($row->souscription_ordre)
                ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
				->setId_canton($row->id_canton)
				->setQuittance_invalide($row->quittance_invalide)
                 ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }







    

    public function fetchAllByTableauBord($publier, $souscription_type = "", $souscription_banque = "", $souscription_personne = "", $souscription_nombre = 0, $souscription_programme = "", $souscription_type_candidat = 0, $souscription_ancien_membre = "", $code_type_acteur = "", $code_statut = "", $code_activite = 0, $id_metier = 0, $id_competence = 0, $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "") {
        $select = $this->getDbTable()->select();
        $select->where("publier = ? ", $publier);
        if($souscription_type != "") {
            $select->where("souscription_type = ? ", $souscription_type);
        }
        if($souscription_banque != "") {
            $select->where("souscription_banque = ? ", $souscription_banque);
        }
        if($souscription_personne != "") {
            $select->where("souscription_personne = ? ", $souscription_personne);
        }
        if($souscription_nombre > 0) {
            $select->where("souscription_nombre = ? ", $souscription_nombre);
        }
        if($souscription_programme != "") {
            $select->where("souscription_programme = ? ", $souscription_programme);
        }
        if($souscription_type_candidat > 0) {
            $select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
        }
        if($souscription_ancien_membre == "NULL") {
            $select->where("(souscription_ancien_membre IS NULL");
            $select->orwhere("souscription_ancien_membre = '')");
        }else if($souscription_ancien_membre == "MCNP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
        }else if($souscription_ancien_membre == "MCNP_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "MCNP_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }else if($souscription_ancien_membre == "RED") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
        }else if($souscription_ancien_membre == "RED_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "RED_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }
        if($code_type_acteur != "") {
            $select->where("code_type_acteur = ? ", $code_type_acteur);
        }
        if($code_statut != "") {
            $select->where("code_statut = ? ", $code_statut);
        }
        if($code_activite > 0) {
            $select->where("code_activite = ? ", $code_activite);
        }
        if($id_metier > 0) {
            $select->where("id_metier = ? ", $id_metier);
        }
        if($id_competence > 0) {
            $select->where("id_competence = ? ", $id_competence);
        }
        if($id_canton > 0) {
            $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
        $select->where("souscription_numero IS NOT NULL ");
        $select->order(array("souscription_id ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
                  ->setSouscription_nom($row->souscription_nom)
                  ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
                  ->setId_canton($row->id_canton)
                  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }







    public function fetchAllByTableauBordTotal($publier, $souscription_type = "", $souscription_banque = "", $souscription_personne = "", $souscription_nombre = 0, $souscription_programme = "", $souscription_type_candidat = 0, $souscription_ancien_membre = "", $code_type_acteur = "", $code_statut = "", $code_activite = 0, $id_metier = 0, $id_competence = 0, $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(souscription_montant) as COUNT'));
        $select->where("publier = ? ", $publier);
        if($souscription_type != "") {
            $select->where("souscription_type = ? ", $souscription_type);
            $select->where("souscription_type != ? ", "BAn");
        }
        if($souscription_banque != "") {
            $select->where("souscription_banque = ? ", $souscription_banque);
        }
        if($souscription_personne != "") {
            $select->where("souscription_personne = ? ", $souscription_personne);
        }
        if($souscription_nombre > 0) {
            $select->where("souscription_nombre = ? ", $souscription_nombre);
        }
        if($souscription_programme != "") {
            $select->where("souscription_programme = ? ", $souscription_programme);
        }
        if($souscription_type_candidat > 0) {
            $select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
        }
        if($souscription_ancien_membre == "NULL") {
            $select->where("(souscription_ancien_membre IS NULL");
            $select->orwhere("souscription_ancien_membre = '')");
        }else if($souscription_ancien_membre == "MCNP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
        }else if($souscription_ancien_membre == "MCNP_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "MCNP_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }else if($souscription_ancien_membre == "RED") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
        }else if($souscription_ancien_membre == "RED_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "RED_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }
        if($code_type_acteur != "") {
            $select->where("code_type_acteur = ? ", $code_type_acteur);
        }
        if($code_statut != "") {
            $select->where("code_statut = ? ", $code_statut);
        }
        if($code_activite > 0) {
            $select->where("code_activite = ? ", $code_activite);
        }
        if($id_metier > 0) {
            $select->where("id_metier = ? ", $id_metier);
        }
        if($id_competence > 0) {
            $select->where("id_competence = ? ", $id_competence);
        }
        if($id_canton > 0) {
            $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
        $select->where("souscription_numero IS NOT NULL ");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }


public function fetchAllByTableauBordNombre($publier, $souscription_type = "", $souscription_banque = "", $souscription_personne = "", $souscription_nombre = 0, $souscription_programme = "", $souscription_type_candidat = 0, $souscription_ancien_membre = "", $code_type_acteur = "", $code_statut = "", $code_activite = 0, $id_metier = 0, $id_competence = 0, $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(souscription_id) as COUNT'));
        $select->where("publier = ? ", $publier);
        if($souscription_type != "") {
            $select->where("souscription_type = ? ", $souscription_type);
            $select->where("souscription_type != ? ", "BAn");
        }
        if($souscription_banque != "") {
            $select->where("souscription_banque = ? ", $souscription_banque);
        }
        if($souscription_personne != "") {
            $select->where("souscription_personne = ? ", $souscription_personne);
        }
        if($souscription_nombre > 0) {
            $select->where("souscription_nombre = ? ", $souscription_nombre);
        }
        if($souscription_programme != "") {
            $select->where("souscription_programme = ? ", $souscription_programme);
        }
        if($souscription_type_candidat > 0) {
            $select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
        }
        if($souscription_ancien_membre == "NULL") {
            $select->where("(souscription_ancien_membre IS NULL");
            $select->orwhere("souscription_ancien_membre = '')");
        }else if($souscription_ancien_membre == "MCNP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
        }else if($souscription_ancien_membre == "MCNP_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "MCNP_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }else if($souscription_ancien_membre == "RED") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
        }else if($souscription_ancien_membre == "RED_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "RED_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }
        if($code_type_acteur != "") {
            $select->where("code_type_acteur = ? ", $code_type_acteur);
        }
        if($code_statut != "") {
            $select->where("code_statut = ? ", $code_statut);
        }
        if($code_activite > 0) {
            $select->where("code_activite = ? ", $code_activite);
        }
        if($id_metier > 0) {
            $select->where("id_metier = ? ", $id_metier);
        }
        if($id_competence > 0) {
            $select->where("id_competence = ? ", $id_competence);
        }
        if($id_canton > 0) {
            $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
        $select->where("souscription_numero IS NOT NULL ");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }




    public function fetchAllByTableauBordReactivation($publier, $souscription_type = "", $souscription_banque = "", $souscription_personne = "", $souscription_nombre = 0, $souscription_programme = "", $souscription_type_candidat = 0, $souscription_ancien_membre = "", $code_type_acteur = "", $code_statut = "", $code_activite = 0, $id_metier = 0, $id_competence = 0, $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "") {
        $select = $this->getDbTable()->select();
        $select->where("publier = ? ", $publier);
        if($souscription_type != "") {
            $select->where("souscription_type = ? ", $souscription_type);
            $select->where("souscription_type != ? ", "BAn");
        }
        if($souscription_banque != "") {
            $select->where("souscription_banque = ? ", $souscription_banque);
        }
        if($souscription_personne != "") {
            $select->where("souscription_personne = ? ", $souscription_personne);
        }
        if($souscription_nombre > 0) {
            $select->where("souscription_nombre = ? ", $souscription_nombre);
        }
        if($souscription_programme != "") {
            $select->where("souscription_programme = ? ", $souscription_programme);
        }
        if($souscription_type_candidat > 0) {
            $select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
        }
        if($souscription_ancien_membre == "NULL") {
            $select->where("(souscription_ancien_membre IS NULL");
            $select->orwhere("souscription_ancien_membre = '')");
        }else if($souscription_ancien_membre == "MCNP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
        }else if($souscription_ancien_membre == "MCNP_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "MCNP_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }else if($souscription_ancien_membre == "RED") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
        }else if($souscription_ancien_membre == "RED_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "RED_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }
        if($code_type_acteur != "") {
            $select->where("code_type_acteur = ? ", $code_type_acteur);
        }
        if($code_statut != "") {
            $select->where("code_statut = ? ", $code_statut);
        }
        if($code_activite > 0) {
            $select->where("code_activite = ? ", $code_activite);
        }
        if($id_metier > 0) {
            $select->where("id_metier = ? ", $id_metier);
        }
        if($id_competence > 0) {
            $select->where("id_competence = ? ", $id_competence);
        }
        if($id_canton > 0) {
            $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
        $select->where("souscription_numero IS NULL ");
        $select->where("souscription_ancien_membre IS NOT NULL ");
        $select->order(array("souscription_id ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSouscription();
            $entry->setSouscription_id($row->souscription_id)
                  ->setSouscription_nom($row->souscription_nom)
                  ->setSouscription_prenom($row->souscription_prenom)
                  ->setSouscription_mobile($row->souscription_mobile)
                  ->setSouscription_membreasso($row->souscription_membreasso)
                  ->setSouscription_email($row->souscription_email)
                  ->setSouscription_raison($row->souscription_raison)
                  ->setSouscription_numero($row->souscription_numero)
                  ->setSouscription_date_numero($row->souscription_date_numero)
                  ->setSouscription_type($row->souscription_type)
                  ->setSouscription_banque($row->souscription_banque)
                  ->setSouscription_date($row->souscription_date)
                  ->setSouscription_personne($row->souscription_personne)
                  ->setSouscription_montant($row->souscription_montant)
                  ->setSouscription_nombre($row->souscription_nombre)
                  ->setSouscription_programme($row->souscription_programme)
                  ->setSouscription_type_candidat($row->souscription_type_candidat)
                  ->setSouscription_filiere($row->souscription_filiere)
                  ->setSouscription_vignette($row->souscription_vignette)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut($row->code_statut)
                  ->setCode_activite($row->code_activite)
                  ->setId_metier($row->id_metier)
                  ->setId_competence($row->id_competence)
                  ->setSouscription_ville($row->souscription_ville)
                  ->setSouscription_quartier($row->souscription_quartier)
                  ->setSouscription_login($row->souscription_login)
                  ->setSouscription_passe($row->souscription_passe)
                  ->setSouscription_souscription($row->souscription_souscription)
                  ->setSouscription_autonome($row->souscription_autonome)
                  ->setSouscription_ordre($row->souscription_ordre)
                  ->setSouscription_ancien_membre($row->souscription_ancien_membre)
                  ->setPublier($row->publier)
                ->setErreur($row->erreur)
                ->setErreurdescription($row->erreurdescription)
                  ->setId_canton($row->id_canton)
                  ->setQuittance_invalide($row->quittance_invalide)
                  ->setId_postulat($row->id_postulat);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByTableauBordReactivationTotal($publier, $souscription_type = "", $souscription_banque = "", $souscription_personne = "", $souscription_nombre = 0, $souscription_programme = "", $souscription_type_candidat = 0, $souscription_ancien_membre = "", $code_type_acteur = "", $code_statut = "", $code_activite = 0, $id_metier = 0, $id_competence = 0, $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(souscription_montant) as COUNT'));
        $select->where("publier = ? ", $publier);
        if($souscription_type != "") {
            $select->where("souscription_type = ? ", $souscription_type);
            $select->where("souscription_type != ? ", "BAn");
        }
        if($souscription_banque != "") {
            $select->where("souscription_banque = ? ", $souscription_banque);
        }
        if($souscription_personne != "") {
            $select->where("souscription_personne = ? ", $souscription_personne);
        }
        if($souscription_nombre > 0) {
            $select->where("souscription_nombre = ? ", $souscription_nombre);
        }
        if($souscription_programme != "") {
            $select->where("souscription_programme = ? ", $souscription_programme);
        }
        if($souscription_type_candidat > 0) {
            $select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
        }
        if($souscription_ancien_membre == "NULL") {
            $select->where("(souscription_ancien_membre IS NULL");
            $select->orwhere("souscription_ancien_membre = '')");
        }else if($souscription_ancien_membre == "MCNP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
        }else if($souscription_ancien_membre == "MCNP_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "MCNP_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }else if($souscription_ancien_membre == "RED") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
        }else if($souscription_ancien_membre == "RED_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "RED_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }
        if($code_type_acteur != "") {
            $select->where("code_type_acteur = ? ", $code_type_acteur);
        }
        if($code_statut != "") {
            $select->where("code_statut = ? ", $code_statut);
        }
        if($code_activite > 0) {
            $select->where("code_activite = ? ", $code_activite);
        }
        if($id_metier > 0) {
            $select->where("id_metier = ? ", $id_metier);
        }
        if($id_competence > 0) {
            $select->where("id_competence = ? ", $id_competence);
        }
        if($id_canton > 0) {
            $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
        $select->where("souscription_numero IS NULL ");
        $select->where("souscription_ancien_membre IS NOT NULL ");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }





    public function fetchAllByTableauBordNombreTotal($publier = "", $souscription_type = "", $souscription_banque = "", $souscription_personne = "", $souscription_nombre = 0, $souscription_programme = "", $souscription_type_candidat = 0, $souscription_ancien_membre = "", $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(souscription_id) as COUNT'));
        
        if($publier == "") {
        $select->where("publier >= ? ", 0);
        } else if($publier > -1) {
        $select->where("publier = ? ", $publier);
        }
        if($souscription_type != "") {
            $select->where("souscription_type = ? ", $souscription_type);
            $select->where("souscription_type != ? ", "BAn");
        }
        if($souscription_banque != "") {
            $select->where("souscription_banque = ? ", $souscription_banque);
        }
        if($souscription_personne != "") {
            $select->where("souscription_personne = ? ", $souscription_personne);
        }
        if($souscription_nombre > 0) {
            $select->where("souscription_nombre = ? ", $souscription_nombre);
        }
        if($souscription_programme != "") {
            $select->where("souscription_programme = ? ", $souscription_programme);
        }
        if($souscription_type_candidat > 0) {
            $select->where("souscription_type_candidat = ? ", $souscription_type_candidat);
        }
        if($souscription_ancien_membre == "NULL") {
            $select->where("(souscription_ancien_membre IS NULL");
            $select->orwhere("souscription_ancien_membre = '')");
        }else if($souscription_ancien_membre == "MCNP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
        }else if($souscription_ancien_membre == "MCNP_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "MCNP_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 20");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }else if($souscription_ancien_membre == "RED") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
        }else if($souscription_ancien_membre == "RED_PP") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'P'");
        }else if($souscription_ancien_membre == "RED_PM") {
            $select->where("LENGTH(souscription_ancien_membre) = 13");
            $select->where("SUBSTRING(souscription_ancien_membre, -1) = 'M'");
        }
        if($id_canton > 0) {
            $select->where("id_canton = ? ", $id_canton);
        }
        if($id_prefecture > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
            $select->where("id_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }






}


?>
