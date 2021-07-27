<?php

class Application_Model_EuTypePropoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypePropo');
        }
        return $this->_dbTable;
    }

    public function find($id_type_propo, Application_Model_EuTypePropo $type_propo) {
        $result = $this->getDbTable()->find($id_type_propo);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $type_propo->setId_type_propo($row->id_type_propo)
                ->setLibelle_type_propo($row->libelle_type_propo);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypePropo();
            $entry->setId_type_propo($row->id_type_propo)
                    ->setLibelle_type_propo($row->libelle_type_propo);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypePropo $type_propo) {
        $data = array(
            'id_type_propo' => $type_propo->getId_type_propo(),
            'libelle_type_propo' => $type_propo->getLibelle_type_propo()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypePropo $type_propo) {
        $data = array(
            'id_type_propo' => $type_propo->getId_type_propo(),
            'libelle_type_propo' => $type_propo->getLibelle_type_propo()
        );
        $this->getDbTable()->update($data, array('id_type_propo = ?' => $type_propo->getId_type_propo()));
    }

    public function delete($id_type_propo) {
        $this->getDbTable()->delete(array('id_type_propo = ?' => $id_type_propo));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_propo) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

