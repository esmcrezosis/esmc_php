<?php
 
class Application_Model_EuMscmMapper {

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
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuMscm');
        }
        return $this->_dbTable;
    }

    public function find($id_mscm, Application_Model_EuMscm $mscm) {
        $result = $this->getDbTable()->find($id_mscm);
        if(count($result) == 0) {
          return false;
        }
        $row = $result->current();
        $mscm->setId_mscm($row->id_mscm)
             ->setCredit_mscm($row->credit_mscm)
             ->setDebit_mscm($row->debit_mscm)
             ->setSolde_mscm($row->solde_mscm);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMscm();
            $entry->setId_mscm($row->id_mscm)
                  ->setCredit_mscm($row->credit_mscm)
                  ->setDebit_mscm($row->debit_mscm)
                  ->setSolde_mscm($row->solde_mscm);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
       $select = $this->getDbTable()->select();
       $select->from($this->getDbTable(), array('MAX(id_mscm) as count'));
       $result = $this->getDbTable()->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }

	
	
    public function save(Application_Model_EuMscm $mscm) {
        $data = array(
          'id_mscm' => $mscm->getId_mscm(),
          'credit_mscm' => $mscm->getCredit_mscm(),
		  'debit_mscm' => $mscm->getDebit_mscm(),
          'solde_mscm' => $mscm->getSolde_mscm()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMscm $mscm) {
        $data = array(
          'id_mscm' => $mscm->getId_mscm(),
          'credit_mscm' => $mscm->getCredit_mscm(),
		  'debit_mscm' => $mscm->getDebit_mscm(),
          'solde_mscm' => $mscm->getSolde_mscm()
        );
        $this->getDbTable()->update($data, array('id_mscm = ?' => $mscm->getId_mscm()));
    }
	
	
	public function  fetchAllByMscm() {
	  $select = $this->getDbTable()->select();
      $select->where('credit_mscm < ?',70000);
	  $select->order('id_mscm asc');
	  $result = $this->getDbTable()->fetchAll($select);
	  if(count($result) == 0) {
         return NULL;
      }
	  
	  $row  = $result->current();
      $mscm = new Application_Model_EuMscm();
	  $mscm->setId_mscm($row->id_mscm)
		   ->setCredit_mscm($row->credit_mscm)
		   ->setDebit_mscm($row->debit_mscm)
		   ->setSolde_mscm($row->solde_mscm);
	  return $mscm;
	}
	

    public function delete($id_mscm) {
      $this->getDbTable()->delete(array('id_mscm = ?' => $id_mscm));
    }


    

}


?>
