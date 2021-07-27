<?php
class Application_Model_EuDetailCommandensubMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailCommandensub');
        }
        return $this->_dbTable;
    }
    public function find($num_com,$code_objet, Application_Model_EuDetailCommandensub $commandensub) {
        $result = $this->getDbTable()->find($num_com,$code_objet);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $commandensub->setnum_com($row->num_com)
                    ->setcode_objet($row->code_objet)	
                    ->setDesign_objet($row->design_objet)
                    ->setQte_objet($row->qte_objet)
                    ->setPu_objet($row->pu_objet)
                    ->setRemise($row->remise);    
    }
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommandensub();
            $entry->setNum_com($row->num_com)
                  ->setCode_objet($row->code_objet)  
                  ->setDesign_objet($row->design_objet)
                  ->setQte_objet($row->qte_objet)
                  ->setPu_objet($row->pu_objet)
                  ->setRemise($row->remise);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuDetailCommandensub $commandensub){
        $data = array(
            'num_com' => $commandensub->getNum_com(),
            'code_objet' => $commandensub->getCode_objet(),
            'design_objet' => $commandensub->getDesign_objet(),
            'qte_objet' => $commandensub->getQte_objet(),
            'pu_objet' => $commandensub->getPu_objet(),
            'remise' => $commandensub->getRemise(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailCommandensub $commandensub) {
        $data = array(
            'num_com' => $commandensub->getNum_com(),
            'code_objet' => $commandensub->getCode_objet(),
            'design_objet' => $commandensub->getDesign_objet(),
            'qte_objet' => $commandensub->getQte_objet(),
            'pu_objet' => $commandensub->getPu_objet(),
            'remise' => $commandensub->getRemise(),
        );
        $this->getDbTable()->update($data, array('num_com = ?' => $commandensub->getNum_com(),'code_objet = ?' => $commandensub->getCode_objet()));
    }
    
    public function delete($num_com,$code_objet) {
        $this->getDbTable()->delete(array('num_com = ?' => $num_com,'code_objet = ?' => $code_objet));
    }
}


