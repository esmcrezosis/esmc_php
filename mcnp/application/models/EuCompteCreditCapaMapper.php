<?php

class Application_Model_EuCompteCreditCapaMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompteCreditCapa');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCompteCreditCapa $CompteCreditCapa) {
        $data = array(
            'id_credit' => $CompteCreditCapa->getId_credit(),
            'montant' => $CompteCreditCapa->getMontant(),
            'code_capa' => $CompteCreditCapa->getCode_capa(),
            'code_produit' => $CompteCreditCapa->getCode_produit()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCompteCreditCapa $CompteCreditCapa) {
        $data = array(
             'id_credit' => $CompteCreditCapa->getId_credit(),
            'montant' => $CompteCreditCapa->getMontant(),
            'code_capa' => $CompteCreditCapa->getCode_capa(),
            'code_produit' => $CompteCreditCapa->getCode_produit()
        );
        $this->getDbTable()->update($data, array('id_credit = ?' => $CompteCreditCapa->getId_credit()));
    }

    public function find($id_credit, Application_Model_EuCompteCreditCapa $CompteCreditCapa) {
        $result = $this->getDbTable()->find($id_credit);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $CompteCreditCapa->setId_credit($row->id_credit)
					->setMontant($row->montant)
                ->setCode_capa($row->code_capa)
                ->setCode_produit($row->code_produit);
        return true;
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteCreditCapa();
            $entry->setId_credit($row->id_credit)
					->setMontant($row->montant)
               	->setCode_capa($row->code_capa)
                ->setCode_produit($row->code_produit);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_credit) {
        $this->getDbTable()->delete(array('id_credit = ?' => $id_credit));
    }






}


