<?php

class Application_Model_EuCategorieFichierMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCategorieFichier');
        }
        return $this->_dbTable;
    }

    public function find($id_categorie_fichier, Application_Model_EuCategorieFichier $fichier) {
        $result = $this->getDbTable()->find($id_categorie_fichier);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $fichier->setId_categorie_fichier($row->id_categorie_fichier)
                ->setLibelle_categorie_fichier($row->libelle_categorie_fichier);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieFichier();
            $entry->setId_categorie_fichier($row->id_categorie_fichier)
                    ->setLibelle_categorie_fichier($row->libelle_categorie_fichier);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuCategorieFichier $fichier) {
        $data = array(
            'id_categorie_fichier' => $fichier->getId_categorie_fichier(),
            'libelle_categorie_fichier' => $fichier->getLibelle_categorie_fichier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCategorieFichier $fichier) {
        $data = array(
            'id_categorie_fichier' => $fichier->getId_categorie_fichier(),
            'libelle_categorie_fichier' => $fichier->getLibelle_categorie_fichier()
        );
        $this->getDbTable()->update($data, array('id_categorie_fichier = ?' => $fichier->getId_categorie_fichier()));
    }

    public function delete($id_categorie_fichier) {
        $this->getDbTable()->delete(array('id_categorie_fichier = ?' => $id_categorie_fichier));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_categorie_fichier) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

