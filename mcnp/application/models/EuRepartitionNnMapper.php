<?php
class Application_Model_EuRepartitionNnMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuRepartitionNn');
        }
        return $this->_dbTable;
    }
	
	public function find($id_rep_nn, Application_Model_EuRepartitionNn $repartition_nn) {
       $result = $this->getDbTable()->find($id_rep_nn);
       if (0 == count($result)) {
           return false;
       }
       $row = $result->current();
       $repartition_nn->setId_rep_nn($row->id_rep_nn)
                      ->setId_detail_appel_nn($row->id_detail_appel_nn)
			          ->setDate_rep($row->date_rep)
			          ->setMont_rep($row->mont_rep)
					  ->setMont_marge($row->mont_marge)
			          ->setId_utilisateur($row->id_utilisateur)
					  ->setId_proposition($row->id_proposition)
					  ;
	    return true;
    }
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuRepartitionNn();
           $entry->setId_rep_nn($row->id_rep_nn)
                 ->setId_detail_appel_nn($row->id_detail_appel_nn)
			     ->setDate_rep($row->date_rep)
			     ->setMont_rep($row->mont_rep)
				 ->setMont_marge($row->mont_marge)
			     ->setId_utilisateur($row->id_utilisateur)
				 ->setId_proposition($row->id_proposition);
           $entries[] = $entry;
        }
        return $entries;
    }

	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_rep_nn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
	
    public function save(Application_Model_EuRepartitionNn $repartitionnn) {
        $data = array(
          'id_rep_nn' => $repartitionnn->getId_rep_nn(),
          'id_detail_appel_nn' => $repartitionnn->getId_detail_appel_nn(),
		  'date_rep' => $repartitionnn->getDate_rep(),
		  'mont_rep' => $repartitionnn->getMont_rep(),
		  'mont_marge' => $repartitionnn->getMont_marge(),
		  'id_utilisateur' => $repartitionnn->getId_utilisateur(),
		  'id_proposition' => $repartitionnn->getId_proposition()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepartitionNn $repartitionnn) {
        $data = array(
          'id_rep_nn' => $repartitionnn->getId_rep_nn(),
          'id_detail_appel_nn' => $repartitionnn->getId_detail_appel_nn(),
		  'date_rep' => $repartitionnn->getDate_rep(),
		  'mont_rep' => $repartitionnn->getMont_rep(),
		  'mont_marge' => $repartitionnn->getMont_marge(),
		  'id_utilisateur' => $repartitionnn->getId_utilisateur(),
		  'id_proposition' => $repartitionnn->getId_proposition()
        );
        $this->getDbTable()->update($data, array('id_rep_nn = ?' => $repartitionnn->getId_rep_nn()));
    }

    public function delete($id_rep_nn) {
           $this->getDbTable()->delete(array('id_rep_nn = ?' => $id_rep_nn));
    }
	
	
	public function fetchAllByDetailAppelNn($id_detail_appel_nn) {
        $select = $this->getDbTable()->select();
		$select->where("id_detail_appel_nn = ? ", $id_detail_appel_nn);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuRepartitionNn();
           $entry->setId_rep_nn($row->id_rep_nn)
                 ->setId_detail_appel_nn($row->id_detail_appel_nn)
			     ->setDate_rep($row->date_rep)
			     ->setMont_rep($row->mont_rep)
				 ->setMont_marge($row->mont_marge)
			     ->setId_utilisateur($row->id_utilisateur)
				 ->setId_proposition($row->id_proposition)
				 ;
           $entries[] = $entry;
        }
        return $entries;
    }
	
	public function fetchAllBySurveillance($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("id_proposition IN (SELECT id_proposition FROM eu_appel_nn WHERE code_membre_morale LIKE ? )", $code_membre);
		$select->where("id_detail_appel_nn IS NULL ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuRepartitionNn();
           $entry->setId_rep_nn($row->id_rep_nn)
                 ->setId_detail_appel_nn($row->id_detail_appel_nn)
			     ->setDate_rep($row->date_rep)
			     ->setMont_rep($row->mont_rep)
				 ->setMont_marge($row->mont_marge)
			     ->setId_utilisateur($row->id_utilisateur)
				 ->setId_proposition($row->id_proposition)
				 ;
           $entries[] = $entry;
        }
        return $entries;
    }
	
	
}		
?>	
	
	
	
	
	
	
	
	
	