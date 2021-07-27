<?php

class Application_Model_EuContratMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuContrat');
        }
        return $this->_dbTable;
    }

	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_contrat) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
    public function save(Application_Model_EuContrat $contrat) {
        $data = array(
            'id_contrat' => $contrat->getId_contrat(),
            'code_membre' => $contrat->getCode_membre(),
            'date_contrat' => $contrat->getDate_contrat(),
            'nature_contrat' => $contrat->getNature_contrat(),
            'id_type_contrat' => $contrat->getId_type_contrat(),
            'id_type_creneau' => $contrat->getId_type_creneau(),
            'id_type_acteur' => $contrat->getId_type_acteur(),
            'id_pays' => $contrat->getId_pays(),
            'id_utilisateur' => $contrat->getId_utilisateur(),
            'filiere' => $contrat->getFiliere(),
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuContrat $contrat) {
        $data = array(
            'id_contrat' => $contrat->getId_contrat(),
            'code_membre' => $contrat->getCode_membre(),
            'date_contrat' => $contrat->getDate_contrat(),
            'nature_contrat' => $contrat->getNature_contrat(),
            'id_type_contrat' => $contrat->getId_type_contrat(),
            'id_type_creneau' => $contrat->getId_type_creneau(),
            'id_type_acteur' => $contrat->getId_type_acteur(),
            'id_pays' => $contrat->getId_pays(),
            'id_utilisateur' => $contrat->getId_utilisateur(),
            'filiere' => $contrat->getFiliere(),
        );
        $this->getDbTable()->update($data, array('id_contrat = ?' => $contrat->getId_contrat()));
    }

    public function find($id_contrat, Application_Model_EuContrat $contrat) {

        $result = $this->getDbTable()->find($id_contrat);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $contrat->setId_contrat($row->id_contrat)
                ->setCode_membre($row->code_membre)
                ->setDate_contrat($row->date_contrat)
                ->setNature_contrat($row->nature_contrat)
                ->setId_type_contrat($row->id_type_contrat)
                ->setId_type_creneau($row->id_type_creneau)
                ->setId_type_acteur($row->id_type_acteur)
                ->setId_pays($row->id_pays)
                ->setId_utilisateur($row->id_utilisateur)
                ->setFiliere($row->filiere);
    }

    public function findByMembre($code_membre) {
        $table = new Application_Model_DbTable_EuContrat();
        $select = $table->select();
        $select->where('code_membre =?', $code_membre);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $contrat = new Application_Model_EuContrat();
        $contrat->setId_contrat($row->id_contrat)
                ->setCode_membre($row->code_membre)
                ->setDate_contrat($row->date_contrat)
                ->setNature_contrat($row->nature_contrat)
                ->setId_type_contrat($row->id_type_contrat)
                ->setId_type_creneau($row->id_type_creneau)
                ->setId_type_acteur($row->id_type_acteur)
                ->setId_pays($row->id_pays)
                ->setId_utilisateur($row->id_utilisateur)
                ->setFiliere($row->filiere);
        return $contrat;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContrat();
            $entry->setId_contrat($row->id_contrat)
                    ->setCode_membre($row->code_membre)
                    ->setDate_contrat($row->date_contrat)
                    ->setNature_contrat($row->nature_contrat)
                    ->setId_type_contrat($row->id_type_contrat)
                    ->setId_type_creneau($row->id_type_creneau)
                    ->setId_type_acteur($row->id_type_acteur)
                    ->setId_pays($row->id_pays)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setFiliere($row->filiere);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_contrat) {
        $this->getDbTable()->delete(array('id_contrat = ?' => $id_contrat));
    }

}