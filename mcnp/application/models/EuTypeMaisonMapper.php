<?php 


class Application_Model_EuTypeMaisonMapper {   

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
            $this->setDbTable('Application_Model_DbTable_EuTypeMaison');
        }
        return $this->_dbTable;
    }
    
    
    public function save(Application_Model_EuTypeMaison $type) {
        $data = array(
            'id_type_maison' => $type->getId_type_maison(),
            'lib_type_maison' => $type->getLib_type_maison(),
            'id_utilisateur' => $type->getId_utilisateur(),
			'date_create' => $type->getDate_create()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeMaison $type) {
        $data = array(
            'id_type_maison' => $type->getId_type_maison(),
            'lib_type_maison' => $type->getLib_type_maison(),
            'id_utilisateur' => $type->getId_utilisateur(),
			'date_create' => $type->getDate_create()
        );
        $this->getDbTable()->update($data, array('id_type_maison = ?' => $type->getId_type_maison()));
    }
    
    
    public function find($id_type_maison, Application_Model_EuTypeMaison $type) {
        $result = $this->getDbTable()->find($id_type_maison);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $type->setId_type_maison($row->id_type_maison)
             ->setLib_type_maison($row->lib_type_maison)
             ->setId_utilisateur($row->id_utilisateur)
			 ->setDate_create($row->date_create);
    }
    
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeMaison();
            $entry->setId_type_maison($row->id_type_maison);
            $entry->setLib_type_maison($row->lib_type_maison);
            $entry->setId_utilisateur($row->id_utilisateur);
			$entry->setDate_create($row->date_create);
            
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function delete($id_type_maison) {
        $this->getDbTable()->delete(array('id_type_maison = ?' => $id_type_maison));
    }
    
    
    
}

?>