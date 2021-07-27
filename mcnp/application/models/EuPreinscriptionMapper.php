<?php
class Application_Model_EuPreinscriptionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPreinscription');
        }
        return $this->_dbTable;
    }
     
	 
	 
    public function find($id_preinscription, Application_Model_EuPreinscription $preinscription) {
        $result = $this->getDbTable()->find($id_preinscription);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $preinscription->setId_preinscription($row->id_preinscription)
                ->setNom_membre(stripslashes (($row->nom_membre)))
                ->setPrenom_membre(stripslashes (($row->prenom_membre)))
                ->setSexe_membre($row->sexe_membre)
                ->setDate_nais_membre($row->date_nais_membre)
                ->setLieu_nais_membre(stripslashes (($row->lieu_nais_membre)))
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
                ->setDate_inscription($row->date_inscription)
                ->setPortable_membre($row->portable_membre)
                ->setCode_membre($row->code_membre)
                ->setHeure_inscription($row->heure_inscription)
                ->setId_religion_membre($row->id_religion_membre)
                ->setCode_fs($row->code_fs)
                ->setCode_fl($row->code_fl)
				->setCode_fkps($row->code_fkps)
                ->setId_pays($row->id_pays)
				->setPublier($row->publier)
				->setCode_agence($row->code_agence)
                ->setId_canton($row->id_canton)
				;
        return true;
    }

	
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPreinscription();
            $entry->setId_preinscription(stripslashes (($row->id_preinscription)))
                    ->setNom_membre(stripslashes (($row->nom_membre)))
                    ->setPrenom_membre(stripslashes (($row->prenom_membre)))
                    ->setSexe_membre($row->sexe_membre)
                    ->setDate_nais_membre($row->date_nais_membre)
                    ->setLieu_nais_membre(stripslashes (($row->lieu_nais_membre)))
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
                    ->setDate_inscription($row->date_inscription)
                    ->setPortable_membre($row->portable_membre)
                    ->setCode_membre($row->code_membre)
                    ->setHeure_inscription($row->heure_inscription)
                    ->setId_religion_membre($row->id_religion_membre)
                    ->setCode_fs($row->code_fs)
                    ->setCode_fl($row->code_fl)
					->setCode_fkps($row->code_fkps)
                    ->setId_pays($row->id_pays)
				    ->setPublier($row->publier)
					->setCode_agence($row->code_agence)
                ->setId_canton($row->id_canton)
					;
            $entries[] = $entry;
        }
        return $entries;
    }



    public function save(Application_Model_EuPreinscription $preinscription) {
        $data = array(
            'id_preinscription' => $preinscription->getId_preinscription(),
            'nom_membre' => $preinscription->getNom_membre(),
            'prenom_membre' => $preinscription->getPrenom_membre(),
            'sexe_membre' => $preinscription->getSexe_membre(),
            'date_nais_membre' => $preinscription->getDate_nais_membre(),
            'lieu_nais_membre' => $preinscription->getLieu_nais_membre(),
             'profession_membre' => $preinscription->getProfession_membre(),
             'formation' => $preinscription->getFormation(),
             'pere_membre' => $preinscription->getPere_membre(),
             'mere_membre' => $preinscription->getMere_membre(),
             'sitfam_membre' => $preinscription->getSitfam_membre(),
             'nbr_enf_membre' => $preinscription->getNbr_enf_membre(),
             'quartier_membre' => $preinscription->getQuartier_membre(),
             'ville_membre' => $preinscription->getVille_membre(),
             'bp_membre' => $preinscription->getBp_membre(),
             'tel_membre' => $preinscription->getTel_membre(),
             'email_membre' => $preinscription->getEmail_membre(),
             'date_inscription' => $preinscription->getDate_inscription(),
             'portable_membre' => $preinscription->getPortable_membre(),
             'code_membre' => $preinscription->getCode_membre(),
             'heure_inscription' => $preinscription->getHeure_inscription(),
             'id_religion_membre' => $preinscription->getId_religion_membre(),
             'id_pays' => $preinscription->getId_pays(),
             'code_fs' => $preinscription->getCode_fs(),
             'code_fkps' => $preinscription->getCode_fkps(),
			 'code_fl' => $preinscription->getCode_fl(),
             'publier' => $preinscription->getPublier(),
			 'code_agence' => $preinscription->getCode_agence(),
            'id_canton' => $preinscription->getId_canton()
            
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPreinscription $preinscription) {
        $data = array(
            'id_preinscription' => $preinscription->getId_preinscription(),
            'nom_membre' => $preinscription->getNom_membre(),
            'prenom_membre' => $preinscription->getPrenom_membre(),
            'sexe_membre' => $preinscription->getSexe_membre(),
            'date_nais_membre' => $preinscription->getDate_nais_membre(),
            'lieu_nais_membre' => $preinscription->getLieu_nais_membre(),
            'profession_membre' => $preinscription->getProfession_membre(),
            'formation' => $preinscription->getFormation(),
            'pere_membre' => $preinscription->getPere_membre(),
            'mere_membre' => $preinscription->getMere_membre(),
            'sitfam_membre' => $preinscription->getSitfam_membre(),
            'nbr_enf_membre' => $preinscription->getNbr_enf_membre(),
            'quartier_membre' => $preinscription->getQuartier_membre(),
            'ville_membre' => $preinscription->getVille_membre(),
            'bp_membre' => $preinscription->getBp_membre(),
            'tel_membre' => $preinscription->getTel_membre(),
            'email_membre' => $preinscription->getEmail_membre(),
            'date_inscription' => $preinscription->getDate_inscription(),
            'portable_membre' => $preinscription->getPortable_membre(),
            'code_membre' => $preinscription->getCode_membre(),
            'heure_inscription' => $preinscription->getHeure_inscription(),
            'id_religion_membre' => $preinscription->getId_religion_membre(),
            'id_pays' => $preinscription->getId_pays(),
            'code_fs' => $preinscription->getCode_fs(),
            'code_fkps' => $preinscription->getCode_fkps(),
			'code_fl' => $preinscription->getCode_fl(),
            'publier' => $preinscription->getPublier(),
			'code_agence' => $preinscription->getCode_agence(),
            'id_canton' => $preinscription->getId_canton()
        );
        $this->getDbTable()->update($data, array('id_preinscription = ?' => $preinscription->getId_preinscription()));
    }

    public function delete($id_preinscription) {
        $this->getDbTable()->delete(array('id_preinscription = ?' => $id_preinscription));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_preinscription) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}


