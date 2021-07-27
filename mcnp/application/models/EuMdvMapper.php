<?php

class Application_Model_EuMdvMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMdv');
        }
        return $this->_dbTable;
    }

    public function find($id_mdv, Application_Model_EuMdv $mdv) {
        $result = $this->getDbTable()->find($id_mdv);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $mdv->setId_mdv($row->id_mdv)
                ->setDuree_vie($row->duree_vie)
                ->setId_filiere($row->id_filiere)
                ->setCode_membre($row->code_membre);
    }

    public function findMdvByFiliere($id_filiere) {
        $select = $this->getDbTable()->select();
        $select->where('id_filiere=?', $id_filiere);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $mdv = new Application_Model_EuMdv();
        $mdv->setId_mdv($row->id_mdv)
                ->setDuree_vie($row->duree_vie)
                ->setId_filiere($row->id_filiere)
                ->setCode_membre($row->code_membre);
        return $mdv;
    }
    
    public function findMdvByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre =?', $code_membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $mdv = new Application_Model_EuMdv();
        $mdv->setId_mdv($row->id_mdv)
                ->setDuree_vie($row->duree_vie)
                ->setId_filiere($row->id_filiere)
                ->setCode_membre($row->code_membre);
        return $mdv;
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMdv();
            $entry->setId_mdv($row->id_mdv)
                    ->setDuree_vie($row->duree_vie)
                    ->setId_filiere($row->id_filiere)
                    ->setCode_Membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuMdv $mdv) {
        $data = array(
            'id_mdv' => $mdv->getId_mdv(),
            'duree_vie' => $mdv->getDuree_vie(),
            'id_filiere' => $mdv->getId_filiere(),
            'code_membre' => $mdv->getCode_membre()
        );
        $this->getDbTable()->insert($data);
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(id_mdv) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function update(Application_Model_EuMdv $mdv) {
        $data = array(
            'id_mdv' => $mdv->getId_mdv(),
            'duree_vie' => $mdv->getDuree_vie(),
            'id_filiere' => $mdv->getId_filiere(),
            'code_membre' => $mdv->getCode_membre()
        );
        $this->getDbTable()->update($data, array('id_mdv = ?' => $mdv->getId_mdv()));
    }

    public function delete($id_mdv) {
        $this->getDbTable()->delete(array('id_mdv = ?' => $id_mdv));
    }

}
?>

