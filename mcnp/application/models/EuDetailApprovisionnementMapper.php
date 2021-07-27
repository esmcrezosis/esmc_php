<?php
 
class Application_Model_EuDetailApprovisionnementMapper {

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
         $this->setDbTable('Application_Model_DbTable_EuDetailApprovisionnement');
      }
      return $this->_dbTable;
    }
	
    public function find($id_detail_approvisionnement, Application_Model_EuDetailApprovisionnement $detailapprovisionnement) {
        $result = $this->getDbTable()->find($id_detail_approvisionnement);
        if (count($result) == 0) {
          return false;
        }
        $row = $result->current();
        $detailapprovisionnement->setId_detail_approvisionnement($row->id_detail_approvisionnement)
                                ->setId_approvisionnement($row->id_approvisionnement)
                                ->setId_credit($row->id_credit)
                                ->setCode_compte($row->code_compte)
				                ->setMontant_detail_approvisionnement($row->montant_detail_approvisionnement);
        return true;
    }

	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailApprovisionnement();
            $entry->setId_detail_approvisionnement($row->id_detail_approvisionnement)
                  ->setId_approvisionnement($row->id_approvisionnement)
                  ->setId_credit($row->id_credit)
                  ->setCode_compte($row->code_compte)
				  ->setMontant_detail_approvisionnement($row->montant_detail_approvisionnement);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_approvisionnement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuDetailApprovisionnement $detailapprovisionnement) {
        $data = array(
          'id_detail_approvisionnement' => $detailapprovisionnement->getId_detail_approvisionnement(),
          'id_approvisionnement' => $detailapprovisionnement->getId_approvisionnement(),
          'id_credit' => $detailapprovisionnement->getId_credit(),
          'code_compte' => $detailapprovisionnement->getCode_compte(),
          'montant_detail_approvisionnement' => $detailapprovisionnement->getMontant_detail_approvisionnement()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailApprovisionnement $detailapprovisionnement) {
        $data = array(
          'id_detail_approvisionnement' => $detailapprovisionnement->getId_detail_approvisionnement(),
          'id_approvisionnement' => $detailapprovisionnement->getId_approvisionnement(),
          'id_credit' => $detailapprovisionnement->getId_credit(),
          'code_compte' => $detailapprovisionnement->getCode_compte(),
          'montant_detail_approvisionnement' => $detailapprovisionnement->getMontant_detail_approvisionnement()
        );
        $this->getDbTable()->update($data, array('id_detail_approvisionnement = ?' => $detailapprovisionnement->getId_detail_approvisionnement()));
    }

    public function delete($id_detail_approvisionnement) {
        $this->getDbTable()->delete(array('id_detail_approvisionnement = ?' => $id_detail_approvisionnement)); 
    }

}


?>
