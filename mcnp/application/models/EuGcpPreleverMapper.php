<?php

class Application_Model_EuGcpPreleverMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGcpPrelever');
        }
        return $this->_dbTable;
    }

    public function find($code_prelevement, Application_Model_EuGcpPrelever $prelevement) {
        $result = $this->getDbTable()->find($code_prelevement);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $prelevement->setId_prelevement($row->id_prelevement)
                ->setId_gcp($row->id_gcp)
                ->setId_operation($row->id_operation)
                ->setCode_tegc($row->code_tegc)
                ->setCode_membre($row->code_membre)
                ->setMont_prelever($row->mont_prelever)
                ->setDate_prelevement($row->date_prelevement)
                ->setHeure_prelevement($row->heure_prelevement)
                ->setId_tpagcp($row->id_tpagcp)
                ->setId_credit($row->id_credit)
                ->setSource_credit($row->source_credit)
                ->setMont_rapprocher($row->mont_rapprocher)
                ->setSolde_prelevement($row->solde_prelevement)
                ->setRapprocher($row->rapprocher);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGcpPrelever();
            $entry->setId_prelevement($row->id_prelevement)
                    ->setId_gcp($row->id_gcp)
                    ->setId_operation($row->id_operation)
                    ->setCode_tegc($row->code_tegc)
                    ->setCode_membre($row->code_membre)
                    ->setMont_prelever($row->mont_prelever)
                    ->setDate_prelevement($row->date_prelevement)
                    ->setHeure_prelevement($row->heure_prelevement)
                    ->setId_tpagcp($row->id_tpagcp)
                    ->setId_credit($row->id_credit)
                    ->setSource_credit($row->source_credit)
                    ->setMont_rapprocher($row->mont_rapprocher)
                    ->setSolde_prelevement($row->solde_prelevement)
                    ->setRapprocher($row->rapprocher);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuGcpPrelever $gcp_preleve) {
        $data = array(
            'id_prelevement' => $gcp_preleve->getId_prelevement(),
            'code_tegc' => $gcp_preleve->getCode_tegc(),
            'id_gcp' => $gcp_preleve->getId_gcp(),
            'code_membre' => $gcp_preleve->getCode_membre(),
            'id_operation' => $gcp_preleve->getId_operation(),
            'mont_prelever' => $gcp_preleve->getMont_prelever(),
            'date_prelevement' => $gcp_preleve->getDate_prelevement(),
            'heure_prelevement' => $gcp_preleve->getHeure_prelevement(),
            'id_tpagcp' => $gcp_preleve->getId_tpagcp(),
            'id_credit' => $gcp_preleve->getId_credit(),
            'source_credit' => $gcp_preleve->getSource_credit(),
            'mont_rapprocher' => $gcp_preleve->getMont_rapprocher(),
            'solde_prelevement' => $gcp_preleve->getSolde_prelevement(),
            'rapprocher' => $gcp_preleve->getRapprocher()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGcpPrelever $gcp_preleve) {
        $data = array(
            'id_prelevement' => $gcp_preleve->getId_prelevement(),
            'code_tegc' => $gcp_preleve->getCode_tegc(),
            'id_gcp' => $gcp_preleve->getId_gcp(),
            'code_membre' => $gcp_preleve->getCode_membre(),
            'id_operation' => $gcp_preleve->getId_operation(),
            'mont_prelever' => $gcp_preleve->getMont_prelever(),
            'date_prelevement' => $gcp_preleve->getDate_prelevement(),
            'heure_prelevement' => $gcp_preleve->getHeure_prelevement(),
            'id_tpagcp' => $gcp_preleve->getId_tpagcp(),
            'id_credit' => $gcp_preleve->getId_credit(),
            'source_credit' => $gcp_preleve->getSource_credit(),
            'mont_rapprocher' => $gcp_preleve->getMont_rapprocher(),
            'solde_prelevement' => $gcp_preleve->getSolde_prelevement(),
            'rapprocher' => $gcp_preleve->getRapprocher()
        );

        $this->getDbTable()->update($data, array('id_prelevement = ?' => $gcp_preleve->getCode_prelevement()));
    }

    public function delete($id_prelevement) {
        $this->getDbTable()->delete(array('id_prelevement = ?' => $id_prelevement));
    }
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_prelevement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

}

