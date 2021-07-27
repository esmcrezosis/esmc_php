<?php

class Application_Model_EuServirMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuServir');
        }
        return $this->_dbTable;
    }

    public function find($id_fn, $code_smcipn, Application_Model_EuServir $just) {
        $result = $this->getDbTable()->find($id_fn, $code_smcipn);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $just->setId_fn($row->id_fn)
                ->setCode_smcipn($row->code_smcipn)
                ->setDate_creation($row->date_creation)
                ->setMontant_allouer($row->montant_allouer);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuServir();
            $entry->setId_fn($row->id_fn)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setDate_creation($row->date_creation)
                    ->setMontant_allouer($row->montant_allouer);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuServir $justif) {
        $data = array(
            'id_fn' => $justif->getId_fn(),
            'code_smcipn' => $justif->getCode_smcipn(),
            'date_creation' => $justif->getDate_creation(),
            'montant_allouer' => $justif->getMontant_allouer()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuServir $justif) {
        $data = array(
            'id_fn' => $justif->getId_fn(),
            'code_smcipn' => $justif->getCode_smcipn(),
            'date_creation' => $justif->getDate_creation(),
            'montant_allouer' => $justif->getMontant_allouer()
        );
        $this->getDbTable()->update($data, array('id_fn = ?' => $justif->getId_fn(), 'code_smcipn = ?' => $justif->getCode_smcipn()));
    }

    public function delete($id_fn, $code_smcipn) {
        $this->getDbTable()->delete(array('id_fn = ?' => $id_fn, 'code_smcipn = ?' => $code_smcipn));
    }

}