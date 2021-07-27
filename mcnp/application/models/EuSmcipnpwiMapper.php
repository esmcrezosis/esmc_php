<?php

class Application_Model_EuSmcipnpwiMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuSmcipnpwi');
        }
        return $this->_dbTable;
    }

    public function findmtsalaire($code) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('montant_salaire'));
        $select->where('code_smcipn = ?', $code);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['montant_salaire'];
    }

    public function findmtinvesti($code) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('montant_investis'));
        $select->where('code_smcipn = ?', $code);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['montant_investis'];
    }

    public function getLastCodeByMembre($code_membre, $type) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_smcipn) as code'));
        $select->where('code_membre LIKE ?', $code_membre);
        $select->where('type_smcipn LIKE ?', $type);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function save(Application_Model_EuSmcipnpwi $smcipn) {
        $data = array(
            'code_smcipn' => $smcipn->getCode_smcipn(),
            'code_membre' => $smcipn->getCode_membre(),
            'date_smcipn' => $smcipn->getDate_smcipn(),
            'mont_salaire' => $smcipn->getMont_salaire(),
            'mont_investis' => $smcipn->getMont_investis(),
            'salaire_alloue' => $smcipn->getSalaire_alloue(),
            'investis_alloue' => $smcipn->getInvestis_alloue(),
            'type_smcipn' => $smcipn->getType_smcipn(),
            'rembourser' => $smcipn->getRembourser(),
            'etat_alloc_salaire' => $smcipn->getEtat_alloc_salaire(),
            'etat_alloc_investis' => $smcipn->getEtat_alloc_investis(),
            'id_utilisateur' => $smcipn->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmcipnpwi $smcipn) {
        $data = array(
            'code_smcipn' => $smcipn->getCode_smcipn(),
            'code_membre' => $smcipn->getCode_membre(),
            'date_smcipn' => $smcipn->getDate_smcipn(),
            'mont_salaire' => $smcipn->getMont_salaire(),
            'mont_investis' => $smcipn->getMont_investis(),
            'salaire_alloue' => $smcipn->getSalaire_alloue(),
            'investis_alloue' => $smcipn->getInvestis_alloue(),
            'type_smcipn' => $smcipn->getType_smcipn(),
            'rembourser' => $smcipn->getRembourser(),
            'etat_alloc_salaire' => $smcipn->getEtat_alloc_salaire(),
            'etat_alloc_investis' => $smcipn->getEtat_alloc_investis(),
            'id_utilisateur' => $smcipn->getId_utilisateur()
        );

        $this->getDbTable()->update($data, array('code_smcipn = ?' => $smcipn->getCode_smcipn()));
    }

    public function find($code_smcipn, Application_Model_EuSmcipnpwi $smcipn) {
        $result = $this->getDbTable()->find($code_smcipn);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smcipn->setCode_smcipn($row->code_smcipn)
                ->setCode_membre($row->code_membre)
                ->setDate_smcipn($row->date_smcipn)
                ->setMont_salaire($row->mont_salaire)
                ->setMont_investis($row->mont_investis)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setInvestis_alloue($row->investis_alloue)
                ->setType_smcipn($row->type_smcipn)
                ->setRembourser($row->rembourser)
                ->setEtat_alloc_salaire($row->etat_alloc_salaire)
                ->setEtat_alloc_investis($row->etat_alloc_investis)
                ->setId_utilisateur($row->id_utilisateur);
        return true;
    }

    public function findByMembre($membre, Application_Model_EuSmcipnpwi $smcipn) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $membre)
                ->where('rembourser = ?', 0);
        $result = $this->getDbTable->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smcipn->setCode_smcipn($row->code_smcipn)
                ->setCode_membre($row->code_membre)
                ->setDate_smcipn($row->date_smcipn)
                ->setMont_salaire($row->mont_salaire)
                ->setMont_investis($row->mont_investis)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setInvestis_alloue($row->investis_alloue)
                ->setType_smcipn($row->type_smcipn)
                ->setRembourser($row->rembourser)
                ->setEtat_alloc_salaire($row->etat_alloc_salaire)
                ->setEtat_alloc_investis($row->etat_alloc_investis)
                ->setId_utilisateur($row->id_utilisateur);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmcipnpwi();
            $entry->setCode_smcipn($row->code_smcipn)
                    ->setCode_membre($row->code_membre)
                    ->setDate_smcipn($row->date_smcipn)
                    ->setMont_salaire($row->mont_salaire)
                    ->setMont_investis($row->mont_investis)
                    ->setSalaire_alloue($row->salaire_alloue)
                    ->setInvestis_alloue($row->investis_alloue)
                    ->setType_smcipn($row->type_smcipn)
                    ->setRembourser($row->rembourser)
                    ->setEtat_alloc_salaire($row->etat_alloc_salaire)
                    ->setEtat_alloc_investis($row->etat_alloc_investis)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_smcipn) {
        $this->getDbTable()->delete(array('code_smcipn = ?' => $code_smcipn));
    }


    public function findByAO($id_appel_offre) {
	    $tabela = new Application_Model_DbTable_EuSmcipnpwi();
		$select = $tabela->select();
        $select->where('numero_appel = ?', $id_appel_offre);
        $result = $tabela->fetchAll($select);
		
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
		$smcipn = new Application_Model_EuSmcipnpwi();
        $smcipn->setCode_smcipn($row->code_smcipn)
                ->setCode_membre($row->code_membre)
                ->setDate_smcipn($row->date_smcipn)
                ->setMont_salaire($row->mont_salaire)
                ->setMont_investis($row->mont_investis)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setInvestis_alloue($row->investis_alloue)
                ->setType_smcipn($row->type_smcipn)
                ->setRembourser($row->rembourser)
                ->setEtat_alloc_salaire($row->etat_alloc_salaire)
                ->setEtat_alloc_investis($row->etat_alloc_investis)
                ->setId_utilisateur($row->id_utilisateur);
        return $smcipn;
    }
	
	
	
	
	
	
	
	
	
}

?>
