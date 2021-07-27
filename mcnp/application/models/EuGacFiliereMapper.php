<?php

class Application_Model_EuGacFiliereMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGacFiliere');
        }
        return $this->_dbTable;
    }

    public function find($code_gac_filiere, Application_Model_EuGacFiliere $gac_filiere) {
        $result = $this->getDbTable()->find($code_gac_filiere);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $gac_filiere->setCode_gac_filiere($row->code_gac_filiere)
                ->setNom_gac_filiere($row->nom_gac_filiere)
                ->setCode_membre($row->code_membre)
                ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
                ->setGroupe($row->groupe)
                ->setCode_gac($row->code_gac);
        return true;
    }

    public function findByGac($code_gac) {
        $table = new Application_Model_DbTable_EuGacFiliere();
        $select = $table->select();
        $select->where('code_gac=?', $code_gac);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGacFiliere();
            $entry->setCode_gac_filiere($row->code_gac_filiere)
                    ->setNom_gac_filiere($row->nom_gac_filiere)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_gac($row->code_gac);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByMembre($membre) {
        $table = new Application_Model_DbTable_EuGacFiliere();
        $select = $table->select();
        $select->where('code_membre=?', $membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGacFiliere();
            $entry->setCode_gac_filiere($row->code_gac_filiere)
                    ->setNom_gac_filiere($row->nom_gac_filiere)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_gac($row->code_gac);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getLastFiliereByGac($code_gac) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_gac_filiere) as code'))
                ->where('code_gac = ?', $code_gac);
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
            $entry = new Application_Model_EuGacFiliere();
            $entry->setCode_gac_filiere($row->code_gac_filiere)
                    ->setNom_gac_filiere($row->nom_gac_filiere)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_gestionnaire($row->code_membre_gestionnaire)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setGroupe($row->groupe)
                    ->setCode_gac($row->code_gac);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuGacFiliere $gac_filiere) {
        $data = array(
            'code_gac_filiere' => $gac_filiere->getCode_gac_filiere(),
            'code_membre' => $gac_filiere->getCode_membre(),
            'nom_gac_filiere' => $gac_filiere->getNom_gac_filiere(),
            'code_membre_gestionnaire' => $gac_filiere->getCode_membre_gestionnaire(),
            'date_creation' => $gac_filiere->getDate_creation(),
            'id_utilisateur' => $gac_filiere->getId_utilisateur(),
            'groupe' => $gac_filiere->getGroupe(),
            'code_gac' => $gac_filiere->getCode_gac()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGacFiliere $gac_filiere) {
        $data = array(
            'code_gac_filiere' => $gac_filiere->getCode_gac_filiere(),
            'code_membre' => $gac_filiere->getCode_membre(),
            'nom_gac_filiere' => $gac_filiere->getNom_gac_filiere(),
            'code_membre_gestionnaire' => $gac_filiere->getCode_membre_gestionnaire(),
            'date_creation' => $gac_filiere->getDate_creation(),
            'id_utilisateur' => $gac_filiere->getId_utilisateur(),
            'groupe' => $gac_filiere->getGroupe(),
            'code_gac' => $gac_filiere->getCode_gac()
        );
        $this->getDbTable()->update($data, array('code_gac_filiere = ?' => $gac_filiere->getCode_gac_filiere()));
    }

    public function delete($code_gac_filiere) {
        $this->getDbTable()->delete(array('code_gac_filiere = ?' => $code_gac_filiere));
    }

}

?>
