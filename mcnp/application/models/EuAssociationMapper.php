<?php
 
class Application_Model_EuAssociationMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuAssociation');
        }
        return $this->_dbTable;
    }

    public function find($association_id, Application_Model_EuAssociation $association) {
        $result = $this->getDbTable()->find($association_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $association->setAssociation_id($row->association_id)
                ->setAssociation_nom($row->association_nom)
                ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                ->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
	                ->setAssociation_nom($row->association_nom)
	                ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                	->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(association_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuAssociation $association) {
        $data = array(
            'association_id' => $association->getAssociation_id(),
            'association_nom' => $association->getAssociation_nom(),
            'association_numero' => $association->getAssociation_numero(),
            'association_mobile' => $association->getAssociation_mobile(),
            'association_date_agrement' => $association->getAssociation_date_agrement(),
            'association_email' => $association->getAssociation_email(),
            'association_recepisse' => $association->getAssociation_recepisse(),
            'association_adresse' => $association->getAssociation_adresse(),
            'association_date' => $association->getAssociation_date(),
            'id_filiere' => $association->getId_filiere(),
            'code_type_acteur' => $association->getCode_type_acteur(),
            'code_statut' => $association->getCode_statut(),
            'code_agence' => $association->getCode_agence(),
            'guichet' => $association->getGuichet(),
            'publier' => $association->getPublier(),
            'code_membre' => $association->getCode_membre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAssociation $association) {
        $data = array(
            'association_nom' => $association->getAssociation_nom(),
            'association_numero' => $association->getAssociation_numero(),
            'association_mobile' => $association->getAssociation_mobile(),
            'association_date_agrement' => $association->getAssociation_date_agrement(),
            'association_email' => $association->getAssociation_email(),
            'association_recepisse' => $association->getAssociation_recepisse(),
            'association_adresse' => $association->getAssociation_adresse(),
            'association_date' => $association->getAssociation_date(),
            'id_filiere' => $association->getId_filiere(),
            'code_type_acteur' => $association->getCode_type_acteur(),
            'code_statut' => $association->getCode_statut(),
            'code_agence' => $association->getCode_agence(),
            'guichet' => $association->getGuichet(),
            'publier' => $association->getPublier(),
            'code_membre' => $association->getCode_membre()
        );
        $this->getDbTable()->update($data, array('association_id = ?' => $association->getAssociation_id()));
    }

    public function delete($association_id) {
        $this->getDbTable()->delete(array('association_id = ?' => $association_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
	                ->setAssociation_nom($row->association_nom)
	                ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                	->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3() {
        $select = $this->getDbTable()->select();
        $select->order(array('association_id DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
                    ->setAssociation_nom($row->association_nom)
                    ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                    ->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByRechercheAssociation($nom) {
        $select = $this->getDbTable()->select();
		$select->where("LOWER(REPLACE(CONCAT(association_nom), ' ', '')) = ? ", strtolower(str_replace(" ", "", $nom)));
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
	                ->setAssociation_nom($row->association_nom)
	                ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                	->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
			$entries = $entry;
        return $entries;
    }





    public function fetchAll4() {
        $select = $this->getDbTable()->select();
        $select->where("association_id IN (SELECT membreasso_association FROM eu_membreasso WHERE code_membre LIKE '%M')");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
                    ->setAssociation_nom($row->association_nom)
                    ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                    ->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByGuichet() {
        $select = $this->getDbTable()->select();
        $select->where("guichet = 1");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
                    ->setAssociation_nom($row->association_nom)
                    ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                    ->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByMembreGuichet($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre LIKE '".$code_membre."' ");
        $select->where("guichet = 1");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
                    ->setAssociation_nom($row->association_nom)
                    ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                    ->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3Recherche($association_nom) {
        $select = $this->getDbTable()->select();
        //$select->where("LOWER(REPLACE(CONCAT(association_nom), ' ', '')) LIKE '%".strtolower(str_replace(" ", "", $association_nom))."%' ");
		$select->where("association_nom like '%".$association_nom."%'");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAssociation();
            $entry->setAssociation_id($row->association_id)
                    ->setAssociation_nom($row->association_nom)
                    ->setAssociation_numero($row->association_numero)
                ->setAssociation_mobile($row->association_mobile)
                ->setAssociation_date_agrement($row->association_date_agrement)
                ->setAssociation_email($row->association_email)
                ->setAssociation_recepisse($row->association_recepisse)
                ->setAssociation_adresse($row->association_adresse)
                ->setAssociation_date($row->association_date)
                ->setId_filiere($row->id_filiere)
                ->setCode_type_acteur($row->code_type_acteur)
                ->setCode_statut($row->code_statut)
                ->setCode_agence($row->code_agence)
                ->setGuichet($row->guichet)
                    ->setPublier($row->publier)
                ->setCode_membre($row->code_membre)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

}


?>
