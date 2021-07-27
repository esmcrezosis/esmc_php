<?php
 
class Application_Model_EuMstiersListebcMapper {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if(is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuMstiersListebc');
        }
        return $this->_dbTable;
    }

	
    public function find($id_mstiers_listebc, Application_Model_EuMstiersListebc $mstierslistebc) {
        $result = $this->getDbTable()->find($id_mstiers_listebc);
        if(count($result) == 0) {
           return false;
        }
		
        $row = $result->current();
        $mstierslistebc->setId_mstiers_listebc($row->id_mstiers_listebc)
                       ->setCode_membre_apporteur($row->code_membre_apporteur)
                       ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                       ->setType_souscription($row->type_souscription)
                       ->setCode_bnp($row->code_bnp)
				       ->setDate_listebc($row->date_listebc)
					   ->setStatut($row->statut);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMstiersListebc();
            $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setType_souscription($row->type_souscription)
                  ->setCode_bnp($row->code_bnp)
				  ->setDate_listebc($row->date_listebc)
				  ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mstiers_listebc) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	public function fetchAllByMembre($membre) {
	   $tabela = new Application_Model_DbTable_EuMstiersListebc();
	   $select = $tabela->select();
	   $select->where('code_membre_apporteur = ?',$membre);   
	   $result = $tabela->fetchAll($select);
       if(count($result) == 0) {
         return NULL;
       }
	   $entries = array();
       foreach($result as $row) {
          $entry = new Application_Model_EuMstiersListebc();
          $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setType_souscription($row->type_souscription)
                  ->setCode_bnp($row->code_bnp)
				  ->setDate_listebc($row->date_listebc)
				  ->setStatut($row->statut);
		   $entries[] = $entry;
	    }
		return $entries;
	}
	
	public function fetchAllByBeneficiaire($membre) {
	    $tabela = new Application_Model_DbTable_EuMstiersListebc();
	    $select = $tabela->select();
	    $select->where('code_membre_beneficiaire = ?',$membre);
        $select->where('code_membre_apporteur is null');		
	    $result = $tabela->fetchAll($select);
        if(count($result) == 0) {
           return NULL;
        }
	    $entries = array();
        foreach($result as $row) {
            $entry = new Application_Model_EuMstiersListebc();
            $entry->setId_mstiers_listebc($row->id_mstiers_listebc)
                  ->setCode_membre_apporteur($row->code_membre_apporteur)
                  ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                  ->setType_souscription($row->type_souscription)
                  ->setCode_bnp($row->code_bnp)
				  ->setDate_listebc($row->date_listebc)
				  ->setStatut($row->statut);
		    $entries[] = $entry;
	    }
		return $entries;
	}
	
	
	
	
	
	
    public function save(Application_Model_EuMstiersListebc $mstierslistebc) {
        $data = array(
          'id_mstiers_listebc' => $mstierslistebc->getId_mstiers_listebc(),
          'code_membre_apporteur' => $mstierslistebc->getCode_membre_apporteur(),
          'code_membre_beneficiaire' => $mstierslistebc->getCode_membre_beneficiaire(),
		  'type_souscription' => $mstierslistebc->getType_souscription(),
		  'code_bnp' => $mstierslistebc->getCode_bnp(),
		  'date_listebc' => $mstierslistebc->getDate_listebc(),
		  'statut' => $mstierslistebc->getStatut()
        );

        $this->getDbTable()->insert($data);
    }

	
	
    public function update(Application_Model_EuMstiers $mstiers) {
        $data = array(
          'id_mstiers_listebc' => $mstierslistebc->getId_mstiers_listebc(),
          'code_membre_apporteur' => $mstierslistebc->getCode_membre_apporteur(),
          'code_membre_beneficiaire' => $mstierslistebc->getCode_membre_beneficiaire(),
		  'type_souscription' => $mstierslistebc->getType_souscription(),
		  'code_bnp' => $mstierslistebc->getCode_bnp(),
		  'date_listebc' => $mstierslistebc->getDate_listebc(),
		  'statut' => $mstierslistebc->getStatut()
        );
        $this->getDbTable()->update($data, array('id_mstiers_listebc = ?' => $mstiers->getId_mstiers_listebc()));
    }

	
	
    public function delete($id_mstiers_listebc) {
        $this->getDbTable()->delete(array('id_mstiers_listebc = ?' => $id_mstiers_listebc));
    }


    

}


?>
