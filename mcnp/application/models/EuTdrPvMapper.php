 <?php

class Application_Model_EuTdrPvMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTdrPv');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_tdr_pv, Application_Model_EuTdrPv $tdr_pv) {
       $result = $this->getDbTable()->find($id_tdr_pv);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $tdr_pv->setId_tdr_pv($row->id_tdr_pv)
		   ->setId_tdr($row->id_tdr)
           ->setLibelle($row->libelle)
           ->setDescription($row->description)
           ->setFichier($row->fichier)
           ->setDatecreation($row->datecreation)
           ->setMontant_retenu($row->montant_retenu)
           ->setMontant_revu($row->montant_revu)
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
            $entry = new Application_Model_EuTdrPv();
            $entry->setId_tdr_pv($row->id_tdr_pv)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setMontant_retenu($row->montant_retenu)
	           ->setMontant_revu($row->montant_revu)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByCodeMembreTdrUtilisateurValidEtat($code_membre = "", $id_tdr = 0, $id_utilisateur = 0, $valid = 0, $etat = 0) {
	    $select = $this->getDbTable()->select();
	    if($code_membre != ""){
	    $select->where("code_membre = ? ", $code_membre);	    	
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
	       $entry = new Application_Model_EuTdrPv();
           $entry->setId_tdr_pv($row->id_tdr_pv)
			   ->setId_tdr($row->id_tdr)
	           ->setLibelle($row->libelle)
	           ->setDescription($row->description)
	           ->setFichier($row->fichier)
	           ->setDatecreation($row->datecreation)
	           ->setMontant_retenu($row->montant_retenu)
	           ->setMontant_revu($row->montant_revu)
	           ->setCode_membre($row->code_membre)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setValid($row->valid)
			   ->setEtat($row->etat)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuTdrPv $tdr_pv) {
        $data = array(
			'id_tdr_pv' => $tdr_pv->getId_tdr_pv(),
			'id_tdr' => $tdr_pv->getId_tdr(),
			'libelle' => $tdr_pv->getLibelle(),
			'description' => $tdr_pv->getDescription(),
			'fichier' => $tdr_pv->getFichier(),
			'datecreation' => $tdr_pv->getDatecreation(),
			'montant_retenu' => $tdr_pv->getMontant_retenu(),
			'montant_revu' => $tdr_pv->getMontant_revu(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $tdr_pv->getId_utilisateur(),
			'valid' => $tdr_pv->getValid(),
			'etat' => $tdr_pv->getEtat()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuTdrPv $tdr_pv) {
        $data = array(
			'id_tdr_pv' => $tdr_pv->getId_tdr_pv(),
			'id_tdr' => $tdr_pv->getId_tdr(),
			'libelle' => $tdr_pv->getLibelle(),
			'description' => $tdr_pv->getDescription(),
			'fichier' => $tdr_pv->getFichier(),
			'datecreation' => $tdr_pv->getDatecreation(),
			'montant_retenu' => $tdr_pv->getMontant_retenu(),
			'montant_revu' => $tdr_pv->getMontant_revu(),
			'code_membre' => $tdr->getCode_membre(),
			'id_utilisateur' => $tdr_pv->getId_utilisateur(),
			'valid' => $tdr_pv->getValid(),
			'etat' => $tdr_pv->getEtat()
        );
        $this->getDbTable()->update($data, array('id_tdr_pv = ?' => $tdr_pv->getId_tdr_pv()));
    }
	

    public function delete($id_tdr_pv) {
        $this->getDbTable()->delete(array('id_tdr_pv = ?' => $id_tdr_pv));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tdr_pv) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
