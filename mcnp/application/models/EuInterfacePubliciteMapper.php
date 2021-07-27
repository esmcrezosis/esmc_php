<?php

class Application_Model_EuInterfacePubliciteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuInterfacePublicite');
        }
        return $this->_dbTable;
    }

    public function find($id_interface_publicite, Application_Model_EuInterfacePublicite $interface_publicite) {
        $result = $this->getDbTable()->find($id_interface_publicite);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $interface_publicite->setId_interface_publicite($row->id_interface_publicite)
                ->setLibelle_interface_publicite($row->libelle_interface_publicite);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuInterfacePublicite();
            $entry->setId_interface_publicite($row->id_interface_publicite)
                    ->setLibelle_interface_publicite($row->libelle_interface_publicite);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuInterfacePublicite $interface_publicite) {
        $data = array(
            'id_interface_publicite' => $interface_publicite->getId_interface_publicite(),
            'libelle_interface_publicite' => $interface_publicite->getLibelle_interface_publicite()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuInterfacePublicite $interface_publicite) {
        $data = array(
            'id_interface_publicite' => $interface_publicite->getId_interface_publicite(),
            'libelle_interface_publicite' => $interface_publicite->getLibelle_interface_publicite()
        );
        $this->getDbTable()->update($data, array('id_interface_publicite = ?' => $interface_publicite->getId_interface_publicite()));
    }

    public function delete($id_interface_publicite) {
        $this->getDbTable()->delete(array('id_interface_publicite = ?' => $id_interface_publicite));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_interface_publicite) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

