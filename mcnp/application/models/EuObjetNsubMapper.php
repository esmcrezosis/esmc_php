<?php
class Application_Model_EuObjetNsubMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuObjetNsub');
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
    
    public function findobjet($objet) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_objet'));
        $select->where('design_objet = ?', $objet);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_objet'];
    }

    public function save(Application_Model_EuObjetNsub $objetnsub) {
        $data = array(
            'code_objet' => $objetnsub->getCode_objet(),
            'pu_objet' => $objetnsub->getPu_objet(),
            'qte_stock' => $objetnsub->getQte_stock(),
            'num_pro' => $objetnsub->getNum_pro()    
        );    
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuObjetnsub $objetnsub) {
        $data = array(
           'code_objet' => $objetnsub->getCode_objet(),
           'pu_objet' => $objetnsub->getPu_objet(),
           'qte_stock' => $objetnsub->getQte_stock()
        );
        $this->getDbTable()->update($data, array('code_objet = ?' => $objetnsub->getCode_objet()));
    }

    public function find($code_objet, Application_Model_EuObjetnsub $objetnsub) {
        $result = $this->getDbTable()->find($code_objet);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $objetnsub->setCode_objet($row->code_objet)
                ->setPu_objet($row->pu_objet)
                ->setQte_stock($row->qte_stock);
    }
  
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuObjetNsub();
            $entry->setCode_objet($row->code_objet);
            $entry->setPu_objet($row->pu_objet);
            $entry->setQte_stock($row->qte_stock);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function delete($code_objet) {
        $this->getDbTable()->delete(array('code_objet = ?' => $code_objet));
    }
    
}

