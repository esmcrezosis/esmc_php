<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuFnMapper
 *
 * @author user
 */
class Application_Model_EuFnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFn');
        }
        return $this->_dbTable;
    }

    public function find($code_fn, Application_Model_EuFn $fn) {
        $result = $this->getDbTable()->find($code_fn);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $fn->setId_fn($row->id_fn)
                ->setCode_capa($row->code_capa)
                ->setType_fn($row->type_fn)
                ->setMontant($row->montant)
                ->setEntree($row->entree)
                ->setSortie($row->sortie)
                ->setSolde($row->solde)
                ->setMt_solde($row->mt_solde)
                ->setDate_fn($row->date_fn)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_domicilier($row->code_domicilier)
                ->setOrigine_fn($row->origine_fn);
        return true;
    }

	public function findBySmcipn($code_smcipn) {
        $table = new Application_Model_DbTable_EuFn();
        $select = $table->select();
        $select->where('code_smcipn LIKE ?',$code_smcipn);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuFn();
            $entry->setId_fn($row->id_fn)
                    ->setCode_capa($row->code_capa)
                    ->setType_fn($row->type_fn)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMt_solde($row->mt_solde)
                    ->setDate_fn($row->date_fn)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_fn($row->origine_fn);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
    public function find1() {
        $table = new Application_Model_DbTable_EuFn();
        $select = $table->select();
        $select->where('mt_solde >?', 0)
                ->order('date_fn', 'ASC')
                ->order('id_fn', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuFn();
            $entry->setId_fn($row->id_fn)
                    ->setCode_capa($row->code_capa)
                    ->setType_fn($row->type_fn)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMt_solde($row->mt_solde)
                    ->setDate_fn($row->date_fn)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_fn($row->origine_fn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
   
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFn();
            $entry->setid_fn($row->id_fn)
                    ->setCode_capa($row->code_capa)
                    ->setType_fn($row->type_fn)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMt_solde($row->mt_solde)
                    ->setDate_fn($row->date_fn)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_fn($row->origine_fn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumRPG($type_fn) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mt_solde) as somme'));
        $select->where('type_fn = ?', $type_fn);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function getSumFN() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mt_solde) as somme'));
        $select->where('mt_solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuFn $fn) {
        $data = array(
            'id_fn' => $fn->getId_fn(),
            'code_capa' => $fn->getCode_capa(),
            'type_fn' => $fn->getType_fn(),
            'montant' => $fn->getMontant(),
            'entree' => $fn->getEntree(),
            'sortie' => $fn->getSortie(),
            'solde' => $fn->getSolde(),
            'mt_solde' => $fn->getMt_solde(),
            'date_fn' => $fn->getDate_fn(),
            'code_smcipn' => $fn->getCode_smcipn(),
            'code_domicilier' => $fn->getCode_domicilier(),
            'origine_fn' => $fn->getOrigine_fn()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFn $fn) {
        $data = array(
            'id_fn' => $fn->getId_fn(),
            'code_capa' => $fn->getCode_capa(),
            'type_fn' => $fn->getType_fn(),
            'montant' => $fn->getMontant(),
            'entree' => $fn->getEntree(),
            'sortie' => $fn->getSortie(),
            'solde' => $fn->getSolde(),
            'mt_solde' => $fn->getMt_solde(),
            'date_fn' => $fn->getDate_fn(),
            'code_smcipn' => $fn->getCode_smcipn(),
            'code_domicilier' => $fn->getCode_domicilier(),
            'origine_fn' => $fn->getOrigine_fn()
        );

        $this->getDbTable()->update($data, array('id_fn = ?' => $fn->getId_fn()));
    }

    public function delete($id_fn) {
        $this->getDbTable()->delete(array('id_fn = ?' => $id_fn));
    }

}
