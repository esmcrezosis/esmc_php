<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EucnpMapper
 *
 * @author user
 */
class Application_Model_EuCnpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCnp');
        }
        return $this->_dbTable;
    }
	
    public function find($id_cnp, Application_Model_EuCnp $cnp) {
        $result = $this->getDbTable()->find($id_cnp);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $cnp->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
    }

    public function findCnpByDomicilie($domi) {
        $select = $this->getDbTable()->select();
        $select->where('code_domicilier LIKE ?', $domi)
                ->order('date_cnp', 'ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCnp();
            $entry->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findCnpByDomiGcp($domi) {
        $table = new Application_Model_DbTable_EuCnp();
        $select = $table->select();
        $select->where('code_domicilier LIKE ?', $domi)
                ->where('transfert_gcp NOT LIKE ?', 1);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCnp();
            $entry->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findCnpBySource($source,$credit) {
        $select = $this->getDbTable()->select();
        $select->where('source_credit = ?', $source)
                ->where('id_credit = ?', $credit)
                ->order('date_cnp', 'ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return NULL;
        }
        $row = $result->current();
        $cnp = new Application_Model_EuCnp();
        $cnp->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
        return $cnp;
    }

    public function findCnpByCreditSource($credit,$source) {
        $select = $this->getDbTable()->select();
        $select->where('id_credit = ?', $credit)
                ->where('source_credit like ?', $source)
                ->where('solde_cnp > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $cnp = new Application_Model_EuCnp();
        $cnp->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
        return $cnp;
    }
	
	public function findCnpByCreditGcp($credit) {
        $select = $this->getDbTable()->select();
        $select->where('id_gcp = ?', $credit)
               ->where('solde_cnp >= ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $cnp = new Application_Model_EuCnp();
        $cnp->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
        return $cnp;
    }
	
	
	
	
	
    
    public function findCnpByCredit($id_credit) {
        $select = $this->getDbTable()->select();
        $select->where('id_credit = ?', $credit)
                ->where('solde_cnp >= ?', 0)
                ->where('code_domicilier IS NULL');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $cnp = new Application_Model_EuCnp();
        $cnp->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
        return $cnp;
    }
    
    public function findCnpByCreditOld($credit, $source) {
        $select = $this->getDbTable()->select();
        $select->where('id_credit = ?', $credit)
                ->where('source_credit != ?', $source)
                ->where('solde_cnp > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCnp();
            $entry->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCnp();
            $entry->setId_cnp($row->id_cnp)
		    ->setDate_cnp($row->date_cnp)
			->setMont_credit($row->mont_credit)
			->setMont_debit($row->mont_debit)
			->setOrigine_cnp($row->origine_cnp)
			->setSolde_cnp($row->solde_cnp)
			->setSource_credit($row->source_credit)
			->setTransfert_gcp($row->transfert_gcp)
			->setType_cnp($row->type_cnp)
			->setCode_capa($row->code_capa)
            ->setId_credit($row->id_credit)
            ->setCode_domicilier($row->code_domicilier)    
		    ->setId_gcp($row->id_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_cnp) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function getSumRPG($type_cnp) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_cnp) as somme'));
        $select->where('type_cnp = ?', $type_cnp);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuCnp $cnp) {
        $data = array(
            'id_cnp' => $cnp->getId_cnp(),
            'id_credit' => $cnp->getId_credit(),
            'mont_debit' => $cnp->getMont_debit(),
            'mont_credit' => $cnp->getMont_credit(),
            'solde_cnp' => $cnp->getSolde_cnp(),
            'source_credit' => $cnp->getSource_credit(),
            'type_cnp' => $cnp->getType_cnp(),
            'date_cnp' => $cnp->getDate_cnp(),
            'code_capa' => $cnp->getCode_capa(),
            'code_domicilier' => $cnp->getCode_domicilier(),
            'origine_cnp' => $cnp->getOrigine_cnp(),
            'transfert_gcp' => $cnp->getTransfert_gcp(),
			'id_gcp' => $cnp->getId_gcp()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCnp $cnp) {
        $data = array(
            'id_cnp' => $cnp->getId_cnp(),
            'id_credit' => $cnp->getId_credit(),
            'mont_debit' => $cnp->getMont_debit(),
            'mont_credit' => $cnp->getMont_credit(),
            'solde_cnp' => $cnp->getSolde_cnp(),
            'source_credit' => $cnp->getSource_credit(),
            'type_cnp' => $cnp->getType_cnp(),
            'date_cnp' => $cnp->getDate_cnp(),
            'code_capa' => $cnp->getCode_capa(),
            'code_domicilier' => $cnp->getCode_domicilier(),
            'origine_cnp' => $cnp->getOrigine_cnp(),
            'transfert_gcp' => $cnp->getTransfert_gcp(),
			'id_gcp' => $cnp->getId_gcp()
        );

        $this->getDbTable()->update($data, array('id_cnp = ?' => $cnp->getId_cnp()));
    }

    public function delete($id_cnp) {
        $this->getDbTable()->delete(array('id_cnp = ?' => $id_cnp));
    }

}
