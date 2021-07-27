<?php

class Application_Model_CategorieMapper {

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
            $this->setDbTable('Application_Model_DbTable_Categorie');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Categorie $categorie) {
        $data = array(
            'code_categorie' => $categorie->getCode_Categorie(),
            'libelle_categorie' => $categorie->getLibelle_Categorie(),
            'description_categorie' => $categorie->getDescription_Categorie(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_Categorie $categorie) {
        $data = array(
            'code_categorie' => $categorie->getCode_Categorie(),
            'libelle_categorie' => $categorie->getLibelle_Categorie(),
            'description_categorie' => $categorie->getDescription_Categorie(),
        );

        $this->getDbTable()->update($data, array('code_categorie = ?' => $categorie->getCode_Categorie()));
    }

    public function find($code_categorie, Application_Model_Categorie $categorie) {
        $result = $this->getDbTable()->find($code_categorie);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $categorie->setCode_categorie($row->code_categorie)
                ->setLibelle_categorie($row->libelle_categorie)
                ->setDescription_categorie($row->description_categorie);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Categorie();
            $entry->setCode_categorie($row->code_categorie)
                    ->setLibelle_categorie($row->libelle_categorie)
                    ->setDescription_categorie($row->description_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByType() {
        $select = $this->getDbTable()->select();
        $select->where('code_categorie NOT LIKE ?','%NR')->where('code_categorie NOT LIKE ?','CNCS%');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Categorie();
            $entry->setCode_categorie($row->code_categorie)
                    ->setLibelle_categorie($row->libelle_categorie)
                    ->setDescription_categorie($row->description_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_categorie) {
        $this->getDbTable()->delete(array('code_categorie = ?' => $code_categorie));
    }

}

