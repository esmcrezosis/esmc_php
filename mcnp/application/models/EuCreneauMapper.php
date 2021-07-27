<?php

class Application_Model_EuCreneauMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCreneau');
        }
        return $this->_dbTable;
    }

    public function findByGacFiliere($code_gac_filiere) {
        $table = new Application_Model_DbTable_EuCreneau();
        $select = $table->select();
        $select->where('code_gac_filiere=?', $code_gac_filiere);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCreneau();
            $entry->setCode_creneau($row->code_creneau)
                    ->setNom_creneau($row->nom_creneau)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_creneau($row->id_type_creneau)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_gac_filiere($row->code_gac_filiere);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find($code_creneau, Application_Model_EuCreneau $cren) {
        $result = $this->getDbTable()->find($code_creneau);
        if (0 == count($result)) {
            return false;
        }

        $row = $result->current();
        $cren->setCode_creneau($row->code_creneau)
                ->setNom_creneau($row->nom_creneau)
                ->setCode_membre($row->code_membre)
                ->setId_type_creneau($row->id_type_creneau)
                ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
                ->setGroupe($row->groupe)
                ->setCode_gac_filiere($row->code_gac_filiere);
        return true;
    }

    public function findByMembre($membre) {
        $table = new Application_Model_DbTable_EuCreneau();
        $select = $table->select();
        $select->where('code_membre=?', $membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCreneau();
            $entry->setCode_creneau($row->code_creneau)
                    ->setNom_creneau($row->nom_creneau)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_creneau($row->id_type_creneau)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_gac_filiere($row->code_gac_filiere);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function getLastCreneauByFil($code_gac_filiere) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_creneau) as code'))
                ->where('code_gac_filiere = ?', $code_gac_filiere);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCreneau();
            $entry->setCode_creneau($row->code_creneau)
                    ->setNom_creneau($row->nom_creneau)
                    ->setCode_membre($row->code_membre)
                    ->setId_type_creneau($row->id_type_creneau)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_gac_filiere($row->code_gac_filiere);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuCreneau $cren) {
        $data = array(
            'code_creneau' => $cren->getCode_creneau(),
            'nom_creneau' => $cren->getNom_creneau(),
            'code_membre' => $cren->getCode_membre(),
            'id_type_creneau' => $cren->getId_type_creneau(),
            'code_membre_gestionnaire' => $cren->getCode_membre_gestionnaire(),
            'date_creation' => $cren->getDate_creation(),
            'id_utilisateur' => $cren->getId_utilisateur(),
            'groupe' => $cren->getGroupe(),
            'code_gac_filiere' => $cren->getCode_gac_filiere()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCreneau $cren) {
        $data = array(
            'code_creneau' => $cren->getCode_creneau(),
            'nom_creneau' => $cren->getNom_creneau(),
            'code_membre' => $cren->getCode_membre(),
            'id_type_creneau' => $cren->getId_type_creneau(),
            'code_membre_gestionnaire' => $cren->getCode_membre_gestionnaire(),
            'date_creation' => $cren->getDate_creation(),
            'id_utilisateur' => $cren->getId_utilisateur(),
            'groupe' => $cren->getGroupe(),
            'code_gac_filiere' => $cren->getCode_gac_filiere()
        );
        $this->getDbTable()->update($data, array('code_creneau = ?' => $cren->getCode_creneau()));
    }

    public function delete($code_creneau) {
        $this->getDbTable()->delete(array('code_creneau = ?' => $code_creneau));
    }

}

?>
