<?php

class Application_Model_EuFormsBudgetNatureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFormsBudgetNature');
        }
        return $this->_dbTable;
    }

    public function find($id_forms_budget_nature, Application_Model_EuFormsBudgetNature $forms_budget_nature) {
       $result = $this->getDbTable()->find($id_forms_budget_nature);
       if(count($result) == 0) {
          return false;
       }
       $row = $result->current();
       $forms_budget_nature->setId_forms_budget_nature($row->id_forms_budget_nature)
                 ->setId_bps_vendu_achat_vente_reciproque($row->id_bps_vendu_achat_vente_reciproque)
                 ->setReference_type_budget($row->reference_type_budget)
                 ->setCode_membre_budget($row->code_membre_budget)
				 ->setType_budget($row->type_budget)
         ->setValid_budget($row->valid_budget)
         ->setRejet($row->rejet)
         ->setMontant_budget($row->montant_budget)
         ->setPayer($row->payer)
         ->setDate_budget($row->date_budget)
         ;   
	    return true;
	}
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFormsBudgetNature();
            $entry->setId_forms_budget_nature($row->id_forms_budget_nature)
                  ->setId_bps_vendu_achat_vente_reciproque($row->id_bps_vendu_achat_vente_reciproque)
                  ->setReference_type_budget($row->reference_type_budget)
                  ->setCode_membre_budget($row->code_membre_budget)
				  ->setType_budget($row->type_budget)
         ->setValid_budget($row->valid_budget)
         ->setRejet($row->rejet)
         ->setMontant_budget($row->montant_budget)
         ->setPayer($row->payer)
         ->setDate_budget($row->date_budget)
         ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function save(Application_Model_EuFormsBudgetNature $forms_budget_nature) {
        $data = array(
		    'id_forms_budget_nature' => $forms_budget_nature->getId_forms_budget_nature(),
			'id_bps_vendu_achat_vente_reciproque' => $forms_budget_nature->getId_bps_vendu_achat_vente_reciproque(),
            'reference_type_budget' => $forms_budget_nature->getReference_type_budget(),
            'code_membre_budget' => $forms_budget_nature->getCode_membre_budget(),
			'type_budget' => $forms_budget_nature->getType_budget(),
      'valid_budget' => $forms_budget_nature->getValid_budget(),
      'rejet' => $forms_budget_nature->getRejet(),
      'montant_budget' => $forms_budget_nature->getMontant_budget(),
      'payer' => $forms_budget_nature->getPayer(),
      'date_budget' => $forms_budget_nature->getDate_budget()
        );
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuFormsBudgetNature $forms_budget_nature) {
        $data = array(
          'id_forms_budget_nature' => $forms_budget_nature->getId_forms_budget_nature(),
		  'id_bps_vendu_achat_vente_reciproque' => $forms_budget_nature->getId_bps_vendu_achat_vente_reciproque(),
          'reference_type_budget' => $forms_budget_nature->getReference_type_budget(),
          'code_membre_budget' => $forms_budget_nature->getCode_membre_budget(),
		  'type_budget' => $forms_budget_nature->getType_budget(),
      'valid_budget' => $forms_budget_nature->getValid_budget(),
      'rejet' => $forms_budget_nature->getRejet(),
      'montant_budget' => $forms_budget_nature->getMontant_budget(),
      'payer' => $forms_budget_nature->getPayer(),
      'date_budget' => $forms_budget_nature->getDate_budget()
        );
        $this->getDbTable()->update($data, array('id_forms_budget_nature = ?' => $forms_budget_nature->getId_forms_budget_nature()));
    }
	

    public function delete($id_forms_budget_nature) {
        $this->getDbTable()->delete(array('id_forms_budget_nature = ?' => $id_forms_budget_nature));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_forms_budget_nature) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    ///////////////////////////////////////////////////////////////
  public  function fetchAllByCodeMembreTypeBudgetReference($code_membre_budget = "", $type_budget = "", $reference_type_budget = 0)  {
    $select = $this->getDbTable()->select();
    if($code_membre_budget != ""){
      $select->where("code_membre_budget like ? ", $code_membre_budget);
}
    if($type_budget != ""){
      $select->where("type_budget like ? ", $type_budget);
}
    if($reference_type_budget > 0){
      $select->where("reference_type_budget = ? ", $reference_type_budget);
}
      $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
      foreach($resultSet as $row) {
         $entry = new Application_Model_EuFormsBudgetNature();
       $entry->setId_forms_budget_nature($row->id_forms_budget_nature)
                 ->setId_bps_vendu_achat_vente_reciproque($row->id_bps_vendu_achat_vente_reciproque)
                 ->setReference_type_budget($row->reference_type_budget)
                 ->setCode_membre_budget($row->code_membre_budget)
         ->setType_budget($row->type_budget)
         ->setValid_budget($row->valid_budget)
         ->setRejet($row->rejet)
         ->setMontant_budget($row->montant_budget)
         ->setPayer($row->payer)
         ->setDate_budget($row->date_budget)
         ;
           $entries[] = $entry;
      }
    return $entries;
  }


}

?>
