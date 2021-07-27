<?php
 
class Application_Model_EuMenuSousMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMenuSous');
        }
        return $this->_dbTable;
    }

    public function find($menusous_id, Application_Model_EuMenuSous $menusous) {
        $result = $this->getDbTable()->find($menusous_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $menusous->setMenusous_id($row->menu_sous_id)
                ->setMenusous_libelle($row->menu_sous_libelle)
                ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order(array("menu_sous_menu ASC", "ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
	                ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(menu_sous_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuMenuSous $menusous) {
        $data = array(
            'menu_sous_id' => $menusous->getMenusous_id(),
            'menu_sous_libelle' => $menusous->getMenusous_libelle(),
            'menu_sous_menu' => $menusous->getMenusous_menu(),
            'menu_sous_url' => $menusous->getMenusous_url(),
            'ordre' => $menusous->getOrdre(),
            'publier' => $menusous->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMenuSous $menusous) {
        $data = array(
            'menu_sous_id' => $menusous->getMenusous_id(),
            'menu_sous_libelle' => $menusous->getMenusous_libelle(),
            'menu_sous_menu' => $menusous->getMenusous_menu(),
            'menu_sous_url' => $menusous->getMenusous_url(),
            'ordre' => $menusous->getOrdre(),
            'publier' => $menusous->getPublier()
        );
        $this->getDbTable()->update($data, array('menu_sous_id = ?' => $menusous->getMenusous_id()));
    }

    public function delete($menusous_id) {
        $this->getDbTable()->delete(array('menu_sous_id = ?' => $menusous_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
	                ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3($menu) {
        $select = $this->getDbTable()->select();
		$select->where("menu_sous_menu = ? ", $menu);
		$select->where("publier = ? ", 1);
		$select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
	                ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll4($menu) {
        $select = $this->getDbTable()->select();
		$select->where("menu_sous_menu = ? ", $menu);
		//$select->where("publier = ? ", 1);
		$select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
	                ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

	 public function findOrdre($menu) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(ordre) as count'));
		$select->where("menu_sous_menu = ? ", $menu);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }




    public function findOrdreMonter($menu, $ordre)
    {
        $select = $this->getDbTable()->select();
		$select->where("menu_sous_menu = ? ", $menu);
		$select->where("ordre < ? ", $ordre);
		$select->order(array('ordre DESC'));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
	                ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	
    public function findOrdreDescendre($menu, $ordre)
    {
        $select = $this->getDbTable()->select();
		$select->where("menu_sous_menu = ? ", $menu);
		$select->where("ordre > ? ", $ordre);
		$select->order(array('ordre ASC'));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
	                ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
	                ->setOrdre($row->ordre)
                	->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }
	




    public function fetchAllByMenu($menu) {
        $select = $this->getDbTable()->select();
        $select->where("menu_sous_menu = ? ", $menu);
        $select->where("publier = ? ", 1);
        $select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMenuSous();
            $entry->setMenusous_id($row->menu_sous_id)
                    ->setMenusous_libelle($row->menu_sous_libelle)
                    ->setMenusous_menu($row->menu_sous_menu)
                ->setMenusous_url($row->menu_sous_url)
                    ->setOrdre($row->ordre)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }






}


?>
