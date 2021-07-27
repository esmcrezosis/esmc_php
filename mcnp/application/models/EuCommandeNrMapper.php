<?php
 
class Application_Model_EuCommandeNrMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCommandeNr');
        }
        return $this->_dbTable;
    }

    public function find($id_commande_nr, Application_Model_EuCommandeNr $commande_nr) {
        $result = $this->getDbTable()->find($id_commande_nr);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $commande_nr->setId_commande_nr($row->id_commande_nr)
                ->setCode_membre($row->code_membre)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setProduit($row->produit)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setTotal_bps($row->total_bps)
                ->setTotal_nr($row->total_nr)
                ->setDate_commande_nr($row->date_commande_nr)
                ->setDate_livraison_estimer($row->date_livraison_estimer)
                ->setActif($row->actif)
                ->setPrk($row->prk)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("id_commande_nr DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommandeNr();
            $entry->setId_commande_nr($row->id_commande_nr)
	              ->setCode_membre($row->code_membre)
                  ->setPrix_unitaire($row->prix_unitaire)
                  ->setProduit($row->produit)
	              ->setDesignation($row->designation)
				  ->setQuantite($row->quantite)
				  ->setTotal_bps($row->total_bps)
                  ->setTotal_nr($row->total_nr)
                  ->setDate_commande_nr($row->date_commande_nr)
                  ->setDate_livraison_estimer($row->date_livraison_estimer)
                  ->setActif($row->actif)
                  ->setPrk($row->prk)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_commande_nr) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCommandeNr $commande_nr) {
        $data = array(
            'id_commande_nr' => $commande_nr->getId_commande_nr(),
            'code_membre' => $commande_nr->getCode_membre(),
            'prix_unitaire' => $commande_nr->getPrix_unitaire(),
            'produit' => $commande_nr->getProduit(),
            'designation' => $commande_nr->getDesignation(),
            'quantite' => $commande_nr->getQuantite(),
            'total_bps' => $commande_nr->getTotal_bps(),
            'total_nr' => $commande_nr->getTotal_nr(),
            'date_commande_nr' => $commande_nr->getDate_commande_nr(),
            'date_livraison_estimer' => $commande_nr->getDate_livraison_estimer(),
            'actif' => $commande_nr->getActif(),
            'prk' => $commande_nr->getPrk()
        );
        
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCommandeNr $commande_nr) {
        $data = array(
            'id_commande_nr' => $commande_nr->getId_commande_nr(),
            'code_membre' => $commande_nr->getCode_membre(),
            'prix_unitaire' => $commande_nr->getPrix_unitaire(),
            'produit' => $commande_nr->getProduit(),
            'designation' => $commande_nr->getDesignation(),
            'quantite' => $commande_nr->getQuantite(),
            'total_bps' => $commande_nr->getTotal_bps(),
            'total_nr' => $commande_nr->getTotal_nr(),
            'date_commande_nr' => $commande_nr->getDate_commande_nr(),
            'date_livraison_estimer' => $commande_nr->getDate_livraison_estimer(),
            'actif' => $commande_nr->getActif(),
            'prk' => $commande_nr->getPrk()
        );
        
        $this->getDbTable()->update($data, array('id_commande_nr = ?' => $commande_nr->getId_commande_nr()));
    }

    public function delete($id_commande_nr) {
        $this->getDbTable()->delete(array('id_commande_nr = ?' => $id_commande_nr));
    }


    public function fetchAllByCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
		$select->where("code_membre = ? ", $code_membre);
        }
        //$select->where("actif = ? ", $actif);
        $select->order("id_commande_nr DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommandeNr();
            $entry->setId_commande_nr($row->id_commande_nr)
	              ->setCode_membre($row->code_membre)
                  ->setPrix_unitaire($row->prix_unitaire)
                  ->setProduit($row->produit)
	              ->setDesignation($row->designation)
				  ->setQuantite($row->quantite)
				  ->setTotal_bps($row->total_bps)
                ->setTotal_nr($row->total_nr)
                ->setDate_commande_nr($row->date_commande_nr)
                ->setDate_livraison_estimer($row->date_livraison_estimer)
                ->setActif($row->actif)
                ->setPrk($row->prk)
				;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCodeMembre0($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);
        }
        $select->where("actif = ? ", 0);
        $select->order("id_commande_nr DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommandeNr();
            $entry->setId_commande_nr($row->id_commande_nr)
                  ->setCode_membre($row->code_membre)
                  ->setPrix_unitaire($row->prix_unitaire)
                  ->setProduit($row->produit)
                  ->setDesignation($row->designation)
                  ->setQuantite($row->quantite)
                  ->setTotal_bps($row->total_bps)
                ->setTotal_nr($row->total_nr)
                ->setDate_commande_nr($row->date_commande_nr)
                ->setDate_livraison_estimer($row->date_livraison_estimer)
                ->setActif($row->actif)
                ->setPrk($row->prk)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByCodeMembre1($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);
        }
        $select->where("actif = ? ", 1);
        $select->order("id_commande_nr DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommandeNr();
            $entry->setId_commande_nr($row->id_commande_nr)
                  ->setCode_membre($row->code_membre)
                  ->setPrix_unitaire($row->prix_unitaire)
                  ->setProduit($row->produit)
                  ->setDesignation($row->designation)
                  ->setQuantite($row->quantite)
                  ->setTotal_bps($row->total_bps)
                ->setTotal_nr($row->total_nr)
                ->setDate_commande_nr($row->date_commande_nr)
                ->setDate_livraison_estimer($row->date_livraison_estimer)
                ->setActif($row->actif)
                ->setPrk($row->prk)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
    

}


?>
