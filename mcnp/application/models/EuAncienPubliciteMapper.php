<?php

class Application_Model_EuAncienPubliciteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienPublicite');
        }
        return $this->_dbTable;
    }

    public function find($id_ancien_publicite, Application_Model_EuAncienPublicite $publicite) {
        $result = $this->getDbTable()->find($id_ancien_publicite);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $publicite->setId_ancien_publicite($row->id_ancien_publicite)
                ->setLibelle_ancien_publicite($row->libelle_ancien_publicite);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienPublicite();
            $entry->setId_ancien_publicite($row->id_ancien_publicite)
                    ->setLibelle_ancien_publicite($row->libelle_ancien_publicite);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuAncienPublicite $publicite) {
        $data = array(
            'id_ancien_publicite' => $publicite->getId_ancien_publicite(),
            'libelle_ancien_publicite' => $publicite->getLibelle_ancien_publicite()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienPublicite $publicite) {
        $data = array(
            'id_ancien_publicite' => $publicite->getId_ancien_publicite(),
            'libelle_ancien_publicite' => $publicite->getLibelle_ancien_publicite()
        );
        $this->getDbTable()->update($data, array('id_ancien_publicite = ?' => $publicite->getId_ancien_publicite()));
    }

    public function delete($id_ancien_publicite) {
        $this->getDbTable()->delete(array('id_ancien_publicite = ?' => $id_ancien_publicite));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_ancien_publicite) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

