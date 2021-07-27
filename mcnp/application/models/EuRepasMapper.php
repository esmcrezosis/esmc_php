<?php

class Application_Model_EuRepasMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRepas');
        }
        return $this->_dbTable;
    }

    public function find($id_repas, Application_Model_EuRepas $repas) {
        $result = $this->getDbTable()->find($id_repas);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $repas->setId_repas($row->id_repas)
                ->setLibelle_repas($row->libelle_repas)
                ->setCode_membre($row->code_membre);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepas();
            $entry->setId_repas($row->id_repas)
                    ->setLibelle_repas($row->libelle_repas)
                ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuRepas $repas) {
        $data = array(
            'id_repas' => $repas->getId_repas(),
            'libelle_repas' => $repas->getLibelle_repas(),
            'code_membre' => $repas->getCode_membre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepas $repas) {
        $data = array(
            'id_repas' => $repas->getId_repas(),
            'libelle_repas' => $repas->getLibelle_repas(),
            'code_membre' => $repas->getCode_membre()
        );
        $this->getDbTable()->update($data, array('id_repas = ?' => $repas->getId_repas()));
    }

    public function delete($id_repas) {
        $this->getDbTable()->delete(array('id_repas = ?' => $id_repas));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_repas) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    
	

    public function fetchAllByCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);    
        }
        $select->order(array("id_repas DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepas();
            $entry->setId_repas($row->id_repas)
                    ->setLibelle_repas($row->libelle_repas)
                ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
    


}
?>

