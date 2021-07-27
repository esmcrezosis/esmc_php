<?php

class Application_Model_EuProformaMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuProforma');
        }
        return $this->_dbTable;
    }
    public function find($code_proforma, Application_Model_EuProforma $proforma) {
        $result = $this->getDbTable()->find($code_proforma);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $proforma->setCode_proforma($row->code_proforma)
                 ->setDate_proforma($row->date_proforma)
                 ->setDate_livre($row->date_livre)
                 ->setLieu_livre($row->lieu_livre)
                 ->setDelai_valid($row->delai_valid)
                 ->setDate_paie($row->date_paie)
                 ->setMontant_ht($row->montant_ht)
                 ->setId_besoin($row->id_besoin)
                 ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                 ->setId_utilisateur($row->id_utilisateur)
                 ->setType_proforma($row->type_proforma)
				 ->setId_taxe($row->id_taxe);    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProforma();
            $entry->setCode_proforma($row->code_proforma)
                  ->setDate_proforma($row->date_proforma)
                  ->setDate_livre($row->date_livre)
                  ->setLieu_livre($row->lieu_livre)
                  ->setDelai_valid($row->delai_valid)
                  ->setDate_paie($row->date_paie)
                  ->setMontant_ht($row->montant_ht)
                  ->setId_besoin($row->id_besoin)
                  ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setType_proforma($row->type_proforma)
				  ->setId_taxe($row->id_taxe);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuProforma $proforma){
        $data = array(
            'code_proforma' => $proforma->getCode_proforma(),
            'date_proforma' => $proforma->getDate_proforma(),
            'date_livre' => $proforma->getDate_livre(),
            'lieu_livre' => $proforma->getLieu_livre(),
            'delai_valid' => $proforma->getDelai_valid(),
            'date_paie' => $proforma->getDate_paie(),
            'montant_ht' => $proforma->getMontant_ht(),
            'id_besoin' => $proforma->getId_besoin(),
            'code_membre_fournisseur' => $proforma->getCode_membre_fournisseur(),
            'id_utilisateur' => $proforma->getId_utilisateur(),
            'type_proforma' => $proforma->getType_proforma(),
			'id_taxe' => $proforma->getId_taxe(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProforma $proforma) {
        $data = array(
            'code_proforma' => $proforma->getCode_proforma(),
            'date_proforma' => $proforma->getDate_proforma(),
            'date_livre' => $proforma->getDate_livre(),
            'lieu_livre' => $proforma->getLieu_livre(),
            'delai_valid' => $proforma->getDelai_valid(),
            'date_paie' => $proforma->getDate_paie(),
            'montant_ht' => $proforma->getMontant_ht(),
            'id_besoin' => $proforma->getId_besoin(),
            'code_membre_fournisseur' => $proforma->getCode_membre_fournisseur(),
            'id_utilisateur' => $proforma->getId_utilisateur(),
            'type_proforma' => $proforma->getType_proforma(),
			'id_taxe' => $proforma->getId_taxe(),
        );

        $this->getDbTable()->update($data, array('code_proforma = ?' => $proforma->getCode_proforma()));
    }
    
    public function delete($code_proforma) {
        $this->getDbTable()->delete(array('code_proforma = ?' => $code_proforma));
    }
    
}
