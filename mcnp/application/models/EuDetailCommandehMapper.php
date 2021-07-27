<?php
class Application_Model_EuDetailCommandehMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailCommandeh');
        }
        return $this->_dbTable;
    }
    public function find($num_com,$id_code_objet, Application_Model_EuDetailCommandeh $commandeh) {
        $result = $this->getDbTable()->find($num_com,$id_code_objet);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $commandeh->setNum_com($row->num_com)
                 ->setId_code_objet($row->id_code_objet)
                 ->setDesign_objet($row->design_objet)
                 ->setQte_objet($row->qte_objet)
                 ->setPu_objet($row->pu_objet)
                 ->setRemise($row->remise);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommandeh();
            $entry->setNum_com($row->num_com)
                  ->setId_code_objet($row->id_code_objet)
                  ->setDesign_objet($row->design_objet)
                  ->setQte_objet($row->qte_objet)
                  ->setPu_objet($row->pu_objet)
                  ->setRemise($row->remise);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuDetailCommandeh $commandeh){
        $data = array(
            'num_com' => $commandeh->getNum_com(),
            'id_code_objet' => $commandeh->getId_code_objet(),
            'design_objet' => $commandeh->getDesign_objet(),
            'qte_objet' => $commandeh->getQte_objet(),
            'pu_objet' => $commandeh->getPu_objet(),
            'remise' => $commandeh->getRemise(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailCommandeh $commandeh) {
        $data = array(
            'num_com' => $commandeh->getNum_com(),
            'id_code_objet' => $commandeh->getId_code_objet(),
            'design_objet' => $commandeh->getDesign_objet(),
            'qte_objet' => $commandeh->getQte_objet(),
            'pu_objet' => $commandeh->getPu_objet(),
            'remise' => $commandeh->getRemise(),
        );
        $this->getDbTable()->update($data, array('num_com = ?' => $commandeh->getNum_com(),'id_code_objet = ?' => $commandeh->getId_code_objet()));
    }
    
    public function delete($num_com,$id_code_objet) {
        $this->getDbTable()->delete(array('num_com = ?' => $num_com,'id_code_objet = ?' => $id_code_objet));
    }
}
