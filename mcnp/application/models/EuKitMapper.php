 <?php

class Application_Model_EuKitMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuKit');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_kit, Application_Model_EuKit $kit) {
       $result = $this->getDbTable()->find($id_kit);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $kit->setId_kit($row->id_kit)
		   ->setCode_membre($row->code_membre)
           ->setMembreasso_id($row->membreasso_id)
           ->setAutomatique($row->automatique)
           ->setDate_kit($row->date_kit)
		   ->setMateriel_kit($row->materiel_kit)
		   ->setLivrer($row->livrer)
		   ->setEtat($row->etat)
           ->setType_kit($row->type_kit)
		   ->setLicence($row->licence)
		   ->setObservation($row->observation)
           ->setQte_kit($row->qte_kit)
		   ;
	    return true;
	}
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuKit();
            $entry->setId_kit($row->id_kit)
			   ->setCode_membre($row->code_membre)
	           ->setMembreasso_id($row->membreasso_id)
	           ->setAutomatique($row->automatique)
	           ->setDate_kit($row->date_kit)
			   ->setMateriel_kit($row->materiel_kit)
			   ->setLivrer($row->livrer)
			   ->setEtat($row->etat)
           ->setType_kit($row->type_kit)
		   ->setLicence($row->licence)
		   ->setObservation($row->observation)
           ->setQte_kit($row->qte_kit)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByCodeMembreMembreassoTypeMaterielLivrerEtat($code_membre = "", $membreasso_id = "", $type_kit = "", $materiel_kit = 0, $livrer = 0, $etat = 0, $automatique = 0) {
	    $select = $this->getDbTable()->select();
	    if($code_membre > 0){
	    $select->where("code_membre = ? ", $code_membre);	    	
	    }
	    if($membreasso_id > 0){
	    $select->where("membreasso_id = ? ", $membreasso_id);	    	
	    }
	    if($type_kit != ""){
	    $select->where("type_kit = ? ", $type_kit);	    	
	    }
	    if($materiel_kit > 0){
	    $select->where("materiel_kit = ? ", $materiel_kit);	    	
	    }
	    if($livrer > 0){
	    $select->where("livrer = ? ", $livrer);	    	
	    }
	    if($etat > 0){
	    $select->where("etat = ? ", $etat);	    	
	    }
	    if($automatique > 0){
	    $select->where("automatique = ? ", $automatique);	    	
	    }
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuKit();
           $entry->setId_kit($row->id_kit)
			   ->setCode_membre($row->code_membre)
	           ->setMembreasso_id($row->membreasso_id)
	           ->setAutomatique($row->automatique)
	           ->setDate_kit($row->date_kit)
			   ->setMateriel_kit($row->materiel_kit)
			   ->setLivrer($row->livrer)
			   ->setEtat($row->etat)
           ->setType_kit($row->type_kit)
		   ->setLicence($row->licence)
		   ->setObservation($row->observation)
           ->setQte_kit($row->qte_kit)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuKit $kit) {
        $data = array(
			'id_kit' => $kit->getId_kit(),
			'code_membre' => $kit->getCode_membre(),
			'membreasso_id' => $kit->getMembreasso_id(),
			'automatique' => $kit->getAutomatique(),
			'date_kit' => $kit->getDate_kit(),
			'materiel_kit' => $kit->getMateriel_kit(),
			'type_kit' => $kit->getType_kit(),
			'livrer' => $kit->getLivrer(),
			'etat' => $kit->getEtat(),
			'licence' => $kit->getLicence(),
			'observation' => $kit->getObservation(),
			'qte_kit' => $kit->getQte_kit(),
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuKit $kit) {
        $data = array(
			'id_kit' => $kit->getId_kit(),
			'code_membre' => $kit->getCode_membre(),
			'membreasso_id' => $kit->getMembreasso_id(),
			'automatique' => $kit->getAutomatique(),
			'date_kit' => $kit->getDate_kit(),
			'materiel_kit' => $kit->getMateriel_kit(),
			'type_kit' => $kit->getType_kit(),
			'livrer' => $kit->getLivrer(),
			'etat' => $kit->getEtat(),
			'licence' => $kit->getLicence(),
			'observation' => $kit->getObservation(),
			'qte_kit' => $kit->getQte_kit(),
        );
        $this->getDbTable()->update($data, array('id_kit = ?' => $kit->getId_kit()));
    }
	

    public function delete($id_kit) {
        $this->getDbTable()->delete(array('id_kit = ?' => $id_kit));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_kit) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
