<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuAutreBudgetMapper {
    
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
            $this->setDbTable('Application_Model_DbTable_EuAutreBudget');
        }
        return $this->_dbTable;
    } 
    
    public function find($id_budget, Application_Model_EuAutreBudget $budget) {
        $result = $this->getDbTable()->find($id_budget);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $budget->setId_budget($row->id_budget)
               ->setLibbesoin($row->libbesoin)
               ->setMontant($row->montant)
               ->setId_investissement($row->id_investissement);
    }
    
    public function findByInv($id_investissement) {
        
        $select = $this->getDbTable()->select();
        $select->where('id_investissement = ?', $id_investissement);
        $result = $this->getDbTable()->fetchAll();
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAutreBudget();
            $entry->setId_budget($row->id_budget)
                  ->setLibbesoin($row->libbesoin)
                  ->setMontant($row->montant);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAutreBudget();
            $entry->setId_budget($row->id_budget)
                  ->setLibbesoin($row->libbesoin)
                  ->setMontant($row->montant)
                  ->setId_investissement($row->id_investissement);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
    public function save(Application_Model_EuAutreBudget $budget) {
        $data = array(
            'id_budget' => $budget->getId_budget(),
            'libbesoin' => $budget->getLibbesoin(),
            'montant' => $budget->getMontant(),
            'id_investissement' => $budget->getId_investissement()
        );

        $this->getDbTable()->insert($data);
    }


    public function update(Application_Model_EuBudgetFacture $budget) {
        $data = array(
           'id_budget' => $budget->getId_budget(),
            'libbesoin' => $budget->getLibbesoin(),
            'montant' => $budget->getMontant(),
            'id_investissement' => $budget->getId_investissement()
        );
        $this->getDbTable()->update($data, array('id_budget = ?' => $budget->getId_budget()));
    }


    public function delete($id_budget) {
        $this->getDbTable()->delete(array('id_budget = ?' => $id_budget));
    }
   
    
}












?>
