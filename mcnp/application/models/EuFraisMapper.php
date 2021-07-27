<?php

class Application_Model_EuFraisMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFrais');
        }
        return $this->_dbTable;
    }

    public function find($id_frais, Application_Model_EuFrais $frais) {
        $result = $this->getDbTable()->find($id_frais);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $frais->setId_frais($row->id_frais)
                ->setCode_gac($row->code_gac)
                ->setPourcent_frais($row->pourcent_frais)
                ->setMont_projet($row->mont_projet)
                ->setDate_frais($row->date_frais)
                ->setId_proposition($row->id_proposition)
                ->setDisponible($row->disponible)
				->setMontant_proposition($row->montant_proposition)
				->setMontant_salaire($row->montant_salaire)
				->setMontant_frais($row->montant_frais)
                ->setValider($row->valider)
                ->setId_utilisateur($row->id_utilisateur);
        return true;
    }

    public function findFraisByPropo($id_proposition, Application_Model_EuFrais $frais) {
        $select = $this->getDbTable()->select();
        $select->where('id_proposition = ?', $id_proposition);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $frais->setId_frais($row->id_frais)
              ->setCode_gac($row->code_gac)
              ->setPourcent_frais($row->pourcent_frais)
              ->setMont_projet($row->mont_projet)
              ->setDate_frais($row->date_frais)
              ->setId_proposition($row->id_proposition)
              ->setDisponible($row->disponible)
			  ->setMontant_proposition($row->montant_proposition)
			  ->setMontant_salaire($row->montant_salaire)
			  ->setMontant_frais($row->montant_frais)
              ->setValider($row->valider)
              ->setId_utilisateur($row->id_utilisateur);
        return true;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(id_frais) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFrais();
            $entry->setId_frais($row->id_frais)
                    ->setCode_gac($row->code_gac)
                    ->setPourcent_frais($row->pourcent_frais)
                    ->setMont_projet($row->mont_projet)
                    ->setDate_frais($row->date_frais)
                    ->setId_proposition($row->id_proposition)
					->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition)
					->setMontant_salaire($row->montant_salaire)
					->setMontant_frais($row->montant_frais)
					->setValider($row->valider)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuFrais $frais) {
        $data = array(
            'id_frais' => $frais->getId_frais(),
            'code_gac' => $frais->getCode_gac(),
            'pourcent_frais' => $frais->getPourcent_frais(),
            'mont_projet' => $frais->getMont_projet(),
            'date_frais' => $frais->getDate_frais(),
            'id_proposition' => $frais->getId_proposition(),
            'disponible' => $frais->getDisponible(),
            'montant_proposition' => $frais->getMontant_proposition(),
            'montant_salaire' => $frais->getMontant_salaire(),
            'montant_frais' => $frais->getMontant_frais(),
            'valider' => $frais->getValider(),
            'id_utilisateur' => $frais->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFrais $frais) {
        $data = array(
            'id_frais' => $frais->getId_frais(),
            'code_gac' => $frais->getCode_gac(),
            'pourcent_frais' => $frais->getPourcent_frais(),
            'mont_projet' => $frais->getMont_projet(),
            'date_frais' => $frais->getDate_frais(),
            'id_proposition' => $frais->getId_proposition(),
            'disponible' => $frais->getDisponible(),
            'montant_proposition' => $frais->getMontant_proposition(),
            'montant_salaire' => $frais->getMontant_salaire(),
            'montant_frais' => $frais->getMontant_frais(),
            'valider' => $frais->getValider(),
            'id_utilisateur' => $frais->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_frais = ?' => $frais->getId_frais()));
    }

    public function delete($id_frais) {
        $this->getDbTable()->delete(array('id_frais = ?' => $id_frais));
    }



    public function fetchAll2($code_membre) {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_proposition', 'eu_proposition.id_proposition = eu_frais.id_proposition');
		$select->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre');
		$select->join('eu_demande', 'eu_demande.id_demande = eu_appel_offre.id_demande');
		$select->where('eu_demande.code_membre_morale = ? ', $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFrais();
            $entry->setId_frais($row->id_frais)
                    ->setCode_gac($row->code_gac)
                    ->setPourcent_frais($row->pourcent_frais)
                    ->setMont_projet($row->mont_projet)
                    ->setDate_frais($row->date_frais)
                    ->setId_proposition($row->id_proposition)
					->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition + $row->autre_budget)
					->setMontant_salaire($row->montant_salaire)
					->setMontant_frais($row->montant_frais)
	                ->setValider($row->valider)
                    ->setId_utilisateur($row->id_demande);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll3() {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_proposition', 'eu_proposition.id_proposition = eu_frais.id_proposition');
		$select->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre');
		$select->join('eu_demande', 'eu_demande.id_demande = eu_appel_offre.id_demande');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFrais();
            $entry->setId_frais($row->id_frais)
                    ->setCode_gac($row->code_gac)
                    ->setPourcent_frais($row->pourcent_frais)
                    ->setMont_projet($row->mont_projet)
                    ->setDate_frais($row->date_frais)
                    ->setId_proposition($row->id_proposition)
					->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition + $row->autre_budget)
					->setMontant_salaire($row->montant_salaire)
					->setMontant_frais($row->montant_frais)
	                ->setValider($row->valider)
                    ->setId_utilisateur($row->id_demande);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function findValider($id_frais, Application_Model_EuFrais $frais) {
        $select = $this->getDbTable()->select();
        $select->where('id_frais = ?', $id_frais);
        $select->where('valider = ?', 1);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $frais->setId_frais($row->id_frais)
                ->setCode_gac($row->code_gac)
                ->setPourcent_frais($row->pourcent_frais)
                ->setMont_projet($row->mont_projet)
                ->setDate_frais($row->date_frais)
                ->setId_proposition($row->id_proposition)
                ->setDisponible($row->disponible)
				->setMontant_proposition($row->montant_proposition)
				->setMontant_salaire($row->montant_salaire)
				->setMontant_frais($row->montant_frais)
                ->setValider($row->valider)
                ->setId_utilisateur($row->id_utilisateur);
        return true;
    }

    public function fetchAll4($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_proposition', 'eu_proposition.id_proposition = eu_frais.id_proposition');
		$select->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre');
		$select->join('eu_demande', 'eu_demande.id_demande = eu_appel_offre.id_demande');
		
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_frais.code_gac');
		$select->where("eu_acteur.type_acteur = ? ", "gac_surveillance");
		
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

		$select->order(array("eu_frais.date_frais DESC"));

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFrais();
            $entry->setId_frais($row->id_frais)
                    ->setCode_gac($row->code_gac)
                    ->setPourcent_frais($row->pourcent_frais)
                    ->setMont_projet($row->mont_projet)
                    ->setDate_frais($row->date_frais)
                    ->setId_proposition($row->id_proposition)
					->setDisponible($row->disponible)
					->setMontant_proposition($row->montant_proposition + $row->autre_budget)
					->setMontant_salaire($row->montant_salaire)
					->setMontant_frais($row->montant_frais)
	                ->setValider($row->valider)
                    ->setId_utilisateur($row->id_demande);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
}
