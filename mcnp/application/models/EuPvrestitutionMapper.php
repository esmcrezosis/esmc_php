<?php

class Application_Model_EuPvrestitutionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPvrestitution');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPvrestitution $pv) {
        $data = array(
          'id_pvrestitution' => $pv->getId_pvrestitution(),
	      'designation_pvrestitution' => $pv->getDesignation_pvrestitution(),
	      'date_pvrestitution' => $pv->getDate_pvrestitution(),
          'valider' => $pv->getValider(),
          'rejeter' => $pv->getRejeter(),
		  'id_lettre' => $pv->getId_lettre(),
		  'contenu' => $pv->getContenu()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPvrestitution $pv) {
        $data = array(
          'id_pvrestitution' => $pv->getId_pvrestitution(),
	      'designation_pvrestitution' => $pv->getDesignation_pvrestitution(),
	      'date_pvrestitution' => $pv->getDate_pvrestitution(),
          'valider' => $pv->getValider(),
          'rejeter' => $pv->getRejeter(),
		  'id_lettre' => $pv->getId_lettre(),
		  'contenu' => $pv->getContenu()
        );
        $this->getDbTable()->update($data, array('id_pvrestitution = ?' => $pv->getId_pvrestitution()));
    }
	
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_pvrestitution) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function find($id_pvrestitution, Application_Model_EuPvrestitution $pv) {
        $result = $this->getDbTable()->find($id_pvrestitution);
        if(count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $pv->setId_pvrestitution($row->id_pvrestitution)
		   ->setDesignation_pvrestitution($row->designation_pvrestitution)
		   ->setDate_pvrestitution($row->date_pvrestitution)
           ->setValider($row->valider)
           ->setRejeter($row->rejeter)
		   ->setId_lettre($row->id_lettre)
		   ->setContenu($row->contenu);
        return true;
    }
    

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuPvrestitution();
            $entry->setId_pvrestitution($row->id_pvrestitution)
		          ->setDesignation_pvrestitution($row->designation_pvrestitution)
		          ->setDate_pvrestitution($row->date_pvrestitution)
                  ->setValider($row->valider)
                  ->setRejeter($row->rejeter)
		          ->setId_lettre($row->id_lettre)
				  ->setContenu($row->contenu);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function delete($id_pvrestitution) {
        $this->getDbTable()->delete(array('id_pvrestitution = ?' => $id_pvrestitution));
    }
	
}

