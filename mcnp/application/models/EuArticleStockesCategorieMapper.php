<?php

class Application_Model_EuArticleStockesCategorieMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuArticleStockesCategorie');
        }
        return $this->_dbTable;
    }

    public function find($id_article_stockes_categorie, Application_Model_EuArticleStockesCategorie $article_stockes_categorie) {
        $result = $this->getDbTable()->find($id_article_stockes_categorie);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $article_stockes_categorie->setId_article_stockes_categorie($row->id_article_stockes_categorie)
                ->setNom_article_stockes_categorie($row->nom_article_stockes_categorie)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setEtat($row->etat)
				->setCode_tegc($row->code_tegc);
    }
	
	
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockesCategorie();
            $entry->setId_article_stockes_categorie($row->id_article_stockes_categorie)
                  ->setNom_article_stockes_categorie($row->nom_article_stockes_categorie)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setEtat($row->etat)
				  ->setCode_tegc($row->code_tegc)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_article_stockes_categorie) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuArticleStockesCategorie $article_stockes_categorie) {
        $data = array(
            'id_article_stockes_categorie' => $article_stockes_categorie->getId_article_stockes_categorie(),
            'nom_article_stockes_categorie' => $article_stockes_categorie->getNom_article_stockes_categorie(),
            'code_membre_morale' => $article_stockes_categorie->getCode_membre_morale(),
			'code_tegc' => $article_stockes_categorie->getCode_tegc(),
            'etat' => $article_stockes_categorie->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuArticleStockesCategorie $article_stockes_categorie) {
        $data = array(
            'id_article_stockes_categorie' => $article_stockes_categorie->getId_article_stockes_categorie(),
            'nom_article_stockes_categorie' => $article_stockes_categorie->getNom_article_stockes_categorie(),
            'code_membre_morale' => $article_stockes_categorie->getCode_membre_morale(),
			'code_tegc' => $article_stockes_categorie->getCode_tegc(),
            'etat' => $article_stockes_categorie->getEtat()
        );
        $this->getDbTable()->update($data, array('id_article_stockes_categorie = ?' => $article_stockes_categorie->getId_article_stockes_categorie()));
    }

    public function delete($id_article_stockes_categorie) {
        $this->getDbTable()->delete(array('id_article_stockes_categorie = ?' => $id_article_stockes_categorie));
    }


    public function fetchAllByCodeMembreMorale($code_membre_morale = "", $etat = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_morale != ""){
		$select->where("code_membre_morale LIKE '".$code_membre_morale."' ");
        }
        if($etat != ""){
        $select->where("etat = ? ", $etat);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockesCategorie();
            $entry->setId_article_stockes_categorie($row->id_article_stockes_categorie)
                ->setNom_article_stockes_categorie($row->nom_article_stockes_categorie)
	                ->setCode_membre_morale($row->code_membre_morale)
                    ->setEtat($row->etat)
					->setCode_tegc($row->code_tegc)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function fetchAllByTegc($code_tegc = "", $etat = "")  {
        $select = $this->getDbTable()->select();
        if($code_tegc != "") {
		   $select->where("code_tegc LIKE '".$code_tegc."' ");
        }
        if($etat != "") {
           $select->where("etat = ? ", $etat);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuArticleStockesCategorie();
           $entry->setId_article_stockes_categorie($row->id_article_stockes_categorie)
                 ->setNom_article_stockes_categorie($row->nom_article_stockes_categorie)
	             ->setCode_membre_morale($row->code_membre_morale)
                 ->setEtat($row->etat)
				 ->setCode_tegc($row->code_tegc);
           $entries[] = $entry;
        }
        return $entries;
    }


}


?>
