<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCycleFormationMapper
 *
 */
class Application_Model_EuCycleFormationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCycleFormation');
        }
        return $this->_dbTable;
    }
	
	protected $id;
    protected $code_cycle_formation;
    protected $nom_cycle_formation;
    protected $duree_annee_formation;
    protected $duree_cycle_formation;
	protected $taux_cycle_formation;

    public function save(Application_Model_EuCycleFormation $formation) {
        $data = array(
         'id' => $formation->getId(),
         'code_cycle_formation' => $formation->getCode_cycle_formation(),
         'nom_cycle_formation' => $formation->getNom_cycle_formation(),
         'duree_annee_formation' => $formation->getDuree_annee_formation(),
		 'duree_cycle_formation' => $formation->getDuree_cycle_formation(),
         'taux_cycle_formation' => $formation->getTaux_cycle_formation()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCycleFormation $formation) {
        $data = array(
         'id' => $formation->getId(),
         'code_cycle_formation' => $formation->getCode_cycle_formation(),
         'nom_cycle_formation' => $formation->getNom_cycle_formation(),
         'duree_annee_formation' => $formation->getDuree_annee_formation(),
		 'duree_cycle_formation' => $formation->getDuree_cycle_formation(),
         'taux_cycle_formation' => $formation->getTaux_cycle_formation()
        );
        $this->getDbTable()->update($data, array('id = ?' => $formation->getId()));
    }

    public function find($id, Application_Model_EuCycleFormation $formation) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $formation->setId($row->id)
                  ->setCode_cycle_formation($row->code_cycle_formation)
                  ->setNom_cycle_formation($row->nom_cycle_formation)
				  ->setDuree_annee_formation($row->duree_annee_formation)
                  ->setDuree_cycle_formation($row->duree_cycle_formation)
                  ->setTaux_cycle_formation($row->taux_cycle_formation);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCours();
            $entry->setId($row->id)
                  ->setCode_cycle_formation($row->code_cycle_formation)
                  ->setNom_cycle_formation($row->nom_cycle_formation)
				  ->setDuree_annee_formation($row->duree_annee_formation)
                  ->setDuree_cycle_formation($row->duree_cycle_formation)
                  ->setTaux_cycle_formation($row->taux_cycle_formation);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

}

?>
