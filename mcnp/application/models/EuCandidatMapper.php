<?php
 
class Application_Model_EuCandidatMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCandidat');
        }
        return $this->_dbTable;
    }

    public function find($candidat_id, Application_Model_EuCandidat $candidat) {
        $result = $this->getDbTable()->find($candidat_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $candidat->setCandidat_id($row->candidat_id)
                ->setId_type_candidat($row->id_type_candidat)
                ->setCandidat_nom($row->candidat_nom)
                ->setCandidat_poste($row->candidat_poste)
                ->setCandidat_document($row->candidat_document)
                ->setCandidat_datenaiss($row->candidat_datenaiss)
                ->setCandidat_nationalite($row->candidat_nationalite)
                ->setCandidat_education($row->candidat_education)
                ->setCandidat_affiliation($row->candidat_affiliation)
                ->setCandidat_formation($row->candidat_formation)
                ->setCandidat_pays($row->candidat_pays)
                ->setCandidat_langue($row->candidat_langue)
                ->setCandidat_experience($row->candidat_experience)
                ->setCandidat_tache($row->candidat_tache)
                ->setCandidat_competence($row->candidat_competence)
                ->setCandidat_attestation($row->candidat_attestation)
                ->setCandidat_date($row->candidat_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCandidat();
            $entry->setCandidat_id($row->candidat_id)
                ->setId_type_candidat($row->id_type_candidat)
	                ->setCandidat_nom($row->candidat_nom)
	                ->setCandidat_poste($row->candidat_poste)
                ->setCandidat_document($row->candidat_document)
                ->setCandidat_datenaiss($row->candidat_datenaiss)
                ->setCandidat_nationalite($row->candidat_nationalite)
                ->setCandidat_education($row->candidat_education)
                ->setCandidat_affiliation($row->candidat_affiliation)
                ->setCandidat_formation($row->candidat_formation)
                ->setCandidat_pays($row->candidat_pays)
                ->setCandidat_langue($row->candidat_langue)
                ->setCandidat_experience($row->candidat_experience)
                ->setCandidat_tache($row->candidat_tache)
                ->setCandidat_competence($row->candidat_competence)
                ->setCandidat_attestation($row->candidat_attestation)
                ->setCandidat_date($row->candidat_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(candidat_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCandidat $candidat) {
        $data = array(
            'candidat_id' => $candidat->getCandidat_id(),
            'id_type_candidat' => $candidat->getId_type_candidat(),
            'candidat_nom' => $candidat->getCandidat_nom(),
            'candidat_poste' => $candidat->getCandidat_poste(),
            'candidat_document' => $candidat->getCandidat_document(),
            'candidat_datenaiss' => $candidat->getCandidat_datenaiss(),
            'candidat_nationalite' => $candidat->getCandidat_nationalite(),
            'candidat_education' => $candidat->getCandidat_education(),
            'candidat_affiliation' => $candidat->getCandidat_affiliation(),
            'candidat_formation' => $candidat->getCandidat_formation(),
            'candidat_pays' => $candidat->getCandidat_pays(),
            'candidat_langue' => $candidat->getCandidat_langue(),
            'candidat_experience' => $candidat->getCandidat_experience(),
            'candidat_tache' => $candidat->getCandidat_tache(),
            'candidat_competence' => $candidat->getCandidat_competence(),
            'candidat_attestation' => $candidat->getCandidat_attestation(),
            'candidat_date' => $candidat->getCandidat_date(),
            'publier' => $candidat->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCandidat $candidat) {
        $data = array(
            'id_type_candidat' => $candidat->getId_type_candidat(),
            'candidat_nom' => $candidat->getCandidat_nom(),
            'candidat_poste' => $candidat->getCandidat_poste(),
            'candidat_document' => $candidat->getCandidat_document(),
            'candidat_datenaiss' => $candidat->getCandidat_datenaiss(),
            'candidat_nationalite' => $candidat->getCandidat_nationalite(),
            'candidat_education' => $candidat->getCandidat_education(),
            'candidat_affiliation' => $candidat->getCandidat_affiliation(),
            'candidat_formation' => $candidat->getCandidat_formation(),
            'candidat_pays' => $candidat->getCandidat_pays(),
            'candidat_langue' => $candidat->getCandidat_langue(),
            'candidat_experience' => $candidat->getCandidat_experience(),
            'candidat_tache' => $candidat->getCandidat_tache(),
            'candidat_competence' => $candidat->getCandidat_competence(),
            'candidat_attestation' => $candidat->getCandidat_attestation(),
            'candidat_date' => $candidat->getCandidat_date(),
            'publier' => $candidat->getPublier()
        );
        $this->getDbTable()->update($data, array('candidat_id = ?' => $candidat->getCandidat_id()));
    }

    public function delete($candidat_id) {
        $this->getDbTable()->delete(array('candidat_id = ?' => $candidat_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCandidat();
            $entry->setCandidat_id($row->candidat_id)
                ->setId_type_candidat($row->id_type_candidat)
	                ->setCandidat_nom($row->candidat_nom)
	                ->setCandidat_poste($row->candidat_poste)
                ->setCandidat_document($row->candidat_document)
                ->setCandidat_datenaiss($row->candidat_datenaiss)
                ->setCandidat_nationalite($row->candidat_nationalite)
                ->setCandidat_education($row->candidat_education)
                ->setCandidat_affiliation($row->candidat_affiliation)
                ->setCandidat_formation($row->candidat_formation)
                ->setCandidat_pays($row->candidat_pays)
                ->setCandidat_langue($row->candidat_langue)
                ->setCandidat_experience($row->candidat_experience)
                ->setCandidat_tache($row->candidat_tache)
                ->setCandidat_competence($row->candidat_competence)
                ->setCandidat_attestation($row->candidat_attestation)
                ->setCandidat_date($row->candidat_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
