<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_EuVilleMapper {

      
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
            $this->setDbTable('Application_Model_DbTable_EuVille');
        }
        return $this->_dbTable;
    }

    

    public function find($id_ville, Application_Model_EuVille $ville) {
        $result = $this->getDbTable()->find($id_ville);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $ville->setId_ville($row->id_ville)
              ->setLib_ville($row->lib_ville)
              ->setDate_create($row->date_create)
              ->setId_pays($row->id_pays)
              ->setId_utilisateur($row->id_utilisateur);
    }

    
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuVille();
            $entry->setId_ville($row->id_ville)
                  ->setLib_ville($row->lib_ville)
                  ->setDate_create($row->date_create)
                  ->setId_pays($row->id_pays)
                  ->setId_utilisateur($row->id_utilisateur)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    
    public function save(Application_Model_EuVille $ville) {
        $data = array(
            'id_ville' => $ville->getId_ville(),
            'lib_ville' => $ville->getLib_ville(),
            'date_create' => $ville->getDate_create(),
            'id_pays' => $ville->getId_pays(),
            'id_utilisateur' => $ville->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    
    
    public function update(Application_Model_EuVille $ville) {
        $data = array(
            'id_ville' => $ville->getId_ville(),
            'lib_ville' => $ville->getLib_ville(),
            'date_create' => $ville->getDate_create(),
            'id_pays' => $ville->getId_pays(),
            'id_utilisateur' => $quartier->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_ville = ?' => $ville->getId_ville()));
    }

    
    
    public function delete($id_ville) {
        $this->getDbTable()->delete(array('id_ville = ?' => $id_ville));
    }




}
?>
