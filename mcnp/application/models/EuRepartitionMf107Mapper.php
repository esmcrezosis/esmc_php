<?php
     
 class Application_Model_EuRepartitionMf107Mapper {
        
     
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
            $this->setDbTable('Application_Model_DbTable_EuRepartitionMf107');
        }
        return $this->_dbTable;
    }
    
	
    public function save(Application_Model_EuRepartitionMf107 $rep) {
        $data = array(
          'id_rep' => $rep->getId_rep(),
          'id_mf107' => $rep->getId_mf107(),
          'code_membre' => $rep->getCode_membre(),
          'date_rep' => $rep->getDate_rep(),
          'mont_rep' => $rep->getMont_rep(),
          'mont_reglt' => $rep->getMont_reglt(),
		  'solde_rep' => $rep->getSolde_rep(),
          'payer' => $rep->getPayer(), 
          'id_utilisateur' => $rep->getId_utilisateur()  
        );
        $this->getDbTable()->insert($data);
    }
    
	
    public function update(Application_Model_EuRepartitionMf107 $rep) {
        $data = array(
             'id_rep' => $rep->getId_rep(),
             'id_mf107' => $rep->getId_mf107(),
             'code_membre' => $rep->getCode_membre(),
             'date_rep' => $rep->getDate_rep(),
             'mont_rep' => $rep->getMont_rep(),
             'mont_reglt' => $rep->getMont_reglt(),
		     'solde_rep' => $rep->getSolde_rep(),
             'payer' => $rep->getPayer(),
             'id_utilisateur' => $rep->getId_utilisateur()
        );

        $this->getDbTable()->update($data, array('id_rep = ?' => $rep->getId_rep()));
    }
    
    
	
    public function find($id_rep,  Application_Model_EuRepartitionMf107 $rep) {
        $result = $this->getDbTable()->find($id_rep);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $rep->setId_rep($row->id_rep)
            ->setId_mf107($row->id_mf107)
            ->setCode_membre($row->code_membre)
            ->setDate_rep($row->date_rep)
            ->setMont_rep($row->mont_rep)    
            ->setMont_reglt($row->mont_reglt)
			->setSolde_rep($row->solde_rep)
            ->setPayer($row->payer)    
                ;
        return true;
    }
    
	public function fetchRepByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre LIKE ?', $code_membre)
		       ->where('payer LIKE 0');
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($results as $row) {
            $entry = new Application_Model_EuRepartitionMf107();
            $entry->setId_rep($row->id_rep)
                  ->setId_mf107($row->id_mf107)
                  ->setCode_membre($row->code_membre)
                  ->setDate_rep($row->date_rep)
                  ->setMont_rep($row->mont_rep)    
                  ->setMont_reglt($row->mont_reglt)
			      ->setSolde_rep($row->solde_rep)  
                  ->setPayer($row->payer);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findsum($code_membre) {
	    $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_rep) as somme'));
        $select->where('code_membre = ?', $code_membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
	}
	
    
    public function getSumReparti($id_mf107,$id_dom,$code_membre) {
         $somme=0;
         $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
         $select->setIntegrityCheck(false);
         $select->join('eu_detail_domicilie_mf107', 'eu_detail_domicilie_mf107.id_mf107 = eu_repartition_mf107.id_mf107');
         $select->where('eu_repartition_mf107.id_mf107 =?',$id_mf107);
         $select->where('eu_repartition_mf107.code_membre = ?',$code_membre);
         $select->where('eu_detail_domicilie_mf107.id_dom = ?',$id_dom);
         $result = $this->getDbTable()->fetchAll($select);
         foreach ($result as $row) {
            $somme = $somme + $row->mont_rep;
         }
         return $somme;
         
    }
    
    public function fetchRepByMf($id_mf107) {
	    $select = $this->getDbTable()->select();
		$select->where('id_mf107 like ?', $id_mf107);
		$results = $this->getDbTable()->fetchAll($select);
		if (count($results) == 0) {
            return NULL;
        }
		$entries = array();
        foreach ($results as $row) {
            $entry = new Application_Model_EuRepartitionMf107();
            $entry->setId_rep($row->id_rep)
                  ->setId_mf107($row->id_mf107)
                  ->setCode_membre($row->code_membre)
                  ->setDate_rep($row->date_rep)
                  ->setMont_rep($row->mont_rep)    
                  ->setMont_reglt($row->mont_reglt)
			      ->setSolde_rep($row->solde_rep)  
                  ->setPayer($row->payer);
            $entries[] = $entry;
        }
        return $entries;
	}
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepartitionMf107();
            $entry->setId_rep($row->id_rep)
                  ->setId_mf107($row->id_mf107)
                  ->setCode_membre($row->code_membre)
                  ->setDate_rep($row->date_rep)
                  ->setMont_rep($row->mont_rep)    
                  ->setMont_reglt($row->mont_reglt)
			      ->setSolde_rep($row->solde_rep)  
                  ->setPayer($row->payer)  
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
     
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_rep) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
		if($row['count'] == NULL){
		   return 0;
		}else {
           return $row['count'];
		}   
    } 
	 
	 
	 
    public function delete($id_rep) {
        $this->getDbTable()->delete(array('id_rep = ?' => $id_rep));
    }
          
 }

?>