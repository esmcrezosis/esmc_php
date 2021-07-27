<?php

class Application_Model_EuDemandeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDemande');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuDemande $demande) {
        $data = array(
            'id_demande' => $demande->getId_demande(),
            'objet_demande' => $demande->getObjet_demande(),
            'description_demande' => $demande->getDescription_demande(),
            'date_demande' => $demande->getDate_demande(),
            'code_membre_morale' => $demande->getCode_membre_morale(),
            'publier' => $demande->getPublier(),
            'livrer' => $demande->getLivrer()
        );
        $this->getDbTable()->insert($data);
    }
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_demande) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    public function update(Application_Model_EuDemande $demande) {
        $data = array(
            'id_demande' => $demande->getId_demande(),
            'objet_demande' => $demande->getObjet_demande(),
            'description_demande' => $demande->getDescription_demande(),
            'date_demande' => $demande->getDate_demande(),
            'code_membre_morale' => $demande->getCode_membre_morale(),
            'publier' => $demande->getPublier(),
            'livrer' => $demande->getLivrer()
        );

        $this->getDbTable()->update($data, array('id_demande = ?' => $demande->getId_demande()));
    }
    public function find($id_demande, Application_Model_EuDemande $demande) {
        $result = $this->getDbTable()->find($id_demande);
		
        if (0 == count($result)) {
            return;
        }
		
        $row = $result->current();
        $demande->setId_demande($row->id_demande)
               ->setObjet_demande($row->objet_demande)
               ->setDescription_demande($row->description_demande)
               ->setDate_demande($row->date_demande)
               ->setCode_membre_morale($row->code_membre_morale)
               ->setPublier($row->publier)
               ->setLivrer($row->livrer);
}

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemande();
            $entry->setId_demande($row->id_demande);
            $entry->setObjet_demande($row->objet_demande);
            $entry->setDescription_demande($row->description_demande);
            $entry->setDate_demande($row->date_demande);
			$entry->setCode_membre_morale($row->code_membre_morale);
            $entry->setPublier($row->publier);
            $entry->setLivrer($row->livrer);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function delete($id_demande) {
        $this->getDbTable()->delete(array('id_demande = ?' => $id_demande));
    }


    public function fetchAll2($code_membre_morale) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre_morale = ? ", $code_membre_morale);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemande();
            $entry->setId_demande($row->id_demande);
            $entry->setObjet_demande($row->objet_demande);
            $entry->setDescription_demande($row->description_demande);
            $entry->setDate_demande($row->date_demande);
			$entry->setCode_membre_morale($row->code_membre_morale);
            $entry->setPublier($row->publier);
            $entry->setLivrer($row->livrer);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		//$select->where("code_membre_morale = ? ", $code_membre_morale);$code_membre_morale
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemande();
            $entry->setId_demande($row->id_demande);
            $entry->setObjet_demande($row->objet_demande);
            $entry->setDescription_demande($row->description_demande);
            $entry->setDate_demande($row->date_demande);
			$entry->setCode_membre_morale($row->code_membre_morale);
            $entry->setPublier($row->publier);
            $entry->setLivrer($row->livrer);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll4($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_demande.code_membre_morale');

		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}
		
		$select->where("eu_demande.publier = ? ", 1);
		$select->order(array("eu_demande.date_demande DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemande();
            $entry->setId_demande($row->id_demande);
            $entry->setObjet_demande($row->objet_demande);
            $entry->setDescription_demande($row->description_demande);
            $entry->setDate_demande($row->date_demande);
			$entry->setCode_membre_morale($row->code_membre_morale);
            $entry->setPublier($row->publier);
            $entry->setLivrer($row->livrer);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll5($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_demande.code_membre_morale');

		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}
		
		$select->where("eu_demande.publier = ? ", 1);
		$select->where("eu_demande.livrer != ? ", 1);
		$select->orwhere("eu_demande.livrer is NULL");
		$select->order(array("eu_demande.date_demande DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemande();
            $entry->setId_demande($row->id_demande);
            $entry->setObjet_demande($row->objet_demande);
            $entry->setDescription_demande($row->description_demande);
            $entry->setDate_demande($row->date_demande);
			$entry->setCode_membre_morale($row->code_membre_morale);
            $entry->setPublier($row->publier);
            $entry->setLivrer($row->livrer);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}


