<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuQuartierMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQuartier');
        }
        return $this->_dbTable;
    }

    public function find($id_quartier, Application_Model_EuQuartier $quartier) {
        $result = $this->getDbTable()->find($id_quartier);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $quartier->setId_quartier($row->id_quartier)
                 ->setLib_quartier($row->lib_quartier)
                 ->setDate_create($row->date_create)
                 ->setId_ville($row->id_ville)
                 ->setId_utilisateur($row->id_utilisateur);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuartier();
            $entry->setId_quartier($row->id_quartier)
                 ->setLib_quartier($row->lib_quartier)
                 ->setDate_create($row->date_create)
                 ->setId_ville($row->id_ville)
                 ->setId_utilisateur($row->id_utilisateur);
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function save(Application_Model_EuQuartier $quartier) {
        $data = array(
            'id_quartier' => $quartier->getId_quartier(),
            'lib_quartier' => $quartier->getLib_quartier(),
            'date_create' => $quartier->getDate_create(),
            'id_ville' => $quartier->getId_ville(),
            'id_utilisateur' => $quartier->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function findpays($id_quartier) {
           $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_ville','eu_ville.id_ville = eu_quartier.id_ville')
                  ->where('eu_quartier.id_quartier = ?',$id_quartier); 
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['id_pays'];
    }
    
    public function findquartier($id_quartier) {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('lib_quartier'));
           $select->where('id_quartier LIKE ?', $id_quartier);
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['lib_quartier'];
    }
    
    
    public function findville($id_quartier) {
           $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_ville','eu_ville.id_ville = eu_quartier.id_ville')
                  ->where('eu_quartier.id_quartier = ?',$id_quartier); 
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['lib_ville'];     
    }
    
    public function update(Application_Model_EuQuartier $quartier) {
        $data = array(
            'id_quartier' => $quartier->getId_quartier(),
            'lib_quartier' => $quartier->getLib_quartier(),
            'date_create' => $quartier->getDate_create(),
            'id_ville' => $quartier->getId_ville(),
            'id_utilisateur' => $quartier->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_quartier = ?' => $quartier->getId_quartier()));
    }

    public function delete($id_quartier) {
        $this->getDbTable()->delete(array('id_quartier = ?' => $id_quartier));
    }


}
?>
