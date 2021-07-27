<?php

class Application_Model_EuFicheSuiviMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFicheSuivi');
        }
        return $this->_dbTable;
    }
    
    public function find($id_fiche_suivi, Application_Model_EuFicheSuivi $fichesuivi) {
        $result = $this->getDbTable()->find($id_fiche_besoin);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $fichesuivi->setId_fiche_suivi($row->id_fiche_suivi)
		           ->setLibelle_fiche_suivi($row->libelle_fiche_suivi)
                    ->setId_facture_prestation($row->id_facture_prestation)
	                ->setId_fiche_besoin($row->id_fiche_besoin)
	                ->setDate_fiche_suivi($row->date_fiche_suivi);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFicheBesoin();
            $entry->setId_fiche_suivi($row->id_fiche_suivi)
		          ->setLibelle_fiche_suivi($row->libelle_fiche_suivi)
                  ->setId_facture_prestation($row->id_facture_prestation)
	              ->setId_fiche_besoin($row->id_fiche_besoin)
	              ->setDate_fiche_suivi($row->date_fiche_suivi);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuFicheSuivi $fichesuivi) {
        $data = array(
          'id_fiche_suivi' => $fichesuivi->getId_fiche_suivi(),
          'libelle_fiche_suivi' => $fichesuivi->getLibelle_fiche_suivi(),
          'id_facture_prestation' => $fichesuivi->getId_facture_prestation(),
		  'id_fiche_besoin' => $fichesuivi->getId_fiche_besoin(),
          'date_fiche_suivi' => $fichesuivi->getDate_fiche_suivi()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFicheSuivi $fichesuivi) {
        $data = array(
          'id_fiche_suivi' => $fichesuivi->getId_fiche_suivi(),
          'libelle_fiche_suivi' => $fichesuivi->getLibelle_fiche_suivi(),
          'id_facture_prestation' => $fichesuivi->getId_facture_prestation(),
		  'id_fiche_besoin' => $fichesuivi->getId_fiche_besoin(),
          'date_fiche_suivi' => $fichesuivi->getDate_fiche_suivi()
        );
        $this->getDbTable()->update($data, array('id_fiche_suivi = ?' => $fichesuivi->getId_fiche_suivi()));
    }
    
    public function delete($id_fiche_besoin) {
      $this->getDbTable()->delete(array('id_fiche_besoin = ?' => $id_fiche_besoin));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fiche_suivi) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>