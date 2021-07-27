<?php

class Application_Model_EuFacturePrestationMapper   {

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
            $this->setDbTable('Application_Model_DbTable_EuFacturePrestation');
        }
        return $this->_dbTable;
    }
    
    public function find($id_facture_prestation, Application_Model_EuFacturePrestation $facture) {
        $result = $this->getDbTable()->find($id_facture_prestation);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $facture->setId_facture_prestation($row->id_facture_prestation)
		        ->setNumero_facture_prestation($row->numero_facture_prestation)
                ->setId_devis_prestation($row->id_devis_prestation)
	            ->setLibelle_facture_prestation($row->libelle_facture_prestation)
	            ->setMontant_facture_prestation($row->montant_facture_prestation)
	            ->setDate_facture_prestation($row->date_facture_prestation)
		        ->setVisa($row->visa)
				->setPayer($row->payer);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDevisPrestation();
            $entry->setId_facture_prestation($row->id_facture_prestation)
			      ->setNumero_facture_prestation($row->numero_facture_prestation)
                  ->setId_devis_prestation($row->id_devis_prestation)
	              ->setLibelle_facture_prestation($row->libelle_facture_prestation)
	              ->setMontant_facture_prestation($row->montant_facture_prestation)
	              ->setDate_facture_prestation($row->date_facture_prestation)
		          ->setVisa($row->visa)
				  ->setPayer($row->payer);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
    public function save(Application_Model_EuFacturePrestation $facture) {
        $data = array(
            'id_facture_prestation' => $facture->getId_facture_prestation(),
			'numero_facture_prestation' => $facture->getNumero_facture_prestation(),
            'id_devis_prestation' => $facture->getId_devis_prestation(),
            'libelle_facture_prestation' => $facture->getLibelle_facture_prestation(),
			'montant_facture_prestation' => $facture->getMontant_facture_prestation(),
            'date_facture_prestation' => $facture->getDate_facture_prestation(),
            'visa' => $facture->getVisa(),
			'payer' => $facture->getPayer()
        );
        $this->getDbTable()->insert($data);
    }
	
	

    public function update(Application_Model_EuFacturePrestation $facture) {
        $data = array(
            'id_facture_prestation' => $facture->getId_facture_prestation(),
			'numero_facture_prestation' => $facture->getNumero_facture_prestation(),
            'id_devis_prestation' => $facture->getId_devis_prestation(),
            'libelle_facture_prestation' => $facture->getLibelle_facture_prestation(),
			'montant_facture_prestation' => $facture->getMontant_facture_prestation(),
            'date_facture_prestation' => $facture->getDate_facture_prestation(),
            'visa' => $facture->getVisa(),
			'payer' => $facture->getPayer()
        );
        $this->getDbTable()->update($data, array('id_facture_prestation = ?' => $facture->getId_facture_prestation()));
    }
    
    public function delete($id_facture_prestation) {
        $this->getDbTable()->delete(array('id_facture_prestation = ?' => $id_facture_prestation));
    }

    public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_facture_prestation) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
}
?>