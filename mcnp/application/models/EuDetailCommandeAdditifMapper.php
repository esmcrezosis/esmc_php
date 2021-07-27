<?php

class Application_Model_EuDetailCommandeAdditifMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailCommandeAdditif');
        }
        return $this->_dbTable;
    }

    public function find($id_detail_commande_additif, Application_Model_EuDetailCommandeAdditif $detail_commande_additif) {
        $result = $this->getDbTable()->find($id_detail_commande_additif);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $detail_commande_additif->setId_detail_commande_additif($row->id_detail_commande_additif)
                ->setId_detail_commande($row->id_detail_commande)
                ->setReference_additif($row->reference_additif)
                ->setId_article_stockes_additif($row->id_article_stockes_additif)
				;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommandeAdditif();
            $entry->setId_detail_commande_additif($row->id_detail_commande_additif)
                ->setId_detail_commande($row->id_detail_commande)
	                ->setReference_additif($row->reference_additif)
                    ->setId_article_stockes_additif($row->id_article_stockes_additif)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_commande_additif) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDetailCommandeAdditif $detail_commande_additif) {
        $data = array(
            'id_detail_commande_additif' => $detail_commande_additif->getId_detail_commande_additif(),
            'id_detail_commande' => $detail_commande_additif->getId_detail_commande(),
            'reference_additif' => $detail_commande_additif->getReference_additif(),
            'id_article_stockes_additif' => $detail_commande_additif->getId_article_stockes_additif()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailCommandeAdditif $detail_commande_additif) {
        $data = array(
            'id_detail_commande_additif' => $detail_commande_additif->getId_detail_commande_additif(),
            'id_detail_commande' => $detail_commande_additif->getId_detail_commande(),
            'reference_additif' => $detail_commande_additif->getReference_additif(),
            'id_article_stockes_additif' => $detail_commande_additif->getId_article_stockes_additif()
        );
        $this->getDbTable()->update($data, array('id_detail_commande_additif = ?' => $detail_commande_additif->getId_detail_commande_additif()));
    }

    public function delete($id_detail_commande_additif) {
        $this->getDbTable()->delete(array('id_detail_commande_additif = ?' => $id_detail_commande_additif));
    }


    public function fetchAllByDetailCommande($id_detail_commande = 0) {
        $select = $this->getDbTable()->select();
        if($id_detail_commande != 0){
		$select->where("id_detail_commande LIKE '".$id_detail_commande."' ");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommandeAdditif();
            $entry->setId_detail_commande_additif($row->id_detail_commande_additif)
                ->setId_detail_commande($row->id_detail_commande)
	                ->setReference_additif($row->reference_additif)
	                ->setId_article_stockes_additif($row->id_article_stockes_additif)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	




}


?>
