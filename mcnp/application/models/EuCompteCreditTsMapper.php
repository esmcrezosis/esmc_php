<?php

class Application_Model_EuCompteCreditTsMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompteCreditTs');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCompteCreditTs $CompteCreditTs) {
        $data = array(
            'id_credit' => $CompteCreditTs->getId_credit(),
            'montant' => $CompteCreditTs->getMontant(),
            'code_membre' => $CompteCreditTs->getCode_membre(),
            'source' => $CompteCreditTs->getSource(),
            'code_compte' => $CompteCreditTs->getCode_compte(),
            'datedeb' => $CompteCreditTs->getDatedeb(),
            'datefin' => $CompteCreditTs->getDatefin(),
            'id_codebarre' => $CompteCreditTs->getId_codebarre(),
            'code_produit' => $CompteCreditTs->getCode_produit(),
            'code_type_credit' => $CompteCreditTs->getCode_type_credit(),
            'id_operation' => $CompteCreditTs->getId_operation()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCompteCreditTs $CompteCreditTs) {
        $data = array(
            'id_credit' => $CompteCreditTs->getId_credit(),
            'montant' => $CompteCreditTs->getMontant(),
            'code_membre' => $CompteCreditTs->getCode_membre(),
            'source' => $CompteCreditTs->getSource(),
            'code_compte' => $CompteCreditTs->getCode_compte(),
            'datedeb' => $CompteCreditTs->getDatedeb(),
            'datefin' => $CompteCreditTs->getDatefin(),
            'id_codebarre' => $CompteCreditTs->getId_codebarre(),
            'code_produit' => $CompteCreditTs->getCode_produit(),
            'code_type_credit' => $CompteCreditTs->getCode_type_credit(),
            'id_operation' => $CompteCreditTs->getId_operation()
        );
        $this->getDbTable()->update($data, array('id_credit = ?' => $CompteCreditTs->getId_credit()));
    }

    public function find($id_credit, Application_Model_EuCompteCreditTs $CompteCreditTs) {
        $result = $this->getDbTable()->find($id_credit);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $CompteCreditTs->setId_credit($row->id_credit)
                ->setMontant($row->montant)
                ->setCode_membre($row->code_membre)
                ->setSource($row->source)
                ->setCode_compte($row->code_compte)
                ->setDatedeb($row->datedeb)
                ->setDatefin($row->datefin)
                ->setId_codebarre($row->id_codebarre)
                ->setCode_produit($row->code_produit)
                ->setCode_type_credit($row->code_type_credit)
                ->setId_operation($row->id_operation);
        return true;
    }

	

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_credit) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditTs();
            $entry->setId_credit($row->id_credit)
                    ->setMontant($row->montant)
                    ->setCode_membre($row->code_membre)
                    ->setSource($row->source)
                    ->setCode_compte($row->code_compte)
					->setDatedeb($row->datedeb)
					->setDatefin($row->datefin)
					->setId_codebarre($row->id_codebarre)
					->setCode_produit($row->code_produit)
					->setCode_type_credit($row->code_type_credit)
                    ->setId_operation($row->id_operation);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_credit) {
        $this->getDbTable()->delete(array('id_credit = ?' => $id_credit));
    }


//////////////////////////////////////////////////:



    public function findByCompteProduitSolde($compte, $produit, Application_Model_EuCompteCreditTs $CompteCreditTs) {
        $table = new Application_Model_DbTable_EuCompteCreditTs();
        $select = $table->select();
        //$select->setIntegrityCheck(false);
		$select->from($table, array('code_compte', 'MAX(montant) as solde'));
		$select->where('montant > ?', 0);
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
		   $entries = array();
				 //$entries['code_produit'] = $row->code_produit;
				 $entries['code_compte'] = $row->code_compte;
				 $entries['solde'] = $row->solde;
      return $entries;
    }



    public function fetchAll2($code_compte, $code_produit) {
        $select = $this->getDbTable()->select();
        $select->setIntegrityCheck(false);
		if(isset($code_compte) && $code_compte!=""){
        $select->where('code_compte = ?', $code_compte);}
		if(isset($code_produit) && $code_produit!=""){
		$select->where('code_produit = ?', $code_produit);}
		$select->where('montant > ?', 0);
        $select->order(array('id_credit DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditTs();
            $entry->setId_credit($row->id_credit)
                    ->setMontant($row->montant)
                    ->setCode_membre($row->code_membre)
                    ->setSource($row->source)
                    ->setCode_compte($row->code_compte)
					->setDatedeb($row->datedeb)
					->setDatefin($row->datefin)
					->setId_codebarre($row->id_codebarre)
					->setCode_produit($row->code_produit)
					->setCode_type_credit($row->code_type_credit)
                    ->setId_operation($row->id_operation);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findCompteCreditTs($code_compte, $code_produit) {
        $select = $this->getDbTable()->select();
        $select->setIntegrityCheck(false);
		if(isset($code_compte) && $code_compte!=""){
        $select->where('code_compte = ?', $code_compte);}
		if(isset($code_produit) && $code_produit!=""){
		$select->where('code_produit = ?', $code_produit);}
		$select->where('montant > ?', 0);
        $select->order(array('id_credit ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditTs();
            $entry->setId_credit($row->id_credit)
                    ->setMontant($row->montant)
                    ->setCode_membre($row->code_membre)
                    ->setSource($row->source)
                    ->setCode_compte($row->code_compte)
					->setDatedeb($row->datedeb)
					->setDatefin($row->datefin)
					->setId_codebarre($row->id_codebarre)
					->setCode_produit($row->code_produit)
					->setCode_type_credit($row->code_type_credit)
                    ->setId_operation($row->id_operation);
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function findCompteCreditTs2($code_compte) {
        $select = $this->getDbTable()->select();
        $select->setIntegrityCheck(false);
		if(isset($code_compte) && $code_compte!=""){
        $select->where('code_compte = ?', $code_compte);}
		//if(isset($code_produit) && $code_produit!=""){
		//$select->where('code_produit = ?', $code_produit);}
		$select->where('montant > ?', 0);
        $select->order(array('id_credit ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditTs();
            $entry->setId_credit($row->id_credit)
                    ->setMontant($row->montant)
                    ->setCode_membre($row->code_membre)
                    ->setSource($row->source)
                    ->setCode_compte($row->code_compte)
					->setDatedeb($row->datedeb)
					->setDatefin($row->datefin)
					->setId_codebarre($row->id_codebarre)
					->setCode_produit($row->code_produit)
					->setCode_type_credit($row->code_type_credit)
                    ->setId_operation($row->id_operation);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function fetchAllByCompteTS($code_membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array("code_compte"));
		$select->distinct();
        $select->where("code_membre = ?", $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditTs();
            $entry->setCode_compte($row->code_compte);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function findCompteCreditTs3($code_compte) {
        $select = $this->getDbTable()->select();
        $select->setIntegrityCheck(false);
		if(isset($code_compte) && $code_compte!=""){
        $select->where('code_compte = ?', $code_compte);}
        $select->order(array('id_credit ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditTs();
            $entry->setId_credit($row->id_credit)
                    ->setMontant($row->montant)
                    ->setCode_membre($row->code_membre)
                    ->setSource($row->source)
                    ->setCode_compte($row->code_compte)
					->setDatedeb($row->datedeb)
					->setDatefin($row->datefin)
					->setId_codebarre($row->id_codebarre)
					->setCode_produit($row->code_produit)
					->setCode_type_credit($row->code_type_credit)
                    ->setId_operation($row->id_operation);
            $entries[] = $entry;
        }
        return $entries;
    }

}


