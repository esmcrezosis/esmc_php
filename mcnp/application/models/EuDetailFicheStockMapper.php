<?php
class Application_Model_EuDetailFicheStock {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailFicheStock');
        }
        return $this->_dbTable;
    }
    public function find($id_detail_fiche_stock, Application_Model_EuDetailFicheStock $detail_fiche_stock) {
        $result = $this->getDbTable()->find($id_detail_fiche_stock);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $detail_fiche_stock->setId_detail_fiche_stock($row->id_detail_fiche_stock)
                    ->setDate_article($row->date_article)
	                ->setReference_article_fiche_stock($row->reference_article_fiche_stock)
	                ->setEntree_qte_article($row->entree_qte_article)
	                ->setId_fiche_stock($row->id_fiche_stock)
	                ->setEntree_prix_unitaire($row->entree_prix_unitaire)
	                ->setEntree_valeur($row->entree_valeur)
	                ->setSortie_qte_article($row->sortie_qte_article)
	                ->setSortie_prix_unitaire($row->sortie_prix_unitaire)
	                ->setSortie_valeur($row->sortie_valeur)
	                ->setStocks_qte_article($row->stocks_qte_article)
	                ->setStocks_prix_unitaire($row->stocks_prix_unitaire)
	                ->setStocks_valeur($row->stocks_valeur)
           ->setEtat($row->etat)
                    ;    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailFicheStock();
            $entry->setId_detail_fiche_stock($row->id_detail_fiche_stock)
                    ->setDate_article($row->date_article)
	                ->setReference_article_fiche_stock($row->reference_article_fiche_stock)
	                ->setEntree_qte_article($row->entree_qte_article)
	                ->setId_fiche_stock($row->id_fiche_stock)
	                ->setEntree_prix_unitaire($row->entree_prix_unitaire)
	                ->setEntree_valeur($row->entree_valeur)
	                ->setSortie_qte_article($row->sortie_qte_article)
	                ->setSortie_prix_unitaire($row->sortie_prix_unitaire)
	                ->setSortie_valeur($row->sortie_valeur)
	                ->setStocks_qte_article($row->stocks_qte_article)
	                ->setStocks_prix_unitaire($row->stocks_prix_unitaire)
	                ->setStocks_valeur($row->stocks_valeur)
           ->setEtat($row->etat)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuDetailFicheStock $detail_fiche_stock){
        $data = array(
			'id_detail_fiche_stock' => $detail_fiche_stock->getId_detail_fiche_stock(),
	        'date_article' => $detail_fiche_stock->getDate_article(),
			'reference_article_fiche_stock' => $detail_fiche_stock->getReference_article_fiche_stock(),
			'entree_qte_article' => $detail_fiche_stock->getEntree_qte_article(),
			'id_fiche_stock' => $detail_fiche_stock->getId_fiche_stock(),
			'entree_prix_unitaire' => $detail_fiche_stock->getEntree_prix_unitaire(),
			'entree_valeur' => $detail_fiche_stock->getEntree_valeur(),
			'sortie_qte_article' => $detail_fiche_stock->getSortie_qte_article(),
			'sortie_prix_unitaire' => $detail_fiche_stock->getSortie_prix_unitaire(),
			'sortie_valeur' => $detail_fiche_stock->getSortie_valeur(),
			'stocks_qte_article' => $detail_fiche_stock->getStocks_qte_article(),
			'stocks_prix_unitaire' => $detail_fiche_stock->getStocks_prix_unitaire(),
			'stocks_valeur' => $detail_fiche_stock->getStocks_valeur(),
            'etat' => $detail_fiche_stock->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailFicheStock $detail_fiche_stock) {
        $data = array(
			'id_detail_fiche_stock' => $detail_fiche_stock->getId_detail_fiche_stock(),
	        'date_article' => $detail_fiche_stock->getDate_article(),
			'reference_article_fiche_stock' => $detail_fiche_stock->getReference_article_fiche_stock(),
			'entree_qte_article' => $detail_fiche_stock->getEntree_qte_article(),
			'id_fiche_stock' => $detail_fiche_stock->getId_fiche_stock(),
			'entree_prix_unitaire' => $detail_fiche_stock->getEntree_prix_unitaire(),
			'entree_valeur' => $detail_fiche_stock->getEntree_valeur(),
			'sortie_qte_article' => $detail_fiche_stock->getSortie_qte_article(),
			'sortie_prix_unitaire' => $detail_fiche_stock->getSortie_prix_unitaire(),
			'sortie_valeur' => $detail_fiche_stock->getSortie_valeur(),
			'stocks_qte_article' => $detail_fiche_stock->getStocks_qte_article(),
			'stocks_prix_unitaire' => $detail_fiche_stock->getStocks_prix_unitaire(),
			'stocks_valeur' => $detail_fiche_stock->getStocks_valeur(),
            'etat' => $detail_fiche_stock->getEtat()
        );
        $this->getDbTable()->update($data, array('id_detail_fiche_stock = ?' => $detail_fiche_stock->getId_detail_fiche_stock()));
    }
    
    public function delete($id_detail_fiche_stock,$id_detail_fiche_stock) {
        $this->getDbTable()->delete(array('id_detail_fiche_stock = ?' => $id_detail_fiche_stock));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_fiche_stock) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>