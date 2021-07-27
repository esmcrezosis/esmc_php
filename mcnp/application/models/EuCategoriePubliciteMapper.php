<?php

class Application_Model_EuCategoriePubliciteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCategoriePublicite');
        }
        return $this->_dbTable;
    }

    public function find($id_categorie_publicite, Application_Model_EuCategoriePublicite $publicite) {
        $result = $this->getDbTable()->find($id_categorie_publicite);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $publicite->setId_categorie_publicite($row->id_categorie_publicite)
                ->setLibelle_categorie_publicite($row->libelle_categorie_publicite);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategoriePublicite();
            $entry->setId_categorie_publicite($row->id_categorie_publicite)
                    ->setLibelle_categorie_publicite($row->libelle_categorie_publicite);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuCategoriePublicite $publicite) {
        $data = array(
            'id_categorie_publicite' => $publicite->getId_categorie_publicite(),
            'libelle_categorie_publicite' => $publicite->getLibelle_categorie_publicite()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCategoriePublicite $publicite) {
        $data = array(
            'id_categorie_publicite' => $publicite->getId_categorie_publicite(),
            'libelle_categorie_publicite' => $publicite->getLibelle_categorie_publicite()
        );
        $this->getDbTable()->update($data, array('id_categorie_publicite = ?' => $publicite->getId_categorie_publicite()));
    }

    public function delete($id_categorie_publicite) {
        $this->getDbTable()->delete(array('id_categorie_publicite = ?' => $id_categorie_publicite));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_categorie_publicite) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

