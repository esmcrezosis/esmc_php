<?php

class Application_Model_EuMobilisateurMapper  {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if(is_string($dbTable)) {
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
           $this->setDbTable('Application_Model_DbTable_EuMobilisateur');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuMobilisateur $mobilisateur) {
      $data = array(
	    'id_mobilisateur' => $mobilisateur->getId_mobilisateur(),
        'code_membre' => $mobilisateur->getCode_membre(),
        'id_utilisateur' => $mobilisateur->getId_utilisateur(),
	    'datecreat' => $mobilisateur->getDatecreat(),
        'etat' => $mobilisateur->getEtat()
      );
      $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuMobilisateur $mobilisateur) {
        $data = array(
		  'id_mobilisateur' => $mobilisateur->getId_mobilisateur(),
          'code_membre' => $mobilisateur->getCode_membre(),
          'id_utilisateur' => $mobilisateur->getId_utilisateur(),
	      'datecreat' => $mobilisateur->getDatecreat(),
          'etat' => $mobilisateur->getEtat()
        );
        $this->getDbTable()->update($data, array('id_mobilisateur = ?' => $mobilisateur->getId_mobilisateur()));
    }
	
	

    public function find($id_mobilisateur, Application_Model_EuMobilisateur $mobilisateur) {
        $result = $this->getDbTable()->find($id_mobilisateur);
        if(0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $mobilisateur->setId_mobilisateur($row->id_mobilisateur)
		        ->setCode_membre($row->code_membre)
                ->setId_utilisateur($row->id_utilisateur)
				->setDatecreat($row->datecreat)
                ->setEtat($row->etat)
                ;
        return true;
    }
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuMobilisateur();
            $entry->setId_mobilisateur($row->id_mobilisateur)
			      ->setCode_membre($row->code_membre)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setDatecreat($row->datecreat)
                  ->setEtat($row->etat)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public  function fetchByMembre($code_membre_mobilisateur)  {
		$tabela = new Application_Model_DbTable_EuMobilisateur();
	    $select = $tabela->select();
	    $select->where('code_membre = ?',$code_membre_mobilisateur);
	    $select->where('etat = ?',1);
		$result = $this->getDbTable()->fetchAll($select);
		if(count($result) == 0) {
          return NULL;
        }
		$row = $result->current();
		$entry = new Application_Model_EuMobilisateur();
		$entry->setId_mobilisateur($row->id_mobilisateur)
			  ->setCode_membre($row->code_membre)
              ->setId_utilisateur($row->id_utilisateur)
			  ->setDatecreat($row->datecreat)
              ->setEtat($row->etat);
		return $entry;
	}
	

    public function delete($id_mobilisateur) {
      $this->getDbTable()->delete(array('id_mobilisateur = ?' => $id_mobilisateur));
    }
        
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mobilisateur) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }


}

?>
