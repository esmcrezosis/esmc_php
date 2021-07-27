<?php

class Application_Model_EuMaterielKitMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMaterielKit');
        }
        return $this->_dbTable;
    }

    public function find($id_materiel_kit, Application_Model_EuMaterielKit $kit) {
        $result = $this->getDbTable()->find($id_materiel_kit);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $kit->setId_materiel_kit($row->id_materiel_kit)
                ->setLibelle_materiel_kit($row->libelle_materiel_kit);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMaterielKit();
            $entry->setId_materiel_kit($row->id_materiel_kit)
                    ->setLibelle_materiel_kit($row->libelle_materiel_kit);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuMaterielKit $kit) {
        $data = array(
            'id_materiel_kit' => $kit->getId_materiel_kit(),
            'libelle_materiel_kit' => $kit->getLibelle_materiel_kit()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMaterielKit $kit) {
        $data = array(
            'id_materiel_kit' => $kit->getId_materiel_kit(),
            'libelle_materiel_kit' => $kit->getLibelle_materiel_kit()
        );
        $this->getDbTable()->update($data, array('id_materiel_kit = ?' => $kit->getId_materiel_kit()));
    }

    public function delete($id_materiel_kit) {
        $this->getDbTable()->delete(array('id_materiel_kit = ?' => $id_materiel_kit));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_materiel_kit) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

