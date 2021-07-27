<?php

class Application_Model_EuBesoinMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuBesoin');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuBesoin $besoin) {
        $data = array(
            'id_besoin' => $besoin->getId_besoin(),
            'objet_besoin' => $besoin->getObjet_besoin(),
            'date_valide' => $besoin->getDate_valide(),
            'date_besoin' => $besoin->getDate_besoin(),
            'code_membre' => $besoin->getCode_membre(),
            'disponible' => $besoin->getDisponible()
        );
        $this->getDbTable()->insert($data);
    }
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_besoin) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    public function update(Application_Model_EuBesoin $besoin) {
        $data = array(
            'id_besoin' => $besoin->getId_besoin(),
            'objet_besoin' => $besoin->getObjet_besoin(),
            'date_valide' => $besoin->getDate_valide(),
            'date_besoin' => $besoin->getDate_besoin(),
            'code_membre' => $besoin->getCode_membre(),
            'disponible' => $besoin->getDisponible()
        );

        $this->getDbTable()->update($data, array('id_besoin = ?' => $besoin->getId_besoin()));
    }
    public function find($id_besoin, Application_Model_EuBesoin $besoin) {
        $result = $this->getDbTable()->find($id_besoin);
		
        if (0 == count($result)) {
            return;
        }
		
        $row = $result->current();
        $besoin->setId_besoin($row->id_besoin)
               ->setObjet_besoin($row->objet_besoin)
               ->setDate_valide($row->date_valide)
               ->setDate_besoin($row->date_besoin)
               ->setCode_membre($row->code_membre);
}

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBesoin();
            $entry->setId_besoin($row->id_besoin);
            $entry->setObjet_besoin($row->objet_besoin);
            $entry->setDate_valide($row->date_valide);
            $entry->setDate_besoin($row->date_besoin);
			$entry->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function delete($id_besoin) {
        $this->getDbTable()->delete(array('id_besoin = ?' => $id_besoin));
    }
	
}


