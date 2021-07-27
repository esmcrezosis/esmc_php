<?php

class Application_Model_EuArticleStockesAdditifMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuArticleStockesAdditif');
        }
        return $this->_dbTable;
    }

    public function find($id_article_stockes_additif, Application_Model_EuArticleStockesAdditif $article_stockes_additif) {
        $result = $this->getDbTable()->find($id_article_stockes_additif);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $article_stockes_additif->setId_article_stockes_additif($row->id_article_stockes_additif)
                ->setNom_article_stockes_additif($row->nom_article_stockes_additif)
                ->setReference($row->reference)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setEtat($row->etat)
				;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockesAdditif();
            $entry->setId_article_stockes_additif($row->id_article_stockes_additif)
                ->setNom_article_stockes_additif($row->nom_article_stockes_additif)
	                ->setReference($row->reference)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setEtat($row->etat)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_article_stockes_additif) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuArticleStockesAdditif $article_stockes_additif) {
        $data = array(
            'id_article_stockes_additif' => $article_stockes_additif->getId_article_stockes_additif(),
            'nom_article_stockes_additif' => $article_stockes_additif->getNom_article_stockes_additif(),
            'reference' => $article_stockes_additif->getReference(),
            'code_membre_morale' => $article_stockes_additif->getCode_membre_morale(),
            'etat' => $article_stockes_additif->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuArticleStockesAdditif $article_stockes_additif) {
        $data = array(
            'id_article_stockes_additif' => $article_stockes_additif->getId_article_stockes_additif(),
            'nom_article_stockes_additif' => $article_stockes_additif->getNom_article_stockes_additif(),
            'reference' => $article_stockes_additif->getReference(),
            'code_membre_morale' => $article_stockes_additif->getCode_membre_morale(),
            'etat' => $article_stockes_additif->getEtat()
        );
        $this->getDbTable()->update($data, array('id_article_stockes_additif = ?' => $article_stockes_additif->getId_article_stockes_additif()));
    }

    public function delete($id_article_stockes_additif) {
        $this->getDbTable()->delete(array('id_article_stockes_additif = ?' => $id_article_stockes_additif));
    }


    public function fetchAllByCodeMembreMoraleReference($code_membre_morale = "", $reference = "", $etat = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_morale != ""){
		$select->where("code_membre_morale LIKE '".$code_membre_morale."' ");
        }
        if($reference != ""){
        $select->where("reference LIKE '".$reference."' ");
        }
        if($etat != ""){
        $select->where("etat = ? ", $etat);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockesAdditif();
            $entry->setId_article_stockes_additif($row->id_article_stockes_additif)
                ->setNom_article_stockes_additif($row->nom_article_stockes_additif)
	                ->setReference($row->reference)
	                ->setCode_membre_morale($row->code_membre_morale)
                    ->setEtat($row->etat)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	




}


?>
