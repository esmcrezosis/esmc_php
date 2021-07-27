<?php

class Application_Model_EuCompteMarchandMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompteMarchand');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCompteMarchand $comptemarchand) {
        $data = array(
            'membre' => $comptemarchand->getMembre(),
            'produit' => $comptemarchand->getProduit(),
            'montant_compte' => $comptemarchand->getMontant_compte(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCompteMarchand $comptemarchand) {
        $data = array(
            'membre' => $comptemarchand->getMembre(),
            'produit' => $comptemarchand->getProduit(),
            'montant_compte' => $comptemarchand->getMontant_compte(),
        );

        $this->getDbTable()->update($data, array('membre = ?' => $comptemarchand->getMembre(), 'produit = ?' => $comptemarchand->getProduit()));
    }

    public function find($membre, $produit, Application_Model_EuCompteMarchand $comptemarchand) {
        $result = $this->getDbTable()->find($membre, $produit);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $comptemarchand->setMembre($row->membre)
                    ->setProduit($row->produit)
                    ->setMontant_compte($row->montant_compte);
            return true;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteMarchand();
            $entry->setMembre($row->membre)
                    ->setProduit($row->produit)
                    ->setMontant_compte($row->montant_compte);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($membre, $produit) {
        $this->getDbTable()->delete(array('membre = ?' => $membre, 'produit = ?' => $produit));
    }

}

