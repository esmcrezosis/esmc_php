<?php

class Application_Model_EuBonLivraisonPrestationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonLivraisonPrestation');
        }
        return $this->_dbTable;
    }
    
    public function find($id_bon_livraison_prestation, Application_Model_EuBonLivraisonPrestation $livraison) {
        $result = $this->getDbTable()->find($id_bon_livraison_prestation);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $livraison->setId_bon_livraison_prestation($row->id_bon_livraison_prestation)
                  ->setId_devis_prestation($row->id_devis_prestation)
	              ->setLibelle_bon_livraison($row->libelle_bon_livraison)
	              ->setMontant_bon_livraison($row->montant_bon_livraison)
	              ->setDate_bon_livraison($row->date_bon_livraison)
		          ->setVisa($row->visa);    
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuBonLivraisonPrestation();
            $entry->setId_bon_livraison_prestation($row->id_bon_livraison_prestation)
                  ->setId_devis_prestation($row->id_devis_prestation)
	              ->setLibelle_bon_livraison($row->libelle_bon_livraison)
	              ->setMontant_bon_livraison($row->montant_bon_livraison)
	              ->setDate_bon_livraison($row->date_bon_livraison)
		          ->setVisa($row->visa);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuBonLivraisonPrestation $livraison) {
        $data = array(
            'id_bon_livraison_prestation' => $livraison->getId_bon_livraison_prestation(),
            'id_devis_prestation' => $livraison->getId_devis_prestation(),
            'libelle_bon_livraison' => $livraison->getLibelle_bon_livraison(),
			'montant_bon_livraison' => $livraison->getMontant_bon_livraison(),
            'date_bon_livraison' => $livraison->getDate_bon_livraison(),
            'visa' => $livraison->getVisa()
        );
        $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuBonLivraisonPrestation $livraison) {
        $data = array(
          'id_bon_livraison_prestation' => $livraison->getId_bon_livraison_prestation(),
          'id_devis_prestation' => $livraison->getId_devis_prestation(),
          'libelle_bon_livraison' => $livraison->getLibelle_bon_livraison(),
	      'montant_bon_livraison' => $livraison->getMontant_bon_livraison(),
          'date_bon_livraison' => $livraison->getDate_bon_livraison(),
          'visa' => $livraison->getVisa()
        );
        $this->getDbTable()->update($data, array('id_bon_livraison_prestation = ?' => $livraison->getId_bon_livraison_prestation()));
    }
    
    public function delete($id_bon_livraison_prestation) {
        $this->getDbTable()->delete(array('id_bon_livraison_prestation = ?' => $id_bon_livraison_prestation));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_bon_livraison_prestation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>