<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuSmcMapper
 *
 * @author user
 */
class Application_Model_EuSmcMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmc');
        }
        return $this->_dbTable;
    }

    public function find($num_op, Application_Model_EuSmc $smc) {
        $result = $this->getDbTable()->find($num_op);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smc->setId_smc($row->id_smc)
                ->setCode_capa($row->code_capa)
                ->setId_credit($row->id_credit)
                ->setType_smc($row->type_smc)
                ->setMontant($row->montant)
                ->setEntree($row->entree)
                ->setSortie($row->sortie)
                ->setSolde($row->solde)
                ->setMontant_solde($row->montant_solde)
                ->setSource_credit($row->source_credit)
                ->setDate_smc($row->date_smc)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setOrigine_smc($row->origine_smc);
        return true;
    }

    public function find1() {
        $table = new Application_Model_DbTable_EuSmc();
        $select = $table->select();
        $select->where('montant_solde >?', 0)
                ->where('origine_smc LIKE ?', 0)
                ->order('date_smc', 'ASC')
                ->order('id_smc', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuSmc();
            $entry->setId_smc($row->id_smc)
                    ->setCode_capa($row->code_capa)
                    ->setId_credit($row->id_credit)
                    ->setType_smc($row->type_smc)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMontant_solde($row->montant_solde)
                    ->setSource_credit($row->source_credit)
                    ->setDate_smc($row->date_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_smc($row->origine_smc);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_smc) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function findBySource($source, $credit) {
        $select = $this->getDbTable()->select();
        $select->where('source_credit = ?', $source)
                ->where('id_credit = ?', $credit)
                ->order('date_smc', 'ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $smc = new Application_Model_EuSmc();
        $smc->setId_smc($row->id_smc)
                ->setCode_capa($row->code_capa)
                ->setId_credit($row->id_credit)
                ->setType_smc($row->type_smc)
                ->setMontant($row->montant)
                ->setEntree($row->entree)
                ->setSortie($row->sortie)
                ->setSolde($row->solde)
                ->setMontant_solde($row->montant_solde)
                ->setSource_credit($row->source_credit)
                ->setDate_smc($row->date_smc)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setOrigine_smc($row->origine_smc);
        return $smc;
    }

    public function findBySmcipn($code_smcipn) {
        $table = new Application_Model_DbTable_EuSmc();
        $select = $table->select();
        $select->where('code_smcipn = ?', $code_smcipn)
               //->where('montant_solde >?', 0)
               //->order('date_smc', 'ASC')
               //->order('id_smc', 'ASC')
			   ;
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuSmc();
            $entry->setId_smc($row->id_smc)
                    ->setCode_capa($row->code_capa)
                    ->setId_credit($row->id_credit)
                    ->setType_smc($row->type_smc)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMontant_solde($row->montant_solde)
                    ->setSource_credit($row->source_credit)
                    ->setDate_smc($row->date_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_smc($row->origine_smc);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByDomiciliation($code_domi) {
        $table = new Application_Model_DbTable_EuSmc();
        $select = $table->select();
        $select->where('code_domicilier = ?', $code_domi)
                ->where('montant_solde >?', 0)
                ->order('date_smc', 'ASC')
                ->order('id_smc', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuSmc();
            $entry->setId_smc($row->id_smc)
                    ->setCode_capa($row->code_capa)
                    ->setId_credit($row->id_credit)
                    ->setType_smc($row->type_smc)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMontant_solde($row->montant_solde)
                    ->setSource_credit($row->source_credit)
                    ->setDate_smc($row->date_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_smc($row->origine_smc);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findBySmcipnp($code_smcipnp) {
        $table = new Application_Model_DbTable_EuSmc();
        $select = $table->select();
        $select->where('code_smcipnp = ?', $code_smcipnp)
                ->where('montant_solde >?', 0)
                ->where('origine_smc = ?', 2)
                ->order('date_smc', 'ASC')
                ->order('id_smc', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuSmc();
            $entry->setId_smc($row->id_smc)
                    ->setCode_capa($row->code_capa)
                    ->setId_credit($row->id_credit)
                    ->setType_smc($row->type_smc)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMontant_solde($row->montant_solde)
                    ->setSource_credit($row->source_credit)
                    ->setDate_smc($row->date_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_smc($row->origine_smc);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmc();
            $entry->setId_smc($row->id_smc)
                    ->setCode_capa($row->code_capa)
                    ->setId_credit($row->id_credit)
                    ->setType_smc($row->type_smc)
                    ->setMontant($row->montant)
                    ->setEntree($row->entree)
                    ->setSortie($row->sortie)
                    ->setSolde($row->solde)
                    ->setMontant_solde($row->montant_solde)
                    ->setSource_credit($row->source_credit)
                    ->setDate_smc($row->date_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setOrigine_smc($row->origine_smc);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumRPG($type_smc) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde) as somme'));
        $select->where('type_smc = ?', $type_smc);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function getSumSMC() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_solde) as somme'));
        $select->where('origine_smc !=?', 1);
        $select->where('montant_solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuSmc $smc) {
        $data = array(
            'id_smc' => $smc->getId_smc(),
            'id_credit' => $smc->getId_credit(),
            'montant' => $smc->getMontant(),
            'entree' => $smc->getEntree(),
            'sortie' => $smc->getSortie(),
            'solde' => $smc->getSolde(),
            'montant_solde' => $smc->getMontant_solde(),
            'source_credit' => $smc->getSource_credit(),
            'type_smc' => $smc->getType_smc(),
            'date_smc' => $smc->getDate_smc(),
            'code_capa' => $smc->getCode_capa(),
            'code_smcipn' => $smc->getCode_smcipn(),
            'code_smcipnp' => $smc->getCode_smcipnp(),
            'code_domicilier' => $smc->getCode_domicilier(),
            'origine_smc' => $smc->getOrigine_smc()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmc $smc) {
        $data = array(
            'id_credit' => $smc->getId_credit(),
            'montant' => $smc->getMontant(),
            'entree' => $smc->getEntree(),
            'sortie' => $smc->getSortie(),
            'solde' => $smc->getSolde(),
            'montant_solde' => $smc->getMontant_solde(),
            'source_credit' => $smc->getSource_credit(),
            'type_smc' => $smc->getType_smc(),
            'date_smc' => $smc->getDate_smc(),
            'code_capa' => $smc->getCode_capa(),
            'code_smcipn' => $smc->getCode_smcipn(),
            'code_smcipnp' => $smc->getCode_smcipnp(),
            'code_domicilier' => $smc->getCode_domicilier(),
            'origine_smc' => $smc->getOrigine_smc()
        );

        $this->getDbTable()->update($data, array('id_smc = ?' => $smc->getId_smc()));
    }

    public function delete($id_smc) {
        $this->getDbTable()->delete(array('id_smc = ?' => $id_smc));
    }

}
