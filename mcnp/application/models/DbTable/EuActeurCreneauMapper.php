 <?php

class Application_Model_EuActeurCreneauMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuActeurCreneau');
        }
        return $this->_dbTable;
    }

    public function findByCreneau($code_creneau) {
        $table = new Application_Model_DbTable_EuActeurCreneau();
        $select = $table->select();
        $select->where('code_creneau=?', $code_creneau);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuActeurCreneau();
            $entry->setCode_acteur($row->code_acteur)
                    ->setNom_acteur($row->nom_acteur)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_acteur($row->id_type_acteur)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_gac_filiere($row->code_gac_filiere)
                    ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function find1($code_acteur, Application_Model_EuActeurCreneau $acteur) {
        $result = $this->getDbTable()->find($code_acteur);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $acteur->setCode_acteur($row->code_acteur)
                ->setNom_acteur($row->nom_acteur)
                ->setCode_membre($row->code_membre)
                ->setId_type_acteur($row->id_type_acteur)
                ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
                ->setGroupe($row->groupe)
                ->setCode_creneau($row->code_creneau)
                ->setCode_gac_filiere($row->code_gac_filiere)
                ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;
        return true;
    }

    public function find($code_acteur, Application_Model_EuActeurCreneau $acteur) {
        $result = $this->getDbTable()->find($code_acteur);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $acteur->setCode_acteur($row->code_acteur)
                ->setNom_acteur($row->nom_acteur)
                ->setCode_membre($row->code_membre)
                ->setId_type_acteur($row->id_type_acteur)
                ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
                ->setGroupe($row->groupe)
                ->setCode_creneau($row->code_creneau)
                ->setCode_gac_filiere($row->code_gac_filiere)
                ->setId_filiere($row->id_filiere)
                ->setFocus($row->focus)
;
	}

    public function findByMembre($membre) {
        $table = new Application_Model_DbTable_EuActeurCreneau();
        $select = $table->select();
        $select->where('code_membre=?', $membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuActeurCreneau();
             $entry->setCode_acteur($row->code_acteur)
                    ->setNom_acteur($row->nom_acteur)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_acteur($row->id_type_acteur)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_gac_filiere($row->code_gac_filiere)
                    ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;

            $entries[] = $entry;
        }
        return $entries;
    }

    public function findActeurByMembre($membre) {
        $table = new Application_Model_DbTable_EuActeurCreneau();
        $select = $table->select();
        $select->where('code_membre=?', $membre);
        $result = $table->fetchAll($select);
        if(count($result) == 0) {
           return NULL;
        } else {
           $row = $result->current();
           $entry = new Application_Model_EuActeurCreneau();
           $entry->setCode_acteur($row->code_acteur)
                 ->setNom_acteur($row->nom_acteur)
                 ->setCode_membre($row->code_membre)
                 ->setId_type_acteur($row->id_type_acteur)
                 ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                 ->setDate_creation($row->date_creation)
                 ->setId_utilisateur($row->id_utilisateur)
                 ->setGroupe($row->groupe)
                 ->setCode_creneau($row->code_creneau)
                 ->setCode_gac_filiere($row->code_gac_filiere)
                 ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;
           return $entry;
        }
		
    }
    
    public function getLastActeurByCrenau() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_acteur) as code'))
               //->where('code_creneau = ?', $code_creneau)
			   ;
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }
    
	
	
    public function getLastActeurByFiliere($code_creneau) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_acteur) as code'))
                ->where('code_gac_filiere = ?', $code_creneau);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }
	
	
	
	public  function getActeurCreneau($id_filiere,$code_membre)   {
            $table = new Application_Model_DbTable_EuActeurCreneau();
            $select = $table->select();
			$select->where('id_filiere =  ?', $id_filiere);
            $select->where('code_membre_gestionnaire = ?', $code_membre);
            $result = $table->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            } else {
               $row = $result->current();
               $entry = new Application_Model_EuActeurCreneau();
               $entry->setCode_acteur($row->code_acteur)
                      ->setNom_acteur($row->nom_acteur)
                      ->setCode_membre($row->code_membre)
                      ->setId_type_acteur($row->id_type_acteur)
                      ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                      ->setDate_creation($row->date_creation)
                      ->setId_utilisateur($row->id_utilisateur)
                      ->setGroupe($row->groupe)
                      ->setCode_creneau($row->code_creneau)
                      ->setCode_gac_filiere($row->code_gac_filiere)
                      ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                      ;
               return $entry;
            }
    }	
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeurCreneau();
             $entry->setCode_acteur($row->code_acteur)
                    ->setNom_acteur($row->nom_acteur)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_acteur($row->id_type_acteur)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_gac_filiere($row->code_gac_filiere)
                    ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;

            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuActeurCreneau $acteur) {
        $data = array(
            'code_acteur' => $acteur->getCode_acteur(),
            'nom_acteur' => $acteur->getNom_acteur(),
            'code_membre' => $acteur->getCode_membre(),
            'id_type_acteur' => $acteur->getId_type_acteur(),
            'code_membre_gestionnaire' => $acteur->getCode_membre_gestionnaire(),
            'date_creation' => $acteur->getDate_creation(),
            'id_utilisateur' => $acteur->getId_utilisateur(),
            'groupe' => $acteur->getGroupe(),
            'code_creneau' => $acteur->getCode_creneau(),
            'code_gac_filiere' => $acteur->getCode_gac_filiere(),
            'id_filiere' => $acteur->getId_filiere(),
            'focus' => $acteur->getFocus()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuActeurCreneau $acteur) {
        $data = array(
            'code_acteur' => $acteur->getCode_acteur(),
            'nom_acteur' => $acteur->getNom_acteur(),
            'code_membre' => $acteur->getCode_membre(),
            'id_type_acteur' => $acteur->getId_type_acteur(),
            'code_membre_gestionnaire' => $acteur->getCode_membre_gestionnaire(),
            'date_creation' => $acteur->getDate_creation(),
            'id_utilisateur' => $acteur->getId_utilisateur(),
            'groupe' => $acteur->getGroupe(),
            'code_creneau' => $acteur->getCode_creneau(),
            'code_gac_filiere' => $acteur->getCode_gac_filiere(),
            'id_filiere' => $acteur->getId_filiere(),
            'focus' => $acteur->getFocus()
        );
        $this->getDbTable()->update($data, array('code_acteur = ?' => $acteur->getcode_acteur()));
    }

    public function delete($code_acteur) {
        $this->getDbTable()->delete(array('code_acteur = ?' => $code_acteur));
    }

    //////////////////////////////////////////////////////////////

    public function fetchAllActeur() {
        $acteur_creneau = new Application_Model_DbTable_EuActeurCreneau();
        $select = $acteur_creneau->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_acteurs_creneaux.code_membre', array('*'));
        $select->join('eu_filiere', 'eu_filiere.id_filiere = eu_acteurs_creneaux.id_filiere', array('*'));
        $select->order(array('eu_filiere.nom_filiere ASC', 'eu_membre_morale.raison_sociale ASC'));
        $resultSet = $acteur_creneau->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeurCreneau();
             $entry->setCode_acteur($row->code_acteur)
                    ->setNom_acteur($row->nom_acteur)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_acteur($row->id_type_acteur)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_gac_filiere($row->code_gac_filiere)
                    ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;

            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllActeurFocus() {
        $acteur_creneau = new Application_Model_DbTable_EuActeurCreneau();
        $select = $acteur_creneau->select();
        $select->where('focus >  ?', 0);
        $select->order(array('focus DESC'));
        $resultSet = $acteur_creneau->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeurCreneau();
             $entry->setCode_acteur($row->code_acteur)
                    ->setNom_acteur($row->nom_acteur)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_acteur($row->id_type_acteur)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_gac_filiere($row->code_gac_filiere)
                    ->setId_filiere($row->id_filiere)
                    ->setFocus($row->focus)
                    ;

            $entries[] = $entry;
        }
        return $entries;
    }






}

?>
