<?php

class Application_Model_EuTypeCaracteristiqueMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeCaracteristique');
        }
        return $this->_dbTable;
    }

    public function find($id_type_caracteristique, Application_Model_EuTypeCaracteristique $caracteristique) {
        $result = $this->getDbTable()->find($id_type_caracteristique);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $caracteristique->setId_type_caracteristique($row->id_type_caracteristique)
                ->setLibelle_type_caracteristique($row->libelle_type_caracteristique)
                ->setId_type_candidat($row->id_type_candidat);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCaracteristique();
            $entry->setId_type_caracteristique($row->id_type_caracteristique)
                    ->setLibelle_type_caracteristique($row->libelle_type_caracteristique)
                ->setId_type_candidat($row->id_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeCaracteristique $caracteristique) {
        $data = array(
            'id_type_caracteristique' => $caracteristique->getId_type_caracteristique(),
            'libelle_type_caracteristique' => $caracteristique->getLibelle_type_caracteristique(),
            'id_type_candidat' => $caracteristique->getId_type_candidat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeCaracteristique $caracteristique) {
        $data = array(
            'id_type_caracteristique' => $caracteristique->getId_type_caracteristique(),
            'libelle_type_caracteristique' => $caracteristique->getLibelle_type_caracteristique(),
            'id_type_candidat' => $caracteristique->getId_type_candidat()
        );
        $this->getDbTable()->update($data, array('id_type_caracteristique = ?' => $caracteristique->getId_type_caracteristique()));
    }

    public function delete($id_type_caracteristique) {
        $this->getDbTable()->delete(array('id_type_caracteristique = ?' => $id_type_caracteristique));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_caracteristique) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll2($id_type_candidat) {
        
        $select = $this->getDbTable()->select();
		$select->where("id_type_candidat = ? ", $id_type_candidat);
		$select->orwhere("id_type_candidat = ? ", 0);
		$select->order("libelle_type_caracteristique ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCaracteristique();
            $entry->setId_type_caracteristique($row->id_type_caracteristique)
                    ->setLibelle_type_caracteristique($row->libelle_type_caracteristique)
                ->setId_type_candidat($row->id_type_candidat);
            $entries[] = $entry;
        }
        return $entries;
        
    }

}
?>

