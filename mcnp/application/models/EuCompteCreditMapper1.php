<?php

class Application_Model_EuCompteCreditMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompteCredit');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCompteCredit $credit) {
        $data = array(
            'id_credit' => $credit->getId_credit(),
            'montant_credit' => $credit->getMontant_credit(),
            'code_membre' => $credit->getCode_membre(),
            'code_produit' => $credit->getCode_produit(),
            'montant_place' => $credit->getMontant_place(),
			'datedeb' => $credit->getDatedeb(),
            'datefin' => $credit->getDatefin(),
            'source' => $credit->getSource(),
            'date_octroi' => $credit->getDate_octroi(),
            'compte_source' => $credit->getCompte_source(),
            'krr' => $credit->getKrr(),
            'renouveller' => $credit->getRenouveller(),
            'bnp' => $credit->getBnp(),
            'code_compte' => $credit->getCode_compte(),
            'id_operation' => $credit->getId_operation(),
            'domicilier' => $credit->getDomicilier(),
            'code_bnp' => $credit->getCode_bnp(),
            'affecter' => $credit->getAffecter()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCompteCredit $credit) {
        $data = array(
            'id_credit' => $credit->getId_credit(),
            'montant_credit' => $credit->getMontant_credit(),
            'code_membre' => $credit->getCode_membre(),
            'code_produit' => $credit->getCode_produit(),
            'montant_place' => $credit->getMontant_place(),
			'datedeb' => $credit->getDatedeb(),
            'datefin' => $credit->getDatefin(),
            'source' => $credit->getSource(),
            'date_octroi' => $credit->getDate_octroi(),
            'compte_source' => $credit->getCompte_source(),
            'krr' => $credit->getKrr(),
            'renouveller' => $credit->getRenouveller(),
            'bnp' => $credit->getBnp(),
            'code_compte' => $credit->getCode_compte(),
            'id_operation' => $credit->getId_operation(),
            'domicilier' => $credit->getDomicilier(),
            'code_bnp' => $credit->getCode_bnp(),
            'affecter' => $credit->getAffecter()
        );
        $this->getDbTable()->update($data, array('id_credit = ?' => $credit->getId_credit()));
    }

    public function find($id_credit, Application_Model_EuCompteCredit $CompteCredit) {
        $result = $this->getDbTable()->find($id_credit);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $CompteCredit->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
        return true;
    }

    public function findByCompte($compte) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $select = $table->select();
        $select->where('code_compte LIKE ?', $compte)
                ->where('montant_credit > ?',0);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findSalByCompte($compte) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $select = $table->select();
        $select->where('code_compte LIKE ?', $compte)
                ->where('montant_credit > ?',0);
        if($compte != '0010010010040000029M'){
            $select->where('datefin < curdate()');
        }
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_credit) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function find1($membre, $produit) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $select = $table->select();
        $select->where('code_membre=?', $membre)
                ->where('code_produit=?', $produit)
                ->where('montant_credit > ?', 0)
                ->order('datefin', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findAll($membre, $produit) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $select = $table->select();
        $select->where('code_membre=?', $membre)
                ->where('code_produit=?', $produit);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findBySMC($source, $num_compte) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $select = $table->select();
        $select->where('compte_source=?', $source)
                ->where('code_compte=?', $num_compte);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchByCompte($compte) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $select = $table->select();
        $select->where('code_compte LIKE ?', $compte)
                ->order('datefin', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchByComptes($comptes) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $mont_credit = 0;
        $select = $table->select();
        $select->where('code_compte IN (?)', $comptes)
                ->where('montant_credit > ?', $mont_credit)
                ->order('datefin', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchByProduits($comptes) {
        $table = new Application_Model_DbTable_EuCompteCredit();
        $mont_credit = 0;
        $select = $table->select();
        $select->where('code_produit IN (?)', $comptes)
                ->where('montant_credit > ?', $mont_credit)
                ->order('datefin', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCredit();
            $entry->setId_credit($row->id_credit)
                ->setMontant_credit($row->montant_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setMontant_place($row->montant_place)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setSource($row->source)
                ->setDate_octroi($row->date_octroi)
                ->setCompte_source($row->compte_source)
                ->setKrr($row->krr)
                ->setRenouveller($row->renouveller)
                ->setBnp($row->bnp)
                ->setCode_compte($row->code_compte)
                ->setId_operation($row->id_operation)
                ->setDomicilier($row->domicilier)
                ->setCode_bnp($row->code_bnp)
                ->setAffecter($row->affecter);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_credit) {
        $this->getDbTable()->delete(array('id_credit = ?' => $id_credit));
    }

}

