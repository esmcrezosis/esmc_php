<?php

class Application_Model_EuRapprochementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRapprochement');
        }
        return $this->_dbTable;
    }

    public function find($id_rappro, Application_Model_EuRapprochement $rappro) {
        $result = $this->getDbTable()->find($id_rappro);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $rappro->setId_rappro($row->id_rappro)
                ->setDebit_rappro($row->debit_rappro)
                ->setCredit_rappro($row->credit_rappro)
                ->setSolde_rappro($row->solde_rappro)
                ->setSource($row->source)
                ->setSource_credit($row->source_credit)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setId_credit($row->id_credit)
                ->setType_rappro($row->type_rappro);
    }

    public function findBySource($source) {
        $select = $this->getDbTable()->select();
        $select->where('source_credit=?', $source)
                ->where('solde_rappro > ?', 0)
                ->order('id_rappro', 'ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $rappro = new Application_Model_EuRapprochement();
        $rappro->setId_rappro($row->id_rappro)
                ->setDebit_rappro($row->debit_rappro)
                ->setCredit_rappro($row->credit_rappro)
                ->setSolde_rappro($row->solde_rappro)
                ->setSource($row->source)
                ->setSource_credit($row->source_credit)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setId_credit($row->id_credit)
                ->setType_rappro($row->type_rappro);
        return $rappro;
    }

    public function findRapproByCreditSource($credit, $source) {
        $select = $this->getDbTable()->select();
        $select->where('id_credit = ?', $credit)
                ->where('source_credit = ?', $source);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        } else {
            $row = $result->current();
            $rappro = new Application_Model_EuRapprochement();
            $rappro->setId_rappro($row->id_rappro)
                    ->setDebit_rappro($row->debit_rappro)
                    ->setCredit_rappro($row->credit_rappro)
                    ->setSolde_rappro($row->solde_rappro)
                    ->setSource($row->source)
                    ->setSource_credit($row->source_credit)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setId_credit($row->id_credit)
                    ->setType_rappro($row->type_rappro);
            return $rappro;
        }
    }

    public function findBySmcipnSource($code_smcipn, $source, $id_credit) {
        $table = new Application_Model_DbTable_EuRapprochement();
        $select = $table->select();
        $select->where('code_smcipn=?', $code_smcipn)
                ->where('source_credit=?', $source)
                ->where('id_credit=?', $id_credit)
                ->where('solde_rappro > ?', 0)
                ->where('source = ?', 'SMC');
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $rappro = new Application_Model_EuRapprochement();
        $rappro->setId_rappro($row->id_rappro)
                ->setDebit_rappro($row->debit_rappro)
                ->setCredit_rappro($row->credit_rappro)
                ->setSolde_rappro($row->solde_rappro)
                ->setSource($row->source)
                ->setSource_credit($row->source_credit)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setId_credit($row->id_credit)
                ->setType_rappro($row->type_rappro);
        return $rappro;
    }

    public function findBySmcipnSource2($code_domi, $source, $id_credit) {
        $table = new Application_Model_DbTable_EuRapprochement();
        $select = $table->select();
        $select->where('code_domicilier=?', $code_domi)
                ->where('source_credit=?', $source)
                ->where('id_credit=?', $id_credit)
                ->where('solde_rappro > ?', 0)
                ->where('source = ?', 'CNP');
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $rappro = new Application_Model_EuRapprochement();
        $rappro->setId_rappro($row->id_rappro)
                ->setDebit_rappro($row->debit_rappro)
                ->setCredit_rappro($row->credit_rappro)
                ->setSolde_rappro($row->solde_rappro)
                ->setSource($row->source)
                ->setSource_credit($row->source_credit)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setId_credit($row->id_credit)
                ->setType_rappro($row->type_rappro);
        return $rappro;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRapprochement();
            $entry->setId_rappro($row->id_rappro)
                    ->setDebit_rappro($row->debit_rappro)
                    ->setCredit_rappro($row->credit_rappro)
                    ->setSolde_rappro($row->solde_rappro)
                    ->setSource($row->source)
                    ->setSource_credit($row->source_credit)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setId_credit($row->id_credit)
                    ->setType_rappro($row->type_rappro);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCompte($source) {
        $select = $this->getDbTable()->select();
        $select->where('source_credit=?', $source)
                ->order('id_rappro', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRapprochement();
            $entry->setId_rappro($row->id_rappro)
                    ->setDebit_rappro($row->debit_rappro)
                    ->setCredit_rappro($row->credit_rappro)
                    ->setSolde_rappro($row->solde_rappro)
                    ->setSource($row->source)
                    ->setSource_credit($row->source_credit)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setCode_domicilier($row->code_domicilier)
                    ->setId_credit($row->id_credit)
                    ->setType_rappro($row->type_rappro);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findBySmcipnp($code_smcipnp) {
        $select = $this->getDbTable()->select();
        $select->where('code_smcipnp=?', $code_smcipnp)
                ->where('solde_rappro > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $rappro = new Application_Model_EuRapprochement();
        $rappro->setId_rappro($row->id_rappro)
                ->setDebit_rappro($row->debit_rappro)
                ->setCredit_rappro($row->credit_rappro)
                ->setSolde_rappro($row->solde_rappro)
                ->setSource($row->source)
                ->setSource_credit($row->source_credit)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setCode_domicilier($row->code_domicilier)
                ->setId_credit($row->id_credit)
                ->setType_rappro($row->type_rappro);
        return $rappro;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_rappro) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuRapprochement $rappro) {
        $data = array(
            'id_rappro' => $rappro->getId_rappro(),
            'debit_rappro' => $rappro->getDebit_rappro(),
            'credit_rappro' => $rappro->getCredit_rappro(),
            'solde_rappro' => $rappro->getSolde_rappro(),
            'source' => $rappro->getSource(),
            'source_credit' => $rappro->getSource_credit(),
            'code_smcipn' => $rappro->getCode_smcipn(),
            'code_smcipnp' => $rappro->getCode_smcipnp(),
            'code_domicilier' => $rappro->getCode_domicilier(),
            'id_credit' => $rappro->getId_credit(),
            'type_rappro' => $rappro->getType_rappro()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRapprochement $rappro) {
        $data = array(
            'id_rappro' => $rappro->getId_rappro(),
            'debit_rappro' => $rappro->getDebit_rappro(),
            'credit_rappro' => $rappro->getCredit_rappro(),
            'solde_rappro' => $rappro->getSolde_rappro(),
            'source' => $rappro->getSource(),
            'source_credit' => $rappro->getSource_credit(),
            'code_smcipn' => $rappro->getCode_smcipn(),
            'code_smcipnp' => $rappro->getCode_smcipnp(),
            'code_domicilier' => $rappro->getCode_domicilier(),
            'id_credit' => $rappro->getId_credit(),
            'type_rappro' => $rappro->getType_rappro()
        );

        $this->getDbTable()->update($data, array('id_rappro = ?' => $rappro->getId_rappro()));
    }

    public function delete($id_rappro) {
        $this->getDbTable()->delete(array('id_rappro = ?' => $id_rappro));
    }

}

?>
