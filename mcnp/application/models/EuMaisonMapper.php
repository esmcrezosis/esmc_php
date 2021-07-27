<?php

class Application_Model_EuMaisonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMaison');
        }
        return $this->_dbTable;
    }

    public function find($id_maison, Application_Model_EUMAISON $maison) {
        $result = $this->getDbTable()->find($id_maison);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $maison->setId_maison($row->id_maison)
                ->setDesignation($row->designation)
                ->setId_proprietaire($row->id_proprietaire)
                ->setCode_membre($row->code_membre)
                ->setType_maison($row->type_maison)
                ->setCode_membre($row->code_membre)
                ->setType_maison($row->type_maison)
                ->setEau($row->eau)
                ->setDate_enregistrement($row->date_enregistrement)
                ->setElectrifier($row->electrifier)
                ->setType_maison($row->type_maison)
                ->setWc_douche($row->wc_douche)
                ->setStatut($row->statut)
                ->setDesc_maison($row->desc_maison)
                ->setFrais_eau($row->frais_eau)
                ->setFrais_electricite($row->frais_electricite)
                ->setFrais_vidange($row->frais_vidange)
                ->setTaxe($row->taxe)
                ->setFrais_tel($row->frais_tel)
                ->setRue($row->rue)
                ->setNum_maison($row->num_maison)
                ->setNum_police_electricite($row->num_police_electricite)
                ->setNum_compteur_eau($row->num_compteur_eau)
                ->setNum_ligne_tel($row->num_ligne_tel)
                ->setId_utilisateur($row->id_utilisateur)
                ->setQuartier($row->quartier)
                ->setCode_agence($row->code_agence)
				->setTel($row->tel)
				->setMontant_loyer($row->montant_loyer)
				->setAutre_charge($row->autre_charge)
				;
    }

    public function findByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre LIKE ?', $code_membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $maison = new Application_Model_EUMAISON();
        $maison->setId_maison($row->id_maison)
                ->setDesignation($row->designation)
                ->setId_proprietaire($row->id_proprietaire)
                ->setCode_membre($row->code_membre)
                ->setType_maison($row->type_maison)
                ->setCode_membre($row->code_membre)
                ->setType_maison($row->type_maison)
                ->setEau($row->eau)
                ->setDate_enregistrement($row->date_enregistrement)
                ->setElectrifier($row->electrifier)
                ->setType_maison($row->type_maison)
                ->setWc_douche($row->wc_douche)
                ->setStatut($row->statut)
                ->setDesc_maison($row->desc_maison)
                ->setFrais_eau($row->frais_eau)
                ->setFrais_electricite($row->frais_electricite)
                ->setFrais_vidange($row->frais_vidange)
                ->setTaxe($row->taxe)
                ->setFrais_tel($row->frais_tel)
                ->setRue($row->rue)
                ->setNum_maison($row->num_maison)
                ->setNum_police_electricite($row->num_police_electricite)
                ->setNum_compteur_eau($row->num_compteur_eau)
                ->setNum_ligne_tel($row->num_ligne_tel)
                ->setId_utilisateur($row->id_utilisateur)
                ->setQuartier($row->quartier)
                ->setCode_agence($row->code_agence)
				->setTel($row->tel)
				->setMontant_loyer($row->montant_loyer)
				->setAutre_charge($row->autre_charge);
        return $maison;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EUMAISON();
            $entry->setId_maison($row->id_maison)
                    ->setDesignation($row->designation)
                    ->setId_proprietaire($row->id_proprietaire)
                    ->setCode_membre($row->code_membre)
                    ->setType_maison($row->type_maison)
                    ->setCode_membre($row->code_membre)
                    ->setType_maison($row->type_maison)
                    ->setEau($row->eau)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setElectrifier($row->electrifier)
                    ->setType_maison($row->type_maison)
                    ->setWc_douche($row->wc_douche)
                    ->setStatut($row->statut)
                    ->setDesc_maison($row->desc_maison)
                    ->setFrais_eau($row->frais_eau)
                    ->setFrais_electricite($row->frais_electricite)
                    ->setFrais_vidange($row->frais_vidange)
                    ->setTaxe($row->taxe)
                    ->setFrais_tel($row->frais_tel)
                    ->setRue($row->rue)
                    ->setNum_maison($row->num_maison)
                    ->setNum_police_electricite($row->num_police_electricite)
                    ->setNum_compteur_eau($row->num_compteur_eau)
                    ->setNum_ligne_tel($row->num_ligne_tel)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setQuartier($row->quartier)
                    ->setCode_agence($row->code_agence)
					->setTel($row->tel)
				    ->setMontant_loyer($row->montant_loyer)
				    ->setAutre_charge($row->autre_charge)
            ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_maison) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EUMAISON $maison) {
        $data = array(
            'id_maison' => $maison->getId_maison(),
            'designation' => $maison->getDesignation(),
            'id_proprietaire' => $maison->getId_proprietaire(),
            'code_membre' => $maison->getCode_membre(),
            'type_maison' => $maison->getType_maison(),
            'eau' => $maison->getEau(),
            'date_enregistrement' => $maison->getDate_enregistrement(),
            'electrifier' => $maison->getElectrifier(),
            'wc_douche' => $maison->getWc_douche(),
            'statut' => $maison->getStatut(),
            'desc_maison' => $maison->getDesc_maison(),
            'frais_eau' => $maison->getFrais_eau(),
            'frais_electricite' => $maison->getFrais_electricite(),
            'frais_vidange' => $maison->getFrais_vidange(),
            'taxe' => $maison->getTaxe(),
            'frais_tel' => $maison->getFrais_tel(),
            'rue' => $maison->getRue(),
            'num_maison' => $maison->getNum_maison(),
            'num_police_electricite' => $maison->getNum_police_electricite(),
            'num_compteur_eau' => $maison->getNum_compteur_eau(),
            'num_ligne_tel' => $maison->getNum_ligne_tel(),
            'id_utilisateur' => $maison->getId_utilisateur(),
            'quartier' => $maison->getQuartier(),
            'code_agence' => $maison->getCode_agence(),
			'tel' => $maison->getTel(),
			'montant_loyer' => $maison->getMontant_loyer(),
			'autre_charge' => $maison->getAutre_charge()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EUMAISON $maison) {
        $data = array(
            'id_maison' => $maison->getId_maison(),
            'designation' => $maison->getDesignation(),
            'id_proprietaire' => $maison->getId_proprietaire(),
            'code_membre' => $maison->getCode_membre(),
            'type_maison' => $maison->getType_maison(),
            'eau' => $maison->getEau(),
            'date_enregistrement' => $maison->getDate_enregistrement(),
            'electrifier' => $maison->getElectrifier(),
            'wc_douche' => $maison->getWc_douche(),
            'statut' => $maison->getStatut(),
            'desc_maison' => $maison->getDesc_maison(),
            'frais_eau' => $maison->getFrais_eau(),
            'frais_electricite' => $maison->getFrais_electricite(),
            'frais_vidange' => $maison->getFrais_vidange(),
            'taxe' => $maison->getTaxe(),
            'frais_tel' => $maison->getFrais_tel(),
            'rue' => $maison->getRue(),
            'num_maison' => $maison->getNum_maison(),
            'num_police_electricite' => $maison->getNum_police_electricite(),
            'num_compteur_eau' => $maison->getNum_compteur_eau(),
            'num_ligne_tel' => $maison->getNum_ligne_tel(),
            'id_utilisateur' => $maison->getId_utilisateur(),
            'quartier' => $maison->getQuartier(),
            'code_agence' => $maison->getCode_agence(),
			'tel' => $maison->getTel(),
			'montant_loyer' => $maison->getMontant_loyer(),
			'autre_charge' => $maison->getAutre_charge()
        );
        $this->getDbTable()->update($data, array('id_maison = ?' => $maison->getId_maison()));
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

    public function delete($id_maison) {
        $this->getDbTable()->delete(array('id_maison = ?' => $id_maison));
    }

//////////////////////////////////////////////////////////////////////////////




}

?>
