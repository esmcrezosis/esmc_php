<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuRepartitionMf11000Mapper {

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
           $this->setDbTable('Application_Model_DbTable_EuRepartitionMf11000');
        }
        return $this->_dbTable;
    } 
 
    public function find($id_rep, Application_Model_EuRepartitionMf11000 $rmf11000) {
        $result = $this->getDbTable()->find($id_rep);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $rmf11000->setId_rep($row->id_rep)
                 ->setId_mf11000($row->id_mf11000)
                 ->setCode_mf11000($row->code_mf11000)
                 ->setCode_membre($row->code_membre)
                 ->setMont_rep($row->mont_rep)
                 ->setDate_rep($row->date_rep)
                 ->setPayer($row->payer)
                 ->setSolde_rep($row->solde_rep)
                 ->setMont_reglt($row->mont_reglt)
                 ->setId_utilisateur($row->id_utilisateur)
				 ->setEtat($row->etat);
        return true;
    }


    public function fetchRepByNumBon($num_bon) {
        $select = $this->getDbTable()->select();
        $select->where('code_mf11000 like ?', $num_bon)
		       //->where('payer LIKE 0')
		;
        $results = $this->getDbTable()->fetchAll($select);
		if (count($results) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($results as $row) {
            $entry = new Application_Model_EuRepartitionMf11000();
            $entry->setId_rep($row->id_rep)
                  ->setId_mf11000($row->id_mf11000)
                  ->setCode_mf11000($row->code_mf11000)
                  ->setCode_membre($row->code_membre)
                  ->setMont_rep($row->mont_rep)
                  ->setDate_rep($row->date_rep)
                  ->setPayer($row->payer)
                  ->setSolde_rep($row->solde_rep)
                  ->setMont_reglt($row->mont_reglt)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setEtat($row->etat);
            $entries[] = $entry;
        }
        return $entries;
    }


	public function findsum($num_bon) {
	    $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_rep) as somme'));
        $select->where('code_mf11000 = ?', $num_bon);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
           return 0;
        }
        $row = $result->current();
        return $row['somme'];
	}
	
	

    public function getSoldeMf11000($num_bon) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_rep) as total'));
        $select->where('code_mf11000 LIKE ?', $num_bon)
               ->where('payer LIKE 0');
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepartitionMf11000();
            $entry->setId_rep($row->id_rep)
                    ->setId_mf11000($row->id_mf11000)
                    ->setCode_mf11000($row->code_mf11000)
                    ->setCode_membre($row->code_membre)
                    ->setMont_rep($row->mont_rep)
                    ->setDate_rep($row->date_rep)
                    ->setPayer($row->payer)
                    ->setSolde_rep($row->solde_rep)
                    ->setMont_reglt($row->mont_reglt)
                    ->setId_utilisateur($row->id_utilisateur)
					->setEtat($row->etat);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuRepartitionMf11000 $rmf11000) {
        $data = array(
            'id_rep' => $rmf11000->getId_rep(),
            'id_mf11000' => $rmf11000->getId_mf11000(),
            'code_mf11000' => $rmf11000->getCode_mf11000(),
            'code_membre' => $rmf11000->getCode_membre(),
            'mont_rep' => $rmf11000->getMont_rep(),
            'mont_reglt' => $rmf11000->getMont_reglt(),
            'date_rep' => $rmf11000->getDate_rep(),
            'payer' => $rmf11000->getPayer(),
            'solde_rep' => $rmf11000->getSolde_rep(),
            'id_utilisateur' => $rmf11000->getId_utilisateur(),
			'etat' => $rmf11000->getEtat()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepartitionMf11000 $rmf11000) {
        $data = array(
            'id_rep' => $rmf11000->getId_rep(),
            'id_mf11000' => $rmf11000->getId_mf11000(),
            'code_mf11000' => $rmf11000->getCode_mf11000(),
            'code_membre' => $rmf11000->getCode_membre(),
            'mont_rep' => $rmf11000->getMont_rep(),
            'mont_reglt' => $rmf11000->getMont_reglt(),
            'date_rep' => $rmf11000->getDate_rep(),
            'payer' => $rmf11000->getPayer(),
            'solde_rep' => $rmf11000->getSolde_rep(),
            'id_utilisateur' => $rmf11000->getId_utilisateur(),
			'etat' => $rmf11000->getEtat()
        );
        $this->getDbTable()->update($data, array('id_rep = ?' => $rmf11000->getId_rep()));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_rep) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
     

    public function delete($id_rep) {
        $this->getDbTable()->delete(array('id_rep = ?' => $id_rep));
    }

}

?>
