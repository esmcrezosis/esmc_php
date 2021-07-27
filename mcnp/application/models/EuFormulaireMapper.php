<?php

class Application_Model_EuFormulaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFormulaire');
        }
        return $this->_dbTable;
    }

    public function find($formulaire_id, Application_Model_EuFormulaire $formulaire) {
        $result = $this->getDbTable()->find($formulaire_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $formulaire->setFormulaire_id($row->formulaire_id)
                ->setFormulaire_libelle($row->formulaire_libelle)
                ->setFormulaire_description($row->formulaire_description)
                ->setFormulaire_url($row->formulaire_url)
                ->setFormulaire_nom($row->formulaire_nom)
                ->setFormulaire_procedure($row->formulaire_procedure)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFormulaire();
            $entry->setFormulaire_id($row->formulaire_id)
	                ->setFormulaire_libelle($row->formulaire_libelle)
                    ->setFormulaire_description($row->formulaire_description)
                    ->setFormulaire_url($row->formulaire_url)
	                ->setFormulaire_nom($row->formulaire_nom)
                    ->setFormulaire_procedure($row->formulaire_procedure)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(formulaire_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFormulaire $formulaire) {
        $data = array(
            'formulaire_id' => $formulaire->getFormulaire_id(),
            'formulaire_libelle' => $formulaire->getFormulaire_libelle(),
            'formulaire_description' => $formulaire->getFormulaire_description(),
            'formulaire_url' => $formulaire->getFormulaire_url(),
            'formulaire_nom' => $formulaire->getFormulaire_nom(),
            'formulaire_procedure' => $formulaire->getFormulaire_procedure(),
            'publier' => $formulaire->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFormulaire $formulaire) {
        $data = array(
            'formulaire_id' => $formulaire->getFormulaire_id(),
            'formulaire_libelle' => $formulaire->getFormulaire_libelle(),
            'formulaire_description' => $formulaire->getFormulaire_description(),
            'formulaire_url' => $formulaire->getFormulaire_url(),
            'formulaire_nom' => $formulaire->getFormulaire_nom(),
            'formulaire_procedure' => $formulaire->getFormulaire_procedure(),
            'publier' => $formulaire->getPublier()
        );
        $this->getDbTable()->update($data, array('formulaire_id = ?' => $formulaire->getFormulaire_id()));
    }

    public function delete($formulaire_id) {
        $this->getDbTable()->delete(array('formulaire_id = ?' => $formulaire_id));
    }




    public function fetchAllByProcedure($formulaire_procedure) {
        $select = $this->getDbTable()->select();
        $select->where("formulaire_procedure = ? ", $formulaire_procedure);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFormulaire();
            $entry->setFormulaire_id($row->formulaire_id)
                    ->setFormulaire_libelle($row->formulaire_libelle)
                    ->setFormulaire_description($row->formulaire_description)
                    ->setFormulaire_url($row->formulaire_url)
                    ->setFormulaire_nom($row->formulaire_nom)
                    ->setFormulaire_procedure($row->formulaire_procedure)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    

}


?>
