
<?php

class Application_Model_EuDepotVenteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDepotVente');
        }
        return $this->_dbTable;
    }
	
	
	
	public function find($id_depot, Application_Model_EuDepotVente $dvente) {
        $result = $this->getDbTable()->find($id_depot);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $dvente->setId_depot($row->id_depot)
               ->setdate_depot($row->date_depot)
			   ->setCode_membre($row->code_membre)
			   ->setCode_produit($row->code_produit)
			   ->setMont_depot($row->mont_depot)
			   ->setMont_vendu($row->mont_vendu)
			   ->setSolde_depot($row->solde_depot)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setType_depot($row->type_depot)
			   ->setSouscription_id($row->souscription_id);
		return true;
	}
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDepotVente();
            $entry->setId_depot($row->id_depot)
                  ->setdate_depot($row->date_depot)
			      ->setCode_membre($row->code_membre)
			      ->setCode_produit($row->code_produit)
			      ->setMont_depot($row->mont_depot)
			      ->setMont_vendu($row->mont_vendu)
			      ->setSolde_depot($row->solde_depot)
			      ->setId_utilisateur($row->id_utilisateur)
				  ->setType_depot($row->type_depot)
				  ->setSouscription_id($row->souscription_id);
           $entries[] = $entry;
        }
        return $entries;
    }
	
	
    
	public function fetchAllByMembre($membre) {
	       $tabela = new Application_Model_DbTable_EuDepotVente();
	       $select = $tabela->select();
		   $select->where('code_membre = ?',$membre);
		   
		   $result = $tabela->fetchAll($select);
           if (count($result) == 0) {
              return NULL;
           }
		   $entries = array();
           foreach ($result as $row) {
              $entry = new Application_Model_EuDepotVente();
              $entry->setId_depot($row->id_depot)
                    ->setDate_depot($row->date_depot)
			        ->setCode_membre($row->code_membre)
			        ->setCode_produit($row->code_produit)
			        ->setMont_depot($row->mont_depot)
			        ->setMont_vendu($row->mont_vendu)
			        ->setSolde_depot($row->solde_depot)
			        ->setId_utilisateur($row->id_utilisateur)
				    ->setType_depot($row->type_depot)
				    ->setSouscription_id($row->souscription_id);
			  $entries[] = $entry;
	
	       }
		   return $entries;
	}
	
	
	public function CumulCM($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_depot) as somme'));
        $select->where('code_membre = ?',$membre);    
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }
    }
	
	
	
	public function findbycmfh($membre) {
	        $tabela = new Application_Model_DbTable_EuDepotVente();
	        $select = $tabela->select();
		    $select->where('code_membre = ?',$membre);
			$select->where('solde_depot > ?',0);
	        $result = $tabela->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            }
            $entries = array();
            foreach ($result as $row) {
            $entry = new Application_Model_EuDepotVente();
            $entry->setId_depot($row->id_depot)
                  ->setDate_depot($row->date_depot)
			      ->setCode_membre($row->code_membre)
			      ->setCode_produit($row->code_produit)
			      ->setMont_depot($row->mont_depot)
			      ->setMont_vendu($row->mont_vendu)
			      ->setSolde_depot($row->solde_depot)
			      ->setId_utilisateur($row->id_utilisateur)
				  ->setType_depot($row->type_depot)
				  ->setSouscription_id($row->souscription_id);
			$entries[] = $entry;
        }
        return $entries;
	}
	
	public function fetchAllCmfhAvecListe($apporteur)  {
	    $tabela = new Application_Model_DbTable_EuDepotVente();
	    $select = $tabela->select();
	    $select->where('solde_depot >= ?',70000);
            $select->where('code_membre like ?',$apporteur);
	    $select->order('date_depot asc');
	   
	    $result = $tabela->fetchAll($select);
            if(count($result) == 0) {
               return NULL;
            }

	    $entries = array();
            foreach($result as $row) {
                $entry = new Application_Model_EuDepotVente();
                $entry->setId_depot($row->id_depot)
                      ->setDate_depot($row->date_depot)
		      ->setCode_membre($row->code_membre)
		      ->setCode_produit($row->code_produit)
		      ->setMont_depot($row->mont_depot)
		      ->setMont_vendu($row->mont_vendu)
		      ->setSolde_depot($row->solde_depot)
		      ->setId_utilisateur($row->id_utilisateur)
		      ->setType_depot($row->type_depot)
		      ->setSouscription_id($row->souscription_id);
	        $entries[] = $entry;
            }
            return $entries;
         }
        

        public function fetchAllCmfhSansListe()  {
	    $tabela = new Application_Model_DbTable_EuDepotVente();
	    $select = $tabela->select();
	    $select->where('solde_depot >= ?',70000);
            $select->where('(code_membre <> ?',"");
	    $select->where('code_membre is not null)');

	    //$select->where('code_membre is not null');
	    $select->order('date_depot asc');
	   
	    $result = $tabela->fetchAll($select);
        if(count($result) == 0) {
            return NULL;
        }
	    $entries = array();
        foreach($result as $row) {
            $entry = new Application_Model_EuDepotVente();
            $entry->setId_depot($row->id_depot)
                  ->setDate_depot($row->date_depot)
		          ->setCode_membre($row->code_membre)
		          ->setCode_produit($row->code_produit)
		          ->setMont_depot($row->mont_depot)
		          ->setMont_vendu($row->mont_vendu)
		          ->setSolde_depot($row->solde_depot)
		          ->setId_utilisateur($row->id_utilisateur)
		          ->setType_depot($row->type_depot)
		          ->setSouscription_id($row->souscription_id);
	        $entries[] = $entry;
        }
        return $entries;
    }


	
	public function findbycmfhsansliste() {
	        $tabela = new Application_Model_DbTable_EuDepotVente();
	        $select = $tabela->select();
		    $select->where('type_depot like ?','SansListe');
			$select->where('solde_depot >= ?',70000);
			$select->order('id_depot asc');
			
	        $result = $tabela->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            }
            $entries = array();
            foreach ($result as $row) {
            $entry = new Application_Model_EuDepotVente();
            $entry->setId_depot($row->id_depot)
                  ->setDate_depot($row->date_depot)
			      ->setCode_membre($row->code_membre)
			      ->setCode_produit($row->code_produit)
			      ->setMont_depot($row->mont_depot)
			      ->setMont_vendu($row->mont_vendu)
			      ->setSolde_depot($row->solde_depot)
			      ->setId_utilisateur($row->id_utilisateur)
				  ->setType_depot($row->type_depot)
				  ->setSouscription_id($row->souscription_id);
			$entries[] = $entry;
            }
            return $entries;
	}
	
	public function findbysouscription($id_souscription) {
	        $tabela = new Application_Model_DbTable_EuDepotVente();
	        $select = $tabela->select();
		    $select->where('souscription_id like ?',$id_souscription);
			$select->where('type_depot like ?','AvecListe');
			$select->where('solde_depot >= ?',70000);
	        $result = $tabela->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            }
			$row = $result->current();
            $entry = new Application_Model_EuDepotVente();
            $entry->setId_depot($row->id_depot)
                  ->setDate_depot($row->date_depot)
			      ->setCode_membre($row->code_membre)
			      ->setCode_produit($row->code_produit)
			      ->setMont_depot($row->mont_depot)
			      ->setMont_vendu($row->mont_vendu)
			      ->setSolde_depot($row->solde_depot)
			      ->setId_utilisateur($row->id_utilisateur)
				  ->setType_depot($row->type_depot)
				  ->setSouscription_id($row->souscription_id);
            return $entry;
	}
	
	public function findbysouscriptionmembre($id_souscription) {
	        $tabela = new Application_Model_DbTable_EuDepotVente();
	        $select = $tabela->select();
		    $select->where('souscription_id like ?',$id_souscription);
	        $result = $tabela->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            }
			$row = $result->current();
            $entry = new Application_Model_EuDepotVente();
            $entry->setId_depot($row->id_depot)
                  ->setDate_depot($row->date_depot)
			      ->setCode_membre($row->code_membre)
			      ->setCode_produit($row->code_produit)
			      ->setMont_depot($row->mont_depot)
			      ->setMont_vendu($row->mont_vendu)
			      ->setSolde_depot($row->solde_depot)
			      ->setId_utilisateur($row->id_utilisateur)
				  ->setType_depot($row->type_depot)
				  ->setSouscription_id($row->souscription_id);
            return $entry;
	}
	
	
	
	
	
	
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_depot) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
    public function save(Application_Model_EuDepotVente $dvente) {
        $data = array(
         'id_depot' => $dvente->getId_depot(),
         'date_depot' => $dvente->getDate_depot(),
		 'code_membre' => $dvente->getCode_membre(),
		 'code_produit' => $dvente->getCode_produit(),
		 'mont_depot' => $dvente->getMont_depot(),
		 'mont_vendu' => $dvente->getMont_vendu(),
		 'solde_depot' => $dvente->getSolde_depot(),
		 'id_utilisateur' => $dvente->getId_utilisateur(),
		 'type_depot' => $dvente->getType_depot(),
		 'souscription_id' => $dvente->getSouscription_id()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDepotVente $dvente) {
        $data = array(
          'id_depot' => $dvente->getId_depot(),
          'date_depot' => $dvente->getDate_depot(),
		  'code_membre' => $dvente->getCode_membre(),
		  'code_produit' => $dvente->getCode_produit(),
		  'mont_depot' => $dvente->getMont_depot(),
		  'mont_vendu' => $dvente->getMont_vendu(),
		  'solde_depot' => $dvente->getSolde_depot(),
		  'id_utilisateur' => $dvente->getId_utilisateur(),
		  'type_depot' => $dvente->getType_depot(),
		  'souscription_id' => $dvente->getSouscription_id()
        );
        $this->getDbTable()->update($data, array('id_depot = ?' => $dvente->getId_depot()));
    }

	
    public function delete($id_depot) {
        $this->getDbTable()->delete(array('id_depot = ?' => $id_depot));   
    }



  public function CumulResteCMFH($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_depot) as somme'));
        $select->where('code_membre = ?',$membre);
	$select->where('solde_depot > ?',0);    
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }
  }


		
}		
?>	
	
	
	
	
	
	
	
	
	