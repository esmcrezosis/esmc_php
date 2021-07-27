 <?php

class Application_Model_EuTdrDdePropoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTdrDdePropo');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_tdr_dde_propo, Application_Model_EuTdrDdePropo $tdr_dde_propo) {
       $result = $this->getDbTable()->find($id_tdr_dde_propo);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $tdr_dde_propo->setId_tdr_dde_propo($row->id_tdr_dde_propo)
		   ->setId_tdr($row->id_tdr)
           ->setLibelle($row->libelle)
           ->setDescription($row->description)
           ->setFichier($row->fichier)
           ->setDatecreation($row->datecreation)
           ->setType_dde_propo($row->type_dde_propo)
		   ->setId_utilisateur($row->id_utilisateur)
		   ->setValid($row->valid)
		   ->setEtat($row->etat)
		   ;
	    return true;
	}
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuTdrDdePropo();
            $entry->setId_tdr_dde_propo($row->id_tdr_dde_propo)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setType_dde_propo($row->type_dde_propo)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByTypeDdePropoTdrUtilisateurValidEtat($type_dde_propo = 0, $id_tdr = 0, $id_utilisateur = 0, $valid = 0, $etat = 0) {
	    $select = $this->getDbTable()->select();
	    if($type_dde_propo > 0){
	    $select->where("type_dde_propo = ? ", $type_dde_propo);	    	
	    }
	    if($id_tdr > 0){
	    $select->where("id_tdr = ? ", $id_tdr);	    	
	    }
	    if($id_utilisateur > 0){
	    $select->where("id_utilisateur = ? ", $id_utilisateur);	    	
	    }
	    if($valid > 0){
	    $select->where("valid = ? ", $valid);	    	
	    }
	    if($etat > 0){
	    $select->where("etat = ? ", $etat);	    	
	    }
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuTdrDdePropo();
           $entry->setId_tdr_dde_propo($row->id_tdr_dde_propo)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setType_dde_propo($row->type_dde_propo)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuTdrDdePropo $tdr_dde_propo) {
        $data = array(
			'id_tdr_dde_propo' => $tdr_dde_propo->getId_tdr_dde_propo(),
			'id_tdr' => $tdr_dde_propo->getId_tdr(),
			'libelle' => $tdr_dde_propo->getLibelle(),
			'description' => $tdr_dde_propo->getDescription(),
			'fichier' => $tdr_dde_propo->getFichier(),
			'datecreation' => $tdr_dde_propo->getDatecreation(),
			'type_dde_propo' => $tdr_dde_propo->getType_dde_propo(),
			'id_utilisateur' => $tdr_dde_propo->getId_utilisateur(),
			'valid' => $tdr_dde_propo->getValid(),
			'etat' => $tdr_dde_propo->getEtat()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuTdrDdePropo $tdr_dde_propo) {
        $data = array(
			'id_tdr_dde_propo' => $tdr_dde_propo->getId_tdr_dde_propo(),
			'id_tdr' => $tdr_dde_propo->getId_tdr(),
			'libelle' => $tdr_dde_propo->getLibelle(),
			'description' => $tdr_dde_propo->getDescription(),
			'fichier' => $tdr_dde_propo->getFichier(),
			'datecreation' => $tdr_dde_propo->getDatecreation(),
			'type_dde_propo' => $tdr_dde_propo->getType_dde_propo(),
			'id_utilisateur' => $tdr_dde_propo->getId_utilisateur(),
			'valid' => $tdr_dde_propo->getValid(),
			'etat' => $tdr_dde_propo->getEtat()
        );
        $this->getDbTable()->update($data, array('id_tdr_dde_propo = ?' => $tdr_dde_propo->getId_tdr_dde_propo()));
    }
	

    public function delete($id_tdr_dde_propo) {
        $this->getDbTable()->delete(array('id_tdr_dde_propo = ?' => $id_tdr_dde_propo));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tdr_dde_propo) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////


	
	public function fetchAllByFiliere($id_filiere = 0) {
	    $select = $this->getDbTable()->select();
	    $select->where("id_tdr IN (SELECT id_tdr FROM eu_tdr WHERE id_filiere = ".$id_filiere.")");	    	
	    $select->where("valid IS NOT NULL");	    	
	    $select->where("etat = ? ", 1);	    	
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuTdrDdePropo();
           $entry->setId_tdr_dde_propo($row->id_tdr_dde_propo)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setType_dde_propo($row->type_dde_propo)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	



}

?>
