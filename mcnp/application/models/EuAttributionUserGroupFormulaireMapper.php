<?php
 
class Application_Model_EuAttributionUserGroupFormulaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAttributionUserGroupFormulaire');
        }
        return $this->_dbTable;
    }

    public function find($attribution_user_group_formulaire_id, Application_Model_EuAttributionUserGroupFormulaire $attribution_user_group_formulaire) {
        $result = $this->getDbTable()->find($attribution_user_group_formulaire_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $attribution_user_group_formulaire->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
                ->setCode_groupe_arrivee($row->code_groupe_arrivee)
                ->setCode_groupe_depart($row->code_groupe_depart)
                ->setFormulaire_id($row->formulaire_id)
                ->setCode_groupe_autre($row->code_groupe_autre)
                ->setEtat($row->etat)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("attribution_user_group_formulaire_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAttributionUserGroupFormulaire();
            $entry->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
	                ->setCode_groupe_arrivee($row->code_groupe_arrivee)
                ->setCode_groupe_depart($row->code_groupe_depart)
                ->setFormulaire_id($row->formulaire_id)
                ->setCode_groupe_autre($row->code_groupe_autre)
                ->setEtat($row->etat)
					;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(attribution_user_group_formulaire_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAttributionUserGroupFormulaire $attribution_user_group_formulaire) {
        $data = array(
            'attribution_user_group_formulaire_id' => $attribution_user_group_formulaire->getAttribution_user_group_formulaire_id(),
            'code_groupe_arrivee' => $attribution_user_group_formulaire->getCode_groupe_arrivee(),
            'code_groupe_depart' => $attribution_user_group_formulaire->getCode_groupe_depart(),
            'code_groupe_autre' => $attribution_user_group_formulaire->getCode_groupe_autre(),
            'etat' => $attribution_user_group_formulaire->getEtat(),
            'formulaire_id' => $attribution_user_group_formulaire->getFormulaire_id()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAttributionUserGroupFormulaire $attribution_user_group_formulaire) {
        $data = array(
            'attribution_user_group_formulaire_id' => $attribution_user_group_formulaire->getAttribution_user_group_formulaire_id(),
            'code_groupe_arrivee' => $attribution_user_group_formulaire->getCode_groupe_arrivee(),
            'code_groupe_depart' => $attribution_user_group_formulaire->getCode_groupe_depart(),
            'code_groupe_autre' => $attribution_user_group_formulaire->getCode_groupe_autre(),
            'etat' => $attribution_user_group_formulaire->getEtat(),
            'formulaire_id' => $attribution_user_group_formulaire->getFormulaire_id()
        );
        $this->getDbTable()->update($data, array('attribution_user_group_formulaire_id = ?' => $attribution_user_group_formulaire->getAttribution_user_group_formulaire_id()));
    }

    public function delete($attribution_user_group_formulaire_id) {
        $this->getDbTable()->delete(array('attribution_user_group_formulaire_id = ?' => $attribution_user_group_formulaire_id));
    }


    public function fetchAllByFormulaireDepart($formulaire_id = 0, $code_groupe_depart = "") {
        $select = $this->getDbTable()->select();
        if($formulaire_id > 0){
        $select->where("formulaire_id = ? ", $formulaire_id);           
        }
        if($code_groupe_depart != ""){
        $select->where("code_groupe_depart = ? ", $code_groupe_depart);           
        $select->where("(code_groupe_autre IS NULL");           
        $select->orwhere("code_groupe_autre != '')");           
        }
        //if($code_groupe_autre != ""){
        //}
        //if($code_groupe_arrivee != ""){
        //$select->where("code_groupe_arrivee = ? ", $code_groupe_arrivee);           
        //}
        $select->where("etat = ? ", 1);           
		//$select->order("code_groupe_depart ASC", "code_groupe_arrivee ASC", "attribution_user_group_formulaire_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAttributionUserGroupFormulaire();
            $entry->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
	                ->setCode_groupe_arrivee($row->code_groupe_arrivee)
                ->setCode_groupe_depart($row->code_groupe_depart)
                ->setFormulaire_id($row->formulaire_id)
                ->setCode_groupe_autre($row->code_groupe_autre)
                    ->setEtat($row->etat)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByFormulaireDepartAutre($formulaire_id = 0, $code_groupe_depart = "", $code_groupe_autre = "") {
        $select = $this->getDbTable()->select();
        if($formulaire_id > 0){
        $select->where("formulaire_id = ? ", $formulaire_id);           
        }
        if($code_groupe_depart != ""){
        $select->where("code_groupe_depart = ? ", $code_groupe_depart);           
        }
        if($code_groupe_autre != ""){
        $select->where("code_groupe_autre = ? ", $code_groupe_autre);           
        }
        //if($code_groupe_arrivee != ""){
        //$select->where("code_groupe_arrivee = ? ", $code_groupe_arrivee);           
        //}
        $select->where("etat = ? ", 1);           
        //$select->order("code_groupe_depart ASC", "code_groupe_arrivee ASC", "attribution_user_group_formulaire_id ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAttributionUserGroupFormulaire();
            $entry->setAttribution_user_group_formulaire_id($row->attribution_user_group_formulaire_id)
                    ->setCode_groupe_arrivee($row->code_groupe_arrivee)
                ->setCode_groupe_depart($row->code_groupe_depart)
                ->setFormulaire_id($row->formulaire_id)
                ->setCode_groupe_autre($row->code_groupe_autre)
                    ->setEtat($row->etat)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	

	


}


?>
