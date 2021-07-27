<?php

class Application_Model_EuTypeDdePropoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeDdePropo');
        }
        return $this->_dbTable;
    }

    public function find($id_type_dde_propo, Application_Model_EuTypeDdePropo $type_dde_propo) {
        $result = $this->getDbTable()->find($id_type_dde_propo);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $type_dde_propo->setId_type_dde_propo($row->id_type_dde_propo)
                ->setLibelle_type_dde_propo($row->libelle_type_dde_propo);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeDdePropo();
            $entry->setId_type_dde_propo($row->id_type_dde_propo)
                    ->setLibelle_type_dde_propo($row->libelle_type_dde_propo);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeDdePropo $type_dde_propo) {
        $data = array(
            'id_type_dde_propo' => $type_dde_propo->getId_type_dde_propo(),
            'libelle_type_dde_propo' => $type_dde_propo->getLibelle_type_dde_propo()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeDdePropo $type_dde_propo) {
        $data = array(
            'id_type_dde_propo' => $type_dde_propo->getId_type_dde_propo(),
            'libelle_type_dde_propo' => $type_dde_propo->getLibelle_type_dde_propo()
        );
        $this->getDbTable()->update($data, array('id_type_dde_propo = ?' => $type_dde_propo->getId_type_dde_propo()));
    }

    public function delete($id_type_dde_propo) {
        $this->getDbTable()->delete(array('id_type_dde_propo = ?' => $id_type_dde_propo));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_dde_propo) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

