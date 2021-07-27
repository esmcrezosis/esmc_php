<?php

class Application_Model_EuTypePubliciteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypePublicite');
        }
        return $this->_dbTable;
    }

    public function find($id_type_publicite, Application_Model_EuTypePublicite $publicite) {
        $result = $this->getDbTable()->find($id_type_publicite);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $publicite->setId_type_publicite($row->id_type_publicite)
                ->setLibelle_type_publicite($row->libelle_type_publicite);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypePublicite();
            $entry->setId_type_publicite($row->id_type_publicite)
                    ->setLibelle_type_publicite($row->libelle_type_publicite);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypePublicite $publicite) {
        $data = array(
            'id_type_publicite' => $publicite->getId_type_publicite(),
            'libelle_type_publicite' => $publicite->getLibelle_type_publicite()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypePublicite $publicite) {
        $data = array(
            'id_type_publicite' => $publicite->getId_type_publicite(),
            'libelle_type_publicite' => $publicite->getLibelle_type_publicite()
        );
        $this->getDbTable()->update($data, array('id_type_publicite = ?' => $publicite->getId_type_publicite()));
    }

    public function delete($id_type_publicite) {
        $this->getDbTable()->delete(array('id_type_publicite = ?' => $id_type_publicite));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_publicite) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

