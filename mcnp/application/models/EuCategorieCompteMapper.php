<?php

class Application_Model_EuCategorieCompteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCategorieCompte');
        }
        return $this->_dbTable;
    }

    public function find($code_cat, Application_Model_EuCategorieCompte $catcompte) {
        $result = $this->getDbTable()->find($code_cat);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $catcompte->setCode_cat($row->code_cat)
                ->setLib_cat($row->lib_cat)
                ->setDesc_cat($row->desc_cat)
				->setCode_type_compte($row->code_type_compte);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieCompte();
            $entry->setCode_cat($row->code_cat)
                    ->setLib_cat($row->lib_cat)
                    ->setDesc_cat($row->desc_cat)
				    ->setCode_type_compte($row->code_type_compte);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuCategorieCompte $catcompte) {
        $data = array(
            'code_cat' => $catcompte->getCode_cat(),
            'lib_cat' => $catcompte->getLib_cat(),
            'desc_cat' => $catcompte->getDesc_cat(),
			'code_type_compte' => $catcompte->getCode_type_compte()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCategorieCompte $catcompte) {
        $data = array(
            'code_cat' => $catcompte->getCode_cat(),
            'lib_cat' => $catcompte->getLib_cat(),
            'desc_cat' => $catcompte->getDesc_cat(),
			'code_type_compte' => $catcompte->getCode_type_compte()
        );

        $this->getDbTable()->update($data, array('code_cat = ?' => $catcompte->getCode_cat()));
    }

    public function delete($code_cat) {
        $this->getDbTable()->delete(array('code_cat = ?' => $code_cat));
    }



///////////////////////////////////////////////////////////
    public function findByTypeMembre($type_membre) {
           $categoriecompte = new Application_Model_DbTable_EuCategorieCompte();
		   $select = $categoriecompte->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
		          ->join('eu_prix_carte', 'eu_prix_carte.code_cat = eu_categorie_compte.code_cat')
				  ->where("eu_categorie_compte.type_membre LIKE '%".$type_membre."%'")
				  ->order(array('eu_categorie_compte.code_type_compte ASC'));
		   $resultSet = $categoriecompte->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieCompte();
            $entry->setCode_cat($row->code_cat)
                    ->setLib_cat($row->lib_cat)
                    ->setDesc_cat($row->prix_carte)
				    ->setCode_type_compte($row->code_type_compte);
            $entries[] = $entry;
        }
        return $entries;
		    }





    public function findByTypeMembre2($type_membre) {
           $categoriecompte = new Application_Model_DbTable_EuCategorieCompte();
		   $select = $categoriecompte->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
		          //->join('eu_prix_carte', 'eu_prix_carte.code_cat = eu_categorie_compte.code_cat')
				  ->where("eu_categorie_compte.type_membre LIKE '%".$type_membre."%'")
				  ->order(array('eu_categorie_compte.code_type_compte ASC'));
		   $resultSet = $categoriecompte->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieCompte();
            $entry->setCode_cat($row->code_cat)
                    ->setLib_cat($row->lib_cat)
                    //->setDesc_cat($row->prix_carte)
				    ->setCode_type_compte($row->code_type_compte);
            $entries[] = $entry;
        }
        return $entries;
		    }



    public function findByTypeMembre3($type_membre) {
           $categoriecompte = new Application_Model_DbTable_EuCategorieCompte();
		   $select = $categoriecompte->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false);
		          //$select->join('eu_prix_carte', 'eu_prix_carte.code_cat = eu_categorie_compte.code_cat');
			$select->where("eu_categorie_compte.type_membre LIKE '%".$type_membre."%'");
		    $select->where("eu_categorie_compte.code_cat LIKE 'TS%'");
            $select->where("eu_categorie_compte.code_cat NOT LIKE 'TSCI%'");
			$select->order(array('eu_categorie_compte.code_type_compte ASC'));
		   $resultSet = $categoriecompte->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieCompte();
            $entry->setCode_cat($row->code_cat)
                    ->setLib_cat($row->lib_cat)
                    //->setDesc_cat($row->prix_carte)
				    ->setCode_type_compte($row->code_type_compte);
            $entries[] = $entry;
        }
        return $entries;
		    }








}

?>
