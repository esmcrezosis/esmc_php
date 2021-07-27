<?php

class Application_Model_EuUsergroupMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUserGroup');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuUserGroup $groupe) {
        $data = array(
            'code_groupe' => $groupe->getCode_groupe(),
            'libelle_groupe' => $groupe->getLibelle_groupe()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUserGroup $groupe) {
        $data = array(
            'code_groupe' => $groupe->getCode_groupe(),
            'libelle_groupe' => $groupe->getLibelle_groupe()
        );

        $this->getDbTable()->update($data, array('code_groupe = ?' => $groupe->getCode_groupe()));
    }

    public function find($login, Application_Model_EuUserGroup $groupe) {
        $result = $this->getDbTable()->find($login);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $groupe->setCode_groupe($row->code_groupe)
                ->setLibelle_groupe($row->libelle_groupe);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUserGroup();
            $entry->setCode_groupe($row->code_groupe)
                ->setLibelle_groupe($row->libelle_groupe);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_groupe) {
        $this->getDbTable()->delete(array('code_groupe = ?' => $code_groupe));
    }

    public function fetchAll10() {
		$liste = array("agregat","detentrice","detentrice_pays","detentrice_region","detentrice_secteur","detentrice_agence","executante","executante_pays","executante_region","executante_secteur","executante_agence","surveillance","surveillance_pays","surveillance_region","surveillance_secteur","surveillance_agence","detentrice_filiere","executante_acnev","surveillance_technopole",
		
		"espace_kacm","espace_cmfh","espace_caps","espace_capa","espace_bps_ei","espace_bps_gp","espace_traite","espace_gp_mf107","espace_gp_mf11000","espace_gp_redemare","espace_gp_mcnp","espace_zppe","espace_tc_pp","espace_tc_pm","espace_tr_pm","espace_bourse");
		
        $select = $this->getDbTable()->select();
		$select->where("code_groupe IN (?) ", $liste);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUserGroup();
            $entry->setCode_groupe($row->code_groupe)
                ->setLibelle_groupe($row->libelle_groupe);
            $entries[] = $entry;
        }
        return $entries;
    }
}

