<?php
class Application_Model_EuDetailContratLivraisonIrrevocableMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailContratLivraisonIrrevocable');
        }
        return $this->_dbTable;
    }
    public function find($id_detail_contrat, Application_Model_EuDetailContratLivraisonIrrevocable $detail_contrat) {
        $result = $this->getDbTable()->find($id_detail_contrat);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $detail_contrat->setId_detail_contrat($row->id_detail_contrat)
                    ->setId_contrat($row->id_contrat)
                    ->setQuantite($row->quantite)
                    ->setPrix_unitaire($row->prix_unitaire)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setMontant_produit($row->montant_produit)
                    ->setStatut($row->statut);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailContratLivraisonIrrevocable();
            $entry->setId_detail_contrat($row->id_detail_contrat)
                  ->setId_contrat($row->id_contrat)  
                  ->setQuantite($row->quantite)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setMontant_produit($row->montant_produit)
                    ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuDetailContratLivraisonIrrevocable $detail_contrat){
        $data = array(
            'id_detail_contrat' => $detail_contrat->getId_detail_contrat(),
            'id_contrat' => $detail_contrat->getId_contrat(),
            'quantite' => $detail_contrat->getQuantite(),
            'prix_unitaire' => $detail_contrat->getPrix_unitaire(),
            'libelle_produit' => $detail_contrat->getLibelle_produit(),
            'montant_produit' => $detail_contrat->getMontant_produit(),
            'statut' => $detail_contrat->getStatut()
);
        
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailContratLivraisonIrrevocable $detail_contrat) {
        $data = array(
            'id_detail_contrat' => $detail_contrat->getId_detail_contrat(),
            'id_contrat' => $detail_contrat->getId_contrat(),
            'quantite' => $detail_contrat->getQuantite(),
            'prix_unitaire' => $detail_contrat->getPrix_unitaire(),
            'libelle_produit' => $detail_contrat->getLibelle_produit(),
            'montant_produit' => $detail_contrat->getMontant_produit(),
            'statut' => $detail_contrat->getStatut()
        );
        $this->getDbTable()->update($data, array('id_detail_contrat = ?' => $detail_contrat->getId_detail_contrat()));
    }
    
    public function delete($id_detail_contrat) {
        $this->getDbTable()->delete(array('id_detail_contrat = ?' => $id_detail_contrat));
    }
    

     
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_contrat) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }




    public function fetchAllByContrat($id_contrat) {
        $select = $this->getDbTable()->select();
        $select->where("id_contrat = ? ", $id_contrat);
        $select->order("id_detail_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailContratLivraisonIrrevocable();
            $entry->setId_detail_contrat($row->id_detail_contrat)
                  ->setId_contrat($row->id_contrat)  
                  ->setQuantite($row->quantite)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setMontant_produit($row->montant_produit)
                    ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByContrat1($id_contrat) {
        $select = $this->getDbTable()->select();
        $select->where("id_contrat = ? ", $id_contrat);
        $select->where("statut = ? ", 1);
        $select->order("id_detail_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailContratLivraisonIrrevocable();
            $entry->setId_detail_contrat($row->id_detail_contrat)
                  ->setId_contrat($row->id_contrat)  
                  ->setQuantite($row->quantite)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setLibelle_produit($row->libelle_produit)
                    ->setMontant_produit($row->montant_produit)
                    ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByContratCumul($id_contrat) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_produit) as count'));
        $select->where("id_contrat = ? ", $id_contrat);
        $select->where("statut = ? ", 1);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
