<?php

class Application_Model_EuDocumentMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDocument');
        }
        return $this->_dbTable;
    }

    public function find($id_document, Application_Model_EuDocument $document) {
        $result = $this->getDbTable()->find($id_document);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $document->setId_document($row->id_document)
                ->setId_type_document($row->id_type_document)
                ->setNom_document($row->nom_document)
                ->setDescrip_document($row->descrip_document)
                ->setDate_creation($row->date_creation)
                ->setDate_debut($row->date_debut)
                ->setDate_fin($row->date_fin)
                ->setPublier($row->publier)
                ->setAccord($row->accord)
                ->setNum_appeloffres($row->num_appeloffres)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_document) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDocument $document) {
        $data = array(
            'id_document' => $document->getId_document(),
            'id_type_document' => $document->getId_type_document(),
            'nom_document' => $document->getNom_document(),
            'descrip_document' => $document->getDescrip_document(),
            'date_creation' => $document->getDate_creation(),
            'date_debut' => $document->getDate_debut(),
            'date_fin' => $document->getDate_fin(),
            'publier' => $document->getPublier(),
            'accord' => $document->getAccord(),
            'num_appeloffres' => $document->getNum_appeloffres(),
            'id_utilisateur' => $document->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDocument $document) {
        $data = array(
            'id_document' => $document->getId_document(),
            'id_type_document' => $document->getId_type_document(),
            'nom_document' => $document->getNom_document(),
            'descrip_document' => $document->getDescrip_document(),
            'date_creation' => $document->getDate_creation(),
            'date_debut' => $document->getDate_debut(),
            'date_fin' => $document->getDate_fin(),
            'publier' => $document->getPublier(),
            'accord' => $document->getAccord(),
            'num_appeloffres' => $document->getNum_appeloffres(),
            'id_utilisateur' => $document->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_document = ?' => $document->getId_document()));
    }

    public function delete($id_document) {
        $this->getDbTable()->delete(array('id_document = ?' => $id_document));
    }


    public function fetchAll2($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->order(array("date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3() {
        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->where("date_debut <= ? ", $date_id->toString('yyyy-MM-dd'));
		$select->where("date_fin >= ? ", $date_id->toString('yyyy-MM-dd'));
		$select->order(array("eu_document.id_utilisateur ASC", "eu_document.date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll4($id_type_document) {
        $select = $this->getDbTable()->select();
		$select->where("id_type_document = ? ", $id_type_document);
		$select->where("publier = ? ", 1);
		$select->order(array("date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll5($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_document.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		
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
		
		$select->order(array("eu_document.date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll6($id_type_document = 0, $code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_document.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');

		if($id_type_document > 0){
		$select->where("eu_document.id_type_document = ? ", $id_type_document);}
		
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
		
		$select->where("eu_document.publier = ? ", 1);
				
		$select->order(array("eu_document.id_utilisateur ASC", "eu_document.date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function find2($id_document, Application_Model_EuDocument $document) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array("id_document", "id_type_document", "nom_document", "descrip_document", "date_creation", "publier", "accord", "num_appeloffres", "id_utilisateur", "date_debut", "date_fin"));
		$select->where("id_document = ? ", $id_document);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $document->setId_document($row->id_document)
                ->setId_type_document($row->id_type_document)
                ->setNom_document($row->nom_document)
                ->setDescrip_document($row->descrip_document)
                ->setDate_creation($row->date_creation)
                ->setDate_debut($row->date_debut)
                ->setDate_fin($row->date_fin)
                ->setPublier($row->publier)
				->setAccord($row->accord)
				->setNum_appeloffres($row->num_appeloffres)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function find3($id_document, Application_Model_EuDocument $document) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array("id_document", "id_type_document", "nom_document", "descrip_document", "date_creation", "publier", "accord", "num_appeloffres", "id_utilisateur", "date_debut", "date_fin"));
		$select->where("id_document = ? ", $id_document);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $document->setId_document($row->id_document)
                ->setId_type_document($row->id_type_document)
                ->setNom_document($row->nom_document)
                ->setDescrip_document($row->descrip_document)
                ->setDate_creation($row->date_creation)
                ->setDate_debut($row->date_debut)
                ->setDate_fin($row->date_fin)
                ->setPublier($row->publier)
				->setAccord($row->accord)
				->setNum_appeloffres($row->num_appeloffres)
                ->setId_utilisateur($row->id_utilisateur);
    }

	
    public function fetchAll50($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_document.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		
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
		
		//$select->where("eu_document.publier = ? ", 1);
		$select->where("eu_document.accord != ? ", 2);

		$select->order(array("eu_document.date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function fetchAll51($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_document.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		
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
		
		$select->where("eu_document.publier = ? ", 1);
		$select->where("eu_document.accord = ? ", 2);

		$select->order(array("eu_document.date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll7($id_type_document = 0, $code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_document.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');

		if($id_type_document > 0){
		$select->where("eu_document.id_type_document = ? ", $id_type_document);}
		
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
		
		//$select->where("eu_document.publier = ? ", 1);
				
		$select->order(array("eu_document.id_utilisateur ASC", "eu_document.date_creation DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDocument();
            $entry->setId_document($row->id_document)
	                ->setId_type_document($row->id_type_document)
                    ->setNom_document($row->nom_document)
                    ->setDescrip_document($row->descrip_document)
                    ->setDate_creation($row->date_creation)
					->setDate_debut($row->date_debut)
					->setDate_fin($row->date_fin)
                	->setPublier($row->publier)
					->setAccord($row->accord)
					->setNum_appeloffres($row->num_appeloffres)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
}


?>
