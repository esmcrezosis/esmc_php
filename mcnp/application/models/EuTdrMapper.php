 <?php

class Application_Model_EuTdrMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTdr');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_tdr, Application_Model_EuTdr $tdr) {
       $result = $this->getDbTable()->find($id_tdr);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $tdr->setId_tdr($row->id_tdr)
		   ->setId_filiere($row->id_filiere)
           ->setLibelle($row->libelle)
           ->setDescription($row->description)
           ->setFichier($row->fichier)
           ->setDatecreation($row->datecreation)
           ->setCode_membre($row->code_membre)
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
            $entry = new Application_Model_EuTdr();
            $entry->setId_tdr($row->id_tdr)
			   ->setId_filiere($row->id_filiere)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByCodeMembreFiliereUtilisateurValidEtat($code_membre = "", $id_filiere = 0, $id_utilisateur = 0, $valid = 0, $etat = 0) {
	    $select = $this->getDbTable()->select();
	    if($code_membre != ""){
	    $select->where("code_membre = ? ", $code_membre);	    	
	    }
	    if($id_filiere > 0){
	    $select->where("id_filiere = ? ", $id_filiere);	    	
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
	       $entry = new Application_Model_EuTdr();
           $entry->setId_tdr($row->id_tdr)
			   ->setId_filiere($row->id_filiere)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuTdr $tdr) {
        $data = array(
			'id_tdr' => $tdr->getId_tdr(),
			'id_filiere' => $tdr->getId_filiere(),
			'libelle' => $tdr->getLibelle(),
			'description' => $tdr->getDescription(),
			'fichier' => $tdr->getFichier(),
			'datecreation' => $tdr->getDatecreation(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $tdr->getId_utilisateur(),
			'valid' => $tdr->getValid(),
			'etat' => $tdr->getEtat()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuTdr $tdr) {
        $data = array(
			'id_tdr' => $tdr->getId_tdr(),
			'id_filiere' => $tdr->getId_filiere(),
			'libelle' => $tdr->getLibelle(),
			'description' => $tdr->getDescription(),
			'fichier' => $tdr->getFichier(),
			'datecreation' => $tdr->getDatecreation(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $tdr->getId_utilisateur(),
			'valid' => $tdr->getValid(),
			'etat' => $tdr->getEtat()
        );
        $this->getDbTable()->update($data, array('id_tdr = ?' => $tdr->getId_tdr()));
    }
	

    public function delete($id_tdr) {
        $this->getDbTable()->delete(array('id_tdr = ?' => $id_tdr));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tdr) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
