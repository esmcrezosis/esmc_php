<?php

class Application_Model_EuUtilisateurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUtilisateur');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuUtilisateur $user) {
        $data = array(
            'id_utilisateur' => $user->getId_utilisateur(),
	        'id_utilisateur_parent' => $user->getId_utilisateur_parent(),
            'login' => $user->getLogin(),
            'pwd' => $user->getPwd(),
            'description' => $user->getDescription(),
            'ulock' => $user->getUlock(),
            'ch_pwd_flog' => $user->getCh_pwd_flog(),
            'code_groupe' => $user->getCode_groupe(),
            'code_membre' => $user->getCode_membre(),
            'connecte' => $user->getConnecte(),
            'code_secteur' => $user->getCode_secteur(),
            'code_agence' => $user->getCode_agence(),
            'code_zone' => $user->getCode_zone(),
            'id_filiere' => $user->getId_filiere(),
            'code_acteur' => $user->getCode_acteur(),
            'nom_utilisateur' => $user->getNom_utilisateur(),
            'prenom_utilisateur' => $user->getPrenom_utilisateur(),
            'question_secrete' => $user->getQuestion_secrete(),
            'reponse' => $user->getReponse(),
            'code_passe' => $user->getCode_passe(),
            'code_gac_filiere' => $user->getCode_gac_filiere(),
			'code_groupe_create' => $user->getCode_groupe_create(),
			'id_pays' => $user->getId_pays(),
			'code_tegc' => $user->getCode_tegc(),
            'role' => $user->getRole(),
			'odd' => $user->getOdd(),
			'gac' => $user->getGac(),
			'section' => $user->getSection(),
			'id_canton' => $user->getId_canton()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUtilisateur $user) {
        $data = array(
            'id_utilisateur' => $user->getId_utilisateur(),
	        'id_utilisateur_parent' => $user->getId_utilisateur_parent(),
            'login' => $user->getLogin(),
            'pwd' => $user->getPwd(),
            'description' => $user->getDescription(),
            'ulock' => $user->getUlock(),
            'ch_pwd_flog' => $user->getCh_pwd_flog(),
            'code_groupe' => $user->getCode_groupe(),
            'code_membre' => $user->getCode_membre(),
            'connecte' => $user->getConnecte(),
            'code_secteur' => $user->getCode_secteur(),
            'code_agence' => $user->getCode_agence(),
            'code_zone' => $user->getCode_zone(),
            'id_filiere' => $user->getId_filiere(),
            'code_acteur' => $user->getCode_acteur(),
            'nom_utilisateur' => $user->getNom_utilisateur(),
            'prenom_utilisateur' => $user->getPrenom_utilisateur(),
            'question_secrete' => $user->getQuestion_secrete(),
            'reponse' => $user->getReponse(),
            'code_passe' => $user->getCode_passe(),
            'code_gac_filiere' => $user->getCode_gac_filiere(),
			'code_groupe_create' => $user->getCode_groupe_create(),
	        'id_pays' => $user->getId_pays(),
			'code_tegc' => $user->getCode_tegc(),
            'role' => $user->getRole(),
			'section' => $user->getSection(),
			'odd' => $user->getOdd(),
			'gac' => $user->getGac(),
			'id_canton' => $user->getId_canton()
        );

        $this->getDbTable()->update($data, array('id_utilisateur = ?' => $user->getId_utilisateur()));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_utilisateur) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function findcountuser($code_groupe,$id_utilisateur) {
	        $select = $this->getDbTable()->select();
		    $select->from($this->getDbTable(), array('COUNT(id_utilisateur) as nbre_user'));
		    $select->where('code_groupe LIKE  ?', $code_groupe);
		    $select->where('id_utilisateur_parent LIKE  ?', $id_utilisateur);
	        $result = $this->getDbTable()->fetchAll($select);
            $row = $result->current();
            return $row['nbre_user'];
	}
	
	
	public function findcountchaine($code_groupe,$id_utilisateur,$id_filiere) {
	        $select = $this->getDbTable()->select();
		    $select->from($this->getDbTable(), array('COUNT(id_utilisateur) as nbre_user'));
		    $select->where('code_groupe LIKE  ?', $code_groupe);
		    $select->where('id_utilisateur_parent =  ?', $id_utilisateur);
			$select->where('id_filiere =  ?', $id_filiere);
	        $result = $this->getDbTable()->fetchAll($select);
            $row = $result->current();
            return $row['nbre_user'];
	}
	
    

    public function find($id_user, Application_Model_EuUtilisateur $user) {
        $result = $this->getDbTable()->find($id_user);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $user->setId_utilisateur($row->id_utilisateur)
		     ->setId_utilisateur_parent($row->id_utilisateur_parent)
             ->setLogin($row->login)
             ->setPwd($row->pwd)
             ->setDescription($row->description)
             ->setUlock($row->ulock)
             ->setCh_pwd_flog($row->ch_pwd_flog)
             ->setConnecte($row->connecte)
             ->setCode_groupe($row->code_groupe)
             ->setCode_membre($row->code_membre)
             ->setCode_secteur($row->code_secteur)
             ->setCode_agence($row->code_agence)
             ->setCode_zone($row->code_zone)
             ->setId_filiere($row->id_filiere)
             ->setCode_acteur($row->code_acteur)
             ->setNom_utilisateur($row->nom_utilisateur)
             ->setPrenom_utilisateur($row->prenom_utilisateur)
             ->setQuestion_secrete($row->question_secrete)
             ->setReponse($row->reponse)
             ->setCode_passe($row->code_passe)
             ->setCode_gac_filiere($row->code_gac_filiere)
		     ->setId_pays($row->id_pays)
		     ->setCode_groupe_create($row->code_groupe_create)
             ->setId_canton($row->id_canton)
			 ->setCode_tegc($row->code_tegc)
			 ->setOdd($row->odd)
			 ->setGac($row->gac)
             ->setRole($row->role)
			 ->setSection($row->section);
        return true;
    }

    public function findLogin($login) {
        $select = $this->getDbTable()->select();
        $select->where('login = ?', $login);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                  ->setLogin($row->login)
                  ->setPwd($row->pwd)
                  ->setDescription($row->description)
                  ->setUlock($row->ulock)
                  ->setCh_pwd_flog($row->ch_pwd_flog)
                  ->setCode_groupe($row->code_groupe)
                  ->setConnecte($row->connecte)
                  ->setCode_membre($row->code_membre)
                  ->setCode_secteur($row->code_secteur)
                  ->setCode_agence($row->code_agence)
                  ->setCode_zone($row->code_zone)
                  ->setId_filiere($row->id_filiere)
                  ->setCode_acteur($row->code_acteur)
                  ->setNom_utilisateur($row->nom_utilisateur)
                  ->setPrenom_utilisateur($row->prenom_utilisateur)
                  ->setQuestion_secrete($row->question_secrete)
                  ->setReponse($row->reponse)
			      ->setCode_passe($row->code_passe)
	              ->setCode_gac_filiere($row->code_gac_filiere)
				  ->setId_pays($row->id_pays)
				  ->setCode_groupe_create($row->code_groupe_create)
                  ->setId_canton($row->id_canton)
			      ->setCode_tegc($row->code_tegc)
                  ->setRole($row->role)
				  ->setOdd($row->odd)
				  ->setGac($row->gac)
				  ->setSection($row->section);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findNoLogin($login, $id) {
        $select = $this->getDbTable()->select();
        $select->where('login = ?', $login);
        $select->where('id_utilisateur != ?', $id);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setId_pays($row->id_pays)
					->setCode_groupe_create($row->code_groupe_create)
					->setCode_tegc($row->code_tegc)
                    ->setId_canton($row->id_canton)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function findgac($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre=?', $code_membre)
                ->where('code_groupe =?', 'gac')
                ->Orwhere('code_groupe = ?', 'gac_filiere')
                ->Orwhere('code_groupe = ?', 'creneaux')
                ->Orwhere('code_groupe = ?', 'acteurs_creneaux');
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setCode_groupe_create($row->code_groupe_create)
					->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
				    ->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                  ->setLogin($row->login)
                  ->setPwd($row->pwd)
                  ->setDescription($row->description)
                  ->setUlock($row->ulock)
                  ->setCh_pwd_flog($row->ch_pwd_flog)
                  ->setCode_groupe($row->code_groupe)
                  ->setConnecte($row->connecte)
                  ->setCode_membre($row->code_membre)
                  ->setCode_secteur($row->code_secteur)
                  ->setCode_agence($row->code_agence)
                  ->setCode_zone($row->code_zone)
                  ->setId_filiere($row->id_filiere)
                  ->setCode_acteur($row->code_acteur)
                  ->setNom_utilisateur($row->nom_utilisateur)
                  ->setPrenom_utilisateur($row->prenom_utilisateur)
                  ->setQuestion_secrete($row->question_secrete)
                  ->setReponse($row->reponse)
			      ->setCode_passe($row->code_passe)
	              ->setCode_gac_filiere($row->code_gac_filiere)
			      ->setCode_groupe_create($row->code_groupe_create)
				  ->setId_pays($row->id_pays)
                  ->setId_canton($row->id_canton)
				  ->setCode_tegc($row->code_tegc)
                  ->setRole($row->role)
				  ->setOdd($row->odd)
				  ->setGac($row->gac)
				  ->setSection($row->section)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function delete($id_utilisateur) {
        $this->getDbTable()->delete(array('id_utilisateur = ?' => $id_utilisateur));
    }
    
	public function findbymembreacteur($code_membre,$code_groupe) {
	       $select = $this->getDbTable()->select();
		   $select->from($this->getDbTable(), array('code_acteur'));
		   $select->where('code_membre LIKE ?', $code_membre);
           $select->where('code_groupe LIKE ?', $code_groupe);
	       $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['code_acteur'];
	}
	
	
    public function findByMembre($code_membre, $code_groupe) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre LIKE ?', $code_membre);
        $select->where('code_groupe IN (?)', $code_groupe);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        $row = $resultSet->current();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setCode_groupe_create($row->code_groupe_create)
					->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
					->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section)
					;
            $entries = $entry;
        //}[]
        return $entries;
    }
	
    public function findByMembre2($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_groupe IN (SELECT code_groupe FROM eu_user_group)');
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        $row = $resultSet->current();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setCode_groupe_create($row->code_groupe_create)
					->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
				    ->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section)
					;
            $entries = $entry;
        //}[]
        return $entries;
    }
	
    public function findUserCodeGroupe($code_membre, $code_groupe) {
	
        $select = $this->getDbTable()->select();
        $select->where('code_membre=?', $code_membre)
                ->where('code_groupe =?', $code_groupe);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        //foreach ($resultSet as $row) {
		    $row = $resultSet->current();
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setCode_groupe_create($row->code_groupe_create)
					->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
				    ->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section)
					;
            //$entries[] = $entry;
        //}
        return $entry;
    }
  
    public function findUserLoginCodeGroupe($code_membre, $login, $code_groupe) {
  
        $select = $this->getDbTable()->select();
        $select->where('code_membre=?', $code_membre)
                ->where('login=?', $login)
                ->where('code_groupe =?', $code_groupe);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        //foreach ($resultSet as $row) {
        $row = $resultSet->current();
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
            ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
                    ->setCode_passe($row->code_passe)
                    ->setCode_gac_filiere($row->code_gac_filiere)
                    ->setCode_groupe_create($row->code_groupe_create)
                    ->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
                    ->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
                    ->setSection($row->section);
            //$entries[] = $entry;
        //}
        return $entry;
    }
	
	public function findLoginAndPwd($login,$pwd) {
	    $select = $this->getDbTable()->select();
        $select->where('login like ?', $login);
		$select->where('pwd like ?', $pwd);
		$select->where('code_groupe like ?',"cnp_tegcp_pbf");
        $resultSet = $this->getDbTable()->fetchAll($select);
		
		if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      ->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setId_pays($row->id_pays)
					->setCode_groupe_create($row->code_groupe_create)
                    ->setId_canton($row->id_canton)
					->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setSection($row->section)
					->setGac($row->gac)
					->setOdd($row->odd)
					;
            $entries[] = $entry;
        }
        return $entries;
	
	}
	
	
	
    public function fetchAllByUtilisateurParent($utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur_parent = ? ", $utilisateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      	->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setCode_groupe_create($row->code_groupe_create)
					->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
				    ->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	
    public function fetchAllByAgenceCodeGroupe($code_agence, $code_groupe) {
        $select = $this->getDbTable()->select();
		$select->where("code_agence = ? ", $code_agence);
		$select->where("code_groupe = ? ", $code_groupe);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_utilisateur($row->id_utilisateur)
			      	->setId_utilisateur_parent($row->id_utilisateur_parent)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescription($row->description)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setCode_groupe($row->code_groupe)
                    ->setConnecte($row->connecte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_secteur($row->code_secteur)
                    ->setCode_agence($row->code_agence)
                    ->setCode_zone($row->code_zone)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_utilisateur($row->nom_utilisateur)
                    ->setPrenom_utilisateur($row->prenom_utilisateur)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse)
					->setCode_passe($row->code_passe)
	                ->setCode_gac_filiere($row->code_gac_filiere)
					->setCode_groupe_create($row->code_groupe_create)
					->setId_pays($row->id_pays)
                    ->setId_canton($row->id_canton)
				    ->setCode_tegc($row->code_tegc)
                    ->setRole($row->role)
					->setOdd($row->odd)
					->setGac($row->gac)
					->setSection($row->section)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
}

