<?php

class Application_Model_EuRecurrentJournalierMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRecurrentJournalier');
        }
        return $this->_dbTable;
    }

    public function find($id_recurrent_journalier, Application_Model_EuRecurrentJournalier $recurrent_journalier) {
        $result = $this->getDbTable()->find($id_recurrent_journalier);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $recurrent_journalier->setId_recurrent_journalier($row->id_recurrent_journalier)
                ->setId_type_produit($row->id_type_produit)
                ->setMontant_journalier($row->montant_journalier)
                ->setMontant_total($row->montant_total)
                ->setFrequence_cumul($row->frequence_cumul)
                ->setId_canton($row->id_canton)
                ->setCode_membre($row->code_membre)
                ->setDate_creation($row->date_creation)
                ->setDate_debut($row->date_debut)
                ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecurrentJournalier();
            $entry->setId_recurrent_journalier($row->id_recurrent_journalier)
                ->setId_type_produit($row->id_type_produit)
                ->setMontant_journalier($row->montant_journalier)
                ->setMontant_total($row->montant_total)
                ->setFrequence_cumul($row->frequence_cumul)
                ->setId_canton($row->id_canton)
                ->setCode_membre($row->code_membre)
                ->setDate_creation($row->date_creation)
                ->setDate_debut($row->date_debut)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_recurrent_journalier) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
    public function save(Application_Model_EuRecurrentJournalier $recurrent_journalier) {
        $data = array(
            'id_recurrent_journalier' => $recurrent_journalier->getId_recurrent_journalier(),
            'id_type_produit' => $recurrent_journalier->getId_type_produit(),
            'montant_journalier' => $recurrent_journalier->getMontant_journalier(),
            'montant_total' => $recurrent_journalier->getMontant_total(),
            'frequence_cumul' => $recurrent_journalier->getFrequence_cumul(),
            'id_canton' => $recurrent_journalier->getId_canton(),
            'code_membre' => $recurrent_journalier->getCode_membre(),
            'date_creation' => $recurrent_journalier->getDate_creation(),
            'date_debut' => $recurrent_journalier->getDate_debut()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRecurrentJournalier $recurrent_journalier) {
        $data = array(
            //'id_recurrent_journalier' => $recurrent_journalier->getId_recurrent_journalier(),
            'id_type_produit' => $recurrent_journalier->getId_type_produit(),
            'montant_journalier' => $recurrent_journalier->getMontant_journalier(),
            'montant_total' => $recurrent_journalier->getMontant_total(),
            'frequence_cumul' => $recurrent_journalier->getFrequence_cumul(),
            'id_canton' => $recurrent_journalier->getId_canton(),
            'code_membre' => $recurrent_journalier->getCode_membre(),
            'date_creation' => $recurrent_journalier->getDate_creation(),
            'date_debut' => $recurrent_journalier->getDate_debut()
        );
        $this->getDbTable()->update($data, array('id_recurrent_journalier = ?' => $recurrent_journalier->getId_recurrent_journalier()));
    }

    public function delete($id_recurrent_journalier) {
        $this->getDbTable()->delete(array('id_recurrent_journalier = ?' => $id_recurrent_journalier));
    }


    public function fetchAllByTypeProduitCantonCodeMembre($id_type_produit = 0, $id_canton = 0, $code_membre = "") {
        $select = $this->getDbTable()->select();
		if($id_type_produit > 0){
        $select->where("id_type_produit = ? ", $id_type_produit);    
        }
        if($id_canton > 0){
        $select->where("id_canton = ? ", $id_canton);    
        }
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);    
        }
        $select->order(array("date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRecurrentJournalier();
            $entry->setId_recurrent_journalier($row->id_recurrent_journalier)
                ->setId_type_produit($row->id_type_produit)
                ->setMontant_journalier($row->montant_journalier)
                ->setMontant_total($row->montant_total)
                ->setFrequence_cumul($row->frequence_cumul)
                ->setId_canton($row->id_canton)
                ->setCode_membre($row->code_membre)
                ->setDate_creation($row->date_creation)
                ->setDate_debut($row->date_debut)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	

	
}


?>
