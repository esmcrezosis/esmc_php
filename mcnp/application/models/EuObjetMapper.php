<?php

class Application_Model_EuObjetMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuObjet');
        }
        return $this->_dbTable;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('COUNT(id_objet) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    
    public function findMax() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_objet) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    
    public function findobjet($design_objet,$unite_mesure) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_objet'));
        $select->where('design_objet = ?', $design_objet);
		$select->where('unite_mesure = ?', $unite_mesure);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_objet'];
    }
    
    
    public function save(Application_Model_EuObjet $objet) {
        $data = array(
            'id_objet' => $objet->getId_objet(),
            'design_objet' => $objet->getDesign_objet(),
			'unite_mesure' => $objet->getUnite_mesure()    
        );    
        $this->getDbTable()->insert($data);
    }

    
    public function update(Application_Model_EuObjet $objet) {
        $data = array(
            'id_objet' => $objet->getId_objet(),
            'design_objet' => $objet->getDesign_objet(),
			'unite_mesure' => $objet->getUnite_mesure()
        );
        $this->getDbTable()->update($data, array('id_objet = ?' => $objet->getId_objet()));
    }

    
    public function find($id_objet, Application_Model_EuObjet $objet) {
        $result = $this->getDbTable()->find($id_objet);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $objet->setId_objet($row->id_objet)
              ->setDesign_objet($row->design_objet)
			  ->setUnite_mesure($row->unite_mesure);
      return true;
    }
    
    public function trouve($design_objet, Application_Model_EuObjet $objet) {
        $result = $this->getDbTable()->trouve($design_objet);
        $rep=array();
        $row = $result->current();
        $id_objet->setId_objet($row->id_objet);
        $rep=$id_objet;
        return $rep;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuObjet();
            $entry->setId_objet($row->id_objet);
            $entry->setDesign_objet($row->design_objet);
			$entry->setUnite_mesure($row->unite_mesure);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function delete($id_objet) {
        $this->getDbTable()->delete(array('id_objet = ?' => $id_objet));
    }
}