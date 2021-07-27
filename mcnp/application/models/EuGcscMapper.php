<?php

class Application_Model_EuGcscMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGcsc');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuGcsc $gcsc) {
        $data = array(
            'id_gcsc' => $gcsc->getId_gcsc(),
            'code_membre' => $gcsc->getCode_membre(),
            'debit' => $gcsc->getDebit(),
            'credit' => $gcsc->getCredit(),
            'solde' => $gcsc->getSolde(),
            'code_smcipn' => $gcsc->getCode_smcipn(),
            'code_domicilier' => $gcsc->getCode_domicilier()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGcsc $gcsc) {
        $data = array(
            'id_gcsc' => $gcsc->getId_gcsc(),
            'code_membre' => $gcsc->getCode_membre(),
            'debit' => $gcsc->getDebit(),
            'credit' => $gcsc->getCredit(),
            'solde' => $gcsc->getSolde(),
            'code_smcipn' => $gcsc->getCode_smcipn(),
            'code_domicilier' => $gcsc->getCode_domicilier()
        );
        $this->getDbTable()->update($data, array('id_gcsc = ?' => $gcsc->getId_gcsc()));
    }

    public function find($id_gcsc, Application_Model_EuGcsc $gcsc) {
        $result = $this->getDbTable()->find($id_gcsc);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $gcsc->setId_gcsc($row->id_gcsc)
                ->setCode_membre($row->code_membre)
                ->setDebit($row->debit)
                ->setCredit($row->credit)
                ->setSolde($row->solde)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_domicilier($row->code_domicilier);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGcsc();
            $entry->setId_gcsc($row->id_gcsc)
                    ->setCode_membre($row->code_membre)
                    ->setDebit($row->debit)
                    ->setCredit($row->credit)
                    ->setSolde($row->solde)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_domicilier($row->code_domicilier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByMembreAndSmcipn($membre, $smcipn) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre= ?', $membre)
                ->where('code_smcipn = ?', $smcipn)
                ->where('solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $gcsc = new Application_Model_EuGcsc();
        $gcsc->setId_gcsc($row->id_gcsc)
                ->setCode_membre($row->code_membre)
                ->setDebit($row->debit)
                ->setCredit($row->credit)
                ->setSolde($row->solde)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_domicilier($row->code_domicilier);
        return $gcsc;
    }

    public function findByDomicilie($code_domici) {
        $select = $this->getDbTable()->select();
        $select->where('code_domicilier = ?', $code_domici)
                ->where('solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $gcsc = new Application_Model_EuGcsc();
        $gcsc->setId_gcsc($row->id_gcsc)
                ->setCode_membre($row->code_membre)
                ->setDebit($row->debit)
                ->setCredit($row->credit)
                ->setSolde($row->solde)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_domicilier($row->code_domicilier);
        return $gcsc;
    }
    
    public function findBySmcipnp($code_smcipnp) {
        $select = $this->getDbTable()->select();
        $select->where('code_smcipn = ?', $code_smcipnp)
                //->where('solde > ?', 0)
				;
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $gcsc = new Application_Model_EuGcsc();
        $gcsc->setId_gcsc($row->id_gcsc)
                ->setCode_membre($row->code_membre)
                ->setDebit($row->debit)
                ->setCredit($row->credit)
                ->setSolde($row->solde)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_domicilier($row->code_domicilier);
        return $gcsc;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_gcsc) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function delete($id_gcsc) {
        $this->getDbTable()->delete(array('id_gcsc = ?' => $id_gcsc));
    }

}

