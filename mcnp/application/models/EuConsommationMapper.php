<?php

class Application_Model_EuConsommationMapper
{
    
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
            $this->setDbTable('Application_Model_DbTable_EuConsommation');
        }
        return $this->_dbTable;
    }
    
    public function find($num_conso, Application_Model_EuConsommation $conso) {
        $result = $this->getDbTable()->find($num_conso);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $conso->setNum_Conso($row->num_consom)
                ->setMembre($row->membre)
                ->setVendeur($row->vendeur)
                ->setProduit($row->produit)
                ->setConsommation($row->consommation)
                ->setDate_conso($row->date_consom);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuConsommation();
            $entry->setVendeur($row->vendeur);
            $entry->setMembre($row->membre);
            $entry->setConsommation($row->consommation);
            $entry->setDate_consom($row->date_consom);
            $entry->setProduit($row->produit);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuConsommation $conso) {
        $data = array(
            'vendeur' => $conso->getVendeur(),
            'membre' => $conso->getMembre(),
            'consommation' => $conso->getConsommation(),
            'date_consom' => $conso->getDate_consom(),
            'produit' => $conso->getProduit()
        );
        $this->getDbTable()->insert($data);
    }

}

