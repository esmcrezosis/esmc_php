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
class Application_Model_EuCncsMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCncs');
        }
        return $this->_dbTable;
    }

    public function find($id_cncs, Application_Model_EuCncs $cnp) {
        $result = $this->getDbTable()->find($id_cncs);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $cnp->setId_cncs($row->id_cncs)
                ->setMembre($row->membre)
                ->setType($row->type)
                ->setCompte($row->compte)
                ->setMontant($row->montant)
                ->setDate($row->date);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCncs();
            $entry->setId_cncs($row->id_cncs)
                    ->setMembre($row->membre)
                    ->setType($row->type)
                    ->setCompte($row->compte)
                    ->setMontant($row->montant)
                    ->setDate($row->date);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumRPG($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant) as somme'));
        $select->where('membre = ?', $membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuCncs $cnp) {
        $data = array(
            'id_cncs' => $cnp->getId_cncs(),
            'membre' => $cnp->getMembre(),
            'compte' => $cnp->getMembre(),
            'montant' => $cnp->getMontant(),
            'type' => $cnp->getType(),
            'date' => $cnp->getDate()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCncs $cnp) {
        $data = array(
            'id_cncs' => $cnp->getId_cncs(),
            'membre' => $cnp->getMembre(),
            'compte' => $cnp->getMembre(),
            'montant' => $cnp->getMontant(),
            'type' => $cnp->getType(),
            'date' => $cnp->getDate()
        );

        $this->getDbTable()->update($data, array('id_cncs = ?' => $cnp->getId_cncs()));
    }

    public function delete($id_cncs) {
        $this->getDbTable()->delete(array('id_cncs = ?' => $id_cncs));
    }

}
