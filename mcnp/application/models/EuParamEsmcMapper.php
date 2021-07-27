<?php

class Application_Model_EuParamEsmcMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuParamEsmc');
        }
        return $this->_dbTable;
    }

    
    public function find($id_param, Application_Model_EuParamEsmc $param) {
        $result = $this->getDbTable()->find($id_param);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $param->setId_param($row->id_param)
                    ->setLibelle_param($row->libelle_param)
                    ->setValeur_param($row->valeur_param);
            return true;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuParamEsmc();
            $entry->setId_param($row->id_param)
                    ->setLibelle_param($row->libelle_param)
                    ->setValeur_param($row->valeur_param);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuParamEsmc $param) {
        $data = array(
            'id_param' => $param->getId_param(),
            'libelle_param' => $param->getLibelle_param(),
            'valeur_param' => $param->getValeur_param()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuParamEsmc $param) {
        $data = array(
            'id_param' => $param->getId_param(),
            'libelle_param' => $param->getLibelle_param(),
            'valeur_param' => $param->getValeur_param()
        );

        $this->getDbTable()->update($data, array('id_param = ?' => $param->getId_param()));
    }

    public function delete($id_param, $libelle_param) {
        $this->getDbTable()->delete(array('id_param = ?' => $id_param));
    }

}

