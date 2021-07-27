<?php
class Application_Model_EuPorterNsubMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPorterNsub');
        }
        return $this->_dbTable;
    }
    public function find($num_pforma,$code_objet, Application_Model_EuPorterNsub $porternsub) {
        $result = $this->getDbTable()->find($num_pforma,$code_objet);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $porternsub->setNum_pforma($row->num_pforma)
                ->setCode_objet($row->code_objet)
                ->setQte_objet($row->qte_objet)
                ->setPu_objet($row->pu_objet)
                ->setRemise($row->remise);    
    }
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPorterNsub();
            $entry->setNum_pforma($row->num_pforma)
                  ->setCode_objet($row->code_objet)
                  ->setQte_objet($row->qte_objet)
                  ->setPu_objet($row->pu_objet)
                  ->setRemise($row->remise);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuPorterNsub $porternsub){
        $data = array(
            'num_pforma' => $porternsub->getNum_pforma(),
            'code_objet' => $porternsub->getCode_objet(),
            'qte_objet' => $porternsub->getQte_objet(),
            'pu_objet' => $porternsub->getPu_objet(),
            'remise' => $porternsub->getRemise()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPorterNsub $porternsub) {
        $data = array(
           'num_pforma' => $porternsub->getNum_pforma(),
            'code_objet' => $porternsub->getCode_objet(),
            'qte_objet' => $porternsub->getQte_objet(),
            'pu_objet' => $porternsub->getPu_objet(),
            'remise' => $porternsub->getRemise()
        );

        $this->getDbTable()->update($data, array('num_pforma = ?' => $porternsub->getNum_pforma(),'code_objet = ?' => $porternsub->getCode_objet()));
    }
    public function delete($num_pforma,$code_objet) {
        $this->getDbTable()->delete(array('num_pforma = ?' => $num_pforma,'code_objet = ?' => $code_objet));
    }
}
