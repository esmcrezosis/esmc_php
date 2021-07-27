<?php
class Application_Model_EuObjetSubMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuObjetSub');
        }
        return $this->_dbTable;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_objet) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    public function findsub($code) {
        $table = new Application_Model_DbTable_EuObjetSub();
        $select = $table->select();
        $select->where('code_demand=?', $code);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuObjetSub();
            $entry->setCode_objet($row->code_objet)
                  ->setCode_demand($row->code_demand)
                  ->setQte_stock($row->qte_stock)
                  ->setPu_sub($row->pu_sub);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findobjet($objet) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_objet'));
        $select->where('design_objet = ?', $objet);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_objet'];
    }

    public function save(Application_Model_EuObjetSub $objetsub) {
        $data = array(
            'code_objet' => $objetsub->getCode_objet(),
            'code_demand' => $objetsub->getCode_demand(),
            'qte_stock' => $objetsub->getQte_stock(),
            'pu_sub' => $objetsub->getPu_sub(),
            'num_pro' => $objetsub->getNum_pro()    
        );    
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuObjetSub $objetsub) {
        $data = array(
            'code_objet' => $objetsub->getCode_objet(),
            'code_demand' => $objetsub->getCode_demand(),
            'qte_stock' => $objetsub->getQte_stock(),
            'pu_sub' => $objetsub->getPu_sub(),
        );
        $this->getDbTable()->update($data, array('code_objet = ?' => $objetsub->getCode_objet(),'code_demand = ?' => $objetsub->getCode_demand()));
    }

    public function find($code_objet,$code_demand, Application_Model_EuObjetSub $objetsub) {
        $result = $this->getDbTable()->find($code_objet,$code_demand);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $objetsub->setCode_objet($row->code_objet)
                ->setCode_demand($row->code_demand)
                ->setQte_stock($row->qte_stock)
                ->setPu_sub($row->pu_sub);
    }
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuObjetSub();
            $entry->setCode_objet($row->code_objet);
            $entry->setcode_demand($row->code_demand);
            $entry->setQte_stock($row->qte_stock);
            $entry->setPu_sub($row->pu_sub);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_objet,$code_demand) {
        $this->getDbTable()->delete(array('code_objet = ?' => $code_objet,'code_demand = ?' => $code_demand));
    }
}
