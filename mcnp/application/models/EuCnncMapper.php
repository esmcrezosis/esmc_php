<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EucnpMapper
 *
 * @author user
 */
class Application_Model_EuCnncMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCnnc');
        }
        return $this->_dbTable;
    }

    public function find($id_cnnc, Application_Model_EuCnnc $cnnc) {
        $result = $this->getDbTable()->find($id_cnnc);
        if (0 == count($result)) {
           return ;
        }
        $row = $result->current();
        $cnnc->setId_cnnc($row->id_cnnc)
             ->setCode_membre($row->code_membre)
             ->setDatefin($row->datefin)
             ->setLibelle($row->libelle)
             ->setMont_credit($row->mont_credit)
             ->setSource_credit($row->source_credit)
			 ->setId_credit($row->id_credit)
			 ->setMont_utilise($row->mont_utilise)
			 ->setSolde($row->solde);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCnnc();
            $entry->setId_cnnc($row->id_cnnc)
                  ->setCode_membre($row->code_membre)
                  ->setDatefin($row->datefin)
                  ->setLibelle($row->libelle)
                  ->setMont_credit($row->mont_credit)
                  ->setSource_credit($row->source_credit)
			      ->setId_credit($row->id_credit)
			      ->setMont_utilise($row->mont_utilise)
			      ->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function findsum() {
	    $t_cnnc = new Application_Model_DbTable_EuCnnc();
        $select = $t_cnnc->select();
        $select->from($t_cnnc, array('SUM(solde) as somme'));
        $result = $t_cnnc->fetchAll($select);
        $row = $result->current();
		return $row['somme'];
	}
	
	public function findCreditByCompte() {
        $table = new Application_Model_DbTable_EuCnnc();
        $select = $table->select();
        $select->where('solde > ?', 0);
		$select->order('id_cnnc ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCnnc();
            $entry->setId_cnnc($row->id_cnnc)
                  ->setCode_membre($row->code_membre)
                  ->setDatefin($row->datefin)
                  ->setLibelle($row->libelle)
                  ->setMont_credit($row->mont_credit)
                  ->setSource_credit($row->source_credit)
			      ->setId_credit($row->id_credit)
			      ->setMont_utilise($row->mont_utilise)
			      ->setSolde($row->solde);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_cnnc) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCnnc $cnnc) {
        $data = array(
        'id_cnnc' => $cnnc->getId_cnnc(),
        'code_membre' => $cnnc->getCode_Membre(),
        'datefin' => $cnnc->getDatefin(),
        'libelle' => $cnnc->getLibelle(),
        'mont_credit' => $cnnc->getMont_credit(),
        'source_credit' => $cnnc->getSource_credit(),
		'id_credit' => $cnnc->getId_credit(),
		'mont_utilise' => $cnnc->getMont_utilise(),
		'solde' => $cnnc->getSolde()
        );
        $this->getDbTable()->insert($data);
    }

	
    public function update(Application_Model_EuCnnc $cnnc) {
        $data = array(
        'id_cnnc' => $cnnc->getId_cnnc(),
        'code_membre' => $cnnc->getCode_Membre(),
        'datefin' => $cnnc->getDatefin(),
        'libelle' => $cnnc->getLibelle(),
        'mont_credit' => $cnnc->getMont_credit(),
        'source_credit' => $cnnc->getSource_credit(),
		'id_credit' => $cnnc->getId_credit(),
		'mont_utilise' => $cnnc->getMont_utilise(),
		'solde' => $cnnc->getSolde()
        );
        $this->getDbTable()->update($data, array('id_cnnc = ?' => $cnnc->getId_cnnc()));
    }

	
    public function delete($id_cnnc) {
        $this->getDbTable()->delete(array('id_cnnc = ?' => $id_cnnc));
    }

}
