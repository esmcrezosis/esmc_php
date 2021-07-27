<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDeviseMapper
 *
 * @author user
 */
class Application_Model_EuCoursMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCours');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCours $cours) {
        $data = array(
            'code_cours' => $cours->getCode_cours(),
            'code_dev_init' => $cours->getCode_dev_init(),
            'code_dev_fin' => $cours->getCode_dev_fin(),
            'val_dev_init' => $cours->getVal_dev_init(),
            'val_dev_fin' => $cours->getVal_dev_fin()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCours $cours) {
        $data = array(
            'code_cours' => $cours->getCode_cours(),
            'code_dev_init' => $cours->getCode_dev_init(),
            'code_dev_fin' => $cours->getCode_dev_fin(),
            'val_dev_init' => $cours->getVal_dev_init(),
            'val_dev_fin' => $cours->getVal_dev_fin()
        );
        $this->getDbTable()->update($data, array('code_cours = ?' => $cours->getCode_cours()));
    }

    public function find($code_cours, Application_Model_EuCours $cours) {
        $result = $this->getDbTable()->find($code_cours);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $cours->setCode_cours($row->code_cours)
                ->setCode_dev_init($row->code_dev_init)
                ->setCode_dev_fin($row->code_dev_fin)
                ->setVal_dev_init($row->val_dev_init)
                ->setVal_dev_fin($row->val_dev_fin);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCours();
            $entry->setCode_cours($row->code_cours)
                    ->setCode_dev_init($row->code_dev_init)
                    ->setCode_dev_fin($row->code_dev_fin)
                    ->setVal_dev_init($row->val_dev_init)
                    ->setVal_dev_fin($row->val_dev_fin);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_cours) {
        $this->getDbTable()->delete(array('code_cours = ?' => $code_cours));
    }

}

?>
