<?php

class Application_Model_EuAppeloffresMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAppeloffres');
        }
        return $this->_dbTable;
    }

    public function find($id_appeloffres, Application_Model_EuAppeloffres $appeloffres) {
        $result = $this->getDbTable()->find($id_appeloffres);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $appeloffres->setId_appeloffres($row->id_appeloffres)
                ->setId_document($row->id_document)
                ->setNum_appeloffres($row->num_appeloffres)
                ->setLibelle_appeloffres($row->libelle_appeloffres)
                ->setDesc_appeloffres($row->desc_appeloffres)
                ->setDate_appeloffres($row->date_appeloffres)
                ->setPreselection($row->preselection)
                ->setSelection($row->selection)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setPropo($row->propo)
                ->setOkfinal($row->okfinal)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
	                ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_appeloffres) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function findappeloffre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where('code_membre_morale LIKE ?', $code_membre);
       $results = $this->getDbTable()->fetchAll($select);
		    if (count($results) > 0) {
		       $row = $results->current();
               $offres = new Application_Model_EuAppeloffres();
               $offres->setId_appeloffres($row->id_appeloffres)
                      ->setNum_appeloffres($row->num_appeloffres)
                      ->setLibelle_appeloffres($row->libelle_appeloffres)
                      ->setDesc_appeloffres($row->desc_appeloffres)
                      ->setDate_appeloffres($row->date_appeloffres)
					  ->setPreselection($row->preselection)
                      ->setId_utilisateur($row->id_utilisateur)
					  ->setSelection($row->selection)
					  ->setId_document($row->id_document)
					  ->setPropo($row->propo)
					->setOkfinal($row->okfinal)
					->setCode_membre_morale($row->code_membre_morale);
              return $offres; 
		   } else {
              return false;
           }
	}
	



	public function findoffres($num_offre) {
	   $select = $this->getDbTable()->select();
	   $select->where('num_appeloffres LIKE ?', $num_offre)
              ->where('code_membre_morale  IS NULL')
			  ->where('selection = ?',1)
			  ->where('okfinal = ?',1);
            $results = $this->getDbTable()->fetchAll($select);
		    if (count($results) > 0) {
		       $row = $results->current();
               $offres = new Application_Model_EuAppeloffres();
               $offres->setId_appeloffres($row->id_appeloffres)
                      ->setNum_appeloffres($row->num_appeloffres)
                      ->setLibelle_appeloffres($row->libelle_appeloffres)
                      ->setDesc_appeloffres($row->desc_appeloffres)
                      ->setDate_appeloffres($row->date_appeloffres)
					  ->setPreselection($row->preselection)
                      ->setId_utilisateur($row->id_utilisateur)
					  ->setSelection($row->selection)
					  ->setId_document($row->id_document)
					  ->setPropo($row->propo)
					->setOkfinal($row->okfinal)
					  ->setCode_membre_morale($row->code_membre_morale);
              return $offres; 
		   } else {
              return false;
           }
	}
	
	
	
    public function save(Application_Model_EuAppeloffres $appeloffres) {
        $data = array(
            'id_appeloffres' => $appeloffres->getId_appeloffres(),
            'id_document' => $appeloffres->getId_document(),
            'num_appeloffres' => $appeloffres->getNum_appeloffres(),
            'libelle_appeloffres' => $appeloffres->getLibelle_appeloffres(),
            'desc_appeloffres' => $appeloffres->getDesc_appeloffres(),
            'date_appeloffres' => $appeloffres->getDate_appeloffres(),
            'preselection' => $appeloffres->getPreselection(),
            'selection' => $appeloffres->getSelection(),
            'code_membre_morale' => $appeloffres->getCode_membre_morale(),
            'propo' => $appeloffres->getPropo(),
            'okfinal' => $appeloffres->getOkfinal(),
            'id_utilisateur' => $appeloffres->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAppeloffres $appeloffres) {
        $data = array(
            //'id_appeloffres' => $appeloffres->getId_appeloffres(),
            'id_document' => $appeloffres->getId_document(),
            'num_appeloffres' => $appeloffres->getNum_appeloffres(),
            'libelle_appeloffres' => $appeloffres->getLibelle_appeloffres(),
            'desc_appeloffres' => $appeloffres->getDesc_appeloffres(),
            'date_appeloffres' => $appeloffres->getDate_appeloffres(),
            'preselection' => $appeloffres->getPreselection(),
            'selection' => $appeloffres->getSelection(),
            'code_membre_morale' => $appeloffres->getCode_membre_morale(),
            'propo' => $appeloffres->getPropo(),
            'okfinal' => $appeloffres->getOkfinal(),
            'id_utilisateur' => $appeloffres->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_appeloffres = ?' => $appeloffres->getId_appeloffres()));
    }

    public function delete($id_appeloffres) {
        $this->getDbTable()->delete(array('id_appeloffres = ?' => $id_appeloffres));
    }


    public function fetchAll2($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
		$select->order(array("date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		$select->where("preselection = ? ", 1);
		$select->order(array("date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
	                ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll4() {
        $select = $this->getDbTable()->select();
		$select->where("selection = ? ", 1);
		$select->order(array("date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
	                ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll6($id_document) {
        $select = $this->getDbTable()->select();
		$select->where("id_document = ? ", $id_document);
		$select->order(array("date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
	                ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	

    public function findConuterAnnee() {
            $date = Zend_Date::now();
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_appeloffres) as count'));
		$select->where("num_appeloffres LIKE ? ", "%/".($date->toString('yyyy')-1)."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $lastyear = $row['count'];
		
		$select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_appeloffres) as count'));
		//$select->where("num_appeloffres = ? ", "%/".date('y')."/%");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        $newyear = $row['count'];
		
		return $newyear - $lastyear;
		
    }
	
	
    public function fetchAll7($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appeloffres.id_utilisateur');
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
		
		$select->order(array("eu_appeloffres.id_document DESC", "eu_appeloffres.date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll8($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appeloffres.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		$select->where("eu_appeloffres.code_membre_morale IS NULL");
		
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
		
		$select->where("(eu_appeloffres.selection = ? ", 1);
		$select->where("eu_appeloffres.id_document IN (SELECT id_document FROM eu_document WHERE accord <= 2))");
		
		$select->orwhere("(eu_appeloffres.selection = ? ", 0);
		$select->where("eu_appeloffres.id_document IN (SELECT id_document FROM eu_document WHERE accord <= 1))");
		
		$select->order(array("eu_appeloffres.id_document DESC", "eu_appeloffres.date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll9($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appeloffres.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		$select->where("eu_appeloffres.code_membre_morale IS NULL");
		
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
		
		$select->where("(eu_appeloffres.selection = ? ", 1);
		$select->where("eu_appeloffres.id_document IN (SELECT id_document FROM eu_document WHERE accord = 2))");
		
		
		$select->order(array("eu_appeloffres.id_document DESC", "eu_appeloffres.date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function fetchAll10($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appeloffres.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		$select->where("eu_appeloffres.code_membre_morale IS NOT NULL");
		
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
		
		$select->where("(eu_appeloffres.selection = ? ", 1);
		$select->where("eu_appeloffres.id_document IN (SELECT id_document FROM eu_document WHERE accord <= 2))");
		
		$select->orwhere("(eu_appeloffres.selection = ? ", 0);
		$select->where("eu_appeloffres.id_document IN (SELECT id_document FROM eu_document WHERE accord <= 1))");
		
		$select->order(array("eu_appeloffres.id_document DESC", "eu_appeloffres.date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll11($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appeloffres.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		$select->where("eu_appeloffres.code_membre_morale IS NOT NULL");
		
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
		
		$select->where("(eu_appeloffres.selection = ? ", 1);
		$select->where("eu_appeloffres.id_document IN (SELECT id_document FROM eu_document WHERE accord = 2))");
		
		
		$select->order(array("eu_appeloffres.id_document DESC", "eu_appeloffres.date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
    public function fetchAll12($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appeloffres.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');
		$select->where("eu_appeloffres.code_membre_morale IS NULL");
		
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
		
		//$select->where("eu_appeloffres.preselection != ? ", 1);
		//$select->where("eu_appeloffres.selection != ? ", 1);
		//$select->where("eu_appeloffres.okfinal != ? ", 1);
		$select->where("eu_appeloffres.id_document NOT IN (SELECT id_document FROM eu_document WHERE accord = 2)");
		
		
		$select->order(array("eu_appeloffres.id_document DESC", "eu_appeloffres.date_appeloffres DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppeloffres();
            $entry->setId_appeloffres($row->id_appeloffres)
	                ->setId_document($row->id_document)
                    ->setNum_appeloffres($row->num_appeloffres)
					->setLibelle_appeloffres($row->libelle_appeloffres)
                    ->setDesc_appeloffres($row->desc_appeloffres)
                    ->setDate_appeloffres($row->date_appeloffres)
                	->setPreselection($row->preselection)
					->setSelection($row->selection)
 	               ->setCode_membre_morale($row->code_membre_morale)
                	->setPropo($row->propo)
					->setOkfinal($row->okfinal)
	                ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
}


?>
