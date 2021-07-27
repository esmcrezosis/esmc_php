<?php

class Application_Model_EuRepasMenuMembreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRepasMenuMembre');
        }
        return $this->_dbTable;
    }

    public function find($id_repas, Application_Model_EuRepasMenuMembre $repas_menu_membre) {
        $result = $this->getDbTable()->find($id_repas);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $repas_menu_membre->setId_repas_menu_membre($row->id_repas_menu_membre)
                ->setId_repas($row->id_repas)
                ->setCode_membre_client($row->code_membre_client)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ->setCode_membre_restaurant($row->code_membre_restaurant)
                ;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenuMembre();
            $entry->setId_repas_menu_membre($row->id_repas_menu_membre)
                ->setId_repas($row->id_repas)
                ->setCode_membre_client($row->code_membre_client)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ->setCode_membre_restaurant($row->code_membre_restaurant)
                ;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuRepasMenuMembre $repas_menu_membre) {
        $data = array(
            'id_repas_menu_membre' => $repas_menu_membre->getId_repas_menu_membre(),
            'id_repas' => $repas_menu_membre->getId_repas(),
            'code_membre_client' => $repas_menu_membre->getCode_membre_client(),
            'jour_semaine' => $repas_menu_membre->getJour_semaine(),
            'date_creation' => $repas_menu_membre->getDate_creation(),
            'code_membre_restaurant' => $repas_menu_membre->getCode_membre_restaurant()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepasMenuMembre $repas_menu_membre) {
        $data = array(
            'id_repas_menu_membre' => $repas_menu_membre->getId_repas_menu_membre(),
            'id_repas' => $repas_menu_membre->getId_repas(),
            'code_membre_client' => $repas_menu_membre->getCode_membre_client(),
            'jour_semaine' => $repas_menu_membre->getJour_semaine(),
            'date_creation' => $repas_menu_membre->getDate_creation(),
            'code_membre_restaurant' => $repas_menu_membre->getCode_membre_restaurant()
        );
        $this->getDbTable()->update($data, array('id_repas_menu_membre = ?' => $repas_menu_membre->getId_repas_menu_membre()));
    }

    public function delete($id_repas_menu_membre) {
        $this->getDbTable()->delete(array('id_repas_menu_membre = ?' => $id_repas_menu_membre));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_repas_menu_membre) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    
	

    public function fetchAllByCodeMembreClient($code_membre_client = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_client != ""){
        $select->where("code_membre_client = ? ", $code_membre_client);    
        }
        $select->order(array("id_repas_menu_membre DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenuMembre();
            $entry->setId_repas_menu_membre($row->id_repas_menu_membre)
                ->setId_repas($row->id_repas)
                ->setCode_membre_client($row->code_membre_client)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ->setCode_membre_restaurant($row->code_membre_restaurant)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCodeMembreRestaurant($code_membre_restaurant = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_restaurant != ""){
        $select->where("code_membre_restaurant = ? ", $code_membre_restaurant);    
        }
        $select->order(array("id_repas_menu_membre DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenuMembre();
            $entry->setId_repas_menu_membre($row->id_repas_menu_membre)
                ->setId_repas($row->id_repas)
                ->setCode_membre_client($row->code_membre_client)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ->setCode_membre_restaurant($row->code_membre_restaurant)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
public function fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($code_membre_client = "", $jour_semaine = 0, $code_membre_restaurant = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_client != ""){
        $select->where("code_membre_client = ? ", $code_membre_client);    
        }
        if($jour_semaine > 0){
        $select->where("jour_semaine = ? ", $jour_semaine);    
        }
        if($code_membre_restaurant != ""){
        $select->where("code_membre_restaurant = ? ", $code_membre_restaurant);    
        }
        $select->order(array("jour_semaine ASC", "id_repas_menu_membre DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenuMembre();
            $entry->setId_repas_menu_membre($row->id_repas_menu_membre)
                ->setId_repas($row->id_repas)
                ->setCode_membre_client($row->code_membre_client)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ->setCode_membre_restaurant($row->code_membre_restaurant)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    
public function fetchAllByJourSemaineCodeMembreRestaurant($jour_semaine = 0, $code_membre_restaurant = "") {
        $select = $this->getDbTable()->select();
        if($jour_semaine > 0){
        $select->where("jour_semaine = ? ", $jour_semaine);    
        }
        if($code_membre_restaurant != ""){
        $select->where("code_membre_restaurant = ? ", $code_membre_restaurant);    
        }
        $select->order(array("code_membre_client ASC", "id_repas_menu_membre DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepasMenuMembre();
            $entry->setId_repas_menu_membre($row->id_repas_menu_membre)
                ->setId_repas($row->id_repas)
                ->setCode_membre_client($row->code_membre_client)
                ->setJour_semaine($row->jour_semaine)
                ->setDate_creation($row->date_creation)
                ->setCode_membre_restaurant($row->code_membre_restaurant)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


}
?>

