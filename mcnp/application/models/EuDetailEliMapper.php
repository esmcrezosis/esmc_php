<?php

class Application_Model_EuDetailEliMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailEli');
        }
        return $this->_dbTable;
    }

    public function find($id_detail_eli, Application_Model_EuDetailEli $detaileli) {
       $result = $this->getDbTable()->find($id_detail_eli);
       if(count($result) == 0) {
          return false;
       }
       $row = $result->current();
       $detaileli->setId_detail_eli($row->id_detail_eli)
                 ->setId_eli($row->id_eli)
                 ->setLibelle_produit($row->libelle_produit)
                 ->setMontant_produit($row->montant_produit)
                 ->setQuantite($row->quantite)
                 ->setPrix_unitaire($row->prix_unitaire)
				 ->setQte_vente($row->qte_vente)
                 ->setPrix_vente($row->prix_vente)
                 ->setStatut($row->statut)
				 ->setType_bps($row->type_bps);   
	    return true;
	}
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDetailEli();
            $entry->setId_detail_eli($row->id_detail_eli)
                  ->setId_eli($row->id_eli)
                  ->setLibelle_produit($row->libelle_produit)
                  ->setMontant_produit($row->montant_produit)
                  ->setQuantite($row->quantite)
                  ->setPrix_unitaire($row->prix_unitaire)
				  ->setQte_vente($row->qte_vente)
                  ->setPrix_vente($row->prix_vente)
                  ->setStatut($row->statut)
				  ->setType_bps($row->type_bps);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public  function fetchAllByEli($id_eli)  {
		$select = $this->getDbTable()->select();
	    $select->where("id_eli = ? ", $id_eli);
		$select->where("statut = ? ",1);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuDetailEli();
		   $entry->setId_detail_eli($row->id_detail_eli)
                 ->setId_eli($row->id_eli)
                 ->setLibelle_produit($row->libelle_produit)
                 ->setMontant_produit($row->montant_produit)
                 ->setQuantite($row->quantite)
                 ->setPrix_unitaire($row->prix_unitaire)
				 ->setQte_vente($row->qte_vente)
                 ->setPrix_vente($row->prix_vente)
                 ->setStatut($row->statut)
				 ->setType_bps($row->type_bps);
           $entries[] = $entry;
	    }
		return $entries;
	}

    public function save(Application_Model_EuDetailEli $detaileli) {
        $data = array(
		    'id_detail_eli' => $detaileli->getId_detail_eli(),
			'id_eli' => $detaileli->getId_eli(),
            'libelle_produit' => $detaileli->getLibelle_produit(),
            'montant_produit' => $detaileli->getMontant_produit(),
            'quantite' => $detaileli->getQuantite(),
            'prix_unitaire' => $detaileli->getPrix_unitaire(),
			'qte_vente' => $detaileli->getQte_vente(),
            'prix_vente' => $detaileli->getPrix_vente(),
		    'statut' => $detaileli->getStatut(),
			'type_bps' => $detaileli->getType_bps()
        );
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuDetailEli $detaileli) {
        $data = array(
          'id_detail_eli' => $detaileli->getId_detail_eli(),
		  'id_eli' => $detaileli->getId_eli(),
          'libelle_produit' => $detaileli->getLibelle_produit(),
          'montant_produit' => $detaileli->getMontant_produit(),
          'quantite' => $detaileli->getQuantite(),
          'prix_unitaire' => $detaileli->getPrix_unitaire(),
		  'qte_vente' => $detaileli->getQte_vente(),
          'prix_vente' => $detaileli->getPrix_vente(),
		  'statut' => $detaileli->getStatut(),
		  'type_bps' => $detaileli->getType_bps()
        );
        $this->getDbTable()->update($data, array('id_detail_eli = ?' => $detaileli->getId_detail_eli()));
    }
	

    public function delete($id_detail_eli) {
        $this->getDbTable()->delete(array('id_detail_eli = ?' => $id_detail_eli));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_eli) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
