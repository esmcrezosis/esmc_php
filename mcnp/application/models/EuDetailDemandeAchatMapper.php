 <?php

class Application_Model_EuDetailDemandeAchatMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailDemandeAchat');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_detail_demande_achat, Application_Model_EuDetailDemandeAchat $ddachat) {
        $result = $this->getDbTable()->find($id_detail_demande_achat);
        if(0 == count($result)) {
           return false;
        }
		
        $row = $result->current();
        $ddachat->setId_detail_demande_achat($row->id_detail_demande_achat)
		        ->setId_demande_achat($row->id_demande_achat)
                ->setReference_article($row->reference_article)
                ->setDesignation_article($row->designation_article)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setValidation($row->validation);
	}
	
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailDemandeAchat();
            $entry->setId_detail_demande_achat($row->id_detail_demande_achat)
		          ->setId_demande_achat($row->id_demande_achat)
                  ->setReference_article($row->reference_article)
                  ->setDesignation_article($row->designation_article)
                  ->setQuantite($row->quantite)
                  ->setPrix_unitaire($row->prix_unitaire)
                  ->setValidation($row->validation);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public  function fetchAllByDemande($id_demande_achat)  {
		$select = $this->getDbTable()->select();
	    $select->where("id_demande_achat = ? ", $id_demande_achat);
		$select->where("validation = ? ",0);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuDetailDemandeAchat();
		   $entry->setId_detail_demande_achat($row->id_detail_demande_achat)
		         ->setId_demande_achat($row->id_demande_achat)
                 ->setReference_article($row->reference_article)
                 ->setDesignation_article($row->designation_article)
                 ->setQuantite($row->quantite)
                 ->setPrix_unitaire($row->prix_unitaire)
                 ->setValidation($row->validation);
           $entries[] = $entry;
	    }
		return $entries;
	}
    

    public function save(Application_Model_EuDetailDemandeAchat $ddachat) {
        $data = array(
		    'id_detail_demande_achat' => $ddachat->getId_detail_demande_achat(),
			'id_demande_achat' => $ddachat->getId_demande_achat(),
            'reference_article' => $ddachat->getReference_article(),
            'designation_article' => $ddachat->getDesignation_article(),
            'quantite' => $ddachat->getQuantite(),
            'prix_unitaire' => $ddachat->getPrix_unitaire(),
            'validation' => $ddachat->getValidation()
        );

        $this->getDbTable()->insert($data);
    }
    
	
	
    public function update(Application_Model_EuDetailDemandeAchat $ddachat) {
        $data = array(
          'id_detail_demande_achat' => $ddachat->getId_detail_demande_achat(),
	      'id_demande_achat' => $ddachat->getId_demande_achat(),
          'reference_article' => $ddachat->getReference_article(),
          'designation_article' => $ddachat->getDesignation_article(),
          'quantite' => $ddachat->getQuantite(),
          'prix_unitaire' => $ddachat->getPrix_unitaire(),
          'validation' => $ddachat->getValidation()
        );
        $this->getDbTable()->update($data, array('id_detail_demande_achat = ?' => $ddachat->getId_detail_demande_achat()));
    }
	
	

    public function delete($id_detail_demande_achat) {
        $this->getDbTable()->delete(array('id_detail_demande_achat = ?' => $id_detail_demande_achat));
    }

    ///////////////////////////////////////////////////////////////

}

?>
