<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDetailDomicilieMf11000Mapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailDomicilieMf11000');
        }
        return $this->_dbTable;
    }

    public function find($id_domi, $id_mf11000, Application_Model_EuDetailDomicilieMf11000 $dmf11000) {
        $result = $this->getDbTable()->find($id_domi, $id_mf11000);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $dmf11000->setId_domi($row->id_domi)
                ->setId_mf11000($row->id_mf11000)
                ->setMt_domi_apport($row->mt_domi_apport)
                ->setNb_repartition($row->nb_repartition)
                ->setReste_repartition($row->nb_repartition);
        return true;
    }

    public function findDetailDomi($id_mf11000) {
        $table = new Application_Model_DbTable_EuDetailDomicilieMf11000();
        $select = $table->select();
        $select->where('id_mf11000 = ?', $id_mf11000);
        $select->where('reste_repartition > ?', 0);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuDetailDomicilieMf11000();
            $entry->setId_domi($row->id_domi)
                    ->setId_mf11000($row->id_mf11000)
                    ->setMt_domi_apport($row->mt_domi_apport)
                    ->setNb_repartition($row->nb_repartition)
                    ->setReste_repartition($row->nb_repartition);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailDomicilieMf11000();
            $entry->setId_domi($row->id_domi)
                    ->setId_mf11000($row->id_mf11000)
                    ->setMt_domi_apport($row->mt_domi_apport)
                    ->setNb_repartition($row->nb_repartition)
                    ->setReste_repartition($row->nb_repartition);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumDetailMf($id_mf11000) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mt_domi_apport) as somme'));
        $select->where('id_mf11000 =?', $id_mf11000);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuDetailDomicilieMf11000 $dmf11000) {
        $data = array(
            'id_domi' => $dmf11000->getId_domi(),
            'id_mf11000' => $dmf11000->getId_mf11000(),
            'mt_domi_apport' => $dmf11000->getMt_domi_apport(),
            'nb_repartition' => $dmf11000->getNb_repartition(),
            'reste_repartition' => $dmf11000->getReste_repartition()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailDomicilieMf11000 $dmf11000) {
        $data = array(
            'id_domi' => $dmf11000->getId_domi(),
            'id_mf11000' => $dmf11000->getId_mf11000(),
            'mt_domi_apport' => $dmf11000->getMt_domi_apport(),
            'nb_repartition' => $dmf11000->getNb_repartition(),
            'reste_repartition' => $dmf11000->getReste_repartition()
        );
        $this->getDbTable()->update($data, array('id_domi = ?' => $dmf11000->getId_domi(), 'id_mf11000 = ?' => $dmf11000->getId_mf11000()));
    }

    public function delete($id_domi, $id_mf11000) {
        $this->getDbTable()->delete(array('id_domi = ?' => $id_domi, 'id_mf11000 = ?' => $id_mf11000));
    }

}

?>
