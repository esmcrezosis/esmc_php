<?php

class Application_Model_EuBudgetFactureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBudgetFacture');
        }
        return $this->_dbTable;
    }


    public function find($id_objet, $code_proforma, Application_Model_EuBudgetFacture $budget) {
        $result = $this->getDbTable()->find($id_objet, $code_proforma);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $budget->setId_objet($row->id_objet)
               ->setCode_proforma($row->code_proforma)
               ->setPu_objet($row->pu_objet)
               ->setQte_objet($row->qte_objet)
               ->setRemise_objet($row->remise_objet)
               ->setCategorie_objet($row->categorie_objet)
               ->setId_besoin($row->id_besoin)  
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
            $entry = new Application_Model_EuBudgetFacture();
            $entry->setId_objet($row->id_objet)
               ->setCode_proforma($row->code_proforma)
               ->setPu_objet($row->pu_objet)
               ->setQte_objet($row->qte_objet)
               ->setRemise_objet($row->remise_objet)
               ->setCategorie_objet($row->categorie_objet)
               ->setId_besoin($row->id_besoin)  
               ->setId_investissement($row->id_investissement);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBudgetFacture();
            $entry->setId_objet($row->id_objet)
               ->setCode_proforma($row->code_proforma)
               ->setPu_objet($row->pu_objet)
               ->setQte_objet($row->qte_objet)
               ->setRemise_objet($row->remise_objet)
               ->setCategorie_objet($row->categorie_objet)
               ->setId_besoin($row->id_besoin)  
               ->setId_investissement($row->id_investissement)
                  ->setId_besoin($row->id_besoin);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function save(Application_Model_EuBudgetFacture $budget) {
        $data = array(
             'id_objet' => $budget->getId_objet(),
             'code_proforma' => $budget->getCode_proforma(),
             'pu_objet' => $budget->getPu_objet(),
             'qte_objet' => $budget->getQte_objet(),
             'remise_objet' => $budget->getRemise_objet(),
             'categorie_objet' => $budget->getCategorie_objet(),
             'id_besoin' => $budget->getId_besoin(),
             'id_investissement' => $budget->getId_investissement()
            
        );

        $this->getDbTable()->insert($data);
    }


    public function update(Application_Model_EuBudgetFacture $budget) {
        $data = array(
            'id_objet' => $budget->getId_objet(),
             'code_proforma' => $budget->getCode_proforma(),
             'pu_objet' => $budget->getPu_objet(),
             'qte_objet' => $budget->getQte_objet(),
             'remise_objet' => $budget->getRemise_objet(),
             'categorie_objet' => $budget->getCategorie_objet(),
             'id_besoin' => $budget->getId_besoin(),
             'id_investissement' => $budget->getId_investissement()
        );
        $this->getDbTable()->update($data, array('id_objet = ?' => $budget->getId_objet(), 'code_proforma = ?' => $budget->getCode_proforma()));
    }


    public function delete($id_objet, $code_proforma) {
        $this->getDbTable()->delete(array('id_objet = ?' => $id_objet, 'code_proforma = ?' => $code_proforma));
    }

}

