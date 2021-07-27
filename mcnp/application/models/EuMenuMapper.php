<?php
 
class Application_Model_EuMenuMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMenu');
        }
        return $this->_dbTable;
    }

    public function find($menu_id, Application_Model_EuMenu $menu) {
        $result = $this->getDbTable()->find($menu_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $menu->setMenu_id($row->menu_id)
                ->setMenu_libelle($row->menu_libelle)
                ->setMenu_type($row->menu_type)
                ->setOrdre($row->ordre)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenu();
            $entry->setMenu_id($row->menu_id)
	                ->setMenu_libelle($row->menu_libelle)
	                ->setMenu_type($row->menu_type)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(menu_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuMenu $menu) {
        $data = array(
            'menu_id' => $menu->getMenu_id(),
            'menu_libelle' => $menu->getMenu_libelle(),
            'menu_type' => $menu->getMenu_type(),
            'ordre' => $menu->getOrdre(),
            'publier' => $menu->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMenu $menu) {
        $data = array(
            'menu_libelle' => $menu->getMenu_libelle(),
            'menu_type' => $menu->getMenu_type(),
            'ordre' => $menu->getOrdre(),
            'publier' => $menu->getPublier()
        );
        $this->getDbTable()->update($data, array('menu_id = ?' => $menu->getMenu_id()));
    }

    public function delete($menu_id) {
        $this->getDbTable()->delete(array('menu_id = ?' => $menu_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenu();
            $entry->setMenu_id($row->menu_id)
	                ->setMenu_libelle($row->menu_libelle)
	                ->setMenu_type($row->menu_type)
                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("menu_type = ? ", $type);
		$select->where("publier = ? ", 1);
		$select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenu();
            $entry->setMenu_id($row->menu_id)
	                ->setMenu_libelle($row->menu_libelle)
	                ->setMenu_type($row->menu_type)
                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



	
	 public function findOrdre() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(ordre) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function findOrdreMonter($ordre)
    {
        $select = $this->getDbTable()->select();
		$select->where("ordre < ? ", $ordre);
		$select->order(array('ordre DESC'));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMenu();
            $entry->setMenu_id($row->menu_id)
	                ->setMenu_libelle($row->menu_libelle)
	                ->setMenu_type($row->menu_type)
                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	
    public function findOrdreDescendre($ordre)
    {
        $select = $this->getDbTable()->select();
		$select->where("ordre > ? ", $ordre);
		$select->order(array('ordre ASC'));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMenu();
            $entry->setMenu_id($row->menu_id)
	                ->setMenu_libelle($row->menu_libelle)
	                ->setMenu_type($row->menu_type)
                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	






}


?>
