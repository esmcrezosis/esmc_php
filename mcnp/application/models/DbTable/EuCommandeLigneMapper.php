<?php

class Application_Model_EuCommandeLigneMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCommandeLigne');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCommandeLigne $commandeligne) {
        $data = array(
            'id_commande_ligne' => $commandeligne->getId_commande_ligne(),
            'code_commande_ligne' => $commandeligne->getCode_commande_ligne(),
            'date_commande_ligne' => $commandeligne->getDate_commande_ligne(),
            'montant_commande_ligne' => $commandeligne->getMontant_commande_ligne(),
            'code_membre' => $commandeligne->getCode_membre(),
            'code_zone' => $commandeligne->getCode_zone(),
            'id_pays' => $commandeligne->getId_pays(),
            'id_region' => $commandeligne->getId_region(),
            'id_prefecture' => $commandeligne->getId_prefecture(),
            'mode_livraison' => $commandeligne->getMode_livraison(),
            'statut' => $commandeligne->getStatut(),
            'montant_livraison' => $commandeligne->getMontant_livraison());

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCommandeLigne $commandeligne) {
        $data = array(
            'id_commande_ligne' => $commandeligne->getId_commande_ligne(),
            'code_commande_ligne' => $commandeligne->getCode_commande_ligne(),
            'date_commande_ligne' => $commandeligne->getDate_commande_ligne(),
            'montant_commande_ligne' => $commandeligne->getMontant_commande_ligne(),
            'code_membre' => $commandeligne->getCode_membre(),
            'code_zone' => $commandeligne->getCode_zone(),
            'id_pays' => $commandeligne->getId_pays(),
            'id_region' => $commandeligne->getId_region(),
            'id_prefecture' => $commandeligne->getId_prefecture(),
            'mode_livraison' => $commandeligne->getMode_livraison(),
            'statut' => $commandeligne->getStatut(),
            'montant_livraison' => $commandeligne->getMontant_livraison()
        );
        $this->getDbTable()->update($data, array('id_commande_ligne' => $commandeligne->getId_commande_ligne()));
    }

    public function find($commande_livraison, Application_Model_EuCommandeLigne $commandeligne) {
        $result = $this->getDbTable()->find($commande_livraison);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $commandeligne->setId_commande_ligne($row->id_commande_ligne)
                      ->setCode_commande_ligne($row->code_commande_ligne)
                      ->setDate_commande_ligne($row->date_commande_ligne)
                      ->setMontant_commande_ligne($row->montant_commande_ligne)
                      ->setCode_membre($row->code_membre)
                      ->setCode_zone($row->code_zone)
                      ->setId_pays($row->id_pays)
                      ->setId_region($row->id_region)
                      ->setId_prefecture($row->id_prefecture)
                      ->setMode_livraison($row->mode_livraison)
                      ->setStatut($row->statut)
                      ->setMontant_livraison($row->montant_livraison);
                      
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Application_Model_EuCommandeLigne();
            $entry->setId_commande_ligne($row->id_commande_ligne)
                      ->setCode_commande_ligne($row->code_commande_ligne)
                      ->setDate_commande_ligne($row->date_commande_ligne)
                      ->setMontant_commande_ligne($row->montant_commande_ligne)
                      ->setCode_membre($row->code_membre)
                      ->setCode_zone($row->code_zone)
                      ->setId_pays($row->id_pays)
                      ->setId_region($row->id_region)
                      ->setId_prefecture($row->id_prefecture)
                      ->setMode_livraison($row->mode_livraison)
                      ->setStatut($row->statut)
                      ->setMontant_livraison($row->montant_livraison);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_commande_ligne) {
        $this->getDbTable()->delete(array('id_commande_ligne = ?' => $id_commande_ligne));
    }


    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_commande_ligne) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }





}