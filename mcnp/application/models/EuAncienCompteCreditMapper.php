<?php
class Application_Model_EuAncienCompteCreditMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienCompteCredit');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuAncienCompteCredit $credit) {
        $data = array(
            'id_credit' => $credit->getId_credit(),
            'montant_credit' => $credit->getMontant_credit(),
            'code_membre' => $credit->getCode_membre(),
            'code_produit' => $credit->getCode_produit(),
            'montant_place' => $credit->getMontant_place(),
            'datefin' => $credit->getDatefin(),
            'datedeb' => $credit->getDatedeb(),
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
            'affecter' => $credit->getAffecter(),
            'prk' => $credit->getPrk(),
            'nbre_renouvel' => $credit->getNbre_renouvel(),
            'code_type_credit' => $credit->getCode_type_credit(),
			'desactiver' => $credit->getDesactiver(),
			'nature' => $credit->getNature()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienCompteCredit $credit) {
        $data = array(
            'id_credit' => $credit->getId_credit(),
            'montant_credit' => $credit->getMontant_credit(),
            'code_membre' => $credit->getCode_membre(),
            'code_produit' => $credit->getCode_produit(),
            'montant_place' => $credit->getMontant_place(),
            'datefin' => $credit->getDatefin(),
            'datedeb' => $credit->getDatedeb(),
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
            'affecter' => $credit->getAffecter(),
            'prk' => $credit->getPrk(),
            //'nbre_renouvel' => $credit->getNbre_renouvel(),
            'code_type_credit' => $credit->getCode_type_credit(),
			'desactiver' => $credit->getDesactiver(),
			'nature' => $credit->getNature()
        );
        $this->getDbTable()->update($data, array('id_credit = ?' => $credit->getId_credit()));
    }

    public function find($id_credit, Application_Model_EuAncienCompteCredit $CompteCredit) {
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
                ->setAffecter($row->affecter)
                ->setPrk($row->prk)
                //->setNbre_renouvel($row->nbre_renouvel)
                ->setCode_type_credit($row->code_type_credit)
				->setDesactiver($row->desactiver)
				->setNature($row->nature)
				;
        return true;
    }

	public function findByCredDomi($id_credit, $domicilier) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
        $select->where('id_credit LIKE ?', $id_credit)
               ->where('domicilier LIKE ?', $domicilier);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $CompteCredit = new Application_Model_EuAncienCompteCredit();
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
                     ->setAffecter($row->affecter)
				     ->setPrk($row->prk)
                     ->setNbre_renouvel($row->nbre_renouvel)
                     ->setCode_type_credit($row->code_type_credit)
				     ->setDesactiver($row->desactiver)
					 ->setNature($row->nature);
        return $CompteCredit;
    }
	
    public function findByCompte($compte) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
        $select->where('code_compte LIKE ?', $compte)
                ->where('MONTANT_credit > ?', 0);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
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
                ->setAffecter($row->affecter)
                ->setPrk($row->prk)
                ->setNbre_renouvel($row->nbre_renouvel)
                ->setCode_type_credit($row->code_type_credit)
				->setDesactiver($row->desactiver)
				->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findCreditByCompte($membre, $produit) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
        $select->where('code_membre LIKE ?', $membre)
                ->where('code_produit LIKE ?', $produit)
                ->where('montant_credit > ?', 0);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
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
                ->setAffecter($row->affecter)
                ->setPrk($row->prk)
                ->setNbre_renouvel($row->nbre_renouvel)
                ->setCode_type_credit($row->code_type_credit)
				->setDesactiver($row->desactiver)
				->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findSalByCompte($compte) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
        $select->where('code_compte LIKE ?', $compte)
                ->where('montant_credit > ?', 0);
        if ($compte != '0010010010040000029M') {
            $select->where('datefin < curdate()');
        }
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
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
                ->setAffecter($row->affecter)
                ->setPrk($row->prk)
                ->setNbre_renouvel($row->nbre_renouvel)
                ->setCode_type_credit($row->code_type_credit)
				->setDesactiver($row->desactiver)
				->setNature($row->nature);
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
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
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
            $entry = new Application_Model_EuAncienCompteCredit();
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function findAll($membre,$produit) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
        $select->where('code_membre = ?',$membre)
               ->where('code_produit = ?',$produit);
        $result = $table->fetchAll($select);
        if (count($result) == 0)  {
           return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    //->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	
    public function findBySMC($source, $num_compte) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
        $select->where('compte_source=?', $source)
                ->where('code_compte=?', $num_compte);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
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
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	
    public function fetchByComptes($comptes) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
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
            $entry = new Application_Model_EuAncienCompteCredit();
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchByProduits($comptes) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
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
            $entry = new Application_Model_EuAncienCompteCredit();
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
            $entry->setId_credit($row->id_credit)
                    ->setMontant_credit($row->montant_credit)
                    ->setCode_membre($row->code_membre)
                    ->setCode_produit($row->code_produit)
                    ->setMontant_place($row->montant_place)
                    ->setDatefin($row->datefin)
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
	public function getSumQuotaRPG($num_membre,$produit) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_place) as somme'));
        $select->where('code_membre = ?', $num_membre);
        $select->where('code_produit = ?', $produit);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }
	
	
	
	
    public function delete($id_credit) {
        $this->getDbTable()->delete(array('id_credit = ?' => $id_credit));
    }


    /////////////////////////////////////////////////////////////////////
    public function fetchAll2($code_compte, $code_produit) {
        $select = $this->getDbTable()->select();
		if(isset($code_compte) && $code_compte!=""){
        $select->where('code_compte = ?', $code_compte);}
		if(isset($code_produit) && $code_produit!=""){
		$select->where('code_produit = ?', $code_produit);}
        $select->order(array('id_credit DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
            $entry->setId_credit($row->id_credit)
                    ->setMontant_credit($row->montant_credit)
                    ->setCode_membre($row->code_membre)
                    ->setCode_produit($row->code_produit)
                    ->setMontant_place($row->montant_place)
                    ->setDatedeb($row->datedeb)
					->setDatefin($row->datefin)
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
                    ->setAffecter($row->affecter)
                    ->setPrk($row->prk)
                    ->setNbre_renouvel($row->nbre_renouvel)
                    ->setCode_type_credit($row->code_type_credit)
					->setDesactiver($row->desactiver)
					->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
	
    public function findByCompteProduit($compte, $produit, Application_Model_EuAncienCompteCredit $CompteCredit) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
		if(isset($compte) && $compte!=""){        
		$select->where('code_compte LIKE ?', $compte);}
		if(isset($produit) && $produit!=""){		
		$select->where('code_produit LIKE ?', $produit);}
		$select->order(array('datefin DESC'));
        $select->limit(1);
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
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
                ->setAffecter($row->affecter)
                ->setPrk($row->prk)
                ->setNbre_renouvel($row->nbre_renouvel)
                ->setCode_type_credit($row->code_type_credit)
				->setDesactiver($row->desactiver)
				->setNature($row->nature);
        return true;
    }


	
	
    public function findByCompteProduitSolde($compte, $produit, Application_Model_EuAncienCompteCredit $CompteCredit) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
		$select->from(array('eu_compte_credit'), array('code_compte', 'code_produit', 'solde' => 'SUM(montant_credit)'));
        $select->group(array('code_compte', 'code_produit'));
		if(isset($compte) && $compte!=""){        
		$select->having('code_compte LIKE ?', $compte);}
		if(isset($produit) && $produit!=""){		
		$select->having('code_produit LIKE ?', $produit);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $CompteCredit->setCode_produit($row->code_produit)
                ->setSolde($row->solde)
                ->setCode_compte($row->code_compte);
        return true;
    }


	
	
    public function findCumul($compte, $produit, Application_Model_EuAncienCompteCredit $CompteCredit) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
		$select->from(array('eu_compte_credit'), array('code_compte', 'code_produit', 'solde' => 'SUM(montant_credit)'));
		$select->where('affecter = ?', 0);
        $select->group(array('code_compte', 'code_produit'));
		if(isset($compte) && $compte!=""){        
		$select->having('code_compte LIKE ?', $compte);}
		if(isset($produit) && $produit!=""){		
		$select->having('code_produit LIKE ?', $produit);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $CompteCredit->setCode_produit($row->code_produit)
                ->setSolde($row->solde)
                ->setCode_compte($row->code_compte);
        return true;
    }

	
	
    public function findCompteCredit($compte, $produit) {
        $table = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $table->select();
		$select->where('affecter = ?', 0);
		$select->where('montant_credit != ?', 0);
		if(isset($compte) && $compte!=""){        
		$select->where('code_compte LIKE ?', $compte);}
		if(isset($produit) && $produit!=""){		
		$select->where('code_produit LIKE ?', $produit);}
		$select->order(array('datedeb ASC'));
        $resultSet = $table->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
            $entry->setId_credit($row->id_credit)
                  ->setMontant_credit($row->montant_credit)
                  ->setCode_membre($row->code_membre)
                  ->setCode_produit($row->code_produit)
                  ->setMontant_place($row->montant_place)
                  ->setDatedeb($row->datedeb)
				  ->setDatefin($row->datefin)
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
                  ->setAffecter($row->affecter)
                  ->setPrk($row->prk)
                  ->setNbre_renouvel($row->nbre_renouvel)
                  ->setCode_type_credit($row->code_type_credit)
				  ->setDesactiver($row->desactiver)
				  ->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAllByCompteCreditTS3($code_type_compte, $code_cat) {
            $select = $this->getDbTable()->select();
            $select->from($this->getDbTable(), array("code_compte"));
		    $select->distinct();
		    $select->where("code_compte LIKE '".$code_type_compte."-".$code_cat."%'");
            $resultSet = $this->getDbTable()->fetchAll($select);
            $entries = array();
            foreach ($resultSet as $row) {
              $entry = new Application_Model_EuAncienCompteCredit();
              $entry->setCode_compte($row->code_compte);
              $entries[] = $entry;
            }
            return $entries;
    }
	


    public function fetchAllCodeCompte($code_compte) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte = ?', $code_compte);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienCompteCredit();
            $entry->setId_credit($row->id_credit)
                  ->setMontant_credit($row->montant_credit)
                  ->setCode_membre($row->code_membre)
                  ->setCode_produit($row->code_produit)
                  ->setMontant_place($row->montant_place)
                  ->setDatedeb($row->datedeb)
				  ->setDatefin($row->datefin)
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
                  ->setAffecter($row->affecter)
                  ->setPrk($row->prk)
				  ->setNbre_renouvel($row->nbre_renouvel)
                  ->setCode_type_credit($row->code_type_credit)
				  ->setDesactiver($row->desactiver)
				  ->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }



}


