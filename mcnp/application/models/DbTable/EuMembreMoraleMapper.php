<?php

class Application_Model_EuMembreMoraleMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMembreMorale');
        }
        return $this->_dbTable;
    }

    public function find($code_membre_morale, Application_Model_EuMembreMorale $membremorale) {
        $result = $this->getDbTable()->find($code_membre_morale);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $membremorale->setCode_membre_morale($row->code_membre_morale)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur(stripslashes(($row->code_type_acteur)))
                ->setCode_statut(stripslashes(($row->code_statut)))
                ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                ->setId_pays($row->id_pays)
                ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                ->setVille_membre(stripslashes(($row->ville_membre)))
                ->setTel_membre($row->tel_membre)
                ->setPortable_membre($row->portable_membre)
                ->setEmail_membre(stripslashes(($row->email_membre)))
                ->setBp_membre($row->bp_membre)
                ->setSite_web(stripslashes(($row->site_web)))
                ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                ->setDate_identification($row->date_identification)
                ->setHeure_identification($row->heure_identification)
                ->setCode_agence($row->code_agence)
                ->setId_utilisateur($row->id_utilisateur)
                ->setAuto_enroler($row->auto_enroler)
                ->setEtat_membre($row->etat_membre)
                ->setId_canton($row->id_canton)
				->setType_fournisseur($row->type_fournisseur)
				;
        return true;
    }

    public function resultfindByCodeMembreMorale($code_membre_morale, Application_Model_EuMembreMorale $membremorale){
        $result = $this->getDbTable()->find($code_membre_morale);
        if (0 == count($result)) {
            return false;
        }
        $membremorale = array();
        foreach ($result as $row) {
            $membremorale = new Application_Model_EuMembreMorale();
            $membremorale->setCode_membre_morale($row->code_membre_morale)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur(stripslashes(($row->code_type_acteur)))
                ->setCode_statut(stripslashes(($row->code_statut)))
                ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                ->setId_pays($row->id_pays)
                ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                ->setVille_membre(stripslashes(($row->ville_membre)))
                ->setTel_membre($row->tel_membre)
                ->setPortable_membre($row->portable_membre)
                ->setEmail_membre(stripslashes(($row->email_membre)))
                ->setBp_membre($row->bp_membre)
                ->setSite_web(stripslashes(($row->site_web)))
                ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                ->setDate_identification($row->date_identification)
                ->setHeure_identification($row->heure_identification)
                ->setCode_agence($row->code_agence)
                ->setId_utilisateur($row->id_utilisateur)
                ->setAuto_enroler($row->auto_enroler)
                ->setEtat_membre($row->etat_membre);
        return $membremorale;
        }

    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
					->setType_fournisseur($row->type_fournisseur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getLastCodeMembreByAgence($code_agence) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_membre_morale) as code'));
        $select->where('code_agence LIKE ?', $code_agence);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function save(Application_Model_EuMembreMorale $membremorale) {
        $data = array(
            'code_membre_morale' => $membremorale->getCode_membre_morale(),
            'id_filiere' => $membremorale->getId_filiere(),
            'code_type_acteur' => $membremorale->getCode_type_acteur(),
            'code_statut' => $membremorale->getCode_statut(),
            'raison_sociale' => strtoupper($membremorale->getRaison_sociale()),
            'id_pays' => $membremorale->getId_pays(),
            'quartier_membre' => strtoupper($membremorale->getQuartier_membre()),
            'ville_membre' => strtoupper($membremorale->getVille_membre()),
            'tel_membre' => $membremorale->getTel_membre(),
            'portable_membre' => $membremorale->getPortable_membre(),
            'email_membre' => $membremorale->getEmail_membre(),
            'bp_membre' => $membremorale->getBp_membre(),
            'site_web' => $membremorale->getSite_web(),
            'domaine_activite' => strtoupper($membremorale->getDomaine_activite()),
            'num_registre_membre' => $membremorale->getNum_registre_membre(),
            'date_identification' => $membremorale->getDate_identification(),
            'heure_identification' => $membremorale->getHeure_identification(),
            'code_agence' => $membremorale->getCode_agence(),
            'id_utilisateur' => $membremorale->getId_utilisateur(),
            'auto_enroler' => $membremorale->getAuto_enroler(),
            'codesecret' => $membremorale->getCodesecret(),
            'etat_membre' => $membremorale->getEtat_membre(),
            'id_canton' => $membremorale->getId_canton(),
			'type_fournisseur' => $membremorale->getType_fournisseur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembreMorale $membremorale) {
        $data = array(
            'code_membre_morale' => $membremorale->getCode_membre_morale(),
			'id_filiere' => $membremorale->getId_filiere(),
            'code_type_acteur' => $membremorale->getCode_type_acteur(),
            'code_statut' => $membremorale->getCode_statut(),
            'raison_sociale' => strtoupper($membremorale->getRaison_sociale()),
            'id_pays' => $membremorale->getId_pays(),
            'quartier_membre' => strtoupper($membremorale->getQuartier_membre()),
            'ville_membre' => strtoupper($membremorale->getVille_membre()),
            'tel_membre' => $membremorale->getTel_membre(),
            'portable_membre' => $membremorale->getPortable_membre(),
            'email_membre' => $membremorale->getEmail_membre(),
            'bp_membre' => $membremorale->getBp_membre(),
            'site_web' => $membremorale->getSite_web(),
            'domaine_activite' => strtoupper($membremorale->getDomaine_activite()),
            'num_registre_membre' => $membremorale->getNum_registre_membre(),
            'date_identification' => $membremorale->getDate_identification(),
            'heure_identification' => $membremorale->getHeure_identification(),
            'code_agence' => $membremorale->getCode_agence(),
            'id_utilisateur' => $membremorale->getId_utilisateur(),
            'codesecret' => $membremorale->getCodesecret(),
			'etat_membre' => $membremorale->getEtat_membre(),
            'id_canton' => $membremorale->getId_canton(),
			'type_fournisseur' => $membremorale->getType_fournisseur()
        );
        $this->getDbTable()->update($data, array('code_membre_morale = ?' => $membremorale->getCode_membre_morale()));
    }

    public function delete($code_membre_morale) {
        $this->getDbTable()->delete(array('code_membre_morale = ?' => $code_membre_morale));
    }

	
    /////////////////////////////////////////////////////////////
    public function fetchAllActeur($id_filiere) {
        $acteur = new Application_Model_DbTable_EuMembreMorale();
        $select = $acteur->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_acteur', 'eu_acteur.code_membre = eu_membre_morale.code_membre_morale')
                ->where('eu_membre_morale.id_filiere = ? ', $id_filiere);
        $select->order(array('eu_membre_morale.raison_sociale ASC'));
        $resultSet = $acteur->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                  ->setId_Filiere($row->id_filiere)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut(stripslashes(($row->code_statut)))
                  ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                  ->setId_pays($row->id_pays)
                  ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                  ->setVille_membre(stripslashes(($row->ville_membre)))
                  ->setTel_membre($row->tel_membre)
                  ->setPortable_membre($row->portable_membre)
                  ->setEmail_membre(stripslashes(($row->email_membre)))
                  ->setBp_membre($row->bp_membre)
                  ->setSite_web(stripslashes(($row->site_web)))
                  ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                  ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                  ->setDate_identification($row->date_identification)
                  ->setHeure_identification($row->heure_identification)
                  ->setCode_agence($row->code_agence)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setAuto_enroler($row->auto_enroler)
                  ->setEtat_membre($row->etat_membre)
                  ->setId_canton($row->id_canton)
				  ->setType_fournisseur($row->type_fournisseur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllrecherche($id_filiere, $quartier, $ville) {
        $acteur = new Application_Model_DbTable_EuMembreMorale();
        $select = $acteur->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_filiere', 'eu_filiere.id_filiere = eu_membre_morale.id_filiere');
        if (isset($id_filiere) && $id_filiere != "") {
            $select->where('eu_membre_morale.id_filiere = ? ', $id_filiere);
        }
        if (isset($quartier) && $quartier != "") {
            $select->where('eu_membre_morale.quartier_membre LIKE ? ', '%' . $quartier . '%');
        }
        if (isset($ville) && $ville != "") {
            $select->where('eu_membre_morale.ville_membre LIKE ? ', '%' . $ville . '%');
        }
        $select->order(array('eu_filiere.nom_filiere ASC', 'eu_membre_morale.raison_sociale ASC'));
        $resultSet = $acteur->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_Filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
					->setType_fournisseur($row->type_fournisseur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllPbfDsms() {
        $acteur = new Application_Model_DbTable_EuMembreMorale();
        $select = $acteur->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_acteur', 'eu_acteur.code_membre = eu_membre_morale.code_membre_morale');
        $select->where('eu_acteur.type_acteur = ? ', 'PBF');
        $select->orwhere('eu_acteur.type_acteur = ? ', 'DSMS');
        $select->order(array('eu_membre_morale.raison_sociale ASC'));
        $resultSet = $acteur->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_Filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
					->setType_fournisseur($row->type_fournisseur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllDivisionSource($filiere) {//
        $acteur = new Application_Model_DbTable_EuMembreMorale();
        $select = $acteur->select();
		if($filiere > 0){
        $select->where('id_filiere = ? ', $filiere);
		}
        $select->order(array('raison_sociale ASC'));
        $resultSet = $acteur->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                  ->setId_Filiere($row->id_filiere)
                  ->setCode_type_acteur($row->code_type_acteur)
                  ->setCode_statut(stripslashes(($row->code_statut)))
                  ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                  ->setId_pays($row->id_pays)
                  ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                  ->setVille_membre(stripslashes(($row->ville_membre)))
                  ->setTel_membre($row->tel_membre)
                  ->setPortable_membre($row->portable_membre)
                  ->setEmail_membre(stripslashes(($row->email_membre)))
                  ->setBp_membre($row->bp_membre)
                  ->setSite_web(stripslashes(($row->site_web)))
                  ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                  ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                  ->setDate_identification($row->date_identification)
                  ->setHeure_identification($row->heure_identification)
                  ->setCode_agence($row->code_agence)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setAuto_enroler($row->auto_enroler)
                  ->setEtat_membre($row->etat_membre)
                  ->setId_canton($row->id_canton)
			      ->setType_fournisseur($row->type_fournisseur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	


    public function fetchAllByActivationMembreasso($membreasso = 0) {
        $select = $this->getDbTable()->select();
		if($membreasso > 0){
        $select->where('code_membre_morale IN (SELECT code_membre FROM eu_code_activation WHERE souscription_id IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso = ?))', $membreasso);
        $select->orwhere('code_membre_morale IN (SELECT code_membre FROM eu_membretierscode WHERE membretierscode_souscription IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso = ?))', $membreasso);
			}
        $select->order(array('code_membre_morale ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_Filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
					->setType_fournisseur($row->type_fournisseur)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


	

    public function fetchAllByActivationAssociation($association = 0) {
        $select = $this->getDbTable()->select();
		if($association > 0) {
           $select->where('code_membre_morale IN (SELECT code_membre FROM eu_code_activation WHERE souscription_id IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)))', $association);
           $select->orwhere('code_membre_morale IN (SELECT code_membre FROM eu_membretierscode WHERE membretierscode_souscription IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)))', $association);
		}
        $select->order(array('code_membre_morale ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_Filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
					->setType_fournisseur($row->type_fournisseur);
            $entries[] = $entry;
        }
        return $entries;
    }







    
    
    public function fetchAllByTableauBord($code_membre_morale = "", $raison_sociale = "", $id_filiere = "", $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $code_type_acteur = "", $code_statut = "", $quartier_membre = "", $ville_membre = "", $date_identification1 = "", $date_identification2 = "", $code_agence = "", $domaine_activite = 0, $auto_enroler = "", $etat_membre = "") {
        $select = $this->getDbTable()->select();
        
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
            
        if($code_membre_morale != ""){
        $select->where("code_membre_morale LIKE '%".$code_membre_morale."%' ");  
        }
        if($raison_sociale != ""){
        $select->where("raison_sociale LIKE '%".$raison_sociale."%' ");  
        }
        if($id_filiere != ""){
        $select->where("id_filiere = ".$id_filiere." ");  
        }
        if($code_type_acteur != ""){
        $select->where("code_type_acteur = '".$code_type_acteur."' ");  
        }
        if($code_statut != ""){
        $select->where("code_statut LIKE '%".$code_statut."%' ");  
        }
        if($quartier_membre != ""){
        $select->where("quartier_membre LIKE '%".$quartier_membre."%' ");  
        }
        if($ville_membre != ""){
        $select->where("ville_membre LIKE '%".$ville_membre."%' ");  
        }
        if($code_agence != ""){
        $select->where("code_agence = '".$code_agence."' ");  
        }
        if($domaine_activite != ""){
        $select->where("domaine_activite LIKE '%".$domaine_activite."%' ");  
        }
        if($auto_enroler != ""){
        $select->where("auto_enroler = '".$auto_enroler."' ");  
        }
        if($etat_membre != ""){
        $select->where("etat_membre = '".$etat_membre."' ");  
        }
        
        $select->where("date_identification BETWEEN  '".$date_identification1."' AND '".$date_identification2."' ");  
        
        $select->order("date_identification DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_Filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
                    ->setType_fournisseur($row->type_fournisseur);
            $entries[] = $entry;
        }
        return $entries;
    }

  


    
    
    


    public function fetchAllByMembreMoraleBoublon() {
/*SELECT DISTINCT *
FROM eu_membre_morale t1
WHERE EXISTS (
              SELECT *
              FROM eu_membre_morale t2
              WHERE t1.code_membre_morale <> t2.code_membre_morale
              AND   t1.raison_sociale = t2.raison_sociale ); */
 
        $select = $this->getDbTable()->select();
        $select->distinct();
        $select->from(array('t1' => 'eu_membre_morale'), array('*'));
        $select->where("EXISTS (SELECT * FROM eu_membre_morale t2 WHERE t1.code_membre_morale <> t2.code_membre_morale AND   t1.raison_sociale = t2.raison_sociale )");
        $select->order(array('raison_sociale ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreMorale();
            $entry->setCode_membre_morale($row->code_membre_morale)
                    ->setId_Filiere($row->id_filiere)
                    ->setCode_type_acteur($row->code_type_acteur)
                    ->setCode_statut(stripslashes(($row->code_statut)))
                    ->setRaison_sociale(stripslashes(($row->raison_sociale)))
                    ->setId_pays($row->id_pays)
                    ->setQuartier_membre(stripslashes(($row->quartier_membre)))
                    ->setVille_membre(stripslashes(($row->ville_membre)))
                    ->setTel_membre($row->tel_membre)
                    ->setPortable_membre($row->portable_membre)
                    ->setEmail_membre(stripslashes(($row->email_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setSite_web(stripslashes(($row->site_web)))
                    ->setDomaine_activite(stripslashes(($row->domaine_activite)))
                    ->setNum_registre_membre(stripslashes(($row->num_registre_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setHeure_identification($row->heure_identification)
                    ->setCode_agence($row->code_agence)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setEtat_membre($row->etat_membre)
                    ->setId_canton($row->id_canton)
                    ->setType_fournisseur($row->type_fournisseur);
            $entries[] = $entry;
        }
        return $entries;
    }






}
