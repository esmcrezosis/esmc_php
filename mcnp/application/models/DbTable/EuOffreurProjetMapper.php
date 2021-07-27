<?php
 
class Application_Model_EuOffreurProjetMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuOffreurProjet');
        }
        return $this->_dbTable;
    }

    public function find($offreur_projet_id, Application_Model_EuOffreurProjet $offreur_projet) {
        $result = $this->getDbTable()->find($offreur_projet_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offreur_projet->setOffreur_projet_id($row->offreur_projet_id)
                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                ->setOffreur_projet_adresse($row->offreur_projet_adresse)
				->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
                ->setOffreur_projet_produit($row->offreur_projet_produit)
                ->setOffreur_projet_type($row->offreur_projet_type)
                ->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("offreur_projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(offreur_projet_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuOffreurProjet $offreur_projet) {
        $data = array(
            'offreur_projet_id' => $offreur_projet->getOffreur_projet_id(),
            'offreur_projet_souscription' => $offreur_projet->getOffreur_projet_souscription(),
            'offreur_projet_adresse' => $offreur_projet->getOffreur_projet_adresse(),
        	'offreur_projet_canton' => $offreur_projet->getOffreurProjetCanton(),
        	'offreur_projet_ville' => $offreur_projet->getOffreurProjetVille(),
                'offreur_projet_fournisseur' => $offreur_projet->getOffreurProjetFournisseur(),
                'offreur_projet_raison_sociale' => $offreur_projet->getOffreur_projet_raison_sociale(),
	        'offreur_projet_code_membre' => $offreur_projet->getOffreur_projet_code_membre(),
            'offreur_projet_produit' => $offreur_projet->getOffreur_projet_produit(),
            'offreur_projet_type' => $offreur_projet->getOffreur_projet_type(),
            'offreur_projet_date' => $offreur_projet->getOffreur_projet_date(),
            'offreur_projet_operationnel' => $offreur_projet->getOffreur_projet_operationnel(),
            'offreur_projet_capacite_production' => $offreur_projet->getOffreur_projet_capacite_production(),
            'offreur_projet_stock_disponible' => $offreur_projet->getOffreur_projet_stock_disponible(),
            'offreur_projet_membreasso' => $offreur_projet->getOffreur_projet_membreasso(),
            'offreur_projet_qte_max' => $offreur_projet->getOffreur_projet_qte_max(),
            'offreur_projet_qte_moyen' => $offreur_projet->getOffreur_projet_qte_moyen(),
            'offreur_projet_qte_min' => $offreur_projet->getOffreur_projet_qte_min(),
            'offreur_projet_nom_entrepot' => $offreur_projet->getOffreur_projet_nom_entrepot(),
            'offreur_projet_adresse_entrepot' => $offreur_projet->getOffreur_projet_adresse_entrepot(),
            'offreur_projet_description_projet' => $offreur_projet->getOffreur_projet_description_projet(),
            'publier' => $offreur_projet->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuOffreurProjet $offreur_projet) {
        $data = array(
            'offreur_projet_id' => $offreur_projet->getOffreur_projet_id(),
            'offreur_projet_souscription' => $offreur_projet->getOffreur_projet_souscription(),
            'offreur_projet_adresse' => $offreur_projet->getOffreur_projet_adresse(),
        	'offreur_projet_canton' => $offreur_projet->getOffreurProjetCanton(),
        	'offreur_projet_ville' => $offreur_projet->getOffreurProjetVille(),
             'offreur_projet_fournisseur' => $offreur_projet->getOffreurProjetFournisseur(),
            'offreur_projet_raison_sociale' => $offreur_projet->getOffreur_projet_raison_sociale(),
			'offreur_projet_code_membre' => $offreur_projet->getOffreur_projet_code_membre(),
            'offreur_projet_produit' => $offreur_projet->getOffreur_projet_produit(),
            'offreur_projet_type' => $offreur_projet->getOffreur_projet_type(),
            'offreur_projet_date' => $offreur_projet->getOffreur_projet_date(),
            'offreur_projet_operationnel' => $offreur_projet->getOffreur_projet_operationnel(),
            'offreur_projet_capacite_production' => $offreur_projet->getOffreur_projet_capacite_production(),
            'offreur_projet_stock_disponible' => $offreur_projet->getOffreur_projet_stock_disponible(),
            'offreur_projet_membreasso' => $offreur_projet->getOffreur_projet_membreasso(),
            'offreur_projet_qte_max' => $offreur_projet->getOffreur_projet_qte_max(),
            'offreur_projet_qte_moyen' => $offreur_projet->getOffreur_projet_qte_moyen(),
            'offreur_projet_qte_min' => $offreur_projet->getOffreur_projet_qte_min(),
            'offreur_projet_nom_entrepot' => $offreur_projet->getOffreur_projet_nom_entrepot(),
            'offreur_projet_adresse_entrepot' => $offreur_projet->getOffreur_projet_adresse_entrepot(),
            'offreur_projet_description_projet' => $offreur_projet->getOffreur_projet_description_projet(),
            'publier' => $offreur_projet->getPublier()
        );
        $this->getDbTable()->update($data, array('offreur_projet_id = ?' => $offreur_projet->getOffreur_projet_id()));
    }

    public function delete($offreur_projet_id) {
        $this->getDbTable()->delete(array('offreur_projet_id = ?' => $offreur_projet_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("offreur_projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	
	public function fetchAllByMembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where("offreur_projet_code_membre = ? ", $code_membre);
	   $resultSet = $this->getDbTable()->fetchAll($select);
	   if (0 == count($resultSet)) {
          return false;
       }
	   $entries = array();
	   foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	              ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                  ->setOffreur_projet_adresse($row->offreur_projet_adresse)
			      ->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                  ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
	              ->setOffreur_projet_produit($row->offreur_projet_produit)
				  ->setOffreur_projet_type($row->offreur_projet_type)
				  ->setOffreur_projet_date($row->offreur_projet_date)
                  ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                  ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                  ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                  ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                  ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                  ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                  ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                  ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                  ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                  ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                  ->setOffreurProjetCanton($row->offreur_projet_canton)
                  ->setOffreurProjetVille($row->offreur_projet_ville)
                 ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                  ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
	}

	
	
	
    public function fetchAllByOffreurProjetType($offreur_projet_type) {
        $select = $this->getDbTable()->select();
		$select->where("offreur_projet_type = ? ", $offreur_projet_type);
		$select->where("publier = ? ", 1);
		$select->order("offreur_projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("offreur_projet_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("offreur_projet_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
    public function fetchAllByPublier($publier, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		if($code_agence != "") {
		  $select->where("offreur_projet_souscription IN (SELECT souscription_id FROM eu_souscription WHERE souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association IN (SELECT association_id FROM eu_association WHERE code_agence LIKE '".$code_agence."'))");
		}
		$select->order(array("offreur_projet_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	

    public function fetchAllByMembreasso($offreur_projet_membreasso) {
        $select = $this->getDbTable()->select();
		$select->where("offreur_projet_membreasso = ? ", $offreur_projet_membreasso);
		$select->order(array("offreur_projet_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByAssociation($association) {
        $select = $this->getDbTable()->select();
		$select->where("offreur_projet_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association);
		$select->order(array("offreur_projet_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllBySouscription($offreur_projet_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("offreur_projet_souscription = ?", $offreur_projet_souscription);
		$select->order(array("offreur_projet_id DESC"));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
	                ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
					->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
	                ->setOffreur_projet_produit($row->offreur_projet_produit)
					->setOffreur_projet_type($row->offreur_projet_type)
					->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                	->setPublier($row->publier);
			$entries = $entry;
        return $entries;
    }
	
	
    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MONTH(offreur_projet_date) as MOIS, YEAR(offreur_projet_date) as ANNEE'));
		$select->distinct();
		$select->where("publier = ? ", 1);
		$select->order(array("offreur_projet_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['MOIS'] = $row['MOIS'];
		$entry['ANNEE'] = $row['ANNEE'];
            $entries[] = $entry;
        }
        return $entries;
    }






    public function fetchAllByTableauBord($publier, $offreur_projet_type = 0, $offreur_projet_membreasso = 0, $offreur_projet_association = 0, $offreur_projet_code_membre = "", $offreur_projet_produit = "", $offreur_projet_ville = 0, $offreur_projet_canton = 0, $id_prefecture = 0, $id_region = 0, $id_pays = 0, $code_zone = "", $offreur_projet_date1 = "", $offreur_projet_date2 = "") {
        $select = $this->getDbTable()->select();
        $select->where("publier = ? ", $publier);
        if($offreur_projet_type > 0) {
            $select->where("offreur_projet_type = ? ", $offreur_projet_type);
        }
        if($offreur_projet_code_membre != "") {
            $select->where("offreur_projet_code_membre LIKE '%".$offreur_projet_code_membre."%' ");
        }
        if($offreur_projet_produit != "") {
            $select->where("offreur_projet_produit LIKE '%".$offreur_projet_produit."%' ");
        }
        if($offreur_projet_association != ""){
        $select->where("offreur_projet_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ? )", $offreur_projet_association);  
        }
        if($offreur_projet_membreasso > 0){
        $select->where("offreur_projet_membreasso = ? ", $offreur_projet_membreasso);  
        }
        if($offreur_projet_ville > 0) {
          $select->where("offreur_projet_ville = ? ", $offreur_projet_ville);
        }
        if($offreur_projet_canton > 0) {
          $select->where("offreur_projet_canton = ? ", $offreur_projet_canton);
        }
        if($id_prefecture > 0) {
          $select->where("offreur_projet_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture = ?)", $id_prefecture);
        }
        if($id_region > 0) {
          $select->where("offreur_projet_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region = ?))", $id_region);
        }
        if($id_pays > 0) {
          $select->where("offreur_projet_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays = ?)))", $id_pays);
        }
        if($code_zone != "") {
          $select->where("offreur_projet_canton IN (SELECT id_canton FROM eu_canton WHERE id_prefecture IN (SELECT id_prefecture FROM eu_prefecture WHERE id_region IN (SELECT id_region FROM eu_region WHERE id_pays IN (SELECT id_pays FROM eu_pays WHERE code_zone = '?'))))", $code_zone);
        }
            
        $select->where("(offreur_projet_date) BETWEEN  '".$offreur_projet_date1."' AND '".$offreur_projet_date2."' ");  
        
        $select->order("offreur_projet_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreurProjet();
            $entry->setOffreur_projet_id($row->offreur_projet_id)
                    ->setOffreur_projet_souscription($row->offreur_projet_souscription)
                    ->setOffreur_projet_adresse($row->offreur_projet_adresse)
                    ->setOffreur_projet_raison_sociale($row->offreur_projet_raison_sociale)
                    ->setOffreur_projet_code_membre($row->offreur_projet_code_membre)
                    ->setOffreur_projet_produit($row->offreur_projet_produit)
                    ->setOffreur_projet_type($row->offreur_projet_type)
                    ->setOffreur_projet_date($row->offreur_projet_date)
                ->setOffreur_projet_operationnel($row->offreur_projet_operationnel)
                ->setOffreur_projet_capacite_production($row->offreur_projet_capacite_production)
                ->setOffreur_projet_stock_disponible($row->offreur_projet_stock_disponible)
                ->setOffreur_projet_membreasso($row->offreur_projet_membreasso)
                ->setOffreur_projet_qte_max($row->offreur_projet_qte_max)
                ->setOffreur_projet_qte_moyen($row->offreur_projet_qte_moyen)
                ->setOffreur_projet_qte_min($row->offreur_projet_qte_min)
                ->setOffreur_projet_nom_entrepot($row->offreur_projet_nom_entrepot)
                ->setOffreur_projet_adresse_entrepot($row->offreur_projet_adresse_entrepot)
                ->setOffreur_projet_description_projet($row->offreur_projet_description_projet)
                ->setOffreurProjetCanton($row->offreur_projet_canton)
                ->setOffreurProjetVille($row->offreur_projet_ville)
                ->setOffreurProjetFournisseur($row->offreur_projet_fournisseur)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }






}


?>
