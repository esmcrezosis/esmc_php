<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuOperationMapper
 *
 * @author user
 */
class Application_Model_EuCapaTsMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCapaTs');
        }
        return $this->_dbTable;
    }

    public function find($code_capa, Application_Model_EuCapaTs $capa) {
        $result = $this->getDbTable()->find($code_capa);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $capa->setCode_capa($row->code_capa)
                ->setId_operation($row->id_operation)
                ->setDate_capa($row->date_capa)
                ->setMontant($row->montant)
                ->setMontant_utiliser($row->montant_utiliser)
                ->setMontant_solde($row->montant_solde)
                ->setCode_membre($row->code_membre)
                ->setType_capa($row->type_capa)
                ->setCode_compte($row->code_compte)
                ->setEtat_capa($row->etat_capa)
                ->setCode_produit($row->code_produit)
                ->setOrigine_capa($row->origine_capa);
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_capa) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCapaTs();
            $entry->setCode_capa($row->code_capa)
                    ->setId_operation($row->id_operation)
                    ->setDate_capa($row->date_capa)
                    ->setMontant($row->montant)
					->setMontant_utiliser($row->montant_utiliser)
					->setMontant_solde($row->montant_solde)
                    ->setCode_membre($row->code_membre)
                    ->setType_capa($row->type_capa)
                    ->setCode_compte($row->code_compte)
                    ->setEtat_capa($row->etat_capa)
                    ->setCode_produit($row->code_produit)
                    ->setOrigine_capa($row->origine_capa);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByUser($user) {
        $select = $this->getDbTable()->select();
        $select->where('id_operation = ?', $user)
                ->order('date_capa', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCapaTs();
            $entry->setCode_capa($row->code_capa)
                    ->setId_operation($row->id_operation)
                    ->setDate_capa($row->date_capa)
                    ->setMontant($row->montant)
					->setMontant_utiliser($row->montant_utiliser)
					->setMontant_solde($row->montant_solde)
                    ->setCode_membre($row->code_membre)
                    ->setType_capa($row->type_capa)
                    ->setCode_compte($row->code_compte)
                    ->setEtat_capa($row->etat_capa)
                    ->setCode_produit($row->code_produit)
                    ->setOrigine_capa($row->origine_capa);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByDate($date) {
        $select = $this->getDbTable()->select();
        $select->where('date_capa=?', $date)
                ->order('date_capa', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCapaTs();
            $entry->setCode_capa($row->code_capa)
                    ->setId_operation($row->id_operation)
                    ->setDate_capa($row->date_capa)
                    ->setMontant($row->montant)
					->setMontant_utiliser($row->montant_utiliser)
					->setMontant_solde($row->montant_solde)
                    ->setCode_membre($row->code_membre)
                    ->setType_capa($row->type_capa)
                    ->setCode_compte($row->code_compte)
                    ->setEtat_capa($row->etat_capa)
                    ->setCode_produit($row->code_produit)
                    ->setOrigine_capa($row->origine_capa);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumRPG($num_membre, $type_capa) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_op) as somme'));
        $select->where('code_membre = ?', $num_membre);
        $select->where('type_capa = ?', $type_capa);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function getSumQuotaRPG($num_membre, $type_capa, $produit) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_capa) as somme'));
        $select->where('code_membre = ?', $num_membre);
        $select->where('type_capa = ?', $type_capa)
                ->where('code_produit = ?', $produit);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuCapaTs $capa) {
        $data = array(
            'code_capa' => $capa->getCode_capa(),
            'id_operation' => $capa->getId_operation(),
            'date_capa' => $capa->getDate_capa(),
            'montant' => $capa->getMontant(),
            'montant_utiliser' => $capa->getMontant_utiliser(),
            'montant_solde' => $capa->getMontant_solde(),
            'code_membre' => $capa->getCode_membre(),
            'type_capa' => $capa->getType_capa(),
            'code_compte' => $capa->getCode_compte(),
            'etat_capa' => $capa->getEtat_capa(),
            'code_produit' => $capa->getCode_produit(),
            'origine_capa' => $capa->getOrigine_capa()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCapaTs $capa) {
        $data = array(
            'code_capa' => $capa->getCode_capa(),
            'id_operation' => $capa->getId_operation(),
            'date_capa' => $capa->getDate_capa(),
            'montant' => $capa->getMontant(),
            'montant_utiliser' => $capa->getMontant_utiliser(),
            'montant_solde' => $capa->getMontant_solde(),
            'code_membre' => $capa->getCode_membre(),
            'type_capa' => $capa->getType_capa(),
            'code_compte' => $capa->getCode_compte(),
            'etat_capa' => $capa->getEtat_capa(),
            'code_produit' => $capa->getCode_produit(),
            'origine_capa' => $capa->getOrigine_capa()
        );

        $this->getDbTable()->update($data, array('code_capa = ?' => $capa->getCode_capa()));
    }

    public function delete($code_capa) {
        $this->getDbTable()->delete(array('code_capa = ?' => $code_capa));
    }
	
	
	////////////////////////////////////////////////////////
    public function fetchAllByCompte($code_compte) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte = ?', $code_compte)
				->where('montant_solde > ?', 0)
                ->order('date_capa', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCapaTs();
            $entry->setCode_capa($row->code_capa)
                    ->setId_operation($row->id_operation)
                    ->setDate_capa($row->date_capa)
                    ->setMontant($row->montant)
					->setMontant_utiliser($row->montant_utiliser)
					->setMontant_solde($row->montant_solde)
                    ->setCode_membre($row->code_membre)
                    ->setType_capa($row->type_capa)
                    ->setCode_compte($row->code_compte)
                    ->setEtat_capa($row->etat_capa)
                    ->setCode_produit($row->code_produit)
                    ->setOrigine_capa($row->origine_capa);
            $entries[] = $entry;
        }
        return $entries;
    }




    public function fetchAll2($code_compte) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte = ?', $code_compte)
                ->order('date_capa', 'DESC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCapaTs();
            $entry->setCode_capa($row->code_capa)
                    ->setId_operation($row->id_operation)
                    ->setDate_capa($row->date_capa)
                    ->setMontant($row->montant)
					->setMontant_utiliser($row->montant_utiliser)
					->setMontant_solde($row->montant_solde)
                    ->setCode_membre($row->code_membre)
                    ->setType_capa($row->type_capa)
                    ->setCode_compte($row->code_compte)
                    ->setEtat_capa($row->etat_capa)
                    ->setCode_produit($row->code_produit)
                    ->setOrigine_capa($row->origine_capa);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
}
