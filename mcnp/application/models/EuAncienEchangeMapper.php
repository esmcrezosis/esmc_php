<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuEchangeMapper
 *
 * @author user
 */
class Application_Model_EuAncienEchangeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienEchange');
        }
        return $this->_dbTable;
    }

    public function find($id_echange, Application_Model_EuAncienEchange $echange) {
        $result = $this->getDbTable()->find($id_echange);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $echange->setId_echange($row->id_echange)
                ->setCode_membre($row->code_membre)
                ->setCode_compte_ech($row->code_compte_ech)
                ->setCode_compte_obt($row->code_compte_obt)
                ->setType_echange($row->type_echange)
                ->setMontant($row->montant)
                ->setMontant_echange($row->montant_echange)
                ->setAgio($row->agio)
                ->setDate_echange($row->date_echange)
                ->setId_utilisateur($row->id_utilisateur)
                ->setCat_echange($row->cat_echange)
                ->setRegler($row->regler)
                ->setDate_reglement($row->date_reglement)
                ->setId_credit($row->id_credit)
                ->setCode_produit($row->code_produit)
                ->setCompenser($row->compenser);
        return true;
    }
    
    public function getLastInsertId() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_echange) as id'));
        $row = $this->getDbTable()->fetchRow($select);
        return $row->id;
    }

    public function findEchangeByCredit($id_credit) {
        $select = $this->getDbTable()->select();
        $select->where('id_credit = ?', $id_credit);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        } else {
            $row = $result->current();
            $echange = new Application_Model_EuAncienEchange();
            $echange->setId_echange($row->id_echange)
                    ->setCode_membre($row->code_membre)
                    ->setCode_compte_ech($row->code_compte_ech)
                    ->setCode_compte_obt($row->code_compte_obt)
                    ->setType_echange($row->type_echange)
                    ->setMontant($row->montant)
                    ->setMontant_echange($row->montant_echange)
                    ->setAgio($row->agio)
                    ->setDate_echange($row->date_echange)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setCat_echange($row->cat_echange)
                    ->setRegler($row->regler)
                    ->setDate_reglement($row->date_reglement)
                    ->setId_credit($row->id_credit)
                    ->setCode_produit($row->code_produit)
                    ->setCompenser($row->compenser);
            return $echange;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienEchange();
            $entry->setId_echange($row->id_echange)
                    ->setCode_membre($row->code_membre)
                    ->setCode_compte_ech($row->code_compte_ech)
                    ->setCode_compte_obt($row->code_compte_obt)
                    ->setType_echange($row->type_echange)
                    ->setMontant($row->montant)
                    ->setMontant_echange($row->montant_echange)
                    ->setAgio($row->agio)
                    ->setDate_echange($row->date_echange)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setCat_echange($row->cat_echange)
                    ->setRegler($row->regler)
                    ->setDate_reglement($row->date_reglement)
                    ->setId_credit($row->id_credit)
                    ->setCode_produit($row->code_produit)
                    ->setCompenser($row->compenser);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuAncienEchange $echange) {
        $data = array(
            'id_echange' => $echange->getId_echange(),
            'code_membre' => $echange->getCode_membre(),
            'code_compte_ech' => $echange->getCode_compte_ech(),
            'code_compte_obt' => $echange->getCode_compte_obt(),
            'type_echange' => $echange->getType_echange(),
            'montant' => $echange->getMontant(),
            'montant_echange' => $echange->getMontant_echange(),
            'agio' => $echange->getAgio(),
            'date_echange' => $echange->getDate_echange(),
            'id_utilisateur' => $echange->getId_utilisateur(),
            'cat_echange' => $echange->getCat_echange(),
            'regler' => $echange->getRegler(),
            'date_reglement' => $echange->getDate_reglement(),
            'code_produit' => $echange->getCode_produit(),
            'id_credit' => $echange->getId_credit(),
            'compenser' => $echange->getCompenser()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienEchange $echange) {
        $data = array(
            'id_echange' => $echange->getId_echange(),
            'code_membre' => $echange->getCode_membre(),
            'code_compte_ech' => $echange->getCode_compte_ech(),
            'code_compte_obt' => $echange->getCode_compte_obt(),
            'type_echange' => $echange->getType_echange(),
            'montant' => $echange->getMontant(),
            'montant_echange' => $echange->getMontant_echange(),
            'agio' => $echange->getAgio(),
            'date_echange' => $echange->getDate_echange(),
            'id_utilisateur' => $echange->getId_utilisateur(),
            'cat_echange' => $echange->getCat_echange(),
            'regler' => $echange->getRegler(),
            'date_reglement' => $echange->getDate_reglement(),
            'code_produit' => $echange->getCode_produit(),
            'id_credit' => $echange->getId_credit(),
            'compenser' => $echange->getCompenser()
        );
        $this->getDbTable()->update($data, array('id_echange = ?' => $echange->getId_echange()));
    }

    public function delete($id_echange) {
        $this->getDbTable()->delete(array('id_echange = ?' => $id_echange));
    }




////////////////////////////////////////

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_echange) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

}

?>
