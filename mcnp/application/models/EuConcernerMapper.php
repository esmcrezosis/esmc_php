<?php

class Application_Model_EuConcernerMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuConcerner');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuConcerner $concerner) {
        $data = array(
            'id_besoin' => $concerner->getId_besoin(),
            'id_objet' => $concerner->getId_objet(),
            'qte_objet' => $concerner->getQte_objet(),
            'type' => $concerner->getType(),
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuConcerner $concerner) {
        $data = array(
            'id_besoin' => $concerner->getId_besoin(),
            'id_objet' => $concerner->getId_objet(),
            'qte_objet' => $concerner->getQte_objet(),
			'type' => $concerner->getType(),
        );
        $this->getDbTable()->update($data, array('id_besoin = ?' => $concerner->getId_besoin(), 'id_objet = ?' => $concerner->getId_objet()));
    }

    public function find($id_besoin,$id_objet, Application_Model_EuConcerner $concerner) {
        $result = $this->getDbTable()->find($id_besoin,$id_objet);
        if (0 == count($result)) {
            return false;
        }
        else{
        $row = $result->current();
        $concerner->setId_besoin($row->id_besoin)
                  ->setId_Objet($row->id_objet)
                  ->setQte_objet($row->qte_objet)
                  ->setType($row->type);
        return true;
        }
}

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuConcerner();
            $entry->setId_besoin($row->id_besoin);
            $entry->setId_Objet($row->id_objet);
            $entry->setQte_objet($row->qte_objet);
            $entry->setType($row->type);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function delete($id_besoin,$id_objet) {
        $this->getDbTable()->delete(array('id_besoin = ?' => $id_besoin,'id_objet = ?' => $id_objet));
    }
	
	
}