 <?php

class Application_Model_EuValidTdrMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuValidTdr');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_valid_tdr, Application_Model_EuValidTdr $valid_tdr) {
       $result = $this->getDbTable()->find($id_valid_tdr);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $valid_tdr->setId_valid_tdr($row->id_valid_tdr)
		   ->setTable($row->table)
           ->setId_table($row->id_table)
           ->setDatecreation($row->datecreation)
           ->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
           ->setEtat($row->etat)
		   ->setId_utilisateur($row->id_utilisateur)
		   ;
	    return true;
	}
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuValidTdr();
            $entry->setId_valid_tdr($row->id_valid_tdr)
			   ->setTable($row->table)
	           ->setId_table($row->id_table)
	           ->setDatecreation($row->datecreation)
	           ->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
	           ->setEtat($row->etat)
			   ->setId_utilisateur($row->id_utilisateur)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByTableIdNiveauTypeUtilisateur($table = "", $id_table = 0, $attribution_user_group_formulaire_id = 0, $etat = 0, $id_utilisateur = 0) {
	    $select = $this->getDbTable()->select();
	    if($etat > 0){
	    $select->where("etat = ? ", $etat);	    	
	    }
	    if($attribution_user_group_formulaire_id > 0){
	    $select->where("attribution_user_group_formulaire_id = ? ", $attribution_user_group_formulaire_id);	    	
	    }
	    if($id_table > 0){
	    $select->where("id_table = ? ", $id_table);	    	
	    }
	    if($id_utilisateur > 0){
	    $select->where("id_utilisateur = ? ", $id_utilisateur);	    	
	    }
	    if($table != ""){
	    $select->where("table = ? ", $table);	    	
	    }
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuValidTdr();
           $entry->setId_valid_tdr($row->id_valid_tdr)
			   ->setTable($row->table)
	           ->setId_table($row->id_table)
	           ->setDatecreation($row->datecreation)
	           ->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
	           ->setEtat($row->etat)
			   ->setId_utilisateur($row->id_utilisateur)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuValidTdr $valid_tdr) {
        $data = array(
			'id_valid_tdr' => $valid_tdr->getId_valid_tdr(),
			'table' => $valid_tdr->getTable(),
			'id_table' => $valid_tdr->getId_table(),
			'datecreation' => $valid_tdr->getDatecreation(),
			'attribution_user_group_formulaire_id' => $valid_tdr->getAttribution_user_group_formulaire_id(),
			'etat' => $tdr->getEtat(),
			'id_utilisateur' => $valid_tdr->getId_utilisateur()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuValidTdr $valid_tdr) {
        $data = array(
			'id_valid_tdr' => $valid_tdr->getId_valid_tdr(),
			'table' => $valid_tdr->getTable(),
			'id_table' => $valid_tdr->getId_table(),
			'datecreation' => $valid_tdr->getDatecreation(),
			'attribution_user_group_formulaire_id' => $valid_tdr->getAttribution_user_group_formulaire_id(),
			'etat' => $tdr->getEtat(),
			'id_utilisateur' => $valid_tdr->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_valid_tdr = ?' => $valid_tdr->getId_valid_tdr()));
    }
	

    public function delete($id_valid_tdr) {
        $this->getDbTable()->delete(array('id_valid_tdr = ?' => $id_valid_tdr));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_valid_tdr) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
