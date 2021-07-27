<?php
 
class Application_Model_EuAllocationCmfhMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAllocationCmfh');
        }
        return $this->_dbTable;
    }

    public function find($allocation_cmfh_id, Application_Model_EuAllocationCmfh $allocation_cmfh) {
        $result = $this->getDbTable()->find($allocation_cmfh_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $allocation_cmfh->setAllocation_cmfh_id($row->allocation_cmfh_id)
                        ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                        ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                        ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
                        ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
                        ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                        ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                        ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                        ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                        ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
				        ->setAllocation_cmfh_type($row->allocation_cmfh_type);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("allocation_cmfh_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAllocationCmfh();
            $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
	              ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                  ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                  ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
		          ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
				  ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                  ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                  ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                  ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                  ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
                  ->setAllocation_cmfh_type($row->allocation_cmfh_type);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(allocation_cmfh_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAllocationCmfh $allocation_cmfh) {
        $data = array(
            'allocation_cmfh_id' => $allocation_cmfh->getAllocation_cmfh_id(),
            'allocation_cmfh_code' => $allocation_cmfh->getAllocation_cmfh_code(),
            'allocation_cmfh_code_membre_cmfh' => $allocation_cmfh->getAllocation_cmfh_code_membre_cmfh(),
            'allocation_cmfh_montant_utilise' => $allocation_cmfh->getAllocation_cmfh_montant_utilise(),
            'allocation_cmfh_code_membre_integrageur' => $allocation_cmfh->getAllocation_cmfh_code_membre_integrageur(),
            'allocation_cmfh_date' => $allocation_cmfh->getAllocation_cmfh_date(),
            'allocation_cmfh_nombre' => $allocation_cmfh->getAllocation_cmfh_nombre(),
            'allocation_cmfh_nombre_utilise' => $allocation_cmfh->getAllocation_cmfh_nombre_utilise(),
            'allocation_cmfh_nombre_solde' => $allocation_cmfh->getAllocation_cmfh_nombre_solde(),
            'allocation_cmfh_actif' => $allocation_cmfh->getAllocation_cmfh_actif(),
            'allocation_cmfh_type' => $allocation_cmfh->getAllocation_cmfh_type()
            );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAllocationCmfh $allocation_cmfh) {
        $data = array(
            'allocation_cmfh_id' => $allocation_cmfh->getAllocation_cmfh_id(),
            'allocation_cmfh_code' => $allocation_cmfh->getAllocation_cmfh_code(),
            'allocation_cmfh_code_membre_cmfh' => $allocation_cmfh->getAllocation_cmfh_code_membre_cmfh(),
            'allocation_cmfh_montant_utilise' => $allocation_cmfh->getAllocation_cmfh_montant_utilise(),
            'allocation_cmfh_code_membre_integrageur' => $allocation_cmfh->getAllocation_cmfh_code_membre_integrageur(),
            'allocation_cmfh_date' => $allocation_cmfh->getAllocation_cmfh_date(),
            'allocation_cmfh_nombre' => $allocation_cmfh->getAllocation_cmfh_nombre(),
            'allocation_cmfh_nombre_utilise' => $allocation_cmfh->getAllocation_cmfh_nombre_utilise(),
            'allocation_cmfh_nombre_solde' => $allocation_cmfh->getAllocation_cmfh_nombre_solde(),
            'allocation_cmfh_actif' => $allocation_cmfh->getAllocation_cmfh_actif(),
            'allocation_cmfh_type' => $allocation_cmfh->getAllocation_cmfh_type()
        );
        $this->getDbTable()->update($data, array('allocation_cmfh_id = ?' => $allocation_cmfh->getAllocation_cmfh_id()));
    }

    public function delete($allocation_cmfh_id) {
        $this->getDbTable()->delete(array('allocation_cmfh_id = ?' => $allocation_cmfh_id));
    }


    public function fetchAllByCMFH($allocation_cmfh_code_membre_cmfh) {
        $select = $this->getDbTable()->select();
		$select->where("allocation_cmfh_code_membre_cmfh = ? ", $allocation_cmfh_code_membre_cmfh);
		$select->order("allocation_cmfh_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAllocationCmfh();
            $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
	              ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                  ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                  ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
		          ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
				  ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                  ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                  ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                  ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                  ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
                  ->setAllocation_cmfh_type($row->allocation_cmfh_type);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByIntegrateur($allocation_cmfh_code_membre_integrageur) {
        $select = $this->getDbTable()->select();
		$select->where("allocation_cmfh_code_membre_integrageur = ? ", $allocation_cmfh_code_membre_integrageur);
		$select->order("allocation_cmfh_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAllocationCmfh();
            $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
	              ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                  ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                  ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
		          ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
				  ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                  ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                  ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                  ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                  ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
                  ->setAllocation_cmfh_type($row->allocation_cmfh_type);
            $entries[] = $entry;
        }
        return $entries;
    }


	public function findByCode($allocation_cmfh_code) {
        $select = $this->getDbTable()->select();
		$select->where("allocation_cmfh_code = ? ", $allocation_cmfh_code);
		$select->where("allocation_cmfh_actif = ? ",1);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuAllocationCmfh();
        $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
	          ->setAllocation_cmfh_code($row->allocation_cmfh_code)
              ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
              ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
		      ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
			  ->setAllocation_cmfh_date($row->allocation_cmfh_date)
              ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
              ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
              ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
              ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
              ->setAllocation_cmfh_type($row->allocation_cmfh_type);
		
         return $entry;
    }
    
	
	
    public function fetchAllByCode($allocation_cmfh_code) {
        $select = $this->getDbTable()->select();
		$select->where("allocation_cmfh_code = ? ", $allocation_cmfh_code);
		$select->where("allocation_cmfh_nombre_solde > ?",0);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuAllocationCmfh();
        $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
	          ->setAllocation_cmfh_code($row->allocation_cmfh_code)
              ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
              ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
		      ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
			  ->setAllocation_cmfh_date($row->allocation_cmfh_date)
              ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
              ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
              ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
              ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
              ->setAllocation_cmfh_type($row->allocation_cmfh_type);
		$entries = $entry;
        return $entries;
    }


    public function fetchAllAllocationCmfhAvecListe($code_membre_cmfh)  {
           $select = $this->getDbTable()->select();
	   $select->where("allocation_cmfh_type = ?",'AvecListe');
	   $select->where("allocation_cmfh_nombre_solde > ?",0);
	   $select->where("allocation_cmfh_code_membre_cmfh like ?",$code_membre_cmfh);
	   $select->where("allocation_cmfh_actif = ? ", 1);
	   $result = $this->getDbTable()->fetchAll($select);
		
	   if(count($result) == 0) {
                return false;
           }
		
	   $entries = array();
           foreach($result as $row) {
	        $entry = new Application_Model_EuAllocationCmfh();
                $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
                      ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                      ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                      ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
                      ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
                      ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                      ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                      ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                      ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                      ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
                      ->setAllocation_cmfh_type($row->allocation_cmfh_type);
                $entries[] = $entry;
	    }
	    return $entries;
    }

	
	
    public function fetchAllAllocation() {
	   $select = $this->getDbTable()->select();
           $select->where("allocation_cmfh_type = ?",'SansListe');
	   $select->where("allocation_cmfh_nombre_solde > ?",0);
	   $select->order(array("allocation_cmfh_id ASC"));
           $select->where("allocation_cmfh_actif = ? ", 1);
	   $result = $this->getDbTable()->fetchAll($select);
	   if(count($result) == 0)  {
             return false;
           }
	   $entries = array();
           foreach ($result as $row) {
	      $entry = new Application_Model_EuAllocationCmfh();
              $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
                    ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                    ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                    ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
                    ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
                    ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                    ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                    ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                    ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                    ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
                    ->setAllocation_cmfh_type($row->allocation_cmfh_type);
               $entries[] = $entry;
	    }
	    return $entries;
     }
	
	
	
	public function fetchAllByType($allocation_cmfh_type) {
        $select = $this->getDbTable()->select();
        $select->where("allocation_cmfh_type = ? ", $allocation_cmfh_type);
        $select->order("allocation_cmfh_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAllocationCmfh();
            $entry->setAllocation_cmfh_id($row->allocation_cmfh_id)
                  ->setAllocation_cmfh_code($row->allocation_cmfh_code)
                  ->setAllocation_cmfh_code_membre_cmfh($row->allocation_cmfh_code_membre_cmfh)
                  ->setAllocation_cmfh_montant_utilise($row->allocation_cmfh_montant_utilise)
                  ->setAllocation_cmfh_code_membre_integrageur($row->allocation_cmfh_code_membre_integrageur)
                  ->setAllocation_cmfh_date($row->allocation_cmfh_date)
                  ->setAllocation_cmfh_nombre($row->allocation_cmfh_nombre)
                  ->setAllocation_cmfh_nombre_utilise($row->allocation_cmfh_nombre_utilise)
                  ->setAllocation_cmfh_nombre_solde($row->allocation_cmfh_nombre_solde)
                  ->setAllocation_cmfh_actif($row->allocation_cmfh_actif)
                  ->setAllocation_cmfh_type($row->allocation_cmfh_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
  
  public function CumulNombreCMFH($allocation_cmfh_code_membre_cmfh) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(allocation_cmfh_nombre) as somme'));
        $select->where("allocation_cmfh_code_membre_cmfh = ? ", $allocation_cmfh_code_membre_cmfh);
        $select->where("allocation_cmfh_actif = ? ", 1);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['somme'];
    }

  public function CumulNombreUtiliseCMFH($allocation_cmfh_code_membre_cmfh) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(allocation_cmfh_nombre_utilise) as somme'));
        $select->where("allocation_cmfh_code_membre_cmfh = ? ", $allocation_cmfh_code_membre_cmfh);
        $select->where("allocation_cmfh_actif = ? ", 0);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['somme'];
    }

public function CumulNombreSoldeCMFH($allocation_cmfh_code_membre_cmfh) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(allocation_cmfh_nombre_solde) as somme'));
        $select->where("allocation_cmfh_code_membre_cmfh = ? ", $allocation_cmfh_code_membre_cmfh);
        $select->where("allocation_cmfh_actif = ? ", 1);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['somme'];
    }



  

}


?>
