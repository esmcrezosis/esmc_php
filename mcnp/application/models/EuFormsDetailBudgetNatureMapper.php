<?php

class Application_Model_EuFormsDetailBudgetNatureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFormsDetailBudgetNature');
        }
        return $this->_dbTable;
    }

    public function find($id_forms_detail_budget_nature, Application_Model_EuFormsDetailBudgetNature $forms_detail_budget_nature) {
       $result = $this->getDbTable()->find($id_forms_detail_budget_nature);
       if(count($result) == 0) {
          return false;
       }
       $row = $result->current();
       $forms_detail_budget_nature->setId_forms_detail_budget_nature($row->id_forms_detail_budget_nature)
                 ->setId_forms_budget_nature($row->id_forms_budget_nature)
                 ->setBps_demande($row->bps_demande)
                 ->setQte_budget_nature($row->qte_budget_nature)
                 ->setPrix_unitaire_budget_nature($row->prix_unitaire_budget_nature)
                 ->setDisponible_budget_nature($row->disponible_budget_nature)
				 ->setTotal_budget_nature($row->total_budget_nature);   
	    return true;
	}
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFormsDetailBudgetNature();
            $entry->setId_forms_detail_budget_nature($row->id_forms_detail_budget_nature)
                  ->setId_forms_budget_nature($row->id_forms_budget_nature)
                  ->setBps_demande($row->bps_demande)
                  ->setQte_budget_nature($row->qte_budget_nature)
                  ->setPrix_unitaire_budget_nature($row->prix_unitaire_budget_nature)
                  ->setDisponible_budget_nature($row->disponible_budget_nature)
				  ->setTotal_budget_nature($row->total_budget_nature);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	

    public function save(Application_Model_EuFormsDetailBudgetNature $forms_detail_budget_nature) {
        $data = array(
		    'id_forms_detail_budget_nature' => $forms_detail_budget_nature->getId_forms_detail_budget_nature(),
			'id_forms_budget_nature' => $forms_detail_budget_nature->getId_forms_budget_nature(),
            'bps_demande' => $forms_detail_budget_nature->getBps_demande(),
            'qte_budget_nature' => $forms_detail_budget_nature->getQte_budget_nature(),
            'prix_unitaire_budget_nature' => $forms_detail_budget_nature->getPrix_unitaire_budget_nature(),
		    'disponible_budget_nature' => $forms_detail_budget_nature->getDisponible_budget_nature(),
			'total_budget_nature' => $forms_detail_budget_nature->getTotal_budget_nature()
        );
        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuFormsDetailBudgetNature $forms_detail_budget_nature) {
        $data = array(
          'id_forms_detail_budget_nature' => $forms_detail_budget_nature->getId_forms_detail_budget_nature(),
		  'id_forms_budget_nature' => $forms_detail_budget_nature->getId_forms_budget_nature(),
          'bps_demande' => $forms_detail_budget_nature->getBps_demande(),
          'qte_budget_nature' => $forms_detail_budget_nature->getQte_budget_nature(),
          'prix_unitaire_budget_nature' => $forms_detail_budget_nature->getPrix_unitaire_budget_nature(),
		  'disponible_budget_nature' => $forms_detail_budget_nature->getDisponible_budget_nature(),
		  'total_budget_nature' => $forms_detail_budget_nature->getTotal_budget_nature()
        );
        $this->getDbTable()->update($data, array('id_forms_detail_budget_nature = ?' => $forms_detail_budget_nature->getId_forms_detail_budget_nature()));
    }
	

    public function delete($id_forms_detail_budget_nature) {
        $this->getDbTable()->delete(array('id_forms_detail_budget_nature = ?' => $id_forms_detail_budget_nature));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_forms_detail_budget_nature) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////
  public  function fetchAllByTypeBudgetReference($id_forms_budget_nature = 0, $disponible_budget_nature = 0)  {
    $select = $this->getDbTable()->select();
    if($id_forms_budget_nature > 0){
      $select->where("id_forms_budget_nature = ? ", $id_forms_budget_nature);
}
    if($disponible_budget_nature > 0){
      $select->where("disponible_budget_nature = ? ", $disponible_budget_nature);
}
      $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
      foreach($resultSet as $row) {
         $entry = new Application_Model_EuFormsDetailBudgetNature();
            $entry->setId_forms_detail_budget_nature($row->id_forms_detail_budget_nature)
                  ->setId_forms_budget_nature($row->id_forms_budget_nature)
                  ->setBps_demande($row->bps_demande)
                  ->setQte_budget_nature($row->qte_budget_nature)
                  ->setPrix_unitaire_budget_nature($row->prix_unitaire_budget_nature)
                  ->setDisponible_budget_nature($row->disponible_budget_nature)
          ->setTotal_budget_nature($row->total_budget_nature);
           $entries[] = $entry;
      }
    return $entries;
  }

}

?>
