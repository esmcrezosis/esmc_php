<?php

class Application_Model_EuDomaineActiviteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDomaineActivite');
        }
        return $this->_dbTable;
    }

    public function find($id_domaine, Application_Model_EuDomaineActivite $domaine) {
        $result = $this->getDbTable()->find($id_domaine);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $domaine->setId_domaine($row->id_domaine)
                ->setLib_domaine($row->lib_domaine)
                ->setDesc_domaine($row->desc_domaine)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDomaineActivite();
            $entry->setId_domaine($row->id_domaine)
                    ->setLib_domaine($row->lib_domaine)
                    ->setDesc_domaine($row->desc_domaine)
                    ->setDate_creation($row->date_creation)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuDomaineActivite $domaine) {
        $data = array(
            'id_domaine' => $domaine->getId_domaine(),
            'lib_domaine' => $domaine->getLib_domaine(),
            'desc_domaine' => $domaine->getDesc_domaine(),
            'date_creation' => $domaine->getDate_creation(),
            'id_utilisateur' => $domaine->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDomaineActivite $domaine) {
        $data = array(
            'id_domaine' => $domaine->getId_domaine(),
            'lib_domaine' => $domaine->getLib_domaine(),
            'desc_domaine' => $domaine->getDesc_domaine(),
            'date_creation' => $domaine->getDate_creation(),
            'id_utilisateur' => $domaine->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_domaine = ?' => $domaine->getId_domaine()));
    }

    public function delete($id_domaine) {
        $this->getDbTable()->delete(array('id_domaine = ?' => $id_domaine));
    }

}

?>
