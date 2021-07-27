<?php

class Application_Model_EuTypeBlogMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeBlog');
        }
        return $this->_dbTable;
    }

    public function find($id_type_blog, Application_Model_EuTypeBlog $blog) {
        $result = $this->getDbTable()->find($id_type_blog);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $blog->setId_type_blog($row->id_type_blog)
                ->setLibelle_type_blog($row->libelle_type_blog);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeBlog();
            $entry->setId_type_blog($row->id_type_blog)
                    ->setLibelle_type_blog($row->libelle_type_blog);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeBlog $blog) {
        $data = array(
            'id_type_blog' => $blog->getId_type_blog(),
            'libelle_type_blog' => $blog->getLibelle_type_blog()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeBlog $blog) {
        $data = array(
            'id_type_blog' => $blog->getId_type_blog(),
            'libelle_type_blog' => $blog->getLibelle_type_blog()
        );
        $this->getDbTable()->update($data, array('id_type_blog = ?' => $blog->getId_type_blog()));
    }

    public function delete($id_type_blog) {
        $this->getDbTable()->delete(array('id_type_blog = ?' => $id_type_blog));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_blog) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

