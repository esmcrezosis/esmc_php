<?php
 
class Application_Model_EuAchatInterimMapper {

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
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuAchatInterim');
        }
        return $this->_dbTable;
    }

	
    public function find($id_achat, Application_Model_EuAchatInterim $achat)  {
        $result = $this->getDbTable()->find($id_achat);
        if(count($result) == 0) {
          return false;
        }
		
        $row = $result->current();
        $achat->setId_achat($row->id_achat)
              ->setCode_achat($row->code_achat)
              ->setMontant_achat($row->montant_achat)
              ->setNom_acheteur($row->nom_acheteur)
              ->setPrenom_acheteur($row->prenom_membre)
		      ->setRaison_acheteur($row->raison_acheteur)
		      ->setDate_achat($row->date_achat)
		      ->setCode_membre($row->code_membre)
		      ->setId_utilisateur($row->id_utilisateur)
		      ->setBon_id($row->bon_id)
		      ->setStatus($row->status)
			  ->setCode_ban($row->code_ban);
        return true;
    }
	
	
	public function fetchAllByCode($code_achat) {
        $select = $this->getDbTable()->select();
		$select->where("code_achat = ? ", $code_achat);
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
           return;
        }
        $row = $result;
        $entry = new Application_Model_EuAchatInterim();
        $entry->setId_achat($row->id_achat)
              ->setCode_achat($row->code_achat)
              ->setMontant_achat($row->montant_achat)
              ->setNom_acheteur($row->nom_acheteur)
              ->setPrenom_acheteur($row->prenom_membre)
		      ->setRaison_acheteur($row->raison_acheteur)
		      ->setDate_achat($row->date_achat)
		      ->setCode_membre($row->code_membre)
		      ->setId_utilisateur($row->id_utilisateur)
		      ->setBon_id($row->bon_id)
		      ->setStatus($row->status)
			  ->setCode_ban($row->code_ban);
		$entries = $entry;
        return $entries;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuAchatInterim();
            $entry->setId_achat($row->id_achat)
                  ->setCode_achat($row->code_achat)
                  ->setMontant_achat($row->montant_achat)
                  ->setNom_acheteur($row->nom_acheteur)
                  ->setPrenom_acheteur($row->prenom_membre)
		          ->setRaison_acheteur($row->raison_acheteur)
		          ->setDate_achat($row->date_achat)
		          ->setCode_membre($row->code_membre)
		          ->setId_utilisateur($row->id_utilisateur)
		          ->setBon_id($row->bon_id)
		          ->setStatus($row->status)
				  ->setCode_ban($row->code_ban);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_achat) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuAchatInterim $achat) {
        $data = array(
            'id_achat' => $achat->getId_achat(),
            'code_achat' => $achat->getCode_achat(),
            'montant_achat' => $achat->getMontant_achat(),
	        'nom_acheteur' => strtoupper($achat->getNom_acheteur()),
	        'prenom_acheteur' => strtoupper($achat->getPrenom_acheteur()),
			'raison_acheteur' => strtoupper($achat->getRaison_acheteur()),
	        'date_achat' => $achat->getDate_achat(),
	        'code_membre' => $achat->getCode_membre(),
	        'id_utilisateur' => $achat->getId_utilisateur(),
            'bon_id' => $achat->getBon_id(),
			'code_ban' => $achat->getCode_ban(),
	        'status' => $achat->getStatus()
        );
        $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuAchatInterim $achat) {
        $data = array(
            'id_achat' => $achat->getId_achat(),
            'code_achat' => $achat->getCode_achat(),
            'montant_achat' => $achat->getMontant_achat(),
	        'nom_acheteur' => strtoupper($achat->getNom_acheteur()),
	        'prenom_acheteur' => strtoupper($achat->getPrenom_acheteur()),
			'raison_acheteur' => strtoupper($achat->getRaison_acheteur()),
	        'date_achat' => $achat->getDate_achat(),
	        'code_membre' => $achat->getCode_membre(),
	        'id_utilisateur' => $achat->getId_utilisateur(),
            'bon_id' => $achat->getBon_id(),
			'code_ban' => $achat->getCode_ban(),
	        'status' => $achat->getStatus()
        );
        $this->getDbTable()->update($data, array('id_achat = ?' => $achat->getId_achat()));
    }
	

    public function delete($id_achat) {
        $this->getDbTable()->delete(array('id_achat = ?' => $id_achat));
    }
    

}


?>
