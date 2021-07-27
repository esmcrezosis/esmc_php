<?php

class Application_Model_EuPreinscriptionMoraleMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPreinscriptionMorale');
        }
        return $this->_dbTable;
    }

    public function find($id_preinscription_morale, Application_Model_EuPreinscriptionMorale $preinscriptionmorale) {
        $result = $this->getDbTable()->find($id_preinscription_morale);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $preinscriptionmorale->setId_preinscription_morale($row->id_preinscription_morale)
                ->setNumero_contrat($row->numero_contrat)
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
                ->setDate_inscription($row->date_inscription)
                ->setHeure_inscription($row->heure_inscription)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie_membre($row->categorie_membre)
                ->setNumero_agrement_filiere($row->numero_agrement_filiere)
                ->setNumero_agrement_acnev($row->numero_agrement_acnev)
                ->setCode_fs($row->code_fs)
                ->setCode_fl($row->code_fl)
				->setCode_fkps($row->code_fkps)
                ->setCode_rep($row->code_rep)
				->setPublier($row->publier)
				->setCode_agence($row->code_agence)
                ->setNumero_agrement_technopole($row->numero_agrement_technopole)
                ->setId_canton($row->id_canton)
				;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPreinscriptionMorale();
            $entry->setId_preinscription_morale($row->id_preinscription_morale)
                    ->setNumero_contrat($row->numero_contrat)
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
                    ->setDate_inscription($row->date_inscription)
                    ->setHeure_inscription($row->heure_inscription)
                    ->setCode_membre_morale($row->code_membre_morale)
                    ->setCategorie_membre($row->categorie_membre)
                    ->setNumero_agrement_filiere($row->numero_agrement_filiere)
                    ->setNumero_agrement_acnev($row->numero_agrement_acnev)
                    ->setCode_fs($row->code_fs)
                    ->setCode_fl($row->code_fl)
				    ->setCode_fkps($row->code_fkps)
                    ->setCode_rep($row->code_rep)
				    ->setPublier($row->publier)
					->setCode_agence($row->code_agence)
                    ->setNumero_agrement_technopole($row->numero_agrement_technopole)
                ->setId_canton($row->id_canton)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function save(Application_Model_EuPreinscriptionMorale $preinscriptionmorale) {
        $data = array(
            'id_preinscription_morale' => $preinscriptionmorale->getId_preinscription_morale(),
            'numero_contrat' => $preinscriptionmorale->getNumero_contrat(),
            'code_type_acteur' => $preinscriptionmorale->getCode_type_acteur(),
            'code_statut' => $preinscriptionmorale->getCode_statut(),
            'raison_sociale' => $preinscriptionmorale->getRaison_sociale(),
            'id_pays' => $preinscriptionmorale->getId_pays(),
            'quartier_membre' => $preinscriptionmorale->getQuartier_membre(),
            'ville_membre' => $preinscriptionmorale->getVille_membre(),
            'tel_membre' => $preinscriptionmorale->getTel_membre(),
            'portable_membre' => $preinscriptionmorale->getPortable_membre(),
            'email_membre' => $preinscriptionmorale->getEmail_membre(),
            'bp_membre' => $preinscriptionmorale->getBp_membre(),
            'site_web' => $preinscriptionmorale->getSite_web(),
            'domaine_activite' => $preinscriptionmorale->getDomaine_activite(),
            'num_registre_membre' => $preinscriptionmorale->getNum_registre_membre(),
            'date_inscription' => $preinscriptionmorale->getDate_inscription(),
            'heure_inscription' => $preinscriptionmorale->getHeure_inscription(),
            'code_membre_morale' => $preinscriptionmorale->getCode_membre_morale(),
            'numero_agrement_filiere' => $preinscriptionmorale->getNumero_agrement_filiere(),
            'numero_agrement_acnev' => $preinscriptionmorale->getNumero_agrement_acnev(),
            'categorie_membre' => $preinscriptionmorale->getCategorie_membre(),
            'numero_agrement_technopole' => $preinscriptionmorale->getNumero_agrement_technopole(),
            'code_rep' => $preinscriptionmorale->getCode_rep(),
            'code_fs' => $preinscriptionmorale->getCode_fs(),
            'code_fkps' => $preinscriptionmorale->getCode_fkps(),
			'code_fl' => $preinscriptionmorale->getCode_fl(),
            'publier' => $preinscriptionmorale->getPublier(),
			'code_agence' => $preinscriptionmorale->getCode_agence(),
            'id_canton' => $preinscriptionmorale->getId_canton()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPreinscriptionMorale $preinscriptionmorale) {
        $data = array(
            'id_preinscription_morale' => $preinscriptionmorale->getId_preinscription_morale(),
            'numero_contrat' => $preinscriptionmorale->getNumero_contrat(),
            'code_type_acteur' => $preinscriptionmorale->getCode_type_acteur(),
            'code_statut' => $preinscriptionmorale->getCode_statut(),
            'raison_sociale' => $preinscriptionmorale->getRaison_sociale(),
            'id_pays' => $preinscriptionmorale->getId_pays(),
            'quartier_membre' => $preinscriptionmorale->getQuartier_membre(),
            'ville_membre' => $preinscriptionmorale->getVille_membre(),
            'tel_membre' => $preinscriptionmorale->getTel_membre(),
            'portable_membre' => $preinscriptionmorale->getPortable_membre(),
            'email_membre' => $preinscriptionmorale->getEmail_membre(),
            'bp_membre' => $preinscriptionmorale->getBp_membre(),
            'site_web' => $preinscriptionmorale->getSite_web(),
            'domaine_activite' => $preinscriptionmorale->getDomaine_activite(),
            'num_registre_membre' => $preinscriptionmorale->getNum_registre_membre(),
            'date_inscription' => $preinscriptionmorale->getDate_inscription(),
            'heure_inscription' => $preinscriptionmorale->getHeure_inscription(),
            'code_membre_morale' => $preinscriptionmorale->getCode_membre_morale(),
            'categorie_membre' => $preinscriptionmorale->getCategorie_membre(),
            'numero_agrement_filiere' => $preinscriptionmorale->getNumero_agrement_filiere(),
            'code_rep' => $preinscriptionmorale->getCode_rep(),
            'code_fs' => $preinscriptionmorale->getCode_fs(),
            'code_fkps' => $preinscriptionmorale->getCode_fkps(),
			'code_fl' => $preinscriptionmorale->getCode_fl(),
            'publier' => $preinscriptionmorale->getPublier(),
			'code_agence' => $preinscriptionmorale->getCode_agence(),
            'id_canton' => $preinscriptionmorale->getId_canton()
        );
        $this->getDbTable()->update($data, array('id_preinscription_morale = ?' => $preinscriptionmorale->getId_preinscription_morale()));
    }

    public function delete($id_preinscription_morale) {
        $this->getDbTable()->delete(array('id_preinscription_morale = ?' => $id_preinscription_morale));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_preinscription_morale) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
