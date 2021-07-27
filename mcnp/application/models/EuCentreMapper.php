<?php

class Application_Model_EuCentreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCentre');
        }
        return $this->_dbTable;
    }

    public function find($centre_id, Application_Model_EuCentre $centre) {
        $result = $this->getDbTable()->find($centre_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $centre->setCentre_id($row->centre_id)
                ->setCentre_libelle($row->centre_libelle)
                ->setCentre_description($row->centre_description)
                ->setCentre_ville($row->centre_ville)
                ->setCentre_quartier($row->centre_quartier)
                    ->setId_pays($row->id_pays)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCentre();
            $entry->setCentre_id($row->centre_id)
	                ->setCentre_libelle($row->centre_libelle)
                    ->setCentre_description($row->centre_description)
                    ->setCentre_ville($row->centre_ville)
	                ->setCentre_quartier($row->centre_quartier)
                    ->setId_pays($row->id_pays)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(centre_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuCentre $centre) {
        $data = array(
            'centre_id' => $centre->getCentre_id(),
            'centre_libelle' => $centre->getCentre_libelle(),
            'centre_description' => $centre->getCentre_description(),
            'centre_ville' => $centre->getCentre_ville(),
            'centre_quartier' => $centre->getCentre_quartier(),
            'id_pays' => $centre->getId_pays(),
            'publier' => $centre->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCentre $centre) {
        $data = array(
            'centre_id' => $centre->getCentre_id(),
            'centre_libelle' => $centre->getCentre_libelle(),
            'centre_description' => $centre->getCentre_description(),
            'centre_ville' => $centre->getCentre_ville(),
            'centre_quartier' => $centre->getCentre_quartier(),
            'id_pays' => $centre->getId_pays(),
            'publier' => $centre->getPublier()
        );
        $this->getDbTable()->update($data, array('centre_id = ?' => $centre->getCentre_id()));
    }

    public function delete($centre_id) {
        $this->getDbTable()->delete(array('centre_id = ?' => $centre_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("centre_libelle ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCentre();
            $entry->setCentre_id($row->centre_id)
	                ->setCentre_libelle($row->centre_libelle)
                    ->setCentre_description($row->centre_description)
                    ->setCentre_ville($row->centre_ville)
	                ->setCentre_quartier($row->centre_quartier)
                    ->setId_pays($row->id_pays)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByPaysVilleQuartier($id_pays = 0,$centre_ville = 0,$centre_quartier = 0) {
        $select = $this->getDbTable()->select();
		if($id_pays > 0){
		$select->where("id_pays = ? ", $id_pays);
		}
		if($centre_ville > 0){
		$select->where("centre_ville = ? ", $centre_ville);
		}
		if($centre_quartier > 0){
		$select->where("centre_quartier = ? ", $centre_quartier);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCentre();
            $entry->setCentre_id($row->centre_id)
	                ->setCentre_libelle($row->centre_libelle)
                    ->setCentre_description($row->centre_description)
                    ->setCentre_ville($row->centre_ville)
	                ->setCentre_quartier($row->centre_quartier)
                    ->setId_pays($row->id_pays)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
