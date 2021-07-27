<?php

class Application_Model_EuCmUtilisateurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCmUtilisateur');
        }
        return $this->_dbTable;
    }

    public function find($id_cm_utilisateur, Application_Model_EuCmUtilisateur $document) {
        $result = $this->getDbTable()->find($id_cm_utilisateur);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $document->setId_cm_utilisateur($row->id_cm_utilisateur)
                ->setLibelle_cm_utilisateur($row->libelle_cm_utilisateur);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCmUtilisateur();
            $entry->setId_cm_utilisateur($row->id_cm_utilisateur)
                    ->setLibelle_cm_utilisateur($row->libelle_cm_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuCmUtilisateur $document) {
        $data = array(
            'id_cm_utilisateur' => $document->getId_cm_utilisateur(),
            'libelle_cm_utilisateur' => $document->getLibelle_cm_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCmUtilisateur $document) {
        $data = array(
            'id_cm_utilisateur' => $document->getId_cm_utilisateur(),
            'libelle_cm_utilisateur' => $document->getLibelle_cm_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_cm_utilisateur = ?' => $document->getId_cm_utilisateur()));
    }

    public function delete($id_cm_utilisateur) {
        $this->getDbTable()->delete(array('id_cm_utilisateur = ?' => $id_cm_utilisateur));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_cm_utilisateur) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

