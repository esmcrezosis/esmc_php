<?php
 
class Application_Model_EuDetailTravailleurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailTravailleur');
        }
        return $this->_dbTable;
    }

    public function find($detail_travailleur_id, Application_Model_EuDetailTravailleur $detail_travailleur) {
        $result = $this->getDbTable()->find($detail_travailleur_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $detail_travailleur->setDetail_travailleur_id($row->detail_travailleur_id)
                              ->setDetail_travailleur_libelle($row->detail_travailleur_libelle)
                              ->setTravailleur_id($row->travailleur_id)
                              ->setEtat($row->etat)
                              ->setDetail_travailleur_fichier($row->detail_travailleur_fichier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailTravailleur();
            $entry->setDetail_travailleur_id($row->detail_travailleur_id)
                  ->setDetail_travailleur_libelle($row->detail_travailleur_libelle)
                  ->setTravailleur_id($row->travailleur_id)
                  ->setEtat($row->etat)
                  ->setDetail_travailleur_fichier($row->detail_travailleur_fichier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(detail_travailleur_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDetailTravailleur $detail_travailleur) {
        $data = array(
          'detail_travailleur_id' => $detail_travailleur->getDetail_travailleur_id(),
          'detail_travailleur_libelle' => $detail_travailleur->getDetail_travailleur_libelle(),
          'travailleur_id' => $detail_travailleur->getTravailleur_id(),
          'etat' => $detail_travailleur->getEtat(),
          'detail_travailleur_fichier' => $detail_travailleur->getDetail_travailleur_fichier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailTravailleur $detail_travailleur) {
        $data = array(
          'detail_travailleur_id' => $detail_travailleur->getDetail_travailleur_id(),
          'detail_travailleur_libelle' => $detail_travailleur->getDetail_travailleur_libelle(),
          'travailleur_id' => $detail_travailleur->getTravailleur_id(),
          'etat' => $detail_travailleur->getEtat(),
          'detail_travailleur_fichier' => $detail_travailleur->getDetail_travailleur_fichier()
        );
        $this->getDbTable()->update($data, array('detail_travailleur_id = ?' => $detail_travailleur->getDetail_travailleur_id()));
    }

    public function delete($detail_travailleur_id) {
        $this->getDbTable()->delete(array('detail_travailleur_id = ?' => $detail_travailleur_id));
    }
	
	public function fetchAllByTravailleur($travailleur_id) {
        $select = $this->getDbTable()->select();
		$select->where("travailleur_id = ?", $travailleur_id);
		$select->order(array("detail_travailleur_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailTravailleur();
            $entry->setDetail_travailleur_id($row->detail_travailleur_id)
                  ->setDetail_travailleur_libelle($row->detail_travailleur_libelle)
                  ->setTravailleur_id($row->travailleur_id)
                  ->setEtat($row->etat)
                  ->setDetail_travailleur_fichier($row->detail_travailleur_fichier);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByTravailleurEtat($travailleur_id, $etat) {
        $select = $this->getDbTable()->select();
        $select->where("travailleur_id = ?", $travailleur_id);
        $select->where("etat = ?", $etat);
        $select->order(array("detail_travailleur_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailTravailleur();
            $entry->setDetail_travailleur_id($row->detail_travailleur_id)
                  ->setDetail_travailleur_libelle($row->detail_travailleur_libelle)
                  ->setTravailleur_id($row->travailleur_id)
                  ->setEtat($row->etat)
                  ->setDetail_travailleur_fichier($row->detail_travailleur_fichier);
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
