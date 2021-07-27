<?php

class Application_Model_EuTarifLivraisonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTarifLivraison');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTarifLivraison $tariflivraison) {
        $data = array(
            'id_tarif_livraison' => $tariflivraison->getId_tarif_livraison(),
            'code_zone' => $tariflivraison->getCode_zone(),
            'id_pays' => $tariflivraison->getId_pays(),
            'id_region' => $tariflivraison->getId_region(),
            'id_prefecture' => $tariflivraison->getId_prefecture(),
            'montant_tarif_livraison' => $tariflivraison->getMontant_tarif_livraison(),
            'statut' => $tariflivraison->getStatut(),
            'code_membre' => $tariflivraison->getCode_membre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTarifLivraison $tariflivraison) {
        $data = array(
            //'id_tarif_livraison' => $tariflivraison->getId_tarif_livraison(),
            'code_zone' => $tariflivraison->getCode_zone(),
            'id_pays' => $tariflivraison->getId_pays(),
            'id_region' => $tariflivraison->getId_region(),
            'id_prefecture' => $tariflivraison->getId_prefecture(),
            'montant_tarif_livraison' => $tariflivraison->getMontant_tarif_livraison(),
            'statut' => $tariflivraison->getStatut(),
            'code_membre' => $tariflivraison->getCode_membre()
        );
        $this->getDbTable()->update($data, array('id_tarif_livraison = ?' => $tariflivraison->getId_tarif_livraison()));
    }

    public function find($id_tarif_livraison, Application_Model_EuTarifLivraison $tariflivraison) {
        $result = $this->getDbTable()->find($id_tarif_livraison);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $tariflivraison->setId_tarif_livraison($row->id_tarif_livraison)
                      ->setCode_membre($row->code_membre)
                      ->setCode_zone($row->code_zone)
                      ->setId_pays($row->id_pays)
                      ->setId_region($row->id_region)
                      ->setId_prefecture($row->id_prefecture)
                      ->setMontant_tarif_livraison($row->montant_tarif_livraison)
                      ->setStatut($row->statut);                      
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTarifLivraison();
            $entry->setId_tarif_livraison($row->id_tarif_livraison)
                      ->setCode_membre($row->code_membre)
                      ->setCode_zone($row->code_zone)
                      ->setId_pays($row->id_pays)
                      ->setId_region($row->id_region)
                      ->setId_prefecture($row->id_prefecture)
                      ->setMontant_tarif_livraison($row->montant_tarif_livraison)
                      ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_tarif_livraison) {
        $this->getDbTable()->delete(array('id_tarif_livraison' => $id_tarif_livraison));
    }


    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tarif_livraison) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }




    
    public function fetchAllByVendeur($code_membre_morale = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_morale != ""){
        $select->where("code_membre = ? ", $code_membre_morale);
    }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTarifLivraison();
            $entry->setId_tarif_livraison($row->id_tarif_livraison)
                      ->setCode_membre($row->code_membre)
                      ->setCode_zone($row->code_zone)
                      ->setId_pays($row->id_pays)
                      ->setId_region($row->id_region)
                      ->setId_prefecture($row->id_prefecture)
                      ->setMontant_tarif_livraison($row->montant_tarif_livraison)
                      ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }


    
    public function fetchAllByVendeur1($code_membre_morale = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_morale != ""){
        $select->where("code_membre = ? ", $code_membre_morale);
    }
        $select->where("statut = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTarifLivraison();
            $entry->setId_tarif_livraison($row->id_tarif_livraison)
                      ->setCode_membre($row->code_membre)
                      ->setCode_zone($row->code_zone)
                      ->setId_pays($row->id_pays)
                      ->setId_region($row->id_region)
                      ->setId_prefecture($row->id_prefecture)
                      ->setMontant_tarif_livraison($row->montant_tarif_livraison)
                      ->setStatut($row->statut);
            $entries[] = $entry;
        }
        return $entries;
    }




}