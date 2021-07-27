<?php

class Application_Model_EuUserGroupSousMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUserGroupSous');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuUserGroupSous $groupe) {
        $data = array(
            'code_groupe_sous' => $groupe->getCode_groupe_sous(),
            'libelle_groupe_sous' => $groupe->getLibelle_groupe_sous(),
            'code_groupe' => $groupe->getCode_groupe()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUserGroupSous $groupe) {
        $data = array(
            'code_groupe_sous' => $groupe->getCode_groupe_sous(),
            'libelle_groupe_sous' => $groupe->getLibelle_groupe_sous(),
            'code_groupe' => $groupe->getCode_groupe()
        );

        $this->getDbTable()->update($data, array('code_groupe_sous = ?' => $groupe->getCode_groupe_sous()));
    }

    public function find($login, Application_Model_EuUserGroupSous $groupe) {
        $result = $this->getDbTable()->find($login);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $groupe->setCode_groupe_sous($row->code_groupe_sous)
                ->setLibelle_groupe_sous($row->libelle_groupe_sous)
				->setCode_groupe($row->code_groupe);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUserGroupSous();
            $entry->setCode_groupe_sous($row->code_groupe_sous)
                ->setLibelle_groupe_sous($row->libelle_groupe_sous)
				->setCode_groupe($row->code_groupe);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_groupe_sous) {
        $this->getDbTable()->delete(array('code_groupe_sous = ?' => $code_groupe_sous));
    }

}

