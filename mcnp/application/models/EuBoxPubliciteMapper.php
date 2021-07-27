<?php

class Application_Model_EuBoxPubliciteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBoxPublicite');
        }
        return $this->_dbTable;
    }

    public function find($id_box_publicite, Application_Model_EuBoxPublicite $box_publicite) {
        $result = $this->getDbTable()->find($id_box_publicite);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $box_publicite->setId_box_publicite($row->id_box_publicite)
                ->setLibelle_box_publicite($row->libelle_box_publicite);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBoxPublicite();
            $entry->setId_box_publicite($row->id_box_publicite)
                    ->setLibelle_box_publicite($row->libelle_box_publicite);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuBoxPublicite $box_publicite) {
        $data = array(
            'id_box_publicite' => $box_publicite->getId_box_publicite(),
            'libelle_box_publicite' => $box_publicite->getLibelle_box_publicite()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBoxPublicite $box_publicite) {
        $data = array(
            'id_box_publicite' => $box_publicite->getId_box_publicite(),
            'libelle_box_publicite' => $box_publicite->getLibelle_box_publicite()
        );
        $this->getDbTable()->update($data, array('id_box_publicite = ?' => $box_publicite->getId_box_publicite()));
    }

    public function delete($id_box_publicite) {
        $this->getDbTable()->delete(array('id_box_publicite = ?' => $id_box_publicite));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_box_publicite) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

