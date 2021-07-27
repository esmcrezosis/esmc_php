<?php

class Application_Model_EuFactureSmcipnDetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFactureSmcipnDetail');
        }
        return $this->_dbTable;
    }

    public function find($id_facture_detail, Application_Model_EuFactureSmcipnDetail $fact) {
        $result = $this->getDbTable()->find($id_facture_detail);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $fact->setId_facture_detail($row->id_facture_detail)
                ->setCode_facture($row->code_facture)
                ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                ->setMont_investis($row->mont_investis)
                ->setInvestis_alloue($row->investis_alloue)
                ->setSolde_investis($row->solde_investis)
                ->setCode_membre_salarier($row->code_membre_salarier)
                ->setMont_salaire($row->mont_salaire)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setSolde_salaire($row->solde_salaire);
    }

    public function findByFactureFournis($code_facture, $code_membre_fournis) {
        $select = $this->getDbTable()->select();
        $select->where('code_facture = ?', $code_facture);
        $select->where('code_membre_fournisseur = ?', $code_membre_fournis);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $entry = new Application_Model_EuFactureSmcipnDetail();
        $entry->setId_facture_detail($row->id_facture_detail)
                ->setCode_facture($row->code_facture)
                ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                ->setMont_investis($row->mont_investis)
                ->setInvestis_alloue($row->investis_alloue)
                ->setSolde_investis($row->solde_investis)
                ->setCode_membre_salarier($row->code_membre_salarier)
                ->setMont_salaire($row->mont_salaire)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setSolde_salaire($row->solde_salaire);
        return $entry;
    }

    public function findByFactureSalaire($code_facture, $code_membre_salarier) {
        $select = $this->getDbTable()->select();
        $select->where('code_facture = ?', $code_facture);
        $select->where('code_membre_salarier = ?', $code_membre_salarier);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $entry = new Application_Model_EuFactureSmcipnDetail();
        $entry->setId_facture_detail($row->id_facture_detail)
                ->setCode_facture($row->code_facture)
                ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                ->setMont_investis($row->mont_investis)
                ->setInvestis_alloue($row->investis_alloue)
                ->setSolde_investis($row->solde_investis)
                ->setCode_membre_salarier($row->code_membre_salarier)
                ->setMont_salaire($row->mont_salaire)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setSolde_salaire($row->solde_salaire);
        return $entry;
    }

    public function findByFacture($code_facture) {
        $select = $this->getDbTable()->select();
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuFactureSmcipnDetail();
            $entry->setId_facture_detail($row->id_facture_detail)
                    ->setCode_facture($row->code_facture)
                    ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                    ->setMont_investis($row->mont_investis)
                    ->setInvestis_alloue($row->investis_alloue)
                    ->setSolde_investis($row->solde_investis)
                    ->setCode_membre_salarier($row->code_membre_salarier)
                    ->setMont_salaire($row->mont_salaire)
                    ->setSalaire_alloue($row->salaire_alloue)
                    ->setSolde_salaire($row->solde_salaire);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFactureSmcipnDetail();
            $entry->setId_facture_detail($row->id_facture_detail)
                    ->setCode_facture($row->code_facture)
                    ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                    ->setMont_investis($row->mont_investis)
                    ->setInvestis_alloue($row->investis_alloue)
                    ->setSolde_investis($row->solde_investis)
                    ->setCode_membre_salarier($row->code_membre_salarier)
                    ->setMont_salaire($row->mont_salaire)
                    ->setSalaire_alloue($row->salaire_alloue)
                    ->setSolde_salaire($row->solde_salaire);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_facture_detail) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFactureSmcipnDetail $fact) {
        $data = array(
            'id_facture_detail' => $fact->getId_facture_detail(),
            'code_facture' => $fact->getCode_facture(),
            'code_membre_fournisseur' => $fact->getCode_membre_fournisseur(),
            'mont_investis' => $fact->getMont_investis(),
            'investis_alloue' => $fact->getInvestis_alloue(),
            'solde_investis' => $fact->getSolde_investis(),
            'code_membre_salarier' => $fact->getCode_membre_salarier(),
            'mont_salaire' => $fact->getMont_salaire(),
            'salaire_alloue' => $fact->getSalaire_alloue(),
            'solde_salaire' => $fact->getSolde_salaire()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFactureSmcipnDetail $fact) {
        $data = array(
            'id_facture_detail' => $fact->getId_facture_detail(),
            'code_facture' => $fact->getCode_facture(),
            'code_membre_fournisseur' => $fact->getCode_membre_fournisseur(),
            'mont_investis' => $fact->getMont_investis(),
            'investis_alloue' => $fact->getInvestis_alloue(),
            'solde_investis' => $fact->getSolde_investis(),
            'code_membre_salarier' => $fact->getCode_membre_salarier(),
            'mont_salaire' => $fact->getMont_salaire(),
            'salaire_alloue' => $fact->getSalaire_alloue(),
            'solde_salaire' => $fact->getSolde_salaire()
        );
        $this->getDbTable()->update($data, array('id_facture_detail = ?' => $fact->getId_facture_detail()));
    }

    public function delete($id_facture_detail) {
        $this->getDbTable()->delete(array('id_facture_detail = ?' => $id_facture_detail));
    }

}
