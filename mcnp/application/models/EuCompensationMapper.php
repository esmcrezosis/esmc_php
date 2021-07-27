<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EucnpMapper
 *
 * @author user
 */
class Application_Model_EuCompensationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompensation');
        }
        return $this->_dbTable;
    }

    public function find($id_compensation, Application_Model_EuCompensation $compens) {
        $result = $this->getDbTable()->find($id_compensation);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $compens->setId_compens($row->id_compens)
                ->setCode_compte($row->code_compte)
                ->setMont_compens($row->mont_compens)
                ->setCode_membre_pbf($row->code_membre_pbf)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setDate_compens($row->date_compens)
                ->setHeure_compens($row->heure_compens)
                ->setId_operation($row->id_operation)
                ->setPeriode($row->periode)
                ->setNtf($row->ntf)
                ->setMont_tranche($row->mont_tranche)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setMont_echu($row->mont_echu)
                ->setDate_deb_tranche($row->date_deb_tranche)
                ->setDate_fin_tranche($row->date_fin_tranche)
                ->setReste_ntf($row->reste_ntf)
                ->setSolde_compensation($row->solde_compensation);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompensation();
            $entry->setId_compens($row->id_compens)
                ->setCode_compte($row->code_compte)
                ->setMont_compens($row->mont_compens)
                ->setCode_membre_pbf($row->code_membre_pbf)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setDate_compens($row->date_compens)
                ->setHeure_compens($row->heure_compens)
                ->setId_operation($row->id_operation)
                ->setPeriode($row->periode)
                ->setNtf($row->ntf)
                ->setMont_tranche($row->mont_tranche)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setMont_echu($row->mont_echu)
                ->setDate_deb_tranche($row->date_deb_tranche)
                ->setDate_fin_tranche($row->date_fin_tranche)
                ->setReste_ntf($row->reste_ntf)
                ->setSolde_compensation($row->solde_compensation);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSoldeByCompte($compte) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('mont_compens', 'mont_echu'))
                ->where('code_compte LIKE ?', $compte);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) > 0) {
            $row = $resultSet->current();
            return $row->mont_compens - $row->mont_echu;
        } else {
            return 0;
        }
    }

    public function getMontCompensationEchu($ids) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_echu) as echu'))
                ->where('id_compens IN (?)', $ids);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) > 0) {
            $row = $resultSet->current();
            return $row->echu;
        } else {
            return 0;
        }
    }

    public function getCompensationByCompte($compte) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte LIKE ?', $compte)
                ->where('mont_echu > ?', 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) > 0) {
            $entries = array();
            foreach ($resultSet as $row) {
                $entry = new Application_Model_EuCompensation();
                $entry->setId_compens($row->id_compens)
                ->setCode_compte($row->code_compte)
                ->setMont_compens($row->mont_compens)
                ->setCode_membre_pbf($row->code_membre_pbf)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setDate_compens($row->date_compens)
                ->setHeure_compens($row->heure_compens)
                ->setId_operation($row->id_operation)
                ->setPeriode($row->periode)
                ->setNtf($row->ntf)
                ->setMont_tranche($row->mont_tranche)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setMont_echu($row->mont_echu)
                ->setDate_deb_tranche($row->date_deb_tranche)
                ->setDate_fin_tranche($row->date_fin_tranche)
                ->setReste_ntf($row->reste_ntf)
                ->setSolde_compensation($row->solde_compensation);
                $entries[] = $entry;
            }
            return $entries;
        } else {
            return NULL;
        }
    }

    public function save(Application_Model_EuCompensation $compens) {
        $data = array(
            'id_compens' => $compens->getId_compens(),
            'code_compte' => $compens->getCode_compte(),
            'mont_compens' => $compens->getMont_compens(),
            'code_membre_pbf' => $compens->getCode_membre_pbf(),
            'code_membre_benef' => $compens->getCode_membre_benef(),
            'date_compens' => $compens->getDate_compens(),
            'heure_compens' => $compens->getHeure_compens(),
            'id_operation' => $compens->getId_operation(),
            'ntf' => $compens->getNtf(),
            'mont_tranche' => $compens->getMont_tranche(),
            'date_deb' => $compens->getDate_deb(),
            'periode' => $compens->getPeriode(),
            'date_fin' => $compens->getDate_fin(),
            'mont_echu' => $compens->getMont_echu(),
            'date_fin_tranche' => $compens->getDate_fin_tranche(),
            'date_deb_tranche' => $compens->getDate_deb_tranche(),
            'reste_ntf' => $compens->getReste_ntf(),
            'solde_compensation' => $compens->getSolde_compensation()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCompensation $compens) {
        $data = array(
           'id_compens' => $compens->getId_compens(),
            'code_compte' => $compens->getCode_compte(),
            'mont_compens' => $compens->getMont_compens(),
            'code_membre_pbf' => $compens->getCode_membre_pbf(),
            'code_membre_benef' => $compens->getCode_membre_benef(),
            'date_compens' => $compens->getDate_compens(),
            'heure_compens' => $compens->getHeure_compens(),
            'id_operation' => $compens->getId_operation(),
            'ntf' => $compens->getNtf(),
            'mont_tranche' => $compens->getMont_tranche(),
            'date_deb' => $compens->getDate_deb(),
            'periode' => $compens->getPeriode(),
            'date_fin' => $compens->getDate_fin(),
            'mont_echu' => $compens->getMont_echu(),
            'date_fin_tranche' => $compens->getDate_fin_tranche(),
            'date_deb_tranche' => $compens->getDate_deb_tranche(),
            'reste_ntf' => $compens->getReste_ntf(),
            'solde_compensation' => $compens->getSolde_compensation()
        );

        $this->getDbTable()->update($data, array('id_compens = ?' => $compens->getId_compens()));
    }

    public function delete($id_compens) {
        $this->getDbTable()->delete(array('id_compens = ?' => $id_compens));
    }

}
