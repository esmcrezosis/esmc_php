<?php

class Application_Model_EuOffreDemandeClotureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuOffreDemandeCloture');
        }
        return $this->_dbTable;
    }

    public function find($id_cloture, Application_Model_EuOffreDemandeCloture $offre_demande_cloture) {
        $result = $this->getDbTable()->find($id_cloture);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_cloture->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeCloture();
            $entry->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_cloture) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuOffreDemandeCloture $offre_demande_cloture) {
        $data = array(
            'id_cloture' => $offre_demande_cloture->getId_cloture(),
            'id_offre' => $offre_demande_cloture->getId_offre(),
            'id_demande' => $offre_demande_cloture->getId_demande(),
            'date_cloture' => $offre_demande_cloture->getDate_cloture(),
            'montant_offre' => $offre_demande_cloture->getMontant_offre(),
            'montant_demande' => $offre_demande_cloture->getMontant_demande(),
            'cloture' => $offre_demande_cloture->getCloture(),
            'id_credit_offre' => $offre_demande_cloture->getId_credit_offre(),
            'id_credit_demande' => $offre_demande_cloture->getId_credit_demande(),
            'code_membre_offre' => $offre_demande_cloture->getCode_membre_offre(),
            'code_membre_demande' => $offre_demande_cloture->getCode_membre_demande(),
            'code_compte_offre' => $offre_demande_cloture->getCode_compte_offre(),
            'code_compte_demande' => $offre_demande_cloture->getCode_compte_demande(),
            'cloture_membre' => $offre_demande_cloture->getCloture_membre(),
            'num_offre_demande' => $offre_demande_cloture->getNum_offre_demande(),
            'code_sms_offre' => $offre_demande_cloture->getCode_sms_offre(),
            'code_sms_demande' => $offre_demande_cloture->getCode_sms_demande()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuOffreDemandeCloture $offre_demande_cloture) {
        $data = array(
            'id_cloture' => $offre_demande_cloture->getId_cloture(),
            'id_offre' => $offre_demande_cloture->getId_offre(),
            'id_demande' => $offre_demande_cloture->getId_demande(),
            'date_cloture' => $offre_demande_cloture->getDate_cloture(),
            'montant_offre' => $offre_demande_cloture->getMontant_offre(),
            'montant_demande' => $offre_demande_cloture->getMontant_demande(),
            'cloture' => $offre_demande_cloture->getCloture(),
            'id_credit_offre' => $offre_demande_cloture->getId_credit_offre(),
            'id_credit_demande' => $offre_demande_cloture->getId_credit_demande(),
            'code_membre_offre' => $offre_demande_cloture->getCode_membre_offre(),
            'code_membre_demande' => $offre_demande_cloture->getCode_membre_demande(),
            'code_compte_offre' => $offre_demande_cloture->getCode_compte_offre(),
            'code_compte_demande' => $offre_demande_cloture->getCode_compte_demande(),
            'cloture_membre' => $offre_demande_cloture->getCloture_membre(),
            'num_offre_demande' => $offre_demande_cloture->getNum_offre_demande(),
            'code_sms_offre' => $offre_demande_cloture->getCode_sms_offre(),
            'code_sms_demande' => $offre_demande_cloture->getCode_sms_demande()
        );
        $this->getDbTable()->update($data, array('id_cloture = ?' => $offre_demande_cloture->getId_cloture()));
    }

    public function delete($id_cloture) {
        $this->getDbTable()->delete(array('id_cloture = ?' => $id_cloture));
    }


    public function fetchAllByOffre($id_offre, Application_Model_EuOffreDemandeCloture $offre_demande_cloture) {
        $select = $this->getDbTable()->select();
		$select->where("id_offre = ? ", $id_offre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_cloture->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
    }
    
    public function fetchAllByDemande($id_demande, Application_Model_EuOffreDemandeCloture $offre_demande_cloture) {
        $select = $this->getDbTable()->select();
		$select->where("id_demande = ? ", $id_demande);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande_cloture->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
    }

    public function fetchAllByOffreDemande($id_offre, $id_demande) {
        $select = $this->getDbTable()->select();
		$select->where("id_offre = ? ", $id_offre);
		$select->where("id_demande = ? ", $id_demande);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeCloture();
            $entry->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByMembre($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("id_demande IN (SELECT id_offre_demande FROM eu_offre_demande WHERE code_membre LIKE ? )", $code_membre);
		$select->orwhere("id_offre  IN (SELECT id_offre_demande FROM eu_offre_demande WHERE code_membre LIKE ? )", $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeCloture();
            $entry->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function findBySMS($codesms) {
        $select = $this->getDbTable()->select();
        $select->where('code_sms_offre LIKE ?', $codesms)
               ->orwhere('code_sms_demande LIKE ?', $codesms)
			   ->where('cloture IN (?)', array(2, 3))
			   ;
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $entry = new Application_Model_EuOffreDemandeCloture();
            $entry->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
            return $entry;
        } else {
            return NULL;
        }
    }

    public function fetchAllByOffre2($id_offre) {
        $select = $this->getDbTable()->select();
		$select->where("id_offre = ? ", $id_offre);
		$select->order("id_cloture DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeCloture();
            $entry->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByDemande2($id_demande) {
        $select = $this->getDbTable()->select();
		$select->where("id_demande = ? ", $id_demande);
		$select->order("id_cloture DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemandeCloture();
            $entry->setId_cloture($row->id_cloture)
                 ->setId_offre($row->id_offre)
                 ->setId_demande($row->id_demande)
                 ->setDate_cloture($row->date_cloture)
                 ->setMontant_offre($row->montant_offre)
                 ->setMontant_demande($row->montant_demande)
                 ->setCloture($row->cloture)
                 ->setId_credit_offre($row->id_credit_offre)
                 ->setId_credit_demande($row->id_credit_demande)
                 ->setCode_membre_offre($row->code_membre_offre)
                 ->setCode_membre_demande($row->code_membre_demande)
                 ->setCode_compte_offre($row->code_compte_offre)
                 ->setCode_compte_demande($row->code_compte_demande)
                 ->setCloture_membre($row->cloture_membre)
                 ->setNum_offre_demande($row->num_offre_demande)
                 ->setCode_sms_offre($row->code_sms_offre)
                 ->setCode_sms_demande($row->code_sms_demande)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
}

?>
