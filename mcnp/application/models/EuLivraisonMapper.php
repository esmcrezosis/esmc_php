<?php
 
class Application_Model_EuLivraisonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLivraison');
        }
        return $this->_dbTable;
    }

    public function find($livraison_id, Application_Model_EuLivraison $livraison) {
        $result = $this->getDbTable()->find($livraison_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $livraison->setLivraison_id($row->livraison_id)
                ->setLivraison_libelle($row->livraison_libelle)
                ->setLivraison_code_produit($row->livraison_code_produit)
                ->setLivraison_montant($row->livraison_montant)
                ->setLivraison_description($row->livraison_description)
                ->setLivraison_code_membre($row->livraison_code_membre)
                ->setLivraison_date($row->livraison_date)
                ->setLivraison_utilisateur($row->livraison_utilisateur)
                	->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("livraison_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLivraison();
            $entry->setLivraison_id($row->livraison_id)
	                ->setLivraison_libelle($row->livraison_libelle)
                    ->setLivraison_code_produit($row->livraison_code_produit)
                    ->setLivraison_montant($row->livraison_montant)
                ->setLivraison_description($row->livraison_description)
	                ->setLivraison_code_membre($row->livraison_code_membre)
					->setLivraison_date($row->livraison_date)
                ->setLivraison_utilisateur($row->livraison_utilisateur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(livraison_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuLivraison $livraison) {
        $data = array(
            'livraison_id' => $livraison->getLivraison_id(),
            'livraison_libelle' => $livraison->getLivraison_libelle(),
            'livraison_code_produit' => $livraison->getLivraison_code_produit(),
            'livraison_montant' => $livraison->getLivraison_montant(),
            'livraison_description' => $livraison->getLivraison_description(),
            'livraison_code_membre' => $livraison->getLivraison_code_membre(),
            'livraison_date' => $livraison->getLivraison_date(),
            'livraison_utilisateur' => $livraison->getLivraison_utilisateur(),
            'publier' => $livraison->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuLivraison $livraison) {
        $data = array(
            'livraison_id' => $livraison->getLivraison_id(),
            'livraison_libelle' => $livraison->getLivraison_libelle(),
            'livraison_code_produit' => $livraison->getLivraison_code_produit(),
            'livraison_montant' => $livraison->getLivraison_montant(),
            'livraison_description' => $livraison->getLivraison_description(),
            'livraison_code_membre' => $livraison->getLivraison_code_membre(),
            'livraison_date' => $livraison->getLivraison_date(),
            'livraison_utilisateur' => $livraison->getLivraison_utilisateur(),
            'publier' => $livraison->getPublier()
        );
        $this->getDbTable()->update($data, array('livraison_id = ?' => $livraison->getLivraison_id()));
    }

    public function delete($livraison_id) {
        $this->getDbTable()->delete(array('livraison_id = ?' => $livraison_id));
    }


    public function fetchAllByCodeProduit($livraison_code_produit) {
        $select = $this->getDbTable()->select();
		$select->where("livraison_code_produit = ? ", $livraison_code_produit);
		$select->order("livraison_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLivraison();
            $entry->setLivraison_id($row->livraison_id)
	                ->setLivraison_libelle($row->livraison_libelle)
                    ->setLivraison_code_produit($row->livraison_code_produit)
                    ->setLivraison_montant($row->livraison_montant)
                ->setLivraison_description($row->livraison_description)
	                ->setLivraison_code_membre($row->livraison_code_membre)
					->setLivraison_date($row->livraison_date)
                ->setLivraison_utilisateur($row->livraison_utilisateur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembre0($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("livraison_code_membre = ? ", $code_membre);
		$select->order("livraison_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLivraison();
            $entry->setLivraison_id($row->livraison_id)
	                ->setLivraison_libelle($row->livraison_libelle)
                    ->setLivraison_code_produit($row->livraison_code_produit)
                    ->setLivraison_montant($row->livraison_montant)
                ->setLivraison_description($row->livraison_description)
	                ->setLivraison_code_membre($row->livraison_code_membre)
					->setLivraison_date($row->livraison_date)
                ->setLivraison_utilisateur($row->livraison_utilisateur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	

	




    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(livraison_id) as count'));
		$select->where("livraison_libelle LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(livraison_id) as count'));
		//$select->where("livraison_libelle = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }


    public function fetchAllByMembre($membre) {
        $select = $this->getDbTable()->select();
		$select->where("livraison_code_membre = ? ", $membre);
		$select->where("publier = ? ", 1);
		$select->order("livraison_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLivraison();
            $entry->setLivraison_id($row->livraison_id)
	                ->setLivraison_libelle($row->livraison_libelle)
                    ->setLivraison_code_produit($row->livraison_code_produit)
                    ->setLivraison_montant($row->livraison_montant)
                ->setLivraison_description($row->livraison_description)
	                ->setLivraison_code_membre($row->livraison_code_membre)
					->setLivraison_date($row->livraison_date)
                ->setLivraison_utilisateur($row->livraison_utilisateur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }




	
    public function fetchAllByPublier($publier, $code_agence = "") {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", $publier);
		if($code_agence != ""){
			$select->where("livraison_code_membre IN (SELECT code_membre_morale FROM eu_membre_morale WHERE code_agence LIKE '".$code_agence."')");
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLivraison();
            $entry->setLivraison_id($row->livraison_id)
	                ->setLivraison_libelle($row->livraison_libelle)
                    ->setLivraison_code_produit($row->livraison_code_produit)
                    ->setLivraison_montant($row->livraison_montant)
                ->setLivraison_description($row->livraison_description)
	                ->setLivraison_code_membre($row->livraison_code_membre)
					->setLivraison_date($row->livraison_date)
                ->setLivraison_utilisateur($row->livraison_utilisateur)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }




	

}


?>
