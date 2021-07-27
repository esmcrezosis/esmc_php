<?php

class Application_Model_EuMembrePropositionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMembreProposition');
        }
        return $this->_dbTable;
    }

    public function find($id_membre_proposition, Application_Model_EuMembreProposition $membre_proposition) {
        $result = $this->getDbTable()->find($id_membre_proposition);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $membre_proposition->setId_membre_proposition($row->id_membre_proposition)
                ->setId_proposition($row->id_proposition)
                ->setCode_membre($row->code_membre);
                //->setSalaire($row->salaire)
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreProposition();
            $entry->setId_membre_proposition($row->id_membre_proposition)
                    ->setId_proposition($row->id_proposition)
                    ->setCode_membre($row->code_membre);
	                //->setSalaire($row->salaire)
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_membre_proposition) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuMembreProposition $membre_proposition) {
        $data = array(
            'id_membre_proposition' => $membre_proposition->getId_membre_proposition(),
            'id_proposition' => $membre_proposition->getId_proposition(),
            'code_membre' => $membre_proposition->getCode_membre()
            //'salaire' => $membre_proposition->getSalaire(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembreProposition $membre_proposition) {
        $data = array(
            'id_membre_proposition' => $membre_proposition->getId_membre_proposition(),
            'id_proposition' => $membre_proposition->getId_proposition(),
            'code_membre' => $membre_proposition->getCode_membre()
            //'salaire' => $membre_proposition->getSalaire(),
        );
        $this->getDbTable()->update($data, array('id_membre_proposition = ?' => $membre_proposition->getId_membre_proposition()));
    }

    public function delete($id_membre_proposition) {
        $this->getDbTable()->delete(array('id_membre_proposition = ?' => $id_membre_proposition));
    }


    public function fetchAll2($id_proposition) {
        $select = $this->getDbTable()->select();
		$select->where("id_proposition = ? ", $id_proposition);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreProposition();
            $entry->setId_membre_proposition($row->id_membre_proposition)
                    ->setId_proposition($row->id_proposition)
                    ->setCode_membre($row->code_membre);
	                //->setSalaire($row->salaire)
            $entries[] = $entry;
        }
        return $entries;
    }
    

}


?>
