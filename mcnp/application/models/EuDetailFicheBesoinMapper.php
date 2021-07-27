<?php

class Application_Model_EuDetailFicheBesoinMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailFicheBesoin');
        }
        return $this->_dbTable;
    }
    
    public function find($id_fiche_besoin, Application_Model_EuDetailFicheBesoin $dfichebesoin) {
        $result = $this->getDbTable()->find($id_detail_fiche_besoin);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $dfichebesoin->setId_detail_fiche_besoin($row->id_detail_fiche_besoin)
		            ->setId_fiche_besoin($row->id_fiche_besoin)
                    ->setCode_identification($row->Code_identification)
					;    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDetailFicheBesoin();
            $entry->setId_detail_fiche_besoin($row->id_detail_fiche_besoin)
		          ->setId_fiche_besoin($row->id_fiche_besoin)
                  ->setCode_identification($row->Code_identification);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuDetailFicheBesoin $dfichebesoin) {
        $data = array(
		    'id_detail_fiche_besoin' => $dfichebesoin->getId_fiche_besoin(),
            'id_fiche_besoin' => $dfichebesoin->getId_fiche_besoin(),
            'code_identification' => $dfichebesoin->getCode_identification()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailFicheBesoin $dfichebesoin) {
        $data = array(
            'id_detail_fiche_besoin' => $dfichebesoin->getId_fiche_besoin(),
            'id_fiche_besoin' => $dfichebesoin->getId_fiche_besoin(),
            'code_identification' => $dfichebesoin->getCode_identification()
        );
        $this->getDbTable()->update($data, array('id_detail_fiche_besoin = ?' => $dfichebesoin->getId_detail_fiche_besoin()));
    }
    
    public function delete($id_detail_fiche_besoin) {
        $this->getDbTable()->delete(array('id_detail_fiche_besoin = ?' => $id_detail_fiche_besoin));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_fiche_besoin) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>