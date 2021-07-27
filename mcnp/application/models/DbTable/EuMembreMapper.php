<?php
class Application_Model_EuMembreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMembre');
        }
        return $this->_dbTable;
    }
     
	 
	public function detail($num_membre){
           $membre = new Application_Model_DbTable_EuMembre();
		   $select = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
		          ->join('eu_pays', 'eu_pays.id_pays = eu_membre.id_pays')
				  ->join('eu_religion', 'eu_religion.id_religion_membre = eu_membre.id_religion_membre')
				  ->where('eu_membre.code_membre = ?', $num_membre);
		   $result = $membre->fetchAll($select);
           $row = $result->current();
		   $entries = array();
				 
				 $entries['code_membre']=$row->code_membre;
				 $entries['nom_membre']=stripslashes (($row->nom_membre));
				 $entries['prenom_membre']=stripslashes (($row->prenom_membre));
				 $entries['sexe_membre']=$row->sexe_membre;
				 $entries['date_nais_membre']= $row->date_nais_membre;
				 $entries['lieu_nais_membre']= stripslashes (($row->lieu_nais_membre));
				 $entries['nationalite']= stripslashes (($row->nationalite));
				 $entries['profession_membre']=stripslashes (($row->profession_membre));
				 $entries['formation']=stripslashes (($row->formation));
                 $entries['pere_membre']=stripslashes (($row->pere_membre));
				 $entries['mere_membre']=stripslashes (($row->mere_membre));
				 $entries['sitfam_membre']=$row->sitfam_membre;
                 $entries['nbr_enf_membre']=$row->nbr_enf_membre;
		         $entries['quartier_membre']=stripslashes (($row->quartier_membre));
                 $entries['ville_membre']=stripslashes (($row->ville_membre));
                 $entries['bp_membre']=$row->bp_membre;
                 $entries['tel_membre']=$row->tel_membre;
                 $entries['email_membre']=stripslashes (($row->email_membre));
                 $entries['date_identification']=$row->date_identification;
                 $entries['portable_membre']=$row->portable_membre;
                 $entries['code_agence']=$row->code_agence;
                 $entries['heure_identification']=$row->heure_identification;
                 $entries['libelle_religion']=stripslashes (($row->libelle_religion));
                 $entries['id_utilisateur']=$row->id_utilisateur;
                 $entries['auto_enroler']=$row->auto_enroler;
                 $entries['id_maison']=$row->id_maison;
				 $entries['code_gac']=$row->code_gac;
                 $entries['id_canton']=$row->id_canton;
		
                return $entries;
           		   
				  
		   


   }

       public function resultfindByCodeMembre($num_membre, Application_Model_EuMembre $membre) {
        $result = $this->getDbTable()->find($num_membre);
        if (0 == count($result)) {
            return false;
        }
        $membre = array();
        foreach ($result as $row) {
            $membre = new Application_Model_EuMembre();
            $membre->setCode_membre($row->code_membre)
                   ->setNom_membre(stripslashes (($row->nom_membre)))
                   ->setPrenom_membre(stripslashes (($row->prenom_membre)))
                   ->setSexe_membre($row->sexe_membre)
                   ->setDate_nais_membre($row->date_nais_membre)
                   ->setLieu_nais_membre(stripslashes (($row->lieu_nais_membre)))
                   ->setId_pays($row->id_pays)
                   ->setProfession_membre(stripslashes (($row->profession_membre)))
                   ->setFormation(stripslashes (($row->formation)))
                   ->setPere_membre(stripslashes (($row->pere_membre)))
                   ->setMere_membre(stripslashes (($row->mere_membre)))
                   ->setSitfam_membre($row->sitfam_membre)
                   ->setNbr_enf_membre($row->nbr_enf_membre)
                   ->setQuartier_membre(stripslashes (($row->quartier_membre)))
                   ->setVille_membre(stripslashes (($row->ville_membre)))
                   ->setBp_membre($row->bp_membre)
                   ->setTel_membre($row->tel_membre)
                   ->setEmail_membre(stripslashes (($row->email_membre)))
                   ->setDate_identification($row->date_identification)
                   ->setPortable_membre($row->portable_membre)
                   ->setCode_agence($row->code_agence)
                   ->setHeure_identification($row->heure_identification)
                   ->setId_religion_membre($row->id_religion_membre)
                   ->setId_utilisateur($row->id_utilisateur)
                   ->setAuto_enroler($row->auto_enroler)
                   ->setId_maison($row->id_maison)
                   ->setEtat_membre($row->etat_membre)
                   ->setCode_gac($row->code_gac)
                   ->setCodesecret($row->codesecret)
				   ->setQuestion_secrete($row->question_secrete)
				   ->setReponse($row->reponse);
				   
             return $membre;     
        }
       
    }	
	 
    public function find($num_membre, Application_Model_EuMembre $membre) {
        $result = $this->getDbTable()->find($num_membre);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $membre->setCode_membre($row->code_membre)
                ->setNom_membre(stripslashes (($row->nom_membre)))
                ->setPrenom_membre(stripslashes (($row->prenom_membre)))
                ->setSexe_membre($row->sexe_membre)
                ->setDate_nais_membre($row->date_nais_membre)
                ->setLieu_nais_membre(stripslashes (($row->lieu_nais_membre)))
                ->setId_pays($row->id_pays)
                ->setProfession_membre(stripslashes (($row->profession_membre)))
                ->setFormation(stripslashes (($row->formation)))
                ->setPere_membre(stripslashes (($row->pere_membre)))
                ->setMere_membre(stripslashes (($row->mere_membre)))
                ->setSitfam_membre($row->sitfam_membre)
                ->setNbr_enf_membre($row->nbr_enf_membre)
                ->setQuartier_membre(stripslashes (($row->quartier_membre)))
                ->setVille_membre(stripslashes (($row->ville_membre)))
                ->setBp_membre($row->bp_membre)
                ->setTel_membre($row->tel_membre)
                ->setEmail_membre(stripslashes (($row->email_membre)))
                ->setDate_identification($row->date_identification)
                ->setPortable_membre($row->portable_membre)
                ->setCode_agence($row->code_agence)
                ->setHeure_identification($row->heure_identification)
                ->setId_religion_membre($row->id_religion_membre)
                ->setId_utilisateur($row->id_utilisateur)
                ->setAuto_enroler($row->auto_enroler)
                ->setId_maison($row->id_maison)
				->setEtat_membre($row->etat_membre)
				->setCode_gac($row->code_gac)
				->setCodesecret($row->codesecret)
                ->setId_canton($row->id_canton)
				->setQuestion_secrete($row->question_secrete)
				->setReponse($row->reponse)
				;
        return true;
    }

	
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembre();
            $entry->setCode_membre(stripslashes (($row->code_membre)))
                    ->setNom_membre(stripslashes (($row->nom_membre)))
                    ->setPrenom_membre(stripslashes (($row->prenom_membre)))
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre(stripslashes (($row->lieu_nais_membre)))
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre(stripslashes (($row->profession_membre)))
                    ->setFormation(stripslashes (($row->formation)))
                    ->setPere_membre(stripslashes (($row->pere_membre)))
                    ->setMere_membre(stripslashes (($row->mere_membre)))
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre(stripslashes (($row->quartier_membre)))
                    ->setVille_membre(stripslashes (($row->ville_membre)))
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre(stripslashes (($row->email_membre)))
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setAuto_enroler($row->auto_enroler)
					->setId_maison($row->id_maison)
					->setEtat_membre($row->etat_membre)
					->setCode_gac($row->code_gac)
					->setCodesecret($row->codesecret)
                    ->setId_canton($row->id_canton)
					->setQuestion_secrete($row->question_secrete)
				   ->setReponse($row->reponse)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getLastCodeMembreByAgence($code_agence) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_membre) as code'));
        $select->where('code_agence LIKE ?', $code_agence);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

	public function fetchByMembre($nom,$prenom,$date_nais,$lieu) {
	       $select = $this->getDbTable()->select();
		   $select->where("LOWER(REPLACE(nom_membre, ' ', '')) = ? ", strtolower(str_replace(" ", "",$nom)));
		   $select->where("LOWER(REPLACE(prenom_membre, ' ', '')) = ? ", strtolower(str_replace(" ", "",$prenom)));
		   $select->where("date_nais_membre like ? ", $date_nais);
		   $select->where("LOWER(REPLACE(lieu_nais_membre, ' ', '')) = ? ", strtolower(str_replace(" ", "",$lieu)));
		   $result = $this->getDbTable()->fetchAll($select);
		   if (count($result) == 0) {
               return false;
           }
		   $entries = array();
           foreach ($result as $row) {
		       $entry = new Application_Model_EuMembre();
               $entry->setCode_membre($row->code_membre)
                    ->setNom_membre($row->nom_membre)
                    ->setPrenom_membre($row->prenom_membre)
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre($row->lieu_nais_membre)
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre($row->profession_membre)
                    ->setFormation($row->formation)
                    ->setPere_membre($row->pere_membre)
                    ->setMere_membre($row->mere_membre)
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre($row->quartier_membre)
                    ->setVille_membre($row->ville_membre)
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre($row->email_membre)
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
					->setId_maison($row->id_maison)
                    ->setEtat_membre($row->etat_membre)
                    ->setAuto_enroler($row->auto_enroler)
					->setCode_gac($row->code_gac)
                    ->setId_canton($row->id_canton)
					->setQuestion_secrete($row->question_secrete)
				   ->setReponse($row->reponse);
                $entries[] = $entry;
		   }
	       return $entries;
	}
	
	
	
	
	
    public function fetchAllByType($type_membre) {
        $select = $this->getDbTable()->select();
        //$select->where('type_membre LIKE ?', $type_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembre();
            $entry->setCode_membre($row->code_membre)
                    ->setNom_membre($row->nom_membre)
                    ->setPrenom_membre($row->prenom_membre)
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre($row->lieu_nais_membre)
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre($row->profession_membre)
                    ->setFormation($row->formation)
                    ->setPere_membre($row->pere_membre)
                    ->setMere_membre($row->mere_membre)
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre($row->quartier_membre)
                    ->setVille_membre($row->ville_membre)
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre($row->email_membre)
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
					->setId_maison($row->id_maison)
                    ->setEtat_membre($row->etat_membre)
                    ->setAuto_enroler($row->auto_enroler)
					->setCode_gac($row->code_gac)
                    ->setId_canton($row->id_canton)
					->setQuestion_secrete($row->question_secrete)
				    ->setReponse($row->reponse)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuMembre $membre) {
        $data = array(
             'code_membre' => $membre->getCode_membre(),
             'nom_membre' => strtoupper($membre->getNom_membre()),
             'prenom_membre' => strtoupper($membre->getPrenom_membre()),
             'sexe_membre' => $membre->getSexe_membre(),
             'date_nais_membre' => $membre->getDate_nais_membre(),
             'lieu_nais_membre' => strtoupper($membre->getLieu_nais_membre()),
             'id_pays' => $membre->getId_pays(),
             'profession_membre' => strtoupper($membre->getProfession_membre()),
             'formation' => strtoupper($membre->getFormation()),
             'pere_membre' => strtoupper($membre->getPere_membre()),
             'mere_membre' => strtoupper($membre->getMere_membre()),
             'sitfam_membre' => $membre->getSitfam_membre(),
             'nbr_enf_membre' => $membre->getNbr_enf_membre(),
             'quartier_membre' => strtoupper($membre->getQuartier_membre()),
             'ville_membre' => strtoupper($membre->getVille_membre()),
             'bp_membre' => $membre->getBp_membre(),
             'tel_membre' => $membre->getTel_membre(),
             'email_membre' => $membre->getEmail_membre(),
             'date_identification' => $membre->getDate_identification(),
             'portable_membre' => $membre->getPortable_membre(),
             'code_agence' => $membre->getCode_agence(),
             'heure_identification' => $membre->getHeure_identification(),
             'id_religion_membre' => $membre->getId_religion_membre(),
             'id_utilisateur' => $membre->getId_utilisateur(),
             'codesecret' => $membre->getCodesecret(),
             'id_maison' => $membre->getId_maison(),
             'etat_membre' => $membre->getEtat_membre(),
			 'code_gac' => $membre->getCode_gac(),
			 'auto_enroler' => $membre->getAuto_enroler(),
             'id_canton' => $membre->getId_canton(),
			 'question_secrete' => $membre->getQuestion_secrete(),
			 'reponse' => $membre->getReponse()   
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembre $membre) {
        $data = array(
            'code_membre' => $membre->getCode_membre(),
            'nom_membre' => strtoupper($membre->getNom_membre()),
            'prenom_membre' => strtoupper($membre->getPrenom_membre()),
            'sexe_membre' => $membre->getSexe_membre(),
            'date_nais_membre' => $membre->getDate_nais_membre(),
            'lieu_nais_membre' => strtoupper($membre->getLieu_nais_membre()),
            'id_pays' => $membre->getId_pays(),
            'profession_membre' => strtoupper($membre->getProfession_membre()),
            'formation' => strtoupper($membre->getFormation()),
            'pere_membre' => strtoupper($membre->getPere_membre()),
            'mere_membre' => strtoupper($membre->getMere_membre()),
            'sitfam_membre' => $membre->getSitfam_membre(),
            'nbr_enf_membre' => $membre->getNbr_enf_membre(),
            'quartier_membre' => strtoupper($membre->getQuartier_membre()),
            'ville_membre' => strtoupper($membre->getVille_membre()),
            'bp_membre' => $membre->getBp_membre(),
            'tel_membre' => $membre->getTel_membre(),
            'email_membre' => $membre->getEmail_membre(),
            'date_identification' => $membre->getDate_identification(),
            'portable_membre' => $membre->getPortable_membre(),
            'code_agence' => $membre->getCode_agence(),
            'heure_identification' => $membre->getHeure_identification(),
            'id_religion_membre' => $membre->getId_religion_membre(),
            'codesecret' => $membre->getCodesecret(),
            'id_maison' => $membre->getId_maison(),
			'etat_membre' => $membre->getEtat_membre(),
			'code_gac' => $membre->getCode_gac(),
            'id_utilisateur' => $membre->getId_utilisateur(),
            'id_canton' => $membre->getId_canton(),
			'question_secrete' => $membre->getQuestion_secrete(),
			'reponse' => $membre->getReponse()
        );

        $this->getDbTable()->update($data, array('code_membre = ?' => $membre->getCode_membre()));
    }

    public function delete($code_membre) {
        $this->getDbTable()->delete(array('code_membre = ?' => $code_membre));
    }











    public function fetchAllByActivationMembreasso($membreasso = 0) {
        $select = $this->getDbTable()->select();
		if($membreasso > 0){
        $select->where('code_membre IN (SELECT code_membre FROM eu_code_activation WHERE souscription_id IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso = ?))', $membreasso);
        $select->orwhere('code_membre IN (SELECT code_membre FROM eu_membretierscode WHERE membretierscode_souscription IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso = ?))', $membreasso);
			}
        $select->order(array('code_membre ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembre();
            $entry->setCode_membre($row->code_membre)
                    ->setNom_membre($row->nom_membre)
                    ->setPrenom_membre($row->prenom_membre)
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre($row->lieu_nais_membre)
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre($row->profession_membre)
                    ->setFormation($row->formation)
                    ->setPere_membre($row->pere_membre)
                    ->setMere_membre($row->mere_membre)
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre($row->quartier_membre)
                    ->setVille_membre($row->ville_membre)
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre($row->email_membre)
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
					->setId_maison($row->id_maison)
                    ->setEtat_membre($row->etat_membre)
                    ->setAuto_enroler($row->auto_enroler)
					->setCode_gac($row->code_gac)
                    ->setId_canton($row->id_canton)
					->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse);
            $entries[] = $entry;
        }
        return $entries;
    }









    public function fetchAllByActivationAssociation($association = 0) {
        $select = $this->getDbTable()->select();
		if($association > 0){
        $select->where('code_membre IN (SELECT code_membre FROM eu_code_activation WHERE souscription_id IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)))', $association);
        $select->orwhere('code_membre IN (SELECT code_membre FROM eu_membretierscode WHERE membretierscode_souscription IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)))', $association);
			}
        $select->order(array('code_membre ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembre();
            $entry->setCode_membre($row->code_membre)
                    ->setNom_membre($row->nom_membre)
                    ->setPrenom_membre($row->prenom_membre)
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre($row->lieu_nais_membre)
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre($row->profession_membre)
                    ->setFormation($row->formation)
                    ->setPere_membre($row->pere_membre)
                    ->setMere_membre($row->mere_membre)
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre($row->quartier_membre)
                    ->setVille_membre($row->ville_membre)
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre($row->email_membre)
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
					->setId_maison($row->id_maison)
                    ->setEtat_membre($row->etat_membre)
                    ->setAuto_enroler($row->auto_enroler)
					->setCode_gac($row->code_gac)
                    ->setId_canton($row->id_canton)
					->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse);
            $entries[] = $entry;
        }
        return $entries;
    }








    
    
    public function fetchAllByTableauBord($code_membre = "", $nom_membre = "", $sexe_membre = "", $id_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $profession_membre = "", $formation = "", $quartier_membre = "", $ville_membre = "", $date_identification1 = "", $date_identification2 = "", $code_agence = "", $id_religion_membre = 0, $auto_enroler = "", $etat_membre = "") {
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
            
        if($code_membre != ""){
        $select->where("code_membre LIKE '%".$code_membre."%' ");  
        }
        if($nom_membre != ""){
        $select->where("nom_membre LIKE '%".$nom_membre."%' ");  
        }
        if($sexe_membre != ""){
        $select->where("sexe_membre LIKE '".$sexe_membre."' ");  
        }
        if($profession_membre != ""){
        $select->where("profession_membre LIKE '%".$profession_membre."%' ");  
        }
        if($formation != ""){
        $select->where("formation LIKE '%".$formation."%' ");  
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
        if($id_religion_membre != ""){
        $select->where("id_religion_membre = ".$id_religion_membre." ");  
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
              $entry = new Application_Model_EuMembre();
            $entry->setCode_membre($row->code_membre)
                    ->setNom_membre($row->nom_membre)
                    ->setPrenom_membre($row->prenom_membre)
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre($row->lieu_nais_membre)
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre($row->profession_membre)
                    ->setFormation($row->formation)
                    ->setPere_membre($row->pere_membre)
                    ->setMere_membre($row->mere_membre)
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre($row->quartier_membre)
                    ->setVille_membre($row->ville_membre)
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre($row->email_membre)
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setId_maison($row->id_maison)
                    ->setEtat_membre($row->etat_membre)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setCode_gac($row->code_gac)
                    ->setId_canton($row->id_canton)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse);
            $entries[] = $entry;
        }
        return $entries;
    }

  


    
    
    


    
    public function fetchAllByMembreBoublon() {
/*SELECT DISTINCT *
FROM eu_membre t1
WHERE EXISTS (
              SELECT *
              FROM eu_membre t2
              WHERE t1.code_membre <> t2.code_membre
              AND   t1.nom_membre = t2.nom_membre
              AND   t1.prenom_membre = t2.prenom_membre );*/

        $select = $this->getDbTable()->select();
        $select->distinct();
        $select->from(array('t1' => 'eu_membre'), array('*'));
        $select->where("EXISTS (SELECT * FROM eu_membre t2 WHERE t1.code_membre <> t2.code_membre AND t1.nom_membre = t2.nom_membre AND t1.prenom_membre = t2.prenom_membre)");
        $select->order(array('t1.nom_membre ASC', 't1.prenom_membre ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembre();
            $entry->setCode_membre($row->code_membre)
                    ->setNom_membre($row->nom_membre)
                    ->setPrenom_membre($row->prenom_membre)
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre($row->lieu_nais_membre)
                    ->setId_pays($row->id_pays)
                    ->setProfession_membre($row->profession_membre)
                    ->setFormation($row->formation)
                    ->setPere_membre($row->pere_membre)
                    ->setMere_membre($row->mere_membre)
                    ->setSitfam_membre($row->sitfam_membre)
                    ->setNbr_enf_membre($row->nbr_enf_membre)
                    ->setQuartier_membre($row->quartier_membre)
                    ->setVille_membre($row->ville_membre)
                    ->setBp_membre($row->bp_membre)
                    ->setTel_membre($row->tel_membre)
                    ->setEmail_membre($row->email_membre)
                    ->setDate_identification($row->date_identification)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_agence($row->code_agence)
                    ->setHeure_identification($row->heure_identification)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setId_maison($row->id_maison)
                    ->setEtat_membre($row->etat_membre)
                    ->setAuto_enroler($row->auto_enroler)
                    ->setCode_gac($row->code_gac)
                    ->setId_canton($row->id_canton)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }










}


