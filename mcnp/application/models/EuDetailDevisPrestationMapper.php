<?php

class Application_Model_EuDetailDevisPrestationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailDevisPrestation');
        }
        return $this->_dbTable;
    }

    
    public function find($id_detail_devis_prestation, Application_Model_EuDetailDevisPrestation $ddevis) {
        $result = $this->getDbTable()->find($id_detail_devis_prestation);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $ddevis->setId_detail_devis_prestation($row->id_detail_devis_prestation)
               ->setId_devis_prestation($row->id_devis_prestation)
	           ->setDesignation_article($row->designation_article)
	           ->setQuantite($row->quantite)
	           ->setPrix_unitaire($row->prix_unitaire)
		       ->setDesignation_prestation($row->designation_prestation)
			   ->setMontant_total($row->montant_total)
			   ->setApprouver($row->approuver);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDetailDevisPrestation();
            $entry->setId_detail_devis_prestation($row->id_detail_devis_prestation)
                  ->setId_devis_prestation($row->id_devis_prestation)
	              ->setDesignation_article($row->designation_article)
	              ->setQuantite($row->quantite)
	              ->setPrix_unitaire($row->prix_unitaire)
		          ->setDesignation_prestation($row->designation_prestation)
			      ->setMontant_total($row->montant_total)
				  ->setApprouver($row->approuver);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuDetailDevisPrestation $ddevis) {
      $data = array(
        'id_detail_devis_prestation' => $ddevis->getId_detail_devis_prestation(),
        'id_devis_prestation' => $ddevis->getId_devis_prestation(),
        'designation_article' => $ddevis->getDesignation_article(),
	    'quantite' => $ddevis->getQuantite(),
        'prix_unitaire' => $ddevis->getPrix_unitaire(),
	    'designation_prestation' => $ddevis->getDesignation_prestation(),
        'montant_total' => $ddevis->getMontant_total(),
	    'approuver' => $ddevis->getApprouver()
      );
      $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailDevisPrestation $ddevis) {
        $data = array(
            'id_detail_devis_prestation' => $ddevis->getId_detail_devis_prestation(),
            'id_devis_prestation' => $ddevis->getId_devis_prestation(),
            'designation_article' => $ddevis->getDesignation_article(),
			'quantite' => $ddevis->getQuantite(),
            'prix_unitaire' => $ddevis->getPrix_unitaire(),
			'designation_prestation' => $ddevis->getDesignation_prestation(),
            'montant_total' => $ddevis->getMontant_total(),
			'approuver' => $ddevis->getApprouver()
        );
        $this->getDbTable()->update($data, array('id_detail_devis_prestation = ?' => $ddevis->getId_detail_devis_prestation()));
    }
    
    public function delete($id_detail_devis_prestation) {
        $this->getDbTable()->delete(array('id_detail_devis_prestation = ?' => $id_detail_devis_prestation));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_devis_prestation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>