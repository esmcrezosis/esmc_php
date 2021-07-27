<?php
 
class Application_Model_EuAttributionUtilisateurFormulaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAttributionUtilisateurFormulaire');
        }
        return $this->_dbTable;
    }

    public function find($attribution_utilisateur_formulaire_id, Application_Model_EuAttributionUtilisateurFormulaire $attribution_utilisateur_formulaire) {
        $result = $this->getDbTable()->find($attribution_utilisateur_formulaire_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $attribution_utilisateur_formulaire->setAttribution_utilisateur_formulaire_id($row->attribution_utilisateur_formulaire_id)
                ->setCentrale_id($row->centrale_id)
                ->setProcedure_id($row->procedure_id)
                ->setFormulaire_id($row->formulaire_id)
                ->setId_utilisateur($row->id_utilisateur)
                ->setEtat($row->etat)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("attribution_utilisateur_formulaire_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAttributionUtilisateurFormulaire();
            $entry->setAttribution_utilisateur_formulaire_id($row->attribution_utilisateur_formulaire_id)
	                ->setCentrale_id($row->centrale_id)
                ->setProcedure_id($row->procedure_id)
                ->setFormulaire_id($row->formulaire_id)
                ->setId_utilisateur($row->id_utilisateur)
                ->setEtat($row->etat)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(attribution_utilisateur_formulaire_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAttributionUtilisateurFormulaire $attribution_utilisateur_formulaire) {
        $data = array(
            'attribution_utilisateur_formulaire_id' => $attribution_utilisateur_formulaire->getAttribution_utilisateur_formulaire_id(),
            'centrale_id' => $attribution_utilisateur_formulaire->getCentrale_id(),
            'procedure_id' => $attribution_utilisateur_formulaire->getProcedure_id(),
            'id_utilisateur' => $attribution_utilisateur_formulaire->getId_utilisateur(),
            'etat' => $attribution_utilisateur_formulaire->getEtat(),
            'formulaire_id' => $attribution_utilisateur_formulaire->getFormulaire_id()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAttributionUtilisateurFormulaire $attribution_utilisateur_formulaire) {
        $data = array(
            'attribution_utilisateur_formulaire_id' => $attribution_utilisateur_formulaire->getAttribution_utilisateur_formulaire_id(),
            'centrale_id' => $attribution_utilisateur_formulaire->getCentrale_id(),
            'procedure_id' => $attribution_utilisateur_formulaire->getProcedure_id(),
            'id_utilisateur' => $attribution_utilisateur_formulaire->getId_utilisateur(),
            'etat' => $attribution_utilisateur_formulaire->getEtat(),
            'formulaire_id' => $attribution_utilisateur_formulaire->getFormulaire_id()
        );
        $this->getDbTable()->update($data, array('attribution_utilisateur_formulaire_id = ?' => $attribution_utilisateur_formulaire->getAttribution_utilisateur_formulaire_id()));
    }

    public function delete($attribution_utilisateur_formulaire_id) {
        $this->getDbTable()->delete(array('attribution_utilisateur_formulaire_id = ?' => $attribution_utilisateur_formulaire_id));
    }


    public function fetchAllByProcedureUtilisateurFormulaireCentrale($procedure_id = 0, $formulaire_id = 0, $id_utilisateur = "", $centrale_id = 0) {
        $select = $this->getDbTable()->select();
        if($procedure_id > 0){
        $select->where("procedure_id = ? ", $procedure_id);           
        }
        if($formulaire_id > 0){
        $select->where("formulaire_id = ? ", $formulaire_id);           
        }
        if($id_utilisateur != ""){
        $select->where("id_utilisateur = ? ", $id_utilisateur);           
        }
        if($centrale_id > 0){
        $select->where("centrale_id = ? ", $centrale_id);           
        }
        $select->where("etat = ? ", 1);           
		$select->order("procedure_id ASC", "centrale_id ASC", "attribution_utilisateur_formulaire_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAttributionUtilisateurFormulaire();
            $entry->setAttribution_utilisateur_formulaire_id($row->attribution_utilisateur_formulaire_id)
	                ->setCentrale_id($row->centrale_id)
                ->setProcedure_id($row->procedure_id)
                ->setFormulaire_id($row->formulaire_id)
                ->setId_utilisateur($row->id_utilisateur)
                    ->setEtat($row->etat)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


	
	

	


}


?>
