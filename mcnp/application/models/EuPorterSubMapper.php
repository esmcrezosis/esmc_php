<?php
class Application_Model_EuPorterSubMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPorterSub');
        }
        return $this->_dbTable;
    }
    public function find($num_pforma,$code_objet, Application_Model_EuPorterSub $portersub) {
        $result = $this->getDbTable()->find($num_pforma,$code_objet);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $portersub->setNum_pforma($row->num_pforma)
                ->setCode_objet($row->code_objet)
                ->setCode_demand($row->code_demand)
                ->setQte_objet($row->qte_objet)
                ->setPu_objet($row->pu_objet)
                ->setRemise($row->remise);    
    }
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPorterSub();
            $entry->setNum_pforma($row->num_pforma)
                  ->setCode_objet($row->code_objet)
                  ->setCode_demand($row->code_demand)  
                  ->setQte_objet($row->qte_objet)
                  ->setPu_objet($row->pu_objet)
                  ->setRemise($row->remise);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuPorterSub $portersub){
        $data = array(
            'num_pforma' => $portersub->getNum_pforma(),
            'code_objet' => $portersub->getCode_objet(),
            'code_demand' => $portersub->getCode_demand(),
            'qte_objet' => $portersub->getQte_objet(),
            'pu_objet' => $portersub->getPu_objet(),
            'remise' => $portersub->getRemise()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPorterSub $portersub) {
        $data = array(
            'num_pforma' => $portersub->getNum_pforma(),
            'code_objet' => $portersub->getCode_objet(),
            'code_demand' => $portersub->getCode_demand(),
            'qte_objet' => $portersub->getQte_objet(),
            'pu_objet' => $portersub->getPu_objet(),
            'remise' => $portersub->getRemise()
        );

        $this->getDbTable()->update($data, array('num_pforma = ?' => $portersub->getNum_pforma(),'code_objet = ?' => $portersub->getCode_objet(),'code_demand = ?' => $portersub->getCode_demand()));
    }
    public function delete($num_pforma,$code_objet) {
        $this->getDbTable()->delete(array('num_pforma = ?' => $num_pforma,'code_objet = ?' => $code_objet));
    }
}