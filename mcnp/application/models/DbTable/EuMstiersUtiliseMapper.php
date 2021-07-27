<?php
 
class Application_Model_EuMstiersUtiliseMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuMstiersUtilise');
        }
        return $this->_dbTable;
    }

	
    public function find($id_mstiers_utilise, Application_Model_EuMstiersUtilise $mstiersutilise) {
        $result = $this->getDbTable()->find($id_mstiers_utilise);
        if(count($result) == 0) {
           return false;
        }
		
        $row = $result->current();
        $mstiersutilise->setId_mstiers_utilise($row->id_mstiers_utilise)
		               ->setId_mstiers($row->id_mstiers)
                       ->setCode_caps($row->code_caps)
					   ->setCode_bnp($row->code_bnp)
                       ->setMontant_utilise($row->montant_utilise)
				       ->setDate_mstiers_utilise($row->date_mstiers_utilise);
        return true;
    }

	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMstiersUtilise();
            $entry->setId_mstiers_utilise($row->id_mstiers_utilise)
		          ->setId_mstiers($row->id_mstiers)
                  ->setCode_caps($row->code_caps)
				  ->setCode_bnp($row->code_bnp)
                  ->setMontant_utilise($row->montant_utilise)
				  ->setDate_mstiers_utilise($row->date_mstiers_utilise);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
    public function findConuter() {
       $select = $this->getDbTable()->select();
       $select->from($this->getDbTable(), array('MAX(id_mstiers_utilise) as count'));
       $result = $this->getDbTable()->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }
	
	public function fetchAllByMembre($membre) {
	   $tabela = new Application_Model_DbTable_EuMstiersUtilise();
	   $select = $tabela->select();
	   $select->where('code_membre_beneficiaire = ?',$membre);   
	   $result = $tabela->fetchAll($select);
       if(count($result) == 0) {
         return NULL;
       }
	   $entries = array();
       foreach($result as $row) {
          $entry = new Application_Model_EuMstiersUtilise();
          $entry->setId_mstiers_utilise($row->id_mstiers_utilise)
		        ->setId_mstiers($row->id_mstiers)
                ->setCode_caps($row->code_caps)
				->setCode_bnp($row->code_bnp)
                ->setMontant_utilise($row->montant_utilise)
				->setDate_mstiers_utilise($row->date_mstiers_utilise);
		   $entries[] = $entry;
	    }
		return $entries;
	}
	
	
    public function save(Application_Model_EuMstiersUtilise $mstiersutilise) {
        $data = array(
          'id_mstiers_utilise' => $mstiersutilise->getId_mstiers_utilise(),
		  'id_mstiers' => $mstiersutilise->getId_mstiers(),
		  'code_caps' => $mstiersutilise->getCode_caps(),
		  'code_bnp' => $mstiersutilise->getCode_bnp(),
		  'montant_utilise' => $mstiersutilise->getMontant_utilise(),
		  'date_mstiers_utilise' => $mstiersutilise->getDate_mstiers_utilise()
        );
        $this->getDbTable()->insert($data);
    }

	
    public function update(Application_Model_EuMstiersUtilise $mstiersutilise) {
        $data = array(
          'id_mstiers_utilise' => $mstiersutilise->getId_mstiers_utilise(),
		  'id_mstiers' => $mstiersutilise->getId_mstiers(),
          'code_caps' => $mstiersutilise->getCode_caps(),
		  'code_bnp' => $mstiersutilise->getCode_bnp(),
		  'montant_utilise' => $mstiersutilise->getMontant_utilise(),
		  'date_mstiers_utilise' => $mstiersutilise->getDate_mstiers_utilise()
        );
        $this->getDbTable()->update($data, array('id_mstiers_utilise = ?' => $mstiersutilise->getId_mstiers_utilise()));
    }
	
	

    public function delete($id_mstiers_utilise) {
        $this->getDbTable()->delete(array('id_mstiers_utilise = ?' => $id_mstiers_utilise));
    }


    

}


?>
