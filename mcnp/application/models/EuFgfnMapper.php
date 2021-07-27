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
class Application_Model_EuFgfnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFgfn');
        }
        return $this->_dbTable;
    }

    public function find($idfg_fn, Application_Model_EuFgfn $fn) {
        $result = $this->getDbTable()->find($idfg_fn);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $fn->setCode_fgfn($row->code_fgfn)
                ->setCode_membre($row->code_membre)
                ->setSolde_fgfn($row->solde_fgfn);
        return true;
    }

    public function find1() {
        $table = new Application_Model_DbTable_EuFgfn();
        $select = $table->select();
        $select->where('solde_fgfn >?', 0)
                ->order('code_fgfn', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuFgfn();
            $entry->setCode_fgfn($row->code_fgfn)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_fgfn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFgfn();
            $entry->setCode_fgfn($row->code_fgfn)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchByUser($user) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre=?', $user);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFgFn();
            $entry->setCode_fgfn($row->code_fgfn)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByPbf($pbf) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre <> ?', $pbf);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFgFn();
            $entry->setCode_fgfn($row->code_fgfn)
                    ->setCode_membre($row->code_membre)
                    ->setSolde($row->solde_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuFgfn $fn) {
        $data = array(
            'code_fgfn' => $fn->getCode_fgfn(),
            'code_membre' => $fn->getCode_membre(),
            'solde_fgfn' => $fn->getSolde_fgfn()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFgfn $fn) {
        $data = array(
            'code_fgfn' => $fn->getCode_fgfn(),
            'code_membre' => $fn->getCode_membre(),
            'solde_fgfn' => $fn->getSolde_fgfn()
        );

        $this->getDbTable()->update($data, array('code_fgfn = ?' => $fn->getCode_fgfn()));
    }

    public function delete($idfg_fn) {
        $this->getDbTable()->delete(array('code_fgfn = ?' => $idfg_fn));
    }

}
