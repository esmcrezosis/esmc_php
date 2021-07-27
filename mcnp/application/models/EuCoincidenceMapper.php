<?php

class Application_Model_EuCoincidenceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCoincidence');
        }
        return $this->_dbTable;
    }

    public function find($id_coincidence, Application_Model_EuCoincidence $coincidence) {
        $result = $this->getDbTable()->find($id_coincidence);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $coincidence->setId_coincidence($row->id_coincidence)
                 ->setType_bon_apporteur($row->type_bon_apporteur)
                 ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setDate_coincidence($row->date_coincidence)
                 ->setMontant_apporteur($row->montant_apporteur)
                 ->setMontant_beneficiaire($row->montant_beneficiaire)
                 ->setPublier($row->publier)
                 ->setCat_produit_apporteur($row->cat_produit_apporteur)
                 ->setCode_tegc_apporteur($row->code_tegc_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setCode_tegc_beneficiaire($row->code_tegc_beneficiaire)
                 ->setCode_apporteur($row->code_apporteur)
                 ->setCode_beneficiaire($row->code_beneficiaire)
                 ->setType_bon_beneficiaire($row->type_bon_beneficiaire)
                 ->setCat_produit_beneficiaire($row->cat_produit_beneficiaire)
                 ->setType_compte_apporteur($row->type_compte_apporteur)
                 ->setType_compte_beneficiaire($row->type_compte_beneficiaire)
                 ->setId_canton_apporteur($row->id_canton_apporteur)
                 ->setId_canton_beneficiaire($row->id_canton_beneficiaire)
				 ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCoincidence();
            $entry->setId_coincidence($row->id_coincidence)
                 ->setType_bon_apporteur($row->type_bon_apporteur)
                 ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setDate_coincidence($row->date_coincidence)
                 ->setMontant_apporteur($row->montant_apporteur)
                 ->setMontant_beneficiaire($row->montant_beneficiaire)
                 ->setPublier($row->publier)
                 ->setCat_produit_apporteur($row->cat_produit_apporteur)
                 ->setCode_tegc_apporteur($row->code_tegc_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setCode_tegc_beneficiaire($row->code_tegc_beneficiaire)
                 ->setCode_apporteur($row->code_apporteur)
                 ->setCode_beneficiaire($row->code_beneficiaire)
                 ->setType_bon_beneficiaire($row->type_bon_beneficiaire)
                 ->setCat_produit_beneficiaire($row->cat_produit_beneficiaire)
                 ->setType_compte_apporteur($row->type_compte_apporteur)
                 ->setType_compte_beneficiaire($row->type_compte_beneficiaire)
                 ->setId_canton_apporteur($row->id_canton_apporteur)
                 ->setId_canton_beneficiaire($row->id_canton_beneficiaire)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_coincidence) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuCoincidence $coincidence) {
        $data = array(
            'id_coincidence' => $coincidence->getId_coincidence(),
            'type_bon_apporteur' => $coincidence->getType_bon_apporteur(),
            'code_membre_apporteur' => $coincidence->getCode_membre_apporteur(),
            'date_coincidence' => $coincidence->getDate_coincidence(),
            'montant_apporteur' => $coincidence->getMontant_apporteur(),
            'montant_beneficiaire' => $coincidence->getMontant_beneficiaire(),
            'publier' => $coincidence->getPublier(),
            'cat_produit_apporteur' => $coincidence->getCat_produit_apporteur(),
            'code_tegc_apporteur' => $coincidence->getCode_tegc_apporteur(),
            'code_membre_beneficiaire' => $coincidence->getCode_membre_beneficiaire(),
            'code_tegc_beneficiaire' => $coincidence->getCode_tegc_beneficiaire(),
            'code_apporteur' => $coincidence->getCode_apporteur(),
            'code_beneficiaire' => $coincidence->getCode_beneficiaire(),
            'type_bon_beneficiaire' => $coincidence->getType_bon_beneficiaire(),
            'cat_produit_beneficiaire' => $coincidence->getCat_produit_beneficiaire(),
            'type_compte_apporteur' => $coincidence->getType_compte_apporteur(),
            'type_compte_beneficiaire' => $coincidence->getType_compte_beneficiaire(),
            'id_canton_apporteur' => $coincidence->getId_canton_apporteur(),
            'id_canton_beneficiaire' => $coincidence->getId_canton_beneficiaire()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCoincidence $coincidence) {
        $data = array(
            'id_coincidence' => $coincidence->getId_coincidence(),
            'type_bon_apporteur' => $coincidence->getType_bon_apporteur(),
            'code_membre_apporteur' => $coincidence->getCode_membre_apporteur(),
            'date_coincidence' => $coincidence->getDate_coincidence(),
            'montant_apporteur' => $coincidence->getMontant_apporteur(),
            'montant_beneficiaire' => $coincidence->getMontant_beneficiaire(),
            'publier' => $coincidence->getPublier(),
            'cat_produit_apporteur' => $coincidence->getCat_produit_apporteur(),
            'code_tegc_apporteur' => $coincidence->getCode_tegc_apporteur(),
            'code_membre_beneficiaire' => $coincidence->getCode_membre_beneficiaire(),
            'code_tegc_beneficiaire' => $coincidence->getCode_tegc_beneficiaire(),
            'code_apporteur' => $coincidence->getCode_apporteur(),
            'code_beneficiaire' => $coincidence->getCode_beneficiaire(),
            'type_bon_beneficiaire' => $coincidence->getType_bon_beneficiaire(),
            'cat_produit_beneficiaire' => $coincidence->getCat_produit_beneficiaire(),
            'type_compte_apporteur' => $coincidence->getType_compte_apporteur(),
            'type_compte_beneficiaire' => $coincidence->getType_compte_beneficiaire(),
            'id_canton_apporteur' => $coincidence->getId_canton_apporteur(),
            'id_canton_beneficiaire' => $coincidence->getId_canton_beneficiaire()
        );
        $this->getDbTable()->update($data, array('id_coincidence = ?' => $coincidence->getId_coincidence()));
    }

    public function delete($id_coincidence) {
        $this->getDbTable()->delete(array('id_coincidence = ?' => $id_coincidence));
    }


    

    public function fetchAllByApporteurBeneficiaire($code_membre_apporteur, $code_membre_beneficiaire) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_apporteur LIKE ? ", $code_membre_apporteur);
		$select->where("code_membre_beneficiaire LIKE ? ", $code_membre_beneficiaire);
        $select->order("id_coincidence DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCoincidence();
            $entry->setId_coincidence($row->id_coincidence)
                 ->setType_bon_apporteur($row->type_bon_apporteur)
                 ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setDate_coincidence($row->date_coincidence)
                 ->setMontant_apporteur($row->montant_apporteur)
                 ->setMontant_beneficiaire($row->montant_beneficiaire)
                 ->setPublier($row->publier)
                 ->setCat_produit_apporteur($row->cat_produit_apporteur)
                 ->setCode_tegc_apporteur($row->code_tegc_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setCode_tegc_beneficiaire($row->code_tegc_beneficiaire)
                 ->setCode_apporteur($row->code_apporteur)
                 ->setCode_beneficiaire($row->code_beneficiaire)
                 ->setType_bon_beneficiaire($row->type_bon_beneficiaire)
                 ->setCat_produit_beneficiaire($row->cat_produit_beneficiaire)
                 ->setType_compte_apporteur($row->type_compte_apporteur)
                 ->setType_compte_beneficiaire($row->type_compte_beneficiaire)
                 ->setId_canton_apporteur($row->id_canton_apporteur)
                 ->setId_canton_beneficiaire($row->id_canton_beneficiaire)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByApporteur($code_membre_apporteur) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_apporteur LIKE ? ", $code_membre_apporteur);
        $select->order("id_coincidence DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCoincidence();
            $entry->setId_coincidence($row->id_coincidence)
                 ->setType_bon_apporteur($row->type_bon_apporteur)
                 ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setDate_coincidence($row->date_coincidence)
                 ->setMontant_apporteur($row->montant_apporteur)
                 ->setMontant_beneficiaire($row->montant_beneficiaire)
                 ->setPublier($row->publier)
                 ->setCat_produit_apporteur($row->cat_produit_apporteur)
                 ->setCode_tegc_apporteur($row->code_tegc_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setCode_tegc_beneficiaire($row->code_tegc_beneficiaire)
                 ->setCode_apporteur($row->code_apporteur)
                 ->setCode_beneficiaire($row->code_beneficiaire)
                 ->setType_bon_beneficiaire($row->type_bon_beneficiaire)
                 ->setCat_produit_beneficiaire($row->cat_produit_beneficiaire)
                 ->setType_compte_apporteur($row->type_compte_apporteur)
                 ->setType_compte_beneficiaire($row->type_compte_beneficiaire)
                 ->setId_canton_apporteur($row->id_canton_apporteur)
                 ->setId_canton_beneficiaire($row->id_canton_beneficiaire)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllByBeneficiaire($code_membre_beneficiaire) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_beneficiaire LIKE ? ", $code_membre_beneficiaire);
		$select->order("id_coincidence DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCoincidence();
            $entry->setId_coincidence($row->id_coincidence)
                 ->setType_bon_apporteur($row->type_bon_apporteur)
                 ->setCode_membre_apporteur($row->code_membre_apporteur)
                 ->setDate_coincidence($row->date_coincidence)
                 ->setMontant_apporteur($row->montant_apporteur)
                 ->setMontant_beneficiaire($row->montant_beneficiaire)
                 ->setPublier($row->publier)
                 ->setCat_produit_apporteur($row->cat_produit_apporteur)
                 ->setCode_tegc_apporteur($row->code_tegc_apporteur)
                 ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                 ->setCode_tegc_beneficiaire($row->code_tegc_beneficiaire)
                 ->setCode_apporteur($row->code_apporteur)
                 ->setCode_beneficiaire($row->code_beneficiaire)
                 ->setType_bon_beneficiaire($row->type_bon_beneficiaire)
                 ->setCat_produit_beneficiaire($row->cat_produit_beneficiaire)
                 ->setType_compte_apporteur($row->type_compte_apporteur)
                 ->setType_compte_beneficiaire($row->type_compte_beneficiaire)
                 ->setId_canton_apporteur($row->id_canton_apporteur)
                 ->setId_canton_beneficiaire($row->id_canton_beneficiaire)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
}

?>
