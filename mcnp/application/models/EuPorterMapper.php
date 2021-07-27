<?php

class Application_Model_EuPorterMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPorter');
        }
        return $this->_dbTable;
    }

    public function find($id_porter, Application_Model_EuPorter $porter) {
        $result = $this->getDbTable()->find($id_porter);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $porter->setId_porter($row->id_porter)
                ->setCode_proforma($row->code_proforma)
                ->setId_objet($row->id_objet)
                ->setQte_objet($row->qte_objet)
                ->setPu_objet($row->pu_objet)
                ->setRemise($row->remise)
                ->setMdv($row->mdv)
                ->setDisponible($row->disponible);
        return true;
    }

    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPorter();
            $entry->setId_porter($row->id_porter)
                  ->setCode_proforma($row->code_proforma)
                  ->setId_objet($row->id_objet)
                  ->setQte_objet($row->qte_objet)
                  ->setPu_objet($row->pu_objet)
                  ->setRemise($row->remise)
                  ->setMdv($row->mdv)
                  ->setDisponible($row->disponible);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuPorter $porter) {
        $data = array(
            'id_porter' => $porter->getId_porter(),
            'code_proforma' => $porter->getCode_proforma(),
            'id_objet' => $porter->getId_objet(),
            'qte_objet' => $porter->getQte_objet(),
            'pu_objet' => $porter->getPu_objet(),
            'remise' => $porter->getRemise(),
            'mdv' => $porter->getMdv(),
            'disponible' => $porter->getDisponible()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPorter $porter) {
         $data = array(
            'id_porter' => $porter->getId_porter(),
            'code_proforma' => $porter->getCode_proforma(),
            'id_objet' => $porter->getId_objet(),
            'qte_objet' => $porter->getQte_objet(),
            'pu_objet' => $porter->getPu_objet(),
            'remise' => $porter->getRemise(),
            'mdv' => $porter->getMdv(),
            'disponible' => $porter->getDisponible()
        );

        $this->getDbTable()->update($data, array('id_porter = ?' => $porter->getId_porter()));
    }

    public function delete($id_porter) {

        $this->getDbTable()->delete(array('id_porter = ?' => $id_porter));
    }

}
