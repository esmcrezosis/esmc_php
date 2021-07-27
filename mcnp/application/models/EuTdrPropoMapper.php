 <?php

class Application_Model_EuTdrPropoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTdrPropo');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_tdr_propo, Application_Model_EuTdrPropo $tdr_propo) {
       $result = $this->getDbTable()->find($id_tdr_propo);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $tdr_propo->setId_tdr_propo($row->id_tdr_propo)
		   ->setId_tdr($row->id_tdr)
           ->setLibelle($row->libelle)
           ->setDescription($row->description)
           ->setFichier($row->fichier)
           ->setDatecreation($row->datecreation)
           ->setType_propo($row->type_propo)
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
            $entry = new Application_Model_EuTdrPropo();
            $entry->setId_tdr_propo($row->id_tdr_propo)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setType_propo($row->type_propo)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByCodeMembreTypePropoTdrUtilisateurValidEtat($code_membre = "", $type_propo = 0, $id_tdr = 0, $id_utilisateur = 0, $valid = 0, $etat = 0) {
	    $select = $this->getDbTable()->select();
	    if($code_membre != ""){
	    $select->where("code_membre = ? ", $code_membre);	    	
	    }
	    if($type_propo > 0){
	    $select->where("type_propo = ? ", $type_propo);	    	
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
	       $entry = new Application_Model_EuTdrPropo();
           $entry->setId_tdr_propo($row->id_tdr_propo)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setType_propo($row->type_propo)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuTdrPropo $tdr_propo) {
        $data = array(
			'id_tdr_propo' => $tdr_propo->getId_tdr_propo(),
			'id_tdr' => $tdr_propo->getId_tdr(),
			'libelle' => $tdr_propo->getLibelle(),
			'description' => $tdr_propo->getDescription(),
			'fichier' => $tdr_propo->getFichier(),
			'datecreation' => $tdr_propo->getDatecreation(),
			'type_propo' => $tdr_propo->getType_propo(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $tdr_propo->getId_utilisateur(),
			'valid' => $tdr_propo->getValid(),
			'etat' => $tdr_propo->getEtat()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuTdrPropo $tdr_propo) {
        $data = array(
			'id_tdr_propo' => $tdr_propo->getId_tdr_propo(),
			'id_tdr' => $tdr_propo->getId_tdr(),
			'libelle' => $tdr_propo->getLibelle(),
			'description' => $tdr_propo->getDescription(),
			'fichier' => $tdr_propo->getFichier(),
			'datecreation' => $tdr_propo->getDatecreation(),
			'type_propo' => $tdr_propo->getType_propo(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $tdr_propo->getId_utilisateur(),
			'valid' => $tdr_propo->getValid(),
			'etat' => $tdr_propo->getEtat()
        );
        $this->getDbTable()->update($data, array('id_tdr_propo = ?' => $tdr_propo->getId_tdr_propo()));
    }
	

    public function delete($id_tdr_propo) {
        $this->getDbTable()->delete(array('id_tdr_propo = ?' => $id_tdr_propo));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tdr_propo) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
