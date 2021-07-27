<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpCreditMapper
 *
 * @author user
 */
class Application_Model_EuBnpCreditMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBnpCredit');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuBnpCredit $bnp) {
        $data = array(
            'code_bnp' => $bnp->getCode_bnp(),
            'id_credit' => $bnp->getId_credit(),
            'mont_credit' => $bnp->getMont_credit(),
            'mont_conus' => $bnp->getMont_conus(),
            'mont_par' => $bnp->getMont_par(),
            'mont_panu' => $bnp->getMont_panu(),
            'mont_fs' => $bnp->getMont_fs(),
            'mont_panu_fs' => $bnp->getMont_panu_fs(),
            'periode_remb' => $bnp->getPeriode_remb()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBnpCredit $bnp) {
        $data = array(
            'code_bnp' => $bnp->getCode_bnp(),
            'id_credit' => $bnp->getId_credit(),
            'mont_credit' => $bnp->getMont_credit(),
            'mont_conus' => $bnp->getMont_conus(),
            'mont_par' => $bnp->getMont_par(),
            'mont_panu' => $bnp->getMont_panu(),
            'mont_fs' => $bnp->getMont_fs(),
            'mont_panu_fs' => $bnp->getMont_panu_fs(),
            'periode_remb' => $bnp->getPeriode_remb()
        );
        $this->getDbTable()->update($data, array('code_bnp = ?' => $bnp->getCode_bnp(), 'id_credit' => $bnp->getId_credit()));
    }

    public function find($code_bnp, $id_credit, Application_Model_EuBnpCredit $bnp) {
        $result = $this->getDbTable()->find($code_bnp, $id_credit);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $bnp->setCode_bnp($row->code_bnp)
                ->setId_credit($row->id_credit)
                ->setMont_credit($row->mont_credit)
                ->setMont_conus($row->mont_conus)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu($row->mont_panu)
                ->setMont_par($row->mont_par)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setPeriode_remb($row->periode_remb);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBnpCredit();
            $entry->setCode_bnp($row->code_bnp)
                    ->setId_credit($row->id_credit)
                    ->setMont_credit($row->mont_credit)
                    ->setMont_conus($row->mont_conus)
                    ->setMont_fs($row->mont_fs)
                    ->setMont_panu($row->mont_panu)
                    ->setMont_par($row->mont_par)
                    ->setMont_panu_fs($row->mont_panu_fs)
                    ->setPeriode_remb($row->periode_remb);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findBnp($codebnp) {
        $select = $this->getDbTable()->select();
        $select->where('code_bnp =?', $codebnp);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            $bnp = new Application_Model_EuBnpCredit();
            $bnp->setCode_bnp($row->code_bnp)
                    ->setId_credit($row->id_credit)
                    ->setMont_credit($row->mont_credit)
                    ->setMont_conus($row->mont_conus)
                    ->setMont_fs($row->mont_fs)
                    ->setMont_panu($row->mont_panu)
                    ->setMont_par($row->mont_par)
                    ->setMont_panu_fs($row->mont_panu_fs)
                    ->setPeriode_remb($row->periode_remb);
            return $bnp;
        }
    }

    public function findBnpCredit($codebnp, $codecredi) {
        $select = $this->getDbTable()->select();
        $select->where('code_bnp =?', $codebnp)->where('code_credit =?', $codecredi);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            $bnp = new Application_Model_EuBnpCredit();
            $bnp->setCode_bnp($row->code_bnp)
                    ->setId_credit($row->id_credit)
                    ->setMont_credit($row->mont_credit)
                    ->setMont_conus($row->mont_conus)
                    ->setMont_fs($row->mont_fs)
                    ->setMont_panu($row->mont_panu)
                    ->setMont_par($row->mont_par)
                    ->setMont_panu_fs($row->mont_panu_fs)
                    ->setPeriode_remb($row->periode_remb);
            return $bnp;
        }
    }

    public function delete($code_bnp, $id_credit) {
        $this->getDbTable()->delete(array('code_bnp = ?' => $code_bnp, 'id_credit' => $id_credit));
    }

}

?>
