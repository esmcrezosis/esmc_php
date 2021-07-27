<?php

class Application_Model_EuDevisPrestationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDevisPrestation');
        }
        return $this->_dbTable;
    }
    
    public function find($id_devis_prestation, Application_Model_EuDevisPrestation $devis) {
        $result = $this->getDbTable()->find($id_devis_prestation);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $devis->setId_devis_prestation($row->id_devis_prestation)
              ->setId_fiche_besoin($row->id_fiche_besoin)
	          ->setLibelle_devis_prestation($row->libelle_devis_prestation)
	          ->setMontant_devis_prestation($row->montant_devis_prestation)
	          ->setDate_devis_prestation($row->date_devis_prestation)
		      ->setCode_membre_fournisseur($row->code_membre_fournisseur)
			  ->setViser($row->viser);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDevisPrestation();
            $entry->setId_devis_prestation($row->id_devis_prestation)
                  ->setId_fiche_besoin($row->id_fiche_besoin)
	              ->setLibelle_devis_prestation($row->libelle_devis_prestation)
	              ->setMontant_devis_prestation($row->montant_devis_prestation)
	              ->setDate_devis_prestation($row->date_devis_prestation)
		          ->setCode_membre_fournisseur($row->code_membre_fournisseur)
				  ->setViser($row->viser);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuDevisPrestation $devis) {
        $data = array(
          'id_devis_prestation' => $devis->getId_devis_prestation(),
          'id_fiche_besoin' => $devis->getId_fiche_besoin(),
          'libelle_devis_prestation' => $devis->getLibelle_devis_prestation(),
		  'montant_devis_prestation' => $devis->getMontant_devis_prestation(),
          'date_devis_prestation' => $devis->getDate_devis_prestation(),
          'code_membre_fournisseur' => $devis->getCode_membre_fournisseur(),
		  'viser' => $devis->getViser()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDevisPrestation $devis) {
        $data = array(
          'id_devis_prestation' => $devis->getId_devis_prestation(),
          'id_fiche_besoin' => $devis->getId_fiche_besoin(),
          'libelle_devis_prestation' => $devis->getLibelle_devis_prestation(),
		  'montant_devis_prestation' => $devis->getMontant_devis_prestation(),
          'date_devis_prestation' => $devis->getDate_devis_prestation(),
          'code_membre_fournisseur' => $devis->getCode_membre_fournisseur(),
		  'viser' => $devis->getViser()
        );
        $this->getDbTable()->update($data, array('id_devis_prestation = ?' => $devis->getId_devis_prestation()));
    }
    
    public function delete($id_devis_prestation) {
        $this->getDbTable()->delete(array('id_devis_prestation = ?' => $id_devis_prestation));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_devis_prestation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>