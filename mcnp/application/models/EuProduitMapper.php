<?php

class Application_Model_EuProduitMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProduit');
        }
        return $this->_dbTable;
    }

    public function fetchAllByCatgorie() {
        $select = $this->getDbTable()->select();
        $select->where('code_categorie NOT LIKE ?', '%nr');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProduit();
            $entry->setCode_produit($row->code_produit)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setDescription_produit($row->description_produit)
                    ->setType_produit($row->type_produit)
                    ->setCode_categorie($row->code_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchByCategorie($categorie) {
        $select = $this->getDbTable()->select();
        $select->where('code_categorie LIKE ?', $categorie);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProduit();
            $entry->setCode_produit($row->code_produit)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setDescription_produit($row->description_produit)
                    ->setType_produit($row->type_produit)
                    ->setCode_categorie($row->code_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchByCategorieType($categorie,$type) {
        $select = $this->getDbTable()->select();
        $select->where('code_categorie LIKE ?', $categorie)
                ->where('type_produit = ?',$type);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProduit();
            $entry->setCode_produit($row->code_produit)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setDescription_produit($row->description_produit)
                    ->setType_produit($row->type_produit)
                    ->setCode_categorie($row->code_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchByType($type) {
        $select = $this->getDbTable()->select();
        $select->where('type_produit = ?',$type);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProduit();
            $entry->setCode_produit($row->code_produit)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setDescription_produit($row->description_produit)
                    ->setType_produit($row->type_produit)
                    ->setCode_categorie($row->code_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function find($code_produit, Application_Model_EuProduit $produit) {
        $result = $this->getDbTable()->find($code_produit);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $produit->setCode_produit($row->code_produit)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setDescription_produit($row->description_produit)
                    ->setType_produit($row->type_produit)
                    ->setCode_categorie($row->code_categorie);
            return true;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProduit();
            $entry->setCode_produit($row->code_produit)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setDescription_produit($row->description_produit)
                    ->setType_produit($row->type_produit)
                    ->setCode_categorie($row->code_categorie);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuProduit $produit) {
        $data = array(
            'code_produit' => $produit->getCode_produit(),
            'libelle_produit' => $produit->getLibelle_produit(),
            'description_produit' => $produit->getDescription_produit(),
            'type_produit' => $produit->getType_produit(),
            'code_categorie' => $produit->getCode_categorie()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProduit $produit) {
        $data = array(
            'code_produit' => $produit->getCode_produit(),
            'libelle_produit' => $produit->getLibelle_produit(),
            'description_produit' => $produit->getDescription_produit(),
            'type_produit' => $produit->getType_produit(),
            'code_categorie' => $produit->getCode_categorie()
        );

        $this->getDbTable()->update($data, array('code_produit = ?' => $produit->getCode_produit()));
    }

    public function delete($code_produit) {
        $this->getDbTable()->delete(array('code_produit = ?' => $code_produit));
    }

}

