<?php

class Application_Model_EuTypeQuittanceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeQuittance');
        }
        return $this->_dbTable;
    }

    public function find($id_type_quittance, Application_Model_EuTypeQuittance $typequittance) {
        $result = $this->getDbTable()->find($id_type_quittance);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $typequittance->setId_type_quittance($row->id_type_quittance)
                ->setLibelle_type_quittance($row->libelle_type_quittance);
    }
    
    /*public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeQuittance();
            $entry->setId_type_quittance($row->id_type_quittance)
                    ->setLibelle_type_quittance($row->libelle_type_quittance);
            $entries[] = $entry;
        }
        return $entries;
        
    }*/

    public function save(Application_Model_EuTypeQuittance $typequittance) {
        $data = array(
            'id_type_quittance' => $typequittance->getId_type_quittance(),
            'libelle_type_quittance' => $typequittance->getLibelle_type_quittance()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeQuittance $typequittance) {
        $data = array(
            'id_type_quittance' => $typequittance->getId_type_quittance(),
            'libelle_type_quittance' => $typequittance->getLibelle_type_quittance()
        );
        $this->getDbTable()->update($data, array('id_type_quittance = ?' => $typequittance->getId_type_quittance()));
    }

    public function delete($id_type_quittance) {
        $this->getDbTable()->delete(array('id_type_quittance = ?' => $id_type_quittance));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_quittance) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        
        $select = $this->getDbTable()->select();
		$select->order(array("id_type_quittance ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeQuittance();
            $entry->setId_type_quittance($row->id_type_quittance)
                    ->setLibelle_type_quittance($row->libelle_type_quittance);
            $entries[] = $entry;
        }
        return $entries;
        
    }

}
?>

