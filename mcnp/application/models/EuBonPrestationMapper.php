<?php

class Application_Model_EuBonPrestationMapper {

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
         $this->setDbTable('Application_Model_DbTable_EuBonPrestation');
       }
       return $this->_dbTable;
   }
	
	

    
    public function find($id_bon_prestation, Application_Model_EuBonPrestation $bon) {
        $result = $this->getDbTable()->find($id_bon_prestation);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $bon->setId_bon_prestation($row->id_bon_prestation)
            ->setId_devis_prestation($row->id_devis_prestation)
	        ->setLibelle_bon_prestation($row->libelle_bon_prestation)
	        ->setMontant_bon_prestation($row->montant_bon_prestation)
	        ->setDate_bon_prestation($row->date_bon_prestation)
		    ->setVisa($row->visa);    
    }
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDevisPrestation();
            $entry->setId_bon_prestation($row->id_bon_prestation)
                  ->setId_devis_prestation($row->id_devis_prestation)
	              ->setLibelle_bon_prestation($row->libelle_bon_prestation)
	              ->setMontant_bon_prestation($row->montant_bon_prestation)
	              ->setDate_bon_prestation($row->date_bon_prestation)
		          ->setVisa($row->visa);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function save(Application_Model_EuBonPrestation $bon) {
        $data = array(
            'id_bon_prestation' => $bon->getId_bon_prestation(),
            'id_devis_prestation' => $bon->getId_devis_prestation(),
            'libelle_bon_prestation' => $bon->getLibelle_bon_prestation(),
			'montant_bon_prestation' => $bon->getMontant_bon_prestation(),
            'date_bon_prestation' => $bon->getDate_bon_prestation(),
            'visa' => $bon->getVisa()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonPrestation $bon) {
        $data = array(
          'id_bon_prestation' => $bon->getId_bon_prestation(),
          'id_devis_prestation' => $bon->getId_devis_prestation(),
          'libelle_bon_prestation' => $bon->getLibelle_bon_prestation(),
	      'montant_bon_prestation' => $bon->getMontant_bon_prestation(),
          'date_bon_prestation' => $bon->getDate_bon_prestation(),
          'visa' => $bon->getVisa()
        );
        $this->getDbTable()->update($data, array('id_bon_prestation = ?' => $bon->getId_bon_prestation()));
    }
    
    public function delete($id_bon_prestation) {
        $this->getDbTable()->delete(array('id_bon_prestation = ?' => $id_bon_prestation));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_bon_prestation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>