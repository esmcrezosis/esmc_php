 <?php

class Application_Model_EuProduitFournisseurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProduitFournisseur');
        }
        return $this->_dbTable;
    }

    public function find($id_produit_fournisseur, Application_Model_EuProduitFournisseur $produit) {
       $result = $this->getDbTable()->find($id_produit_fournisseur);
       if(count($result) == 0) {
          return false;
       }
       $row = $result->current();
       $produit->setId_produit_fournisseur($row->id_produit_fournisseur)
               ->setLibelle_produit_fournisseur($row->libelle_produit_fournisseur)
               ->setDesc_produit_fournisseur($row->desc_produit_fournisseur)
               ->setCode_membre_fournisseur($row->code_membre_fournisseur)
               ->setCode_tegc($row->code_tegc)
			   ->setDate_creation($row->date_creation)
               ->setActiver($row->activer);   
	   return true;
	}
	
	
	public function findByFournisseur($code_membre) {
	   $select = $this->getDbTable()->select();
       $select->where('code_membre_fournisseur like ?', $code_membre);
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	      $entry = new Application_Model_EuProduitFournisseur();
          $entry->setId_produit_fournisseur($row->id_produit_fournisseur)
               ->setLibelle_produit_fournisseur($row->libelle_produit_fournisseur)
               ->setDesc_produit_fournisseur($row->desc_produit_fournisseur)
               ->setCode_membre_fournisseur($row->code_membre_fournisseur)
               ->setCode_tegc($row->code_tegc)
			   ->setDate_creation($row->date_creation)
               ->setActiver($row->activer); 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	
	
	public function findByFournisseurActiver($code_membre) {
	   $select = $this->getDbTable()->select();
       $select->where('code_membre_fournisseur like ?', $code_membre);
	   $select->where('activer = ?', 1);
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	      $entry = new Application_Model_EuProduitFournisseur();
          $entry->setId_produit_fournisseur($row->id_produit_fournisseur)
                ->setLibelle_produit_fournisseur($row->libelle_produit_fournisseur)
                ->setDesc_produit_fournisseur($row->desc_produit_fournisseur)
                ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                ->setCode_tegc($row->code_tegc)
			    ->setDate_creation($row->date_creation)
                ->setActiver($row->activer); 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	
	
	
	
	public function findByTegc($code_tegc) {
	   $select = $this->getDbTable()->select();
       $select->where('code_tegc like ?', $code_tegc);
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	      $entry = new Application_Model_EuProduitFournisseur();
          $entry->setId_produit_fournisseur($row->id_produit_fournisseur)
               ->setLibelle_produit_fournisseur($row->libelle_produit_fournisseur)
               ->setDesc_produit_fournisseur($row->desc_produit_fournisseur)
               ->setCode_membre_fournisseur($row->code_membre_fournisseur)
               ->setCode_tegc($row->code_tegc)
			   ->setDate_creation($row->date_creation)
               ->setActiver($row->activer); 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	
	
	public function findByTegcActiver($code_tegc) {
	   $select = $this->getDbTable()->select();
       $select->where('code_tegc like ?', $code_tegc);
	   $select->where('activer = ?',1);
       $resultSet = $this->getDbTable()->fetchAll($select);
	   $entries = array();
	   foreach($resultSet as $row) {
	      $entry = new Application_Model_EuProduitFournisseur();
          $entry->setId_produit_fournisseur($row->id_produit_fournisseur)
               ->setLibelle_produit_fournisseur($row->libelle_produit_fournisseur)
               ->setDesc_produit_fournisseur($row->desc_produit_fournisseur)
               ->setCode_membre_fournisseur($row->code_membre_fournisseur)
               ->setCode_tegc($row->code_tegc)
			   ->setDate_creation($row->date_creation)
               ->setActiver($row->activer); 
		  $entries[] = $entry;	
	   }
	   return $entries;
	}
	
	
	public function fetchAll()  {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
          $entry = new Application_Model_EuProduitFournisseur();
          $entry->setId_produit_fournisseur($row->id_produit_fournisseur)
                ->setLibelle_produit_fournisseur($row->libelle_produit_fournisseur)
                ->setDesc_produit_fournisseur($row->desc_produit_fournisseur)
                ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                ->setCode_tegc($row->code_tegc)
				->setDate_creation($row->date_creation)
                ->setActiver($row->activer);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function save(Application_Model_EuProduitFournisseur $produit) {
      $data = array(
	    'id_produit_fournisseur' => $produit->getId_produit_fournisseur(),
        'libelle_produit_fournisseur' => $produit->getLibelle_produit_fournisseur(),
        'desc_produit_fournisseur' => $produit->getDesc_produit_fournisseur(),
        'code_membre_fournisseur' => $produit->getCode_membre_fournisseur(),
        'code_tegc' => $produit->getCode_tegc(),
		'date_creation' => $produit->getDate_creation(),
        'activer' => $produit->getActiver()
      );
      $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuProduitFournisseur $produit) {
        $data = array(
          'id_produit_fournisseur' => $produit->getId_produit_fournisseur(),
          'libelle_produit_fournisseur' => $produit->getLibelle_produit_fournisseur(),
          'desc_produit_fournisseur' => $produit->getDesc_produit_fournisseur(),
          'code_membre_fournisseur' => $produit->getCode_membre_fournisseur(),
          'code_tegc' => $produit->getCode_tegc(),
		  'date_creation' => $produit->getDate_creation(),
          'activer' => $produit->getActiver()
        );
        $this->getDbTable()->update($data, array('id_produit_fournisseur = ?' => $produit->getId_produit_fournisseur()));
    }
	

    public function delete($id_produit_fournisseur) {
      $this->getDbTable()->delete(array('id_produit_fournisseur = ?' => $id_produit_fournisseur));
    }

    ///////////////////////////////////////////////////////////////

}

?>
