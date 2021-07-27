<?php

class Application_Model_EuPageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPage');
        }
        return $this->_dbTable;
    }

    public function find($id_page, Application_Model_EuPage $page) {
        $result = $this->getDbTable()->find($id_page);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $page->setId_page($row->id_page)
                ->setTitre($row->titre)
                ->setResume($row->resume)
                ->setDescription($row->description)
                ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $select->order(array("menu ASC", "ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_page) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuPage $page) {
        $data = array(
            'id_page' => $page->getId_page(),
            'titre' => $page->getTitre(),
            'resume' => $page->getResume(),
            'description' => $page->getDescription(),
            'vignette' => $page->getVignette(),
            'menu' => $page->getMenu(),
            'menusous' => $page->getMenusous(),
            'spotlight' => $page->getSpotlight(),
            'ordre' => $page->getOrdre(),
            'deroulant' => $page->getDeroulant(),
            'titre_autre' => $page->getTitre_autre(),
            'titre_deroulant' => $page->getTitre_deroulant(),
            'publier' => $page->getPublier(),
            'liendirect' => $page->getLiendirect()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPage $page) {
        $data = array(
            'id_page' => $page->getId_page(),
            'titre' => $page->getTitre(),
            'resume' => $page->getResume(),
            'description' => $page->getDescription(),
            'vignette' => $page->getVignette(),
            'menu' => $page->getMenu(),
            'menusous' => $page->getMenusous(),
            'spotlight' => $page->getSpotlight(),
            'ordre' => $page->getOrdre(),
            'deroulant' => $page->getDeroulant(),
            'titre_autre' => $page->getTitre_autre(),
            'titre_deroulant' => $page->getTitre_deroulant(),
            'publier' => $page->getPublier(),
            'liendirect' => $page->getLiendirect()
        );
        $this->getDbTable()->update($data, array('id_page = ?' => $page->getId_page()));
    }

    public function delete($id_page) {
        $this->getDbTable()->delete(array('id_page = ?' => $id_page));
    }


    
    public function find2($id_page, Application_Model_EuPage $page) {
        $select = $this->getDbTable()->select();
        $select->where("id_page = ? ", $id_page);
        $select->where("publier = ? ", 1);
        $result = $this->getDbTable()->fetchRow($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result;//->current()
        $page->setId_page($row->id_page)
                ->setTitre($row->titre)
                ->setResume($row->resume)
                ->setDescription($row->description)
                ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
        return true;
    }

    public function find3($menu, $menusous, Application_Model_EuPage $page) {
        $select = $this->getDbTable()->select();
        $select->where("menu = ? ", $menu);
        $select->where("menusous = ? ", $menusous);
        $select->where("publier = ? ", 1);
        $result = $this->getDbTable()->fetchRow($select);
        if (count($result) == 0) {
            return false;
        }
        $row = $result;//->current()
        $page->setId_page($row->id_page)
                ->setTitre($row->titre)
                ->setResume($row->resume)
                ->setDescription($row->description)
                ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
        return true;
    }

    public function fetchAll2() {
        $select = $this->getDbTable()->select();
        $select->where("publier = ? ", 1);
        $select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3($page, $menu) {
        $select = $this->getDbTable()->select();
        $select->where("id_page != ? ", $page);
        $select->where("id_page != ? ", ($page - 1));
        $select->where("id_page != ? ", ($page + 1));
        $select->where("menu = ? ", $menu);
        $select->where("publier = ? ", 1);
        $select->order(array("ordre ASC"));
        //$select->order(new Zend_Db_Expr("'RAND()'"));
        $select->limit(4);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll4($type = "") {
        $select = $this->getDbTable()->select();
        if($type != ""){
        $select->where("menu IN (SELECT menu_id FROM eu_menu WHERE menu_type = '".$type."')");
            }
        $select->where("vignette IS NOT NULL");
        $select->where("spotlight = ? ", 1);
        $select->where("publier = ? ", 1);
        $select->order(array("menu ASC", "ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll5() {
        $select = $this->getDbTable()->select();
        $select->where("vignette IS NOT NULL");
        $select->where("spotlight = ? ", 1);
        $select->where("publier = ? ", 1);
        $select->order(array("menu ASC", "ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }



     public function findOrdre($menu) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(ordre) as count'));
        $select->where("menu = ? ", $menu);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }






    public function findOrdreMonter($menu, $ordre)
    {
        $select = $this->getDbTable()->select();
        $select->where("menu = ? ", $menu);
        $select->where("ordre < ? ", $ordre);
        $select->order(array('ordre DESC'));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries = $entry;
        return $entries;
    }
    
    public function findOrdreDescendre($menu, $ordre)
    {
        $select = $this->getDbTable()->select();
        $select->where("menu = ? ", $menu);
        $select->where("ordre > ? ", $ordre);
        $select->order(array('ordre ASC'));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries = $entry;
        return $entries;
    }
    



    public function findOrdreSuivantPrecedent($menu, $ordre)
    {
        $select = $this->getDbTable()->select();
        $select->where("menu = ? ", $menu);
        $select->where("ordre = ? ", $ordre);
        $select->where("publier = ? ", 1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries = $entry;
        return $entries;
    }



    public function fetchAll6($type) {
        $select = $this->getDbTable()->select();
        //$select->where("menu IN (SELECT menu_id FROM eu_menu WHERE menu_type = '".$type."')");
        $select->where("deroulant = ? ", 1);
        $select->where("publier = ? ", 1);
        $select->order(array("menu ASC", "ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByMenu($menu) {
        $select = $this->getDbTable()->select();
        $select->where("menu = ? ", $menu);
        $select->where("publier = ? ", 1);
        $select->order(array("menu ASC", "ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }


    
    public function fetchAllByMenuSousMenu($menu = 0, $menusous = 0) {
        $select = $this->getDbTable()->select();
        if($menu > 0){
        $select->where("menu = ? ", $menu);
        }
        if($menusous > 0){
        $select->where("menusous = ? ", $menusous);
        }
        $select->where("publier = ? ", 1);
        $select->order(array("ordre ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPage();
            $entry->setId_page($row->id_page)
                    ->setTitre($row->titre)
                    ->setResume($row->resume)
                    ->setDescription($row->description)
                    ->setVignette($row->vignette)
                ->setMenu($row->menu)
                ->setMenusous($row->menusous)
                    ->setSpotlight($row->spotlight)
                    ->setOrdre($row->ordre)
                    ->setDeroulant($row->deroulant)
                ->setTitre_autre($row->titre_autre)
                ->setTitre_deroulant($row->titre_deroulant)
                    ->setPublier($row->publier)
                ->setLiendirect($row->liendirect)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
