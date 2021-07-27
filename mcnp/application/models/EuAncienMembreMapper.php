<?php

class Application_Model_EuAncienMembreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienMembre');
        }
        return $this->_dbTable;
    }

    public function find($ancien_code_membre, Application_Model_EuAncienMembre $ancienmembre) {
           $result = $this->getDbTable()->find($ancien_code_membre);
           if (0 == count($result)) {
              return false;
           }
           $row = $result->current();
           $ancienmembre->setAncien_code_membre($row->ancien_code_membre)
                     ->setCode_gac_filiere($row->code_gac_filiere)
                     ->setCode_type_acteur($row->code_type_acteur)
                     ->setType_membre($row->type_membre)
                     ->setRaison_sociale($row->raison_sociale)
                     ->setNom_membre($row->nom_membre)
                     ->setPrenom_membre($row->prenom_membre)
                     ->setSexe_membre($row->sexe_membre)
                     ->setId_pays($row->id_pays)
                     ->setPere_membre($row->pere_membre)
					 ->setMere_membre($row->mere_membre)
					 ->setSitfam_membre($row->sitfam_membre)
					 ->setNbr_enf_membre($row->nbr_enf_membre)
					 ->setId_religion_membre($row->id_religion_membre)
					 ->setProfession_membre($row->profession_membre)
					 ->setFormation($row->formation)
					 ->setQuartier_membre($row->quartier_membre)
					 ->setVille_membre($row->ville_membre)
					 ->setBp_membre($row->bp_membre)
					 ->setTel_membre($row->tel_membre)
					 ->setPortable_membre($row->portable_membre)
					 ->setEmail_membre($row->email_membre)
					 ->setSite_web($row->site_web)
					 ->setPhoto_membre($row->photo_membre)
					 ->setDomaine_activite($row->domaine_activite)
					 ->setNum_registre_membre($row->num_registre_membre)
					 ->setCode_agence($row->code_agence)
					 ->setEmpreinte_membre($row->empreinte_membre)
					 ->setDate_identification($row->date_identification)
					 ->setHeure_identification($row->heure_identification)
					 ->setId_utilisateur($row->id_utilisateur)
					 ->setAuto_enroler($row->auto_enroler)
					 ->setEtat_contrat($row->etat_contrat)
					 ->setCode_membre($row->code_membre);
					 
		    return true;
		
		
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienMembre();
            $entry->setAncien_code_membre($row->ancien_code_membre)
                  ->setCode_gac_filiere($row->code_gac_filiere)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setType_membre($row->type_membre)
                  ->setRaison_sociale($row->raison_sociale)
                  ->setNom_membre($row->nom_membre)
                  ->setPrenom_membre($row->prenom_membre)
                  ->setSexe_membre($row->sexe_membre)
                  ->setId_pays($row->id_pays)
                  ->setPere_membre($row->pere_membre)
			      ->setMere_membre($row->mere_membre)
				  ->setSitfam_membre($row->sitfam_membre)
				  ->setNbr_enf_membre($row->nbr_enf_membre)
				  ->setId_religion_membre($row->id_religion_membre)
				  ->setProfession_membre($row->profession_membre)
				  ->setFormation($row->formation)
				  ->setQuartier_membre($row->quartier_membre)
				  ->setVille_membre($row->ville_membre)
				  ->setBp_membre($row->bp_membre)
				  ->setTel_membre($row->tel_membre)
				  ->setPortable_membre($row->portable_membre)
				  ->setEmail_membre($row->email_membre)
				  ->setSite_web($row->site_web)
				  ->setPhoto_membre($row->photo_membre)
				  ->setDomaine_activite($row->domaine_activite)
				  ->setNum_registre_membre($row->num_registre_membre)
				  ->setCode_agence($row->code_agence)
				  ->setEmpreinte_membre($row->empreinte_membre)
				  ->setDate_identification($row->date_identification)
				  ->setHeure_identification($row->heure_identification)
				  ->setId_utilisateur($row->id_utilisateur)
				  ->setAuto_enroler($row->auto_enroler)
				  ->setEtat_contrat($row->etat_contrat)
				  ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuAncienMembre $ancienmembre) {
        $data = array(
            'ancien_code_membre' => $ancienmembre->getAncien_code_membre(),
            'code_gac_filiere' => $ancienmembre->getCode_gac_filiere(),
            'code_type_acteur' => $ancienmembre->getCode_type_acteur(),
            'type_membre' => $ancienmembre->getType_membre(),
            'raison_sociale' => $ancienmembre->getRaison_sociale(),
            'nom_membre' => $ancienmembre->getNom_membre(),
            'prenom_membre' => $ancienmembre->getPrenom_membre(),
            'sexe_membre' => $ancienmembre->getSexe_membre(),
            'id_pays' => $ancienmembre->getId_pays(),
            'pere_membre' => $ancienmembre->getPere_membre(),
			'mere_membre' => $ancienmembre->getMere_membre(),
			'sitfam_membre' => $ancienmembre->getSitfam_membre(),
			'nbr_enf_membre' => $ancienmembre->getNbr_enf_membre(),
			'id_religion_membre' => $ancienmembre->getId_religion_membre(),
			'profession_membre' => $ancienmembre->getProfession_membre(),
			'formation' => $ancienmembre->getFormation(),
			'quartier_membre' => $ancienmembre->getQuartier_membre(),
			'ville_membre' => $ancienmembre->getVille_membre(),
			'bp_membre' => $ancienmembre->getBp_membre(),
			'tel_membre' => $ancienmembre->getTel_membre(),
			'portable_membre' => $ancienmembre->getPortable_membre(),
			'email_membre' => $ancienmembre->getEmail_membre(),
			'site_web' => $ancienmembre->getSite_web(),
			'photo_membre' => $ancienmembre->getPhoto_membre(),
			'domaine_activite' => $ancienmembre->getDomaine_activite(),
			'num_registre_membre' => $ancienmembre->getNum_registre_membre(),
			'code_agence' => $ancienmembre->getCode_agence(),
			'empreinte_membre' => $ancienmembre->getEmpreinte_membre(),
			'date_identification' => $ancienmembre->getDate_identification(),
			'heure_identification' => $ancienmembre->getHeure_identification(),
			'id_utilisateur' => $ancienmembre->getId_utilisateur(),
			'auto_enroler' => $ancienmembre->getAuto_enroler(),
			'etat_contrat' => $ancienmembre->getEtat_contrat(),
			'code_membre' => $ancienmembre->getCode_membre()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienMembre $ancienmembre) {
        $data = array(
            'ancien_code_membre' => $ancienmembre->getAncien_code_membre(),
            'code_gac_filiere' => $ancienmembre->getCode_gac_filiere(),
            'code_type_acteur' => $ancienmembre->getCode_type_acteur(),
            'type_membre' => $ancienmembre->getType_membre(),
            'raison_sociale' => $ancienmembre->getRaison_sociale(),
            'nom_membre' => $ancienmembre->getNom_membre(),
            'prenom_membre' => $ancienmembre->getPrenom_membre(),
            'sexe_membre' => $ancienmembre->getSexe_membre(),
            'id_pays' => $ancienmembre->getId_pays(),
            'pere_membre' => $ancienmembre->getPere_membre(),
			'mere_membre' => $ancienmembre->getMere_membre(),
			'sitfam_membre' => $ancienmembre->getSitfam_membre(),
			'nbr_enf_membre' => $ancienmembre->getNbr_enf_membre(),
			'id_religion_membre' => $ancienmembre->getId_religion_membre(),
			'profession_membre' => $ancienmembre->getProfession_membre(),
			'formation' => $ancienmembre->getFormation(),
			'quartier_membre' => $ancienmembre->getQuartier_membre(),
			'ville_membre' => $ancienmembre->getVille_membre(),
			'bp_membre' => $ancienmembre->getBp_membre(),
			'tel_membre' => $ancienmembre->getTel_membre(),
			'portable_membre' => $ancienmembre->getPortable_membre(),
			'email_membre' => $ancienmembre->getEmail_membre(),
			'site_web' => $ancienmembre->getSite_web(),
			'photo_membre' => $ancienmembre->getPhoto_membre(),
			'domaine_activite' => $ancienmembre->getDomaine_activite(),
			'num_registre_membre' => $ancienmembre->getNum_registre_membre(),
			'code_agence' => $ancienmembre->getCode_agence(),
			'empreinte_membre' => $ancienmembre->getEmpreinte_membre(),
			'date_identification' => $ancienmembre->getDate_identification(),
			'heure_identification' => $ancienmembre->getHeure_identification(),
			'id_utilisateur' => $ancienmembre->getId_utilisateur(),
			'auto_enroler' => $ancienmembre->getAuto_enroler(),
			'etat_contrat' => $ancienmembre->getEtat_contrat(),
			'code_membre' => $ancienmembre->getCode_membre()
        );
        $this->getDbTable()->update($data, array('ancien_code_membre = ?' => $ancienmembre->getAncien_code_membre()));
    }

    public function fetchByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre LIKE ?',$code_membre);
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) == 0) {
            return NULL;
        }
        $row = $results->current();
        $entry = new Application_Model_EuAncienMembre();
        $entry->setAncien_code_membre($row->ancien_code_membre)
              ->setCode_gac_filiere($row->code_gac_filiere)
              ->setCode_type_acteur($row->code_type_acteur)
              ->setType_membre($row->type_membre)
              ->setRaison_sociale($row->raison_sociale)
              ->setNom_membre($row->nom_membre)
              ->setPrenom_membre($row->prenom_membre)
              ->setSexe_membre($row->sexe_membre)
              ->setId_pays($row->id_pays)
              ->setPere_membre($row->pere_membre)
			  ->setMere_membre($row->mere_membre)
		      ->setSitfam_membre($row->sitfam_membre)
		      ->setNbr_enf_membre($row->nbr_enf_membre)
			  ->setId_religion_membre($row->id_religion_membre)
			  ->setProfession_membre($row->profession_membre)
			  ->setFormation($row->formation)
			  ->setQuartier_membre($row->quartier_membre)
			  ->setVille_membre($row->ville_membre)
			  ->setBp_membre($row->bp_membre)
			  ->setTel_membre($row->tel_membre)
			  ->setPortable_membre($row->portable_membre)
			  ->setEmail_membre($row->email_membre)
			  ->setSite_web($row->site_web)
			  ->setPhoto_membre($row->photo_membre)
			  ->setDomaine_activite($row->domaine_activite)
			  ->setNum_registre_membre($row->num_registre_membre)
			  ->setCode_agence($row->code_agence)
			  ->setEmpreinte_membre($row->empreinte_membre)
			  ->setDate_identification($row->date_identification)
			  ->setHeure_identification($row->heure_identification)
			  ->setId_utilisateur($row->id_utilisateur)
			  ->setAuto_enroler($row->auto_enroler)
			  ->setEtat_contrat($row->etat_contrat)
			  ->setCode_membre($row->code_membre);
         return $entry;
    }
     


    public function delete($ancien_code_membre) {
           $this->getDbTable()->delete(array('ancien_code_membre = ?' => $ancien_code_membre));
    }

}
