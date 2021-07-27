<?php

class Application_Model_EuStandMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuStand');
        }
        return $this->_dbTable;
    }

    public function find($id_stand, Application_Model_EuStand $stand) {
        $result = $this->getDbTable()->find($id_stand);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $stand->setId_stand($row->id_stand)
              ->setDesign_stand($row->design_stand)
              ->setDescription($row->description)
              ->setCode_membre($row->code_membre) ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuStand();
            $entry->setId_stand($row->id_stand)
                  ->setDesign_stand($row->design_stand)
                  ->setDescription($row->description)
                  ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuStand $stand) {
        $data = array(
            'id_stand' => $stand->getId_stand(),
            'design_stand' => $stand->getDesign_stand(),
            'description' => $stand->getDescription(),
            'code_membre' => $stand->getCode_membre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuStand $stand) {
        $data = array(
          'id_stand' => $stand->getId_stand(),
          'design_stand' => $stand->getDesign_stand(),
          'description' => $stand->getDescription(),
          'code_membre' => $stand->getCode_membre()  
    );

        $this->getDbTable()->update($data, array('id_stand = ?' => $stand->getId_stand()));
    }

    public function delete($id_stand) {
        $this->getDbTable()->delete(array('id_stand = ?' => $id_stand));
    }

}

