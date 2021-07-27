<?php
 
class Application_Model_EuDetailOffreurProjetMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailOffreurProjet');
        }
        return $this->_dbTable;
    }

    public function find($id_detail_offreur_projet, Application_Model_EuDetailOffreurProjet $detail_offreur_projet) {
        $result = $this->getDbTable()->find($id_detail_offreur_projet);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $detail_offreur_projet->setId_detail_offreur_projet($row->id_detail_offreur_projet)
                              ->setSouscription_id($row->souscription_id)
                              ->setOffreur_projet_id($row->offreur_projet_id)
                              ->setDate_detail_offreur_projet($row->date_detail_offreur_projet);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailOffreurProjet();
            $entry->setId_detail_offreur_projet($row->id_detail_offreur_projet)
                  ->setSouscription_id($row->souscription_id)
                  ->setOffreur_projet_id($row->offreur_projet_id)
                  ->setDate_detail_offreur_projet($row->date_detail_offreur_projet);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_offreur_projet) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDetailOffreurProjet $detail_offreur_projet) {
        $data = array(
          'id_detail_offreur_projet'       =>   $detail_offreur_projet->getId_detail_offreur_projet(),
          'souscription_id'                =>   $detail_offreur_projet->getSouscription_id(),
          'offreur_projet_id'              =>   $detail_offreur_projet->getOffreur_projet_id(),
          'date_detail_offreur_projet'     =>   $detail_offreur_projet->getDate_detail_offreur_projet()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailOffreurProjet $detail_offreur_projet) {
        $data = array(
          'id_detail_offreur_projet'      =>   $detail_offreur_projet->getId_detail_offreur_projet(),
          'souscription_id'               =>   $detail_offreur_projet->getSouscription_id(),
          'offreur_projet_id'             =>   $detail_offreur_projet->getOffreur_projet_id(),
          'date_detail_offreur_projet'    =>   $detail_offreur_projet->getDate_detail_offreur_projet()
        );
        $this->getDbTable()->update($data, array('id_detail_offreur_projet = ?' => $detail_offreur_projet->getId_detail_offreur_projet()));
    }

    public function delete($id_detail_offreur_projet) {
        $this->getDbTable()->delete(array('id_detail_offreur_projet = ?' => $id_detail_offreur_projet));
    }
	
	public function fetchAllBySouscription($souscription_id) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_id = ?", $souscription_id);
		$select->order(array("id_detail_offreur_projet DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuDetailOffreurProjet();
        $entry->setId_detail_offreur_projet($row->id_detail_offreur_projet)
	          ->setSouscription_id($row->souscription_id)
              ->setOffreur_projet_id($row->offreur_projet_id)
              ->setDate_detail_offreur_projet($row->date_detail_offreur_projet);
		$entries = $entry;
        return $entries;
    }


}


?>
