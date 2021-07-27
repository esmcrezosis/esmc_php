<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDomicilieMf11000Mapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDomicilieMf11000');
        }
        return $this->_dbTable;
    }

    public function find($id_domi, Application_Model_EuDomicilieMf11000 $dmf11000) {
        $result = $this->getDbTable()->find($id_domi);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $dmf11000->setId_domi($row->id_domi)
                ->setCode_membre($row->code_membre)
                ->setMt_domiciliation($row->mt_domiciliation)
                ->setMt_domicilie($row->mt_domicilie)
                ->setEtat_domi($row->etat_domi)
                ->setDate_domi($row->date_domi)
                ->setHeure_domi($row->heure_domi)
                ->setCel($row->cel)
                ->setId_utilisateur($row->id_utilisateur);
        return true;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_domi) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDomicilieMf11000();
            $entry->setId_domi($row->id_domi)
                    ->setCode_membre($row->code_membre)
                    ->setMt_domiciliation($row->mt_domiciliation)
                    ->setMt_domicilie($row->mt_domicilie)
                    ->setEtat_domi($row->etat_domi)
                    ->setDate_domi($row->date_domi)
                    ->setHeure_domi($row->heure_domi)
                    ->setCel($row->cel)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuDomicilieMf11000 $dmf11000) {
        $data = array(
            'id_domi' => $dmf11000->getId_domi(),
            'code_membre' => $dmf11000->getCode_membre(),
            'mt_domiciliation' => $dmf11000->getMt_domiciliation(),
            'mt_domicilie' => $dmf11000->getMt_domicilie(),
            'etat_domi' => $dmf11000->getEtat_domi(),
            'date_domi' => $dmf11000->getDate_domi(),
            'heure_domi' => $dmf11000->getHeure_domi(),
            'cel' => $dmf11000->getCel(),
            'id_utilisateur' => $dmf11000->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDomicilieMf11000 $dmf11000) {
        $data = array(
            'id_domi' => $dmf11000->getId_domi(),
            'code_membre' => $dmf11000->getCode_membre(),
            'mt_domiciliation' => $dmf11000->getMt_domiciliation(),
            'mt_domicilie' => $dmf11000->getMt_domicilie(),
            'etat_domi' => $dmf11000->getEtat_domi(),
            'date_domi' => $dmf11000->getDate_domi(),
            'heure_domi' => $dmf11000->getHeure_domi(),
            'cel' => $dmf11000->getCel(),
            'id_utilisateur' => $dmf11000->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_domi = ?' => $dmf11000->getId_domi()));
    }

    public function delete($id_domi) {
        $this->getDbTable()->delete(array('id_domi = ?' => $id_domi));
    }

}

?>
