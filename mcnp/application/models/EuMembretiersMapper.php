<?php
 
class Application_Model_EuMembretiersMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMembretiers');
        }
        return $this->_dbTable;
    }

    public function find($membretiers_id, Application_Model_EuMembretiers $membretiers) {
        $result = $this->getDbTable()->find($membretiers_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $membretiers->setMembretiers_id($row->membretiers_id)
                ->setMembretiers_nom($row->membretiers_nom)
                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretiers();
            $entry->setMembretiers_id($row->membretiers_id)
	                ->setMembretiers_nom($row->membretiers_nom)
	                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(membretiers_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuMembretiers $membretiers) {
        $data = array(
            'membretiers_id' => $membretiers->getMembretiers_id(),
            'membretiers_nom' => $membretiers->getMembretiers_nom(),
            'membretiers_prenom' => $membretiers->getMembretiers_prenom(),
            'membretiers_mobile' => $membretiers->getMembretiers_mobile(),
            'membretiers_souscription' => $membretiers->getMembretiers_souscription(),
            'membretiers_email' => $membretiers->getMembretiers_email(),
            'membretiers_date' => $membretiers->getMembretiers_date(),
            'membretiers_filiere' => $membretiers->getMembretiers_filiere(),
            'code_activite' => $membretiers->getCode_activite(),
            'id_metier' => $membretiers->getId_metier(),
            'id_competence' => $membretiers->getId_competence(),
            'membretiers_ville' => $membretiers->getMembretiers_ville(),
            'membretiers_quartier' => $membretiers->getMembretiers_quartier(),
            'publier' => $membretiers->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembretiers $membretiers) {
        $data = array(
            'membretiers_nom' => $membretiers->getMembretiers_nom(),
            'membretiers_prenom' => $membretiers->getMembretiers_prenom(),
            'membretiers_mobile' => $membretiers->getMembretiers_mobile(),
            'membretiers_souscription' => $membretiers->getMembretiers_souscription(),
            'membretiers_email' => $membretiers->getMembretiers_email(),
            'membretiers_date' => $membretiers->getMembretiers_date(),
            'membretiers_filiere' => $membretiers->getMembretiers_filiere(),
            'code_activite' => $membretiers->getCode_activite(),
            'id_metier' => $membretiers->getId_metier(),
            'id_competence' => $membretiers->getId_competence(),
            'membretiers_ville' => $membretiers->getMembretiers_ville(),
            'membretiers_quartier' => $membretiers->getMembretiers_quartier(),
            'publier' => $membretiers->getPublier()
        );
        $this->getDbTable()->update($data, array('membretiers_id = ?' => $membretiers->getMembretiers_id()));
    }

    public function delete($membretiers_id) {
        $this->getDbTable()->delete(array('membretiers_id = ?' => $membretiers_id));
    }
	
    public function fetchAll1() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretiers();
            $entry->setMembretiers_id($row->membretiers_id)
	                ->setMembretiers_nom($row->membretiers_nom)
	                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretiers();
            $entry->setMembretiers_id($row->membretiers_id)
	                ->setMembretiers_nom($row->membretiers_nom)
	                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		//$select->where("publier = ? ", 1);
		$select->order(array("membretiers_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretiers();
            $entry->setMembretiers_id($row->membretiers_id)
	                ->setMembretiers_nom($row->membretiers_nom)
	                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllBySouscription($membretiers_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("membretiers_souscription = ? ", $membretiers_souscription);
		$select->order(array("membretiers_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretiers();
            $entry->setMembretiers_id($row->membretiers_id)
	                ->setMembretiers_nom($row->membretiers_nom)
	                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByAssociation($association) {
        $select = $this->getDbTable()->select();
		$select->where("membretiers_souscription IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association);
		$select->order(array("membretiers_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembretiers();
            $entry->setMembretiers_id($row->membretiers_id)
	                ->setMembretiers_nom($row->membretiers_nom)
	                ->setMembretiers_prenom($row->membretiers_prenom)
                ->setMembretiers_mobile($row->membretiers_mobile)
                ->setMembretiers_souscription($row->membretiers_souscription)
                ->setMembretiers_email($row->membretiers_email)
                ->setMembretiers_date($row->membretiers_date)
                ->setMembretiers_filiere($row->membretiers_filiere)
                ->setCode_activite($row->code_activite)
                ->setId_metier($row->id_metier)
                ->setId_competence($row->id_competence)
                ->setMembretiers_ville($row->membretiers_ville)
                ->setMembretiers_quartier($row->membretiers_quartier)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


?>
