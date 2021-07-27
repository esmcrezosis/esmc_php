<?php
 
class Application_Model_EuChargePayeMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuChargePaye');
        }
        return $this->_dbTable;
    }
	
    public function find($id_charge_paye, Application_Model_EuChargePaye $charge)  {
        $result = $this->getDbTable()->find($id_charge_paye);
        if(count($result) == 0) {
          return false;
        }
		
        $row = $result->current();
        $charge->setId_charge_paye($row->id_charge_paye)
               ->setDate_charge($row->date_charge)
               ->setId_charge($row->id_charge)
               ->setLibelle_charge($row->libelle_charge)
               ->setMontant_charge($row->montant_charge)
		       ->setType_doc($row->type_doc)
		       ->setNum_doc($row->num_doc)
		       ->setCode_smcipn($row->code_smcipn)
		       ->setCode_membre_creancier($row->code_membre_creancier)
		       ->setCode_membre_debiteur($row->code_membre_debiteur)
			   ->setOrigine_charge($row->origine_charge);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuChargePaye();
            $entry->setId_charge_paye($row->id_charge_paye)
                  ->setDate_charge($row->date_charge)
                  ->setId_charge($row->id_charge)
                  ->setLibelle_charge($row->libelle_charge)
                  ->setMontant_charge($row->montant_charge)
		          ->setType_doc($row->type_doc)
		          ->setNum_doc($row->num_doc)
		          ->setCode_smcipn($row->code_smcipn)
		          ->setCode_membre_creancier($row->code_membre_creancier)
		          ->setCode_membre_debiteur($row->code_membre_debiteur)
			      ->setOrigine_charge($row->origine_charge);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_charge_paye) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuChargePaye $charge) {
        $data = array(
            'id_charge_paye' => $charge->getId_charge_paye(),
            'date_charge' => $charge->getDate_charge(),
            'id_charge' => $charge->getId_charge(),
	        'libelle_charge' => $charge->getLibelle_charge(),
	        'montant_charge' => $charge->getMontant_charge(),
			'type_doc' => $charge->getType_doc(),
	        'num_doc' => $charge->getNum_doc(),
	        'code_smcipn' => $charge->getCode_smcipn(),
	        'code_membre_creancier' => $charge->getCode_membre_creancier(),
            'code_membre_debiteur' => $charge->getCode_membre_debiteur(),
			'origine_charge' => $charge->getOrigine_charge()
        );
        $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuChargePaye $charge) {
        $data = array(
            'id_charge_paye' => $charge->getId_charge_paye(),
            'date_charge' => $charge->getDate_charge(),
            'id_charge' => $charge->getId_charge(),
	        'libelle_charge' => $charge->getLibelle_charge(),
	        'montant_charge' => $charge->getMontant_charge(),
			'type_doc' => $charge->getType_doc(),
	        'num_doc' => $charge->getNum_doc(),
	        'code_smcipn' => $charge->getCode_smcipn(),
	        'code_membre_creancier' => $charge->getCode_membre_creancier(),
            'code_membre_debiteur' => $charge->getCode_membre_debiteur(),
			'origine_charge' => $charge->getOrigine_charge()
        );
        $this->getDbTable()->update($data, array('id_charge_paye = ?' => $charge->getId_charge_paye()));
    }
	

    public function delete($id_charge_paye) {
        $this->getDbTable()->delete(array('id_charge_paye = ?' => $id_charge_paye));
    }
    

}


?>
