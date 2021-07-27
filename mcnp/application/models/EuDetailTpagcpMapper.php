<?php
 
class Application_Model_EuDetailTpagcpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailTpagcp');
        }
        return $this->_dbTable;
    }

    public function find($id_tpagcp, Application_Model_EuDetailTpagcp $detail_tpagcp) {
        $result = $this->getDbTable()->find($id_tpagcp);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $detail_tpagcp->setId_tpagcp($row->id_tpagcp)
                ->setCode_tegc($row->code_tegc)
                ->setMontant($row->montant)
				;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("detail_tpagcp_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailTpagcp();
            $entry->setId_tpagcp($row->id_tpagcp)
	                ->setCode_tegc($row->code_tegc)
					->setMontant($row->montant)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tpagcp) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDetailTpagcp $detail_tpagcp) {
        $data = array(
            'id_tpagcp' => $detail_tpagcp->getId_tpagcp(),
            'code_tegc' => $detail_tpagcp->getCode_tegc(),
            'montant' => $detail_tpagcp->getMontant()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailTpagcp $detail_tpagcp) {
        $data = array(
            'id_tpagcp' => $detail_tpagcp->getId_tpagcp(),
            'code_tegc' => $detail_tpagcp->getCode_tegc(),
            'montant' => $detail_tpagcp->getMontant()
        );
        $this->getDbTable()->update($data, array('id_tpagcp = ?' => $detail_tpagcp->getId_tpagcp()));
    }

    public function delete($id_tpagcp) {
        $this->getDbTable()->delete(array('id_tpagcp = ?' => $id_tpagcp));
    }


   
	
	public function findDetailTpagcpTegcp($tegcp) {
	   $select = $this->getDbTable()->select();
		$select->where("code_tegc = ? ", $tegcp);
       $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailTpagcp();
            $entry->setId_tpagcp($row->id_tpagcp)
	                ->setCode_tegc($row->code_tegc)
					->setMontant($row->montant)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	public function findDetailTpagcpTpagcp($id_tpagcp) {
	   $select = $this->getDbTable()->select();
		$select->where("id_tpagcp = ? ", $id_tpagcp);
       $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailTpagcp();
            $entry->setId_tpagcp($row->id_tpagcp)
	                ->setCode_tegc($row->code_tegc)
					->setMontant($row->montant)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	
	
}


?>
