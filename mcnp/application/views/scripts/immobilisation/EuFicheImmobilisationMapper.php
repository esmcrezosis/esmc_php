<?php

class Application_Model_EuFicheImmobilisationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFicheImmobilisation');
        }
        return $this->_dbTable;
    }
    
    public function find($id_fiche_immobilisation, Application_Model_EuFicheImmobilisation $immobilisation) {
        $result = $this->getDbTable()->find($id_fiche_immobilisation);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $immobilisation->setId_fiche_immobilisation($row->id_fiche_immobilisation)
                       ->setDesignation_immobilisation($row->designation_immobilisation)
	                   ->setNature_immobilisation($row->nature_immobilisation)
	                   ->setFamille_immobilisation($row->famille_immobilisation)
	                   ->setCode_identification($row->code_identification)
	                   ->setLieu_affectation($row->lieu_affectation)
	                   ->setDate_entree($row->date_entree)
                       ->setValeur_acquisition($row->valeur_acquisition)
                       ->setSource_financement($row->source_financement)
                       ->setDate_sortie($row->date_sortie)
                       ->setEtat_utilisation($row->etat_utilisation)
                       ->setObservations($row->observations)
					   ->setId_pvacquisition($row->id_pvacquisition)
					   ->setId_pvrestitution($row->id_pvrestitution)
					   ->setRestituer($row->restituer)
					   ->setDate_codification($row->date_codification)
					   ->setDate_creation($row->date_creation)
					   ->setTraiter($row->traiter);    
    }
	
	
	public function findByCodeIdentification($code_identification)  {
		$table = new Application_Model_DbTable_EuFicheImmobilisation;
        $select = $table->select();
        $select->where('code_identification like ?',$code_identification);
        $result = $table->fetchAll($select);
        if(0 == count($result)) {
            return false;
        }
        $row = $result->current();
		$immobilisation = new Application_Model_EuFicheImmobilisation();
		$immobilisation->setId_fiche_immobilisation($row->id_fiche_immobilisation)
                       ->setDesignation_immobilisation($row->designation_immobilisation)
	                   ->setNature_immobilisation($row->nature_immobilisation)
	                   ->setFamille_immobilisation($row->famille_immobilisation)
	                   ->setCode_identification($row->code_identification)
	                   ->setLieu_affectation($row->lieu_affectation)
	                   ->setDate_entree($row->date_entree)
                       ->setValeur_acquisition($row->valeur_acquisition)
                       ->setSource_financement($row->source_financement)
                       ->setDate_sortie($row->date_sortie)
                       ->setEtat_utilisation($row->etat_utilisation)
                       ->setObservations($row->observations)
					   ->setId_pvacquisition($row->id_pvacquisition)
					   ->setId_pvrestitution($row->id_pvrestitution)
					   ->setRestituer($row->restituer)
					   ->setDate_codification($row->date_codification)
					   ->setDate_creation($row->date_creation)
					   ->setTraiter($row->traiter);
		
		return $immobilisation;
	}
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFicheImmobilisation();
            $entry->setId_fiche_immobilisation($row->id_fiche_immobilisation)
                    ->setDesignation_immobilisation($row->designation_immobilisation)
                    ->setNature_immobilisation($row->nature_immobilisation)
                    ->setFamille_immobilisation($row->famille_immobilisation)
                    ->setCode_identification($row->code_identification)
                    ->setLieu_affectation($row->lieu_affectation)
                    ->setDate_entree($row->date_entree)
                    ->setValeur_acquisition($row->valeur_acquisition)
                    ->setSource_financement($row->source_financement)
                    ->setDate_sortie($row->date_sortie)
                    ->setEtat_utilisation($row->etat_utilisation)
                    ->setObservations($row->observations)
					->setId_pvacquisition($row->id_pvacquisition)
					->setId_pvrestitution($row->id_pvrestitution)
					->setRestituer($row->restituer)
					->setDate_codification($row->date_codification)
					->setDate_creation($row->date_creation)
					->setTraiter($row->traiter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuFicheImmobilisation $immobilisation) {
        $data = array(
            'id_fiche_immobilisation' => $immobilisation->getId_fiche_immobilisation(),
            'designation_immobilisation' => $immobilisation->getDesignation_immobilisation(),
            'nature_immobilisation' => $immobilisation->getNature_immobilisation(),
            'famille_immobilisation' => $immobilisation->getfamille_immobilisation(),
            'code_identification' => $immobilisation->getCode_identification(),
            'lieu_affectation' => $immobilisation->getLieu_affectation(),
            'date_entree' => $immobilisation->getDate_entree(),
            'valeur_acquisition' => $immobilisation->getValeur_acquisition(),
            'source_financement' => $immobilisation->getSource_financement(),
            'date_sortie' => $immobilisation->getDate_sortie(),
            'etat_utilisation' => $immobilisation->getEtat_utilisation(),
            'observations' => $immobilisation->getObservations(),
			'id_pvacquisition' => $immobilisation->getId_pvacquisition(),
			'id_pvrestitution' => $immobilisation->getId_pvrestitution(),
			'date_codification' => $immobilisation->getDate_codification(),
			'date_creation' => $immobilisation->getDate_creation(),
			'traiter' => $immobilisation->getTraiter(),
			'restituer' => $immobilisation->getRestituer()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFicheimmobilisation $immobilisation) {
        $data = array(
            'id_fiche_immobilisation' => $immobilisation->getId_fiche_immobilisation(),
            'designation_immobilisation' => $immobilisation->getDesignation_immobilisation(),
            'nature_immobilisation' => $immobilisation->getNature_immobilisation(),
            'famille_immobilisation' => $immobilisation->getfamille_immobilisation(),
            'code_identification' => $immobilisation->getCode_identification(),
            'lieu_affectation' => $immobilisation->getLieu_affectation(),
            'date_entree' => $immobilisation->getDate_entree(),
            'valeur_acquisition' => $immobilisation->getValeur_acquisition(),
            'source_financement' => $immobilisation->getSource_financement(),
            'date_sortie' => $immobilisation->getDate_sortie(),
            'etat_utilisation' => $immobilisation->getEtat_utilisation(),
            'observations' => $immobilisation->getObservations(),
			'id_pvacquisition' => $immobilisation->getId_pvacquisition(),
			'id_pvrestitution' => $immobilisation->getId_pvrestitution(),
			'date_codification' => $immobilisation->getDate_codification(),
			'date_creation' => $immobilisation->getDate_creation(),
			'traiter' => $immobilisation->getTraiter(),
			'restituer' => $immobilisation->getRestituer()
        );
        $this->getDbTable()->update($data, array('id_fiche_immobilisation = ?' => $immobilisation->getId_fiche_immobilisation()));
    }
    
    public function delete($id_fiche_immobilisation) {
        $this->getDbTable()->delete(array('id_fiche_immobilisation = ?' => $id_fiche_immobilisation));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fiche_immobilisation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>