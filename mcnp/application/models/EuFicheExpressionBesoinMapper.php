 <?php

class Application_Model_EuFicheExpressionBesoinMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFicheExpressionBesoin');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_fiche_expression_besoin, Application_Model_EuFicheExpressionBesoin $fiche_expression_besoin) {
       $result = $this->getDbTable()->find($id_fiche_expression_besoin);
       if(count($result) == 0) {
          return false;
       }
	   
       $row = $result->current();
       $fiche_expression_besoin->setId_fiche_expression_besoin($row->id_fiche_expression_besoin)
		   ->setDesignation_article($row->designation_article)
           ->setDescription_bien($row->description_bien)
           ->setQuantite_article($row->quantite_article)
           ->setPrix_unitaire($row->prix_unitaire)
           ->setVisa_gerant($row->visa_gerant)
           ->setAvis_gerant($row->avis_gerant)
		   ->setValid_up($row->valid_up)
		   ->setValid_up($row->valid_up)
           ->setDate_demande($row->date_demande)
           ->setAppreciation($row->appreciation)
		   ->setValid($row->valid)
		   ->setEtat($row->etat)
		   ;
	    return true;
	}
	
	
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFicheExpressionBesoin();
            $entry->setId_fiche_expression_besoin($row->id_fiche_expression_besoin)
		   ->setDesignation_article($row->designation_article)
           ->setDescription_bien($row->description_bien)
           ->setQuantite_article($row->quantite_article)
           ->setPrix_unitaire($row->prix_unitaire)
           ->setVisa_gerant($row->visa_gerant)
           ->setAvis_gerant($row->avis_gerant)
		   ->setValid_up($row->valid_up)
		   ->setValid_up($row->valid_up)
           ->setDate_demande($row->date_demande)
           ->setAppreciation($row->appreciation)
		   ->setValid($row->valid)
		   ->setEtat($row->etat)
			   ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
	public function fetchAllByCodeMembreEliUtilisateurValidEtat($code_membre = "", $id_eli = 0, $id_utilisateur = 0, $valid = 0, $etat = 0) {
	    $select = $this->getDbTable()->select();
	    if($code_membre != ""){
	    $select->where("code_membre = ? ", $code_membre);	    	
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
	       $entry = new Application_Model_EuFicheExpressionBesoin();
           $entry->setId_fiche_expression_besoin($row->id_fiche_expression_besoin)
		   ->setDesignation_article($row->designation_article)
           ->setDescription_bien($row->description_bien)
           ->setQuantite_article($row->quantite_article)
           ->setPrix_unitaire($row->prix_unitaire)
           ->setVisa_gerant($row->visa_gerant)
           ->setAvis_gerant($row->avis_gerant)
		   ->setValid_up($row->valid_up)
		   ->setValid_up($row->valid_up)
           ->setDate_demande($row->date_demande)
           ->setAppreciation($row->appreciation)
		   ->setValid($row->valid)
		   ->setEtat($row->etat)
			   ;
           $entries[] = $entry;
	    }
		return $entries;
	}
	
		

    public function save(Application_Model_EuFicheExpressionBesoin $fiche_expression_besoin) {
        $data = array(
			'id_fiche_expression_besoin' => $fiche_expression_besoin->getId_fiche_expression_besoin(),
			'designation_article' => $fiche_expression_besoin->getDesignation_article(),
			'description_bien' => $fiche_expression_besoin->getDescription_bien(),
			'quantite_article' => $fiche_expression_besoin->getQuantite_article(),
			'prix_unitaire' => $fiche_expression_besoin->getPrix_unitaire(),
			'visa_gerant' => $fiche_expression_besoin->getVisa_gerant(),
			'avis_gerant' => $fiche_expression_besoin->getAvis_gerant(),
			'valid_up' => $fiche_expression_besoin->getValid_up(),
			'valid_up' => $fiche_expression_besoin->getValid_up(),
			'date_demande' => $fiche_expression_besoin->getDate_demande(),
			'appreciation' => $fiche_expression_besoin->getAppreciation(),
			'valid' => $fiche_expression_besoin->getValid(),
			'etat' => $fiche_expression_besoin->getEtat()
		);
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuFicheExpressionBesoin $fiche_expression_besoin) {
        $data = array(
			'id_fiche_expression_besoin' => $fiche_expression_besoin->getId_fiche_expression_besoin(),
			'designation_article' => $fiche_expression_besoin->getDesignation_article(),
			'description_bien' => $fiche_expression_besoin->getDescription_bien(),
			'quantite_article' => $fiche_expression_besoin->getQuantite_article(),
			'prix_unitaire' => $fiche_expression_besoin->getPrix_unitaire(),
			'visa_gerant' => $fiche_expression_besoin->getVisa_gerant(),
			'avis_gerant' => $fiche_expression_besoin->getAvis_gerant(),
			'valid_up' => $fiche_expression_besoin->getValid_up(),
			'valid_up' => $fiche_expression_besoin->getValid_up(),
			'date_demande' => $fiche_expression_besoin->getDate_demande(),
			'appreciation' => $fiche_expression_besoin->getAppreciation(),
			'valid' => $fiche_expression_besoin->getValid(),
			'etat' => $fiche_expression_besoin->getEtat()
        );
        $this->getDbTable()->update($data, array('id_fiche_expression_besoin = ?' => $fiche_expression_besoin->getId_fiche_expression_besoin()));
    }
	

    public function delete($id_fiche_expression_besoin) {
        $this->getDbTable()->delete(array('id_fiche_expression_besoin = ?' => $id_fiche_expression_besoin));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fiche_expression_besoin) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
