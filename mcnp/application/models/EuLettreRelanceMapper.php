 <?php

class Application_Model_EuLettreRelanceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLettreRelance');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_lettre_relance, Application_Model_EuLettreRelance $lettre_relance) {
       $result = $this->getDbTable()->find($id_lettre_relance);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $lettre_relance->setId_lettre_relance($row->id_lettre_relance)
		   ->setId_eli($row->id_eli)
           ->setLibelle($row->libelle)
           ->setDescription($row->description)
           ->setFichier($row->fichier)
           ->setDatecreation($row->datecreation)
           ->setCode_membre($row->code_membre)
		   ->setId_utilisateur($row->id_utilisateur)
		   ->setValid($row->valid)
		   ->setEtat($row->etat)
           ->setType_lettre($row->type_lettre)
		   ;
	    return true;
	}
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuLettreRelance();
            $entry->setId_lettre_relance($row->id_lettre_relance)
			   ->setId_eli($row->id_eli)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
           ->setType_lettre($row->type_lettre)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByCodeMembreTypeEliUtilisateurValidEtat($code_membre = "", $type_lettre = "", $id_eli = 0, $id_utilisateur = 0, $valid = 0, $etat = 0) {
	    $select = $this->getDbTable()->select();
	    if($code_membre != ""){
	    $select->where("code_membre = ? ", $code_membre);	    	
	    }
	    if($type_lettre != ""){
	    $select->where("type_lettre = ? ", $type_lettre);	    	
	    }
	    if($id_eli > 0){
	    $select->where("id_eli = ? ", $id_eli);	    	
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
	       $entry = new Application_Model_EuLettreRelance();
           $entry->setId_lettre_relance($row->id_lettre_relance)
			   ->setId_eli($row->id_eli)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
           ->setType_lettre($row->type_lettre)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuLettreRelance $lettre_relance) {
        $data = array(
			'id_lettre_relance' => $lettre_relance->getId_lettre_relance(),
			'id_eli' => $lettre_relance->getId_eli(),
			'libelle' => $lettre_relance->getLibelle(),
			'description' => $lettre_relance->getDescription(),
			'fichier' => $lettre_relance->getFichier(),
			'datecreation' => $lettre_relance->getDatecreation(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $lettre_relance->getId_utilisateur(),
			'type_lettre' => $lettre_relance->getType_lettre(),
			'valid' => $lettre_relance->getValid(),
			'etat' => $lettre_relance->getEtat()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuLettreRelance $lettre_relance) {
        $data = array(
			'id_lettre_relance' => $lettre_relance->getId_lettre_relance(),
			'id_eli' => $lettre_relance->getId_eli(),
			'libelle' => $lettre_relance->getLibelle(),
			'description' => $lettre_relance->getDescription(),
			'fichier' => $lettre_relance->getFichier(),
			'datecreation' => $lettre_relance->getDatecreation(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $lettre_relance->getId_utilisateur(),
			'type_lettre' => $lettre_relance->getType_lettre(),
			'valid' => $lettre_relance->getValid(),
			'etat' => $lettre_relance->getEtat()
        );
        $this->getDbTable()->update($data, array('id_lettre_relance = ?' => $lettre_relance->getId_lettre_relance()));
    }
	

    public function delete($id_lettre_relance) {
        $this->getDbTable()->delete(array('id_lettre_relance = ?' => $id_lettre_relance));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_lettre_relance) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
