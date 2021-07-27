<?php

class Application_Model_EuJustifierMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuJustifier');
        }
        return $this->_dbTable;
    }

    public function find($code_membre, $code_smcipn, Application_Model_EuJustifier $just) {
        $result = $this->getDbTable()->find($code_membre, $code_smcipn);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $just->setCode_membre($row->code_membre)
                ->setCode_smcipn($row->code_smcipn)
                ->setSalaire($row->salaire)
                ->setAffecter($row->affecter)
                ->setSolde($row->solde);
    }

    public function findBySmcipn($code_smcipn) {
        $select = $this->getDbTable()->select();
        $select->where('code_smcipn = ?', $code_smcipn);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuJustifier();
            $entry->setCode_membre($row->code_membre)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setSalaire($row->salaire)
                    ->setAffecter($row->affecter)
                    ->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuJustifier();
            $entry->setCode_membre($row->code_membre)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setSalaire($row->salaire)
                    ->setAffecter($row->affecter)
                    ->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuJustifier $justif) {
        $data = array(
            'code_membre' => $justif->getCode_membre(),
            'code_smcipn' => $justif->getCode_smcipn(),
            'salaire' => $justif->getSalaire(),
            'affecter' => $justif->getAffecter(),
            'solde' => $justif->getSolde()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuJustifier $justif) {
        $data = array(
            'code_membre' => $justif->getCode_membre(),
            'code_smcipn' => $justif->getCode_smcipn(),
            'salaire' => $justif->getSalaire(),
            'affecter' => $justif->getAffecter(),
            'solde' => $justif->getSolde()
        );
        $this->getDbTable()->update($data, array('code_membre = ?' => $justif->getCode_membre(), 'code_smcipn = ?' => $justif->getCode_smcipn()));
    }

    public function delete($code_membre, $code_smcipn) {
        $this->getDbTable()->delete(array('code_membre = ?' => $code_membre, 'code_smcipn = ?' => $code_smcipn));
    }

}