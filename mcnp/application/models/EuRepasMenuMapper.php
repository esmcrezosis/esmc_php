<?php

class Application_Model_EuRepasMenuMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRepasMenu');
        }
        return $this->_dbTable;
    }

    public function find($id_repas, Application_Model_EuRepasMenu $repas_menu) {
        $result = $this->getDbTable()->find($id_repas);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $repas_menu->setId_repas_menu($row->id_repas_menu)
                ->setId_repas($row->id_repas)
                ->setCode_membre($row->code_membre)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenu();
            $entry->setId_repas_menu($row->id_repas_menu)
                ->setId_repas($row->id_repas)
                ->setCode_membre($row->code_membre)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuRepasMenu $repas_menu) {
        $data = array(
            'id_repas_menu' => $repas_menu->getId_repas_menu(),
            'id_repas' => $repas_menu->getId_repas(),
            'code_membre' => $repas_menu->getCode_membre(),
            'jour_semaine' => $repas_menu->getJour_semaine(),
            'date_creation' => $repas_menu->getDate_creation()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepasMenu $repas_menu) {
        $data = array(
            'id_repas_menu' => $repas_menu->getId_repas_menu(),
            'id_repas' => $repas_menu->getId_repas(),
            'code_membre' => $repas_menu->getCode_membre(),
            'jour_semaine' => $repas_menu->getJour_semaine(),
            'date_creation' => $repas_menu->getDate_creation()
        );
        $this->getDbTable()->update($data, array('id_repas_menu = ?' => $repas_menu->getId_repas_menu()));
    }

    public function delete($id_repas_menu) {
        $this->getDbTable()->delete(array('id_repas_menu = ?' => $id_repas_menu));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_repas_menu) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    
	

    public function fetchAllByCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);    
        }
        $select->order(array("id_repas_menu DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenu();
            $entry->setId_repas_menu($row->id_repas_menu)
                ->setId_repas($row->id_repas)
                ->setCode_membre($row->code_membre)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByCodeMembreJourSemaine($code_membre = "", $jour_semaine = 0) {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);    
        }
        if($jour_semaine > 0){
        $select->where("jour_semaine = ? ", $jour_semaine);    
        }
        $select->order(array("jour_semaine ASC", "id_repas ASC", "id_repas_menu DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenu();
            $entry->setId_repas_menu($row->id_repas_menu)
                ->setId_repas($row->id_repas)
                ->setCode_membre($row->code_membre)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

}
?>

