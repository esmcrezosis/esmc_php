<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDetailMf11000Mapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailMf11000');
        }
        return $this->_dbTable;
    }

    public function find($id_mf11000, Application_Model_EuDetailMf11000 $dmf11000) {
        $result = $this->getDbTable()->find($id_mf11000);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $dmf11000->setId_mf11000($row->id_mf11000)
                ->setNum_bon($row->num_bon)
                ->setCode_membre($row->code_membre)
                ->setDate_mf11000($row->date_mf11000)
                ->setMont_apport($row->mont_apport)
                ->setCel($row->cel)
                ->setPourcentage($row->pourcentage)
                ->setId_utilisateur($row->id_utilisateur)
                ->setProprietaire($row->proprietaire);
        return true;
    }

    public function findByNumbon($num_bon) {
        $select = $this->getDbTable()->select();
        $select->where('num_bon = ?', $num_bon);
        $select->where('proprietaire = ?', 1);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $dmf11000 = new Application_Model_EuDetailMf11000();
        $dmf11000->setId_mf11000($row->id_mf11000)
                ->setNum_bon($row->num_bon)
                ->setCode_membre($row->code_membre)
                ->setDate_mf11000($row->date_mf11000)
                ->setMont_apport($row->mont_apport)
                ->setCel($row->cel)
                ->setPourcentage($row->pourcentage)
                ->setId_utilisateur($row->id_utilisateur)
                ->setProprietaire($row->proprietaire);
        return $dmf11000;
    }

    public function findByNumerobon($num_bon) {
        $select = $this->getDbTable()->select();
        $select->where('num_bon = ?', $num_bon);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuDetailMf11000();
            $entry->setId_mf11000($row->id_mf11000)
                    ->setNum_bon($row->num_bon)
                    ->setCode_membre($row->code_membre)
                    ->setDate_mf11000($row->date_mf11000)
                    ->setMont_apport($row->mont_apport)
                    ->setCel($row->cel)
                    ->setPourcentage($row->pourcentage)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setProprietaire($row->proprietaire);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(),array('MAX(id_mf11000) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function getSumNumbon($num_bon) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_apport) as somme'));
        $select->where('num_bon =?', $num_bon);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailMf11000();
            $entry->setId_mf11000($row->id_mf11000)
                    ->setNum_bon($row->num_bon)
                    ->setCode_membre($row->code_membre)
                    ->setDate_mf11000($row->date_mf11000)
                    ->setMont_apport($row->mont_apport)
                    ->setCel($row->cel)
                    ->setPourcentage($row->pourcentage)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setProprietaire($row->proprietaire);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuDetailMf11000 $dmf11000) {
        $data = array(
            'id_mf11000' => $dmf11000->getId_mf11000(),
            'num_bon' => $dmf11000->getNum_bon(),
            'code_membre' => $dmf11000->getCode_membre(),
            'date_mf11000' => $dmf11000->getDate_mf11000(),
            'mont_apport' => $dmf11000->getMont_apport(),
            'cel' => $dmf11000->getCel(),
            'pourcentage' => $dmf11000->getPourcentage(),
            'id_utilisateur' => $dmf11000->getId_utilisateur(),
            'proprietaire' => $dmf11000->getProprietaire()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailMf11000 $dmf11000) {
        $data = array(
            'id_mf11000' => $dmf11000->getId_mf11000(),
            'num_bon' => $dmf11000->getNum_bon(),
            'code_membre' => $dmf11000->getCode_membre(),
            'date_mf11000' => $dmf11000->getDate_mf11000(),
            'mont_apport' => $dmf11000->getMont_apport(),
            'cel' => $dmf11000->getCel(),
            'pourcentage' => $dmf11000->getPourcentage(),
            'id_utilisateur' => $dmf11000->getId_utilisateur(),
            'proprietaire' => $dmf11000->getProprietaire()
        );
        $this->getDbTable()->update($data, array('id_mf11000 = ?' => $dmf11000->getId_mf11000()));
    }

    public function delete($id_mf11000) {
        $this->getDbTable()->delete(array('id_mf11000 = ?' => $id_mf11000));
    }

}

?>
