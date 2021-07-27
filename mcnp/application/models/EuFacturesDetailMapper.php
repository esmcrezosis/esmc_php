<?php
 
class Application_Model_EuFacturesDetailMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFacturesDetail');
        }
        return $this->_dbTable;
    }

    public function find($facture_detail_id, Application_Model_EuFacturesDetail $facture_detail) {
        $result = $this->getDbTable()->find($facture_detail_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $facture_detail->setFacture_detail_id($row->facture_detail_id)
                ->setFacture_detail_libelle($row->facture_detail_libelle)
                ->setFacture_detail_quantite($row->facture_detail_quantite)
                ->setFacture_detail_reference($row->facture_detail_reference)
                ->setFacture_id($row->facture_id)
                ->setFacture_detail_prix_unitaire($row->facture_detail_prix_unitaire)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("facture_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFacturesDetail();
            $entry->setFacture_detail_id($row->facture_detail_id)
	                ->setFacture_detail_libelle($row->facture_detail_libelle)
                    ->setFacture_detail_quantite($row->facture_detail_quantite)
                    ->setFacture_detail_reference($row->facture_detail_reference)
	                ->setFacture_id($row->facture_id)
					->setFacture_detail_prix_unitaire($row->facture_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(facture_detail_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFacturesDetail $facture_detail) {
        $data = array(
            'facture_detail_id' => $facture_detail->getFacture_detail_id(),
            'facture_detail_libelle' => $facture_detail->getFacture_detail_libelle(),
            'facture_detail_quantite' => $facture_detail->getFacture_detail_quantite(),
            'facture_detail_reference' => $facture_detail->getFacture_detail_reference(),
            'facture_id' => $facture_detail->getFacture_id(),
            'facture_detail_prix_unitaire' => $facture_detail->getFacture_detail_prix_unitaire()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFacturesDetail $facture_detail) {
        $data = array(
            'facture_detail_id' => $facture_detail->getFacture_detail_id(),
            'facture_detail_libelle' => $facture_detail->getFacture_detail_libelle(),
            'facture_detail_quantite' => $facture_detail->getFacture_detail_quantite(),
            'facture_detail_reference' => $facture_detail->getFacture_detail_reference(),
            'facture_id' => $facture_detail->getFacture_id(),
            'facture_detail_prix_unitaire' => $facture_detail->getFacture_detail_prix_unitaire()
        );
        $this->getDbTable()->update($data, array('facture_detail_id = ?' => $facture_detail->getFacture_detail_id()));
    }

    public function delete($facture_detail_id) {
        $this->getDbTable()->delete(array('facture_detail_id = ?' => $facture_detail_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->order("facture_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFacturesDetail();
            $entry->setFacture_detail_id($row->facture_detail_id)
	                ->setFacture_detail_libelle($row->facture_detail_libelle)
                    ->setFacture_detail_quantite($row->facture_detail_quantite)
                    ->setFacture_detail_reference($row->facture_detail_reference)
	                ->setFacture_id($row->facture_id)
					->setFacture_detail_prix_unitaire($row->facture_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("facture_id = ? ", $type);
		$select->order("facture_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFacturesDetail();
            $entry->setFacture_detail_id($row->facture_detail_id)
	                ->setFacture_detail_libelle($row->facture_detail_libelle)
                    ->setFacture_detail_quantite($row->facture_detail_quantite)
                    ->setFacture_detail_reference($row->facture_detail_reference)
	                ->setFacture_id($row->facture_id)
					->setFacture_detail_prix_unitaire($row->facture_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("facture_detail_id != ? ", $id);
		$select->order("facture_detail_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFacturesDetail();
            $entry->setFacture_detail_id($row->facture_detail_id)
	                ->setFacture_detail_libelle($row->facture_detail_libelle)
                    ->setFacture_detail_quantite($row->facture_detail_quantite)
                    ->setFacture_detail_reference($row->facture_detail_reference)
	                ->setFacture_id($row->facture_id)
					->setFacture_detail_prix_unitaire($row->facture_detail_prix_unitaire)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
