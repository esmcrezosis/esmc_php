<?php
 
class Application_Model_EuPostesMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPostes');
        }
        return $this->_dbTable;
    }

    public function find($id_postes, Application_Model_EuPostes $postes) {
        $result = $this->getDbTable()->find($id_postes);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $poste->setPoste_id($row->id_postes)
                ->setNom_postes($row->nom_postes);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("nom_postes ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPostes();
            $entry->setId_postes($row->id_postes)
	              ->setNom_postes($row->nom_postes);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_postes) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuPostes $postes) {
        $data = array(
            'id_postes' => $poste->getId_postes(),
            'nom_postes' => $poste->getNom_postes(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPoste $poste) {
        $data = array(
            'id_postes' => $poste->getId_postes(),
            'nom_postes' => $poste->getNom_postes(),
        );
        $this->getDbTable()->update($data, array('id_postes = ?' => $poste->getId_postes()));
    }

    public function delete($id_postes) {
        $this->getDbTable()->delete(array('id_postes = ?' => $id_postes));
    }	
}


?>
