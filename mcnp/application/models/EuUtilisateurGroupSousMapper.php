<?php

class Application_Model_EuUtilisateurGroupSousMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUtilisateurGroupSous');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuUtilisateurGroupSous $groupe) {
        $data = array(
            'code_groupe_sous' => $groupe->getCode_groupe_sous(),
            'id_utilisateur' => $groupe->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUtilisateurGroupSous $groupe) {
        $data = array(
            'code_groupe_sous' => $groupe->getCode_groupe_sous(),
            'id_utilisateur' => $groupe->getId_utilisateur()
        );

        $this->getDbTable()->update($data, array('id_utilisateur = ?' => $groupe->getId_utilisateur(), 'code_groupe_sous = ?' => $groupe->getCode_groupe_sous()));
    }

    public function find1($id_utilisateur, Application_Model_EuUtilisateurGroupSous $groupe) {
        $result = $this->getDbTable()->find($id_utilisateur);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $groupe->setCode_groupe_sous($row->code_groupe_sous)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function find2($code_groupe_sous, Application_Model_EuUtilisateurGroupSous $groupe) {
        $result = $this->getDbTable()->find($code_groupe_sous);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $groupe->setCode_groupe_sous($row->code_groupe_sous)
                ->setId_utilisateur($row->id_utilisateur);
    }
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateurGroupSous();
            $entry->setCode_groupe_sous($row->code_groupe_sous)
                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_utilisateur, $code_groupe_sous) {
        $this->getDbTable()->delete(array('id_utilisateur = ?' => $id_utilisateur, 'code_groupe_sous = ?' => $code_groupe_sous));
    }




}

