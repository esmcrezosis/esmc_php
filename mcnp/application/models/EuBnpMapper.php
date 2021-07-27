<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpSqmaxMapper
 *
 * @author user
 */
class Application_Model_EuBnpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBnp');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuBnp $bnp) {
        $data = array(
            'code_bnp' => $bnp->getCode_bnp(),
            'id_operation' => $bnp->getId_operation(),
            'code_type_bnp' => $bnp->getCode_type_bnp(),
            'code_membre_app' => $bnp->getCode_membre_app(),
            'code_membre_benef' => $bnp->getCode_membre_benef(),
            'montant_bnp' => $bnp->getMontant_bnp(),
            'mont_credit' => $bnp->getMont_credit(),
            'mont_conus' => $bnp->getMont_conus(),
            'mont_par' => $bnp->getMont_par(),
            'mont_panu' => $bnp->getMont_panu(),
            'reconst_par' => $bnp->getReconst_par(),
            'reconst_panu' => $bnp->getReconst_panu(),
            'rembourser' => $bnp->getRembourser(),
            'periode' => $bnp->getPeriode(),
            'conus' => $bnp->getConus(),
            'panu' => $bnp->getPanu()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBnp $bnp) {
        $data = array(
            'code_bnp' => $bnp->getCode_bnp(),
            'id_operation' => $bnp->getId_operation(),
            'code_type_bnp' => $bnp->getCode_type_bnp(),
            'code_membre_app' => $bnp->getCode_membre_app(),
            'code_membre_benef' => $bnp->getCode_membre_benef(),
            'montant_bnp' => $bnp->getMontant_bnp(),
            'mont_credit' => $bnp->getMont_credit(),
            'mont_conus' => $bnp->getMont_conus(),
            'mont_par' => $bnp->getMont_par(),
            'mont_panu' => $bnp->getMont_panu(),
            'reconst_par' => $bnp->getReconst_par(),
            'reconst_panu' => $bnp->getReconst_panu(),
            'rembourser' => $bnp->getRembourser(),
            'periode' => $bnp->getPeriode(),
            'conus' => $bnp->getConus(),
            'panu' => $bnp->getPanu()
        );
        $this->getDbTable()->update($data, array('code_bnp = ?' => $bnp->getCode_bnp()));
    }

    public function find($num_compte, Application_Model_EuBnp $bnp) {
        $result = $this->getDbTable()->find($num_compte);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $bnp->setCode_bnp($row->code_bnp)
                ->setId_operation($row->id_operation)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setCode_membre_app($row->code_membre_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMontant_bnp($row->montant_bnp)
                ->setMont_credit($row->mont_credit)
                ->setMont_conus($row->mont_conus)
                ->setMont_par($row->mont_par)
                ->setMont_panu($row->mont_panu)
                ->setReconst_par($row->reconst_par)
                ->setReconst_panu($row->reconst_panu)
                ->setRembourser($row->rembourser)
                ->setPeriode($row->periode)
                ->setConus($row->conus)
                ->setPanu($row->panu);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBnp();
            $entry->setCode_bnp($row->code_bnp)
                    ->setId_operation($row->id_operation)
                    ->setCode_type_bnp($row->code_type_bnp)
                    ->setCode_membre_app($row->code_membre_app)
                    ->setCode_membre_benef($row->code_membre_benef)
                    ->setMontant_bnp($row->montant_bnp)
                    ->setMont_credit($row->mont_credit)
                    ->setMont_conus($row->mont_conus)
                    ->setMont_par($row->mont_par)
                    ->setMont_panu($row->mont_panu)
                    ->setReconst_par($row->reconst_par)
                    ->setReconst_panu($row->reconst_panu)
                    ->setRembourser($row->rembourser)
                    ->setPeriode($row->periode)
                    ->setConus($row->conus)
                    ->setPanu($row->panu);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findBnp($codebnp, $membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_type_bnp = ?', $codebnp)->where('code_membre_benef = ?', $membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            $bnp = new Application_Model_EuBnp();
            $bnp->setCode_bnp($row->code_bnp)
                ->setId_operation($row->id_operation)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setCode_membre_app($row->code_membre_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMontant_bnp($row->montant_bnp)
                ->setMont_credit($row->mont_credit)
                ->setMont_conus($row->mont_conus)
                ->setMont_par($row->mont_par)
                ->setMont_panu($row->mont_panu)
                ->setReconst_par($row->reconst_par)
                ->setReconst_panu($row->reconst_panu)
                ->setRembourser($row->rembourser)
                ->setPeriode($row->periode)
                ->setConus($row->conus)
                ->setPanu($row->panu);
				return $bnp;
        }
    }

    public function delete($code_bnp) {
        $this->getDbTable()->delete(array('code_bnp = ?' => $code_bnp));
    }

}

?>
