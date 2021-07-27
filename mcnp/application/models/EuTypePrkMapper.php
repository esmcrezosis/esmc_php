<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuTegcMapper
 *
 * @author user
 */
class Application_Model_EuTypePrkMapper {
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
            $this->setDbTable('Application_Model_DbTable_EuTypePrk');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTypePrk $prk) {
      $data = array(
        'id_type_prk' => $prk->getId_type_prk(),
        'valeur_prk' => $prk->getValeur_prk()
      );
      $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypePrk $prk) {
        $data = array(
          'id_type_prk' => $prk->getId_type_prk(),
          'valeur_prk' => $prk->getValeur_prk()
        );
        $this->getDbTable()->update($data, array('id_type_prk = ?' => $prk->getId_type_prk()));
    }

    public function find($id_type_prk,Application_Model_EuTypePrk $prk) {
        $result = $this->getDbTable()->find($id_type_prk);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $prk->setId_type_prk($row->id_type_prk)
                ->setValeur_prk($row->valeur_prk);
            return true;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypePrk();
            $entry->setId_type_prk($row->id_type_prk)
                  ->setValeur_prk($row->valeur_prk);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function delete($id_type_prk) {
        $this->getDbTable()->delete(array('id_type_prk = ?' => $id_type_prk));
    }

}

?>
