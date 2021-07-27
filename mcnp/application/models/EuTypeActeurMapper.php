<?php

class Application_Model_EuTypeActeurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeActeur');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTypeActeur $type_acteur) {
        $data = array(
            'id_type_acteur' => $type_acteur->getId_type_acteur(),
            'lib_type_acteur' => $type_acteur->getLib_type_acteur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeActeur $type_acteur) {
        $data = array(
            'id_type_acteur' => $type_acteur->getId_type_acteur(),
            'lib_type_acteur' => $type_acteur->getLib_type_acteur()
        );

        $this->getDbTable()->update($data, array('id_type_acteur = ?' => $type_acteur->getId_type_acteur()));
    }

    public function find($id_type_acteur, Application_Model_EuTypeActeur $type_acteur) {
        $result = $this->getDbTable()->find($id_type_acteur);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $type_acteur->setId_type_acteur($row->id_type_acteur)
                    ->setLib_type_acteur($row->lib_type_acteur);
    }

    public function fetchAll() {
	
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
		
            $entry = new Application_Model_EuTypeActeur();
            $entry->setId_type_acteur($row->id_type_acteur)
                  ->setLib_type_acteur($row->lib_type_acteur);
            $entries[] = $entry;
			
        }
        return $entries;
		
    }

    public function delete($id_type_acteur) {
        $this->getDbTable()->delete(array('id_type_acteur = ?' => $id_type_acteur));
    }

}

