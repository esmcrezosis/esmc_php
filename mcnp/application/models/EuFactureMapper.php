<?php

class Application_Model_EuFactureMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFacture');
        }
        return $this->_dbTable;
    }

    public function find($code_facture, Application_Model_EuFacture $facture) {
        $result = $this->getDbTable()->find($code_facture);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $facture->setCode_facture($row->code_facture)
                ->setCode_commande($row->code_commande)
                ->setCode_membre_client($row->code_membre_client)
                ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                ->setDate_facture($row->date_facture)
                ->setEtat_facture($row->etat_facture)
                ->setMontant_ht($row->montant_ht)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_taxe($row->id_taxe)
        ;
    }

    public function findcom($code_facture) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_commande'));
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_commande'];
    }

    public function findtotal($code_facture) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('montant_ht'));
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['montant_ht'];
    }

    public function findnumfournis($code_facture) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_membre_fournisseur'));
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_membre_fournisseur'];
    }

    public function findnumclt($code_facture) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_membre_client'));
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_membre_client'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFacture();
            $entry->setCode_facture($row->code_facture)
                    ->setCode_commande($row->code_commande)
                    ->setCode_membre_client($row->code_membre_client)
                    ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                    ->setDate_facture($row->date_facture)
                    ->setEtat_facture($row->etat_facture)
                    ->setMontant_ht($row->montant_ht)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setId_taxe($row->id_taxe)
            ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuFacture $facture) {
        $data = array(
            'code_facture' => $facture->getCode_facture(),
            'code_commande' => $facture->getCode_commande(),
            'code_membre_client' => $facture->getCode_membre_client(),
            'code_membre_fournisseur' => $facture->getCode_membre_fournisseur(),
            'date_facture' => $facture->getDate_facture(),
            'etat_facture' => $facture->getEtat_facture(),
            'montant_ht' => $facture->getMontant_ht(),
            'id_utilisateur' => $facture->getId_utilisateur(),
            'id_taxe' => $facture->getId_taxe()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFacture $facture) {
        $data = array(
            'code_facture' => $facture->getCode_facture(),
            'code_commande' => $facture->getCode_commande(),
            'code_membre_client' => $facture->getCode_membre_client(),
            'code_membre_fournisseur' => $facture->getCode_membre_fournisseur(),
            'date_facture' => $facture->getDate_facture(),
            'etat_facture' => $facture->getEtat_facture(),
            'montant_ht' => $facture->getMontant_ht(),
            'id_utilisateur' => $facture->getId_utilisateur(),
            'id_taxe' => $facture->getId_taxe()
        );
        $this->getDbTable()->update($data, array('code_facture = ?' => $facture->getCode_facture()));
    }

    public function delete($code_facture) {
        $this->getDbTable()->delete(array('code_facture = ?' => $code_facture));
    }

}
?>

