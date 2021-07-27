<?php

class Application_Model_EuStandProduitMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuStandProduit');
        }
        return $this->_dbTable;
    }

    public function find($id_produit, Application_Model_EuStandProduit $standp) {
        $result = $this->getDbTable()->find($id_produit);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $standp->setId_produit($row->id_produit)
               ->setDesign_produit($row->design_produit)
               ->setId_stand($row->id_stand)
               ->setId_filiere($row->id_filiere) ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuStandProduit();
            $entry->setId_produit($row->id_produit)
                  ->setDesign_produit($row->design_produit)
                  ->setId_stand($row->id_stand)
                  ->setId_filiere($row->id_filiere);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuStandProduit $standp) {
        $data = array(
            'id_produit' => $standp->getId_produit(),
            'design_produit' => $standp->getDesign_produit(),
            'id_stand' => $standp->getId_stand(),
            'id_filiere' => $standp->getId_filiere()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuStandProduit $standp) {
        $data = array(
            'id_produit' => $standp->getId_produit(),
            'design_produit' => $standp->getDesign_produit(),
            'id_stand' => $standp->getId_stand(),
            'id_filiere' => $standp->getId_filiere() 
    );

        $this->getDbTable()->update($data, array('id_produit = ?' => $standp->getId_produit()));
    }

    public function delete($id_produit) {
        
        $this->getDbTable()->delete(array('id_produit = ?' => $id_produit));
        
    }

}


