<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuMprgMapper
 *
 * @author user
 */
class Application_Model_EuMprgMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMprg');
        }
        return $this->_dbTable;
    }

    public function find($id_mprg, Application_Model_EuMprg $mprg) {
        $result = $this->getDbTable()->find($id_mprg);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $mprg->setId_mprg($row->id_mprg)
                ->setMembre($row->membre)
                ->setCompte($row->compte)
                ->setCredit($row->credit)
                ->setDatedeb($row->datedeb)
                ->setNbre_tranche($row->nbre_tranche)
                ->setDatefin($row->datefin)
                ->setMontant($row->montant)
                ->setMont_echu($row->mont_echu)
                ->setMont_remb($row->mont_remb)
                ->setSolde($row->solde)
                ->setPeriode($row->periode)
                ->setSource($row->source)
                ->setDate_oper($row->date_oper)
                ->setOperateur($row->operateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMprg();
            $entry->setId_mprg($row->id_mprg)
                    ->setMembre($row->membre)
                    ->setCompte($row->compte)
                    ->setCredit($row->credit)
                    ->setDatedeb($row->datedeb)
                    ->setNbre_tranche($row->nbre_tranche)
                    ->setDatefin($row->datefin)
                    ->setMontant($row->montant)
                    ->setMont_echu($row->mont_echu)
                    ->setMont_remb($row->mont_remb)
                    ->setSolde($row->solde)
                    ->setPeriode($row->periode)
                    ->setSource($row->source)
                    ->setDate_oper($row->date_oper)
                    ->setOperateur($row->operateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuMprg $mprg) {
        $data = array(
            'id_mprg' => $mprg->getId_mprg(),
            'membre' => $mprg->getMembre(),
            'compte' => $mprg->getCompte(),
            'credit' => $mprg->getCredit(),
            'datedeb' => $mprg->getDatedeb(),
            'nbre_tranche' => $mprg->getNbre_tranche(),
            'datefin' => $mprg->getDatefin(),
            'montant' => $mprg->getMontant(),
            'mont_echu' => $mprg->getMont_echu(),
            'mont_remb' => $mprg->getMont_remb(),
            'solde' => $mprg->getSolde(),
            'periode' => $mprg->getPeriode(),
            'source' => $mprg->getSource(),
            'date_oper' => $mprg->getDate_oper(),
            'operateur' => $mprg->getOperateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMprg $mprg) {
        $data = array(
            'id_mprg' => $mprg->getId_mprg(),
            'membre' => $mprg->getMembre(),
            'compte' => $mprg->getCompte(),
            'credit' => $mprg->getCredit(),
            'datedeb' => $mprg->getDatedeb(),
            'nbre_tranche' => $mprg->getNbre_tranche(),
            'datefin' => $mprg->getDatefin(),
            'montant' => $mprg->getMontant(),
            'mont_echu' => $mprg->getMont_echu(),
            'mont_remb' => $mprg->getMont_remb(),
            'solde' => $mprg->getSolde(),
            'periode' => $mprg->getPeriode(),
            'source' => $mprg->getSource(),
            'date_oper' => $mprg->getDate_oper(),
            'operateur' => $mprg->getOperateur()
        );
        $this->getDbTable()->update($data, array('id_mprg = ?' => $mprg->getId_mprg()));
    }

    public function delete($id_mprg) {
        $this->getDbTable()->delete(array('id_mprg = ?' => $id_mprg));
    }

}

?>
