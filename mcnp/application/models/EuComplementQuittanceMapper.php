<?php
 
class Application_Model_EuComplementQuittanceMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuComplementQuittance');
        }
        return $this->_dbTable;
    }

    public function find($id_complement_quittance, Application_Model_EuComplementQuittance $complement_quittance) {
        $result = $this->getDbTable()->find($id_complement_quittance);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $complement_quittance->setId_complement_quittance($row->id_complement_quittance)
                 ->setIntegrateur_id($row->integrateur_id)
                 ->setSouscription_id($row->souscription_id)
                 ->setDate_complement_quittance($row->date_complement_quittance);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuComplementQuittance();
            $entry->setId_complement_quittance($row->id_complement_quittance)
	              ->setIntegrateur_id($row->integrateur_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setDate_complement_quittance($row->date_complement_quittance);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_complement_quittance) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuComplementQuittance $complement_quittance) {
        $data = array(
          'id_complement_quittance'   =>   $complement_quittance->getId_complement_quittance(),
          'integrateur_id'            =>   $complement_quittance->getIntegrateur_id(),
          'souscription_id'           =>   $complement_quittance->getSouscription_id(),
          'date_complement_quittance' =>   $complement_quittance->getDate_complement_quittance()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuComplementQuittance $complement_quittance) {
        $data = array(
          'id_complement_quittance'   =>   $complement_quittance->getId_complement_quittance(),
          'integrateur_id'            =>   $complement_quittance->getIntegrateur_id(),
          'souscription_id'           =>   $complement_quittance->getSouscription_id(),
          'date_complement_quittance' =>   $complement_quittance->getDate_complement_quittance()
        );
        $this->getDbTable()->update($data, array('id_complement_quittance = ?' => $complement_quittance->getId_complement_quittance()));
    }

	
    public function delete($id_complement_quittance) {
        $this->getDbTable()->delete(array('id_complement_quittance = ?' => $id_complement_quittance));
    }
	
	
	public function fetchAllBySouscription($souscription_id) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_id = ?", $souscription_id);
		$select->order(array("id_complement_quittance DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuComplementQuittance();
        $entry->setId_complement_quittance($row->id_complement_quittance)
	          ->setIntegrateur_id($row->integrateur_id)
              ->setSouscription_id($row->souscription_id)
              ->setDate_complement_quittance($row->date_complement_quittance);
		$entries = $entry;
        return $entries;
    }
	
	







}


?>
