<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailBnpMapper
 *
 * @author user
 */
class Application_Model_EuDetailBnpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailBnp');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuDetailBnp $bnp) {
        $data = array(
            'id_detail' => $bnp->getId_detail(),
            'code_bnp' => $bnp->getCode_bnp(),
            'id_credit' => $bnp->getId_credit(),
            'mont_capa' => $bnp->getMont_capa(),
            'montant_credit' => $bnp->getMontant_credit(),
            'mont_par' => $bnp->getMont_par(),
            'mont_panu' => $bnp->getMont_panu(),
            'mont_fs' => $bnp->getMont_fs(),
            'mont_panu_fs' => $bnp->getMont_panu_fs(),
            'mont_conus' => $bnp->getMont_conus(),
            'periode' => $bnp->getPeriode(),
            'renouv_effectue' => $bnp->getRenouv_effectue()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailBnp $bnp) {
        $data = array(
            'id_detail' => $bnp->getId_detail(),
            'code_bnp' => $bnp->getCode_bnp(),
            'id_credit' => $bnp->getId_credit(),
            'mont_capa' => $bnp->getMont_capa(),
            'montant_credit' => $bnp->getMontant_credit(),
            'mont_par' => $bnp->getMont_par(),
            'mont_panu' => $bnp->getMont_panu(),
            'mont_fs' => $bnp->getMont_fs(),
            'mont_panu_fs' => $bnp->getMont_panu_fs(),
            'mont_conus' => $bnp->getMont_conus(),
            'periode' => $bnp->getPeriode(),
            'renouv_effectue' => $bnp->getRenouv_effectue()
        );
        $this->getDbTable()->update($data, array('id_detail = ?' => $bnp->getId_detail()));
    }

    public function find($id_detail, Application_Model_EuDetailBnp $bnp) {
        $result = $this->getDbTable()->find($id_detail);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $bnp->setId_detail($row->id_detail)
                ->setCode_bnp($row->code_bnp)
                ->setId_credit($row->id_credit)
                ->setMont_capa($row->mont_capa)
                ->setMontant_credit($row->montant_credit)
                ->setMont_conus($row->mont_conus)
                ->setMont_par($row->mont_par)
                ->setMont_panu($row->mont_panu)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setPeriode($row->periode)
                ->setRenouv_effectue($row->renouv_effectue);
        return true;
    }

	public function findConuter() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('MAX(id_detail) as count'));
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];
    }
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailBnp();
            $entry->setId_detail($row->id_detail)
                    ->setCode_bnp($row->code_bnp)
                    ->setId_credit($row->id_credit)
                    ->setMont_capa($row->mont_capa)
                    ->setMontant_credit($row->montant_credit)
                    ->setMont_conus($row->mont_conus)
                    ->setMont_par($row->mont_par)
                    ->setMont_panu($row->mont_panu)
                    ->setMont_fs($row->mont_fs)
                    ->setMont_panu_fs($row->mont_panu_fs)
                    ->setPeriode($row->periode)
                    ->setRenouv_effectue($row->renouv_effectue);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findDetailBnp($codebnp) {
        $select = $this->getDbTable()->select();
        $select->where('code_bnp =?', $codebnp);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $entries = array();
            foreach ($result as $row) {
                $entry = new Application_Model_EuDetailBnp();
                $entry->setId_detail($row->id_detail)
                        ->setCode_bnp($row->code_bnp)
                        ->setId_credit($row->id_credit)
                        ->setMont_capa($row->mont_capa)
                        ->setMontant_credit($row->montant_credit)
                        ->setMont_conus($row->mont_conus)
                        ->setMont_par($row->mont_par)
                        ->setMont_panu($row->mont_panu)
                        ->setMont_fs($row->mont_fs)
                        ->setMont_panu_fs($row->mont_panu_fs)
                        ->setPeriode($row->periode)
                        ->setRenouv_effectue($row->renouv_effectue);
                $entries[] = $entry;
            }
            return $entries;
        }
    }

    public function findDetailBnpByCredit($codebnp,$codecredi) {
        $select = $this->getDbTable()->select();
        $select->where('code_bnp =?', $codebnp)->where('id_credit =?', $codecredi);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
           return NULL;
        } else {
            $entries = array();
            foreach ($result as $row) {
                $entry = new Application_Model_EuDetailBnp();
                $entry->setId_detail($row->id_detail)
                      ->setCode_bnp($row->code_bnp)
                      ->setId_credit($row->id_credit)
                      ->setMont_capa($row->mont_capa)
                      ->setMontant_credit($row->montant_credit)
                      ->setMont_conus($row->mont_conus)
                      ->setMont_par($row->mont_par)
                      ->setMont_panu($row->mont_panu)
                      ->setMont_fs($row->mont_fs)
                      ->setMont_panu_fs($row->mont_panu_fs)
                      ->setPeriode($row->periode)
                      ->setRenouv_effectue($row->renouv_effectue);
                $entries[] = $entry;
            }
            return $entries;
        }
    }

    public function findDetailBnpByCreditPeriode($codebnp, $codecredi, $per_deb, $per_fin) {
        $select = $this->getDbTable()->select();
        $select->where('code_bnp =?', $codebnp)
                ->where('id_credit =?', $codecredi)
                ->where('periode >?', $per_deb)
                ->where('periode <=?', $per_fin);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            $bnp = new Application_Model_EuDetailBnp();
            $bnp->setId_detail($row->id_detail)
                    ->setCode_bnp($row->code_bnp)
                    ->setId_credit($row->id_credit)
                    ->setMont_capa($row->mont_capa)
                    ->setMontant_credit($row->montant_credit)
                    ->setMont_conus($row->mont_conus)
                    ->setMont_par($row->mont_par)
                    ->setMont_panu($row->mont_panu)
                    ->setMont_fs($row->mont_fs)
                    ->setMont_panu_fs($row->mont_panu_fs)
                    ->setPeriode($row->periode)
                    ->setRenouv_effectue($row->renouv_effectue);
            return $bnp;
        }
    }

    public function findDetailBnpByPeriode($codebnp, $codecredit, $periode) {
        $select = $this->getDbTable()->select();
        $select->where('code_bnp =?', $codebnp)
                ->where('id_credit =?', $codecredit)
                ->where('periode >=?', $periode);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $entries = array();
            foreach ($result as $row) {
                $entry = new Application_Model_EuDetailBnp();
                $entry->setId_detail($row->id_detail)
                        ->setCode_bnp($row->code_bnp)
                        ->setId_credit($row->id_credit)
                        ->setMont_capa($row->mont_capa)
                        ->setMontant_credit($row->montant_credit)
                        ->setMont_conus($row->mont_conus)
                        ->setMont_par($row->mont_par)
                        ->setMont_panu($row->mont_panu)
                        ->setMont_fs($row->mont_fs)
                        ->setMont_panu_fs($row->mont_panu_fs)
                        ->setPeriode($row->periode)
                        ->setRenouv_effectue($row->renouv_effectue);
                $entries[] = $entry;
            }
            return $entries;
        }
    }

    public function delete($id_detail) {
        $this->getDbTable()->delete(array('id_detail = ?' => $id_detail));
    }

}

?>
