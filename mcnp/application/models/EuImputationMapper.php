<?php
 
class Application_Model_EuImputationMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuImputation');
        }
        return $this->_dbTable;
    }

	
    public function find($id_imputation, Application_Model_EuImputation $imputation)  {
        $result = $this->getDbTable()->find($id_imputation);
        if(count($result) == 0) {
            return false;
        }
		
        $row = $result->current();
        $imputation->setId_imputation($row->id_imputation)
                   ->setNum_compte_debit1($row->num_compte_debit1)
                   ->setNum_compte_credit1($row->num_compte_credit1)
				   ->setNum_compte_debit2($row->num_compte_debit2)
                   ->setNum_compte_credit2($row->num_compte_credit2)
                   ->setLibelle_imputation($row->libelle_imputation)
                   ->setMontant_imputation($row->montant_imputation)
		           ->setDate_imputation($row->date_imputation)
		           ->setDate_creation($row->date_creation)
		           ->setId_utilisateur($row->id_utilisateur)
		           ->setType_operation($row->type_operation)
			       ->setId_traitement($row->id_traitement);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuImputation();
            $entry->setId_imputation($row->id_imputation)
                  ->setNum_compte_debit1($row->num_compte_debit1)
                  ->setNum_compte_credit1($row->num_compte_credit1)
				  ->setNum_compte_debit2($row->num_compte_debit2)
                  ->setNum_compte_credit2($row->num_compte_credit2)
                  ->setLibelle_imputation($row->libelle_imputation)
                  ->setMontant_imputation($row->montant_imputation)
		          ->setDate_imputation($row->date_imputation)
		          ->setDate_creation($row->date_creation)
		          ->setId_utilisateur($row->id_utilisateur)
		          ->setType_operation($row->type_operation)
			      ->setId_traitement($row->id_traitement);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_imputation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuImputation $imputation) {
        $data = array(
           'id_imputation' => $imputation->getId_imputation(),
           'num_compte_debit1' => $imputation->getNum_compte_debit1(),
           'num_compte_credit1' => $imputation->getNum_compte_credit1(),
		   'num_compte_debit2' => $imputation->getNum_compte_debit2(),
           'num_compte_credit2' => $imputation->getNum_compte_credit2(),
	       'libelle_imputation' => strtoupper($imputation->getLibelle_imputation()),
	       'montant_imputation' => $imputation->getMontant_imputation(),
	       'date_imputation' => $imputation->getDate_imputation(),
		   'date_creation' => $imputation->getDate_creation(),
	       'id_utilisateur' => $imputation->getId_utilisateur(),
           'type_operation' => $imputation->getType_operation(),
		   'id_traitement' => $imputation->getId_traitement()
        );
        $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuImputation $imputation) {
        $data = array(
           'id_imputation' => $imputation->getId_imputation(),
           'num_compte_debit1' => $imputation->getNum_compte_debit1(),
           'num_compte_credit1' => $imputation->getNum_compte_credit1(),
		   'num_compte_debit2' => $imputation->getNum_compte_debit2(),
           'num_compte_credit2' => $imputation->getNum_compte_credit2(),
	       'libelle_imputation' => strtoupper($imputation->getLibelle_imputation()),
	       'montant_imputation' => $imputation->getMontant_imputation(),
	       'date_imputation' => $imputation->getDate_imputation(),
		   'date_creation' => $imputation->getDate_creation(),
	       'id_utilisateur' => $imputation->getId_utilisateur(),
           'type_operation' => $imputation->getType_operation(),
		   'id_traitement' => $imputation->getId_traitement()
        );
        $this->getDbTable()->update($data, array('id_imputation = ?' => $imputation->getId_imputation()));
    }
	

    public function delete($id_imputation) {
        $this->getDbTable()->delete(array('id_imputation = ?' => $id_imputation));
    }
    
}


?>
