<?php

class Application_Model_EuTypeDocumentMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeDocument');
        }
        return $this->_dbTable;
    }

    public function find($id_type_document, Application_Model_EuTypeDocument $document) {
        $result = $this->getDbTable()->find($id_type_document);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $document->setId_type_document($row->id_type_document)
                ->setLibelle_type_document($row->libelle_type_document);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeDocument();
            $entry->setId_type_document($row->id_type_document)
                    ->setLibelle_type_document($row->libelle_type_document);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeDocument $document) {
        $data = array(
            'id_type_document' => $document->getId_type_document(),
            'libelle_type_document' => $document->getLibelle_type_document()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeDocument $document) {
        $data = array(
            'id_type_document' => $document->getId_type_document(),
            'libelle_type_document' => $document->getLibelle_type_document()
        );
        $this->getDbTable()->update($data, array('id_type_document = ?' => $document->getId_type_document()));
    }

    public function delete($id_type_document) {
        $this->getDbTable()->delete(array('id_type_document = ?' => $id_type_document));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_document) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

