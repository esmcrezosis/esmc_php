<?php

class Application_Model_EuAlerteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAlerte');
        }
        return $this->_dbTable;
    }

    public function find($id_alerte, Application_Model_EuAlerte $alerte) {
        $result = $this->getDbTable()->find($id_alerte);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $alerte->setId_alerte($row->id_alerte)
                ->setCode_membre_client($row->code_membre_client)
                ->setCode_membre_assureur($row->code_membre_assureur)
                ->setCode_membre_acteur($row->code_membre_acteur)
                ->setLib_alerte($row->lib_alerte)
                ->setMotif_alerte($row->motif_alerte)
                ->setCode_smcipn($row->code_smcipn)
                ->setDate_alerte($row->date_alerte)
                ->setHeure_alerte($row->heure_alerte)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAlerte();
            $entry->setId_alerte($row->id_alerte)
                    ->setCode_membre_client($row->code_membre_client)
                    ->setCode_membre_assureur($row->code_membre_assureur)
                    ->setCode_membre_acteur($row->code_membre_acteur)
                    ->setLib_alerte($row->lib_alerte)
                    ->setMotif_alerte($row->motif_alerte)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setDate_alerte($row->date_alerte)
                    ->setHeure_alerte($row->heure_alerte)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(id_alerte) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAlerte $alerte) {
        $data = array(
            'id_alerte' => $alerte->getId_alerte(),
            'code_membre_client' => $alerte->getCode_membre_client(),
            'code_membre_assureur' => $alerte->getCode_membre_assureur(),
            'code_membre_acteur' => $alerte->getCode_membre_acteur(),
            'lib_alerte' => $alerte->getLib_alerte(),
            'motif_alerte' => $alerte->getMotif_alerte(),
            'code_smcipn' => $alerte->getCode_smcipn(),
            'date_alerte' => $alerte->getDate_alerte(),
            'heure_alerte' => $alerte->getHeure_alerte(),
            'id_utilisateur' => $alerte->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAlerte $alerte) {
        $data = array(
            'id_alerte' => $alerte->getId_alerte(),
            'code_membre_client' => $alerte->getCode_membre_client(),
            'code_membre_assureur' => $alerte->getCode_membre_assureur(),
            'code_membre_acteur' => $alerte->getCode_membre_acteur(),
            'lib_alerte' => $alerte->getLib_alerte(),
            'motif_alerte' => $alerte->getMotif_alerte(),
            'code_smcipn' => $alerte->getCode_smcipn(),
            'date_alerte' => $alerte->getDate_alerte(),
            'heure_alerte' => $alerte->getHeure_alerte(),
            'id_utilisateur' => $alerte->getId_utilisateur()
        );

        $this->getDbTable()->update($data, array('id_alerte = ?' => $alerte->getId_alerte()));
    }

    public function delete($id_alerte) {
        $this->getDbTable()->delete(array('id_alerte = ?' => $id_alerte));
    }

}
