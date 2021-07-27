<?php

class Application_Model_EuTypeProduitMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeProduit');
        }
        return $this->_dbTable;
    }

    public function find($id_type_produit, Application_Model_EuTypeProduit $type_produit) {
        $result = $this->getDbTable()->find($id_type_produit);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $type_produit->setId_type_produit($row->id_type_produit)
                ->setLibelle_type_produit($row->libelle_type_produit)
                ->setIndice_type_produit($row->indice_type_produit);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeProduit();
            $entry->setId_type_produit($row->id_type_produit)
                    ->setLibelle_type_produit($row->libelle_type_produit)
                ->setIndice_type_produit($row->indice_type_produit);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuTypeProduit $type_produit) {
        $data = array(
            'id_type_produit' => $type_produit->getId_type_produit(),
            'libelle_type_produit' => $type_produit->getLibelle_type_produit(),
            'indice_type_produit' => $type_produit->getIndice_type_produit()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeProduit $type_produit) {
        $data = array(
            'id_type_produit' => $type_produit->getId_type_produit(),
            'libelle_type_produit' => $type_produit->getLibelle_type_produit(),
            'indice_type_produit' => $type_produit->getIndice_type_produit()
        );
        $this->getDbTable()->update($data, array('id_type_produit = ?' => $type_produit->getId_type_produit()));
    }

    public function delete($id_type_produit) {
        $this->getDbTable()->delete(array('id_type_produit = ?' => $id_type_produit));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_type_produit) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    
	


}
?>

