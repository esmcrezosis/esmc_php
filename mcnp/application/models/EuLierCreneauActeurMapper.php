<?php

class Application_Model_EuLierCreneauActeurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLierCreneauActeur');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuLierCreneauActeur $lier) {
        $data = array(
            'id' => $lier->getId(),
            'code_creneau' => $lier->getCode_creneau(),
            'code_acteur' => $lier->getCode_acteur(),
            'date_adhesion' => $lier->getDate_adhesion(),
            'heure_adhesion' => $lier->getHeure_adhesion(),
            'cree_par' => $lier->getCree_par(),
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuLierCreneauActeur $lier) {
        $data = array(
            'id' => $lier->getId(),
            'code_creneau' => $lier->getCode_creneau(),
            'code_acteur' => $lier->getCode_acteur(),
            'date_adhesion' => $lier->getDate_adhesion(),
            'heure_adhesion' => $lier->getHeure_adhesion(),
            'cree_par' => $lier->getCree_par(),
        );
        $this->getDbTable()->update($data, array('id = ?' => $lier->getId()));
    }

    public function find($id, Application_Model_EuLierCreneauActeur $lier) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $lier->setId($row->id)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_acteur($row->code_acteur)
                    ->setDate_adhesion($row->date_adhesion)
                    ->setHeure_adhesion($row->heure_adhesion)
                    ->setCree_par($row->cree_par);
            return true;
        }
    }
    
    public function find1($code_creneau, $code_acteur) {
        $table = new Application_Model_DbTable_EuLierCreneauActeur();
        $select = $table->select();
        $select->where('code_creneau=?', $code_creneau);
        $select->where('code_acteur=?', $code_acteur);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuLierCreneauActeur();
            $entry->setId($row->id)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_acteur($row->code_acteur)
                    ->setDate_adhesion($row->date_adhesion)
                    ->setHeure_adhesion($row->heure_adhesion)
                    ->setCree_par($row->cree_par);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find2($code_creneau) {
        $table = new Application_Model_DbTable_EuLierCreneauActeur();
        $select = $table->select();
        $select->where('code_creneau=?', $code_creneau);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuLierCreneauActeur();
            $entry->setId($row->id)
                    ->setCode_creneau($row->code_creneau)
                    ->setCode_acteur($row->code_acteur)
                    ->setDate_adhesion($row->date_adhesion)
                    ->setHeure_adhesion($row->heure_adhesion)
                    ->setCree_par($row->cree_par);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLierCreneauActeur();
            $entry->setId($row->id);
            $entry->setCode_creneau($row->code_creneau);
            $entry->setCode_acteur($row->code_acteur);
            $entry->setDate_adhesion($row->date_adhesion);
            $entry->setHeure_adhesion($row->heure_adhesion);
            $entry->setCree_par($row->cree_par);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

}