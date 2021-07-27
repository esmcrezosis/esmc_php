<?php

class Application_Model_EuCompteGeneralMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompteGeneral');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCompteGeneral $comptegeneral) {
        $data = array(
            'code_compte' => $comptegeneral->getCode_compte(),
            'intitule' => $comptegeneral->getIntitule(),
            'service' => $comptegeneral->getService(),
            'solde' => $comptegeneral->getSolde(),
            'code_type_compte' => $comptegeneral->getCode_type_compte()
        );

        $this->getDbTable()->insert($data);
    }

    
	public function update(Application_Model_EuCompteGeneral $comptegeneral) {
        $data = array(
            'code_compte' => $comptegeneral->getCode_compte(),
            'intitule' => $comptegeneral->getIntitule(),
            'service' => $comptegeneral->getService(),
            'solde' => $comptegeneral->getSolde(),
            'code_type_compte' => $comptegeneral->getCode_type_compte()
        );
        $this->getDbTable()->update($data, array('code_compte = ?' => $comptegeneral->getCode_compte(), 'code_type_compte = ?' => $comptegeneral->getCode_type_compte(), 'service = ?' => $comptegeneral->getService()));
    }

    
	
	public function find($num_compte, $code_type, $service, Application_Model_EuCompteGeneral $comptegeneral) {
        $result = $this->getDbTable()->find($num_compte, $code_type, $service);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $comptegeneral->setCode_compte($row->code_compte)
                ->setIntitule($row->intitule)
                ->setService($row->service)
                ->setSolde($row->solde)
                ->setCode_type_compte($row->code_type_compte);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteGeneral();
            $entry->setCode_compte($row->code_compte)
                    ->setIntitule($row->intitule)
                    ->setService($row->service)
                    ->setSolde($row->solde)
                    ->setCode_type_compte($row->code_type_compte);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($num_compte, $code_type, $service) {
        $this->getDbTable()->delete(array('code_compte = ?' => $num_compte, 'code_type_compte' => $code_type, 'service' => $service));
    }

}

