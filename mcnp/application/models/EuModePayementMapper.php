<?php

class Application_Model_EuModePayementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuModePayement');
        }
        return $this->_dbTable;
    }

    public function find($id_mode_payement, Application_Model_EuModePayement $payement) {
        $result = $this->getDbTable()->find($id_mode_payement);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $payement->setId_mode_payement($row->id_mode_payement)
                ->setLibelle_mode_payement($row->libelle_mode_payement);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuModePayement();
            $entry->setId_mode_payement($row->id_mode_payement)
                    ->setLibelle_mode_payement($row->libelle_mode_payement);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuModePayement $payement) {
        $data = array(
            'id_mode_payement' => $payement->getId_mode_payement(),
            'libelle_mode_payement' => $payement->getLibelle_mode_payement()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuModePayement $payement) {
        $data = array(
            'id_mode_payement' => $payement->getId_mode_payement(),
            'libelle_mode_payement' => $payement->getLibelle_mode_payement()
        );
        $this->getDbTable()->update($data, array('id_mode_payement = ?' => $payement->getId_mode_payement()));
    }

    public function delete($id_mode_payement) {
        $this->getDbTable()->delete(array('id_mode_payement = ?' => $id_mode_payement));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mode_payement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAllByMode($id_mode_payement) {
        $select = $this->getDbTable()->select();
		$select->where("id_mode_payement = ? ", $id_mode_payement);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuModePayement();
            $entry->setId_mode_payement($row->id_mode_payement)
                    ->setLibelle_mode_payement($row->libelle_mode_payement);
            $entries[] = $entry;
        }
        return $entries;
    }
	


}
?>

