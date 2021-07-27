<?php
 
class Application_Model_EuDetailProjetMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailProjet');
        }
        return $this->_dbTable;
    }

    public function find($detail_projet_id, Application_Model_EuDetailProjet $detail_projet) {
        $result = $this->getDbTable()->find($detail_projet_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $detail_projet->setDetail_projet_id($row->detail_projet_id)
                              ->setDetail_projet_libelle($row->detail_projet_libelle)
                              ->setProjet_id($row->projet_id)
                              ->setEtat($row->etat)
                              ->setDetail_projet_fichier($row->detail_projet_fichier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailProjet();
            $entry->setDetail_projet_id($row->detail_projet_id)
                  ->setDetail_projet_libelle($row->detail_projet_libelle)
                  ->setProjet_id($row->projet_id)
                  ->setEtat($row->etat)
                  ->setDetail_projet_fichier($row->detail_projet_fichier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(detail_projet_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDetailProjet $detail_projet) {
        $data = array(
          'detail_projet_id' => $detail_projet->getDetail_projet_id(),
          'detail_projet_libelle' => $detail_projet->getDetail_projet_libelle(),
          'projet_id' => $detail_projet->getProjet_id(),
          'etat' => $detail_projet->getEtat(),
          'detail_projet_fichier' => $detail_projet->getDetail_projet_fichier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailProjet $detail_projet) {
        $data = array(
          'detail_projet_id' => $detail_projet->getDetail_projet_id(),
          'detail_projet_libelle' => $detail_projet->getDetail_projet_libelle(),
          'projet_id' => $detail_projet->getProjet_id(),
          'etat' => $detail_projet->getEtat(),
          'detail_projet_fichier' => $detail_projet->getDetail_projet_fichier()
        );
        $this->getDbTable()->update($data, array('detail_projet_id = ?' => $detail_projet->getDetail_projet_id()));
    }

    public function delete($detail_projet_id) {
        $this->getDbTable()->delete(array('detail_projet_id = ?' => $detail_projet_id));
    }
	
	public function fetchAllByProjet($projet_id) {
        $select = $this->getDbTable()->select();
		$select->where("projet_id = ?", $projet_id);
		$select->order(array("detail_projet_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailProjet();
            $entry->setDetail_projet_id($row->detail_projet_id)
                  ->setDetail_projet_libelle($row->detail_projet_libelle)
                  ->setProjet_id($row->projet_id)
                  ->setEtat($row->etat)
                  ->setDetail_projet_fichier($row->detail_projet_fichier);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByProjetEtat($projet_id, $etat) {
        $select = $this->getDbTable()->select();
        $select->where("projet_id = ?", $projet_id);
        $select->where("etat = ?", $etat);
        $select->order(array("detail_projet_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailProjet();
            $entry->setDetail_projet_id($row->detail_projet_id)
                  ->setDetail_projet_libelle($row->detail_projet_libelle)
                  ->setProjet_id($row->projet_id)
                  ->setEtat($row->etat)
                  ->setDetail_projet_fichier($row->detail_projet_fichier);
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
