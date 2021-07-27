<?php

class Application_Model_EuLier4Mapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLier4');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuLier4 $lier) {
        $data = array(
            'num_pforma' => $lier->getNum_pforma(),
            'id_objet_hors' => $lier->getId_objet_hors(),
            'qte_objet' => $lier->getQte_objet(),
            'pu_objet' => $lier->getPu_objet(),
            'remise' => $lier->getRemise(),
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuLier4 $lier) {
        $data = array(
            'num_pforma' => $lier->getNum_pforma(),
            'id_objet_hors' => $lier->getId_objet_hors(),
            'qte_objet' => $lier->getQte_objet(),
            'pu_objet' => $lier->getPu_objet(),
            'remise' => $lier->getRemise(),
        );
        $this->getDbTable()->update($data, array('num_pforma = ?' => $lier->getNum_pforma(),'id_objet_hors = ?' => $lier->getId_objet_hors()));
    }

    public function find($num_pforma,$id_objet_hors, Application_Model_EuLier4 $lier) {
        $result = $this->getDbTable()->find($num_pforma,$id_objet_hors);
        if (0 == count($result)) {
            return;
        } else {
            $row = $result->current();
            $lier->setNum_pforma($row->num_pforma)
                    ->setId_objet_hors($row->id_objet_hors)
                    ->setQte_objet($row->qte_objet)
                    ->setPu_objet($row->pu_objet)
                    ->setRemise($row->remise);
            return true;
        }
    }
    
    
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLier4();
            $entry->setNum_pforma($row->num_pforma);
            $entry->setId_objet_hors($row->id_objet_hors);
            $entry->setQte_objet($row->qte_objet);
            $entry->setPu_objet($row->pu_objet);
            $entry->setRemise($row->remise);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($num_pforma,$id_objet_hors) {
        $this->getDbTable()->delete(array('num_pforma = ?' => $num_pforma,'id_objet_hors = ?' => $id_objet_hors));
    }

}
