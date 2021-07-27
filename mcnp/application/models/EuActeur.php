<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCnpEntree
 *
 * @author user
 */
class Application_Model_EuActeur {

    //put your code here
    protected $id_acteur;
    protected $code_acteur;
    protected $date_creation;
    protected $code_membre;
    protected $type_acteur;
    protected $code_activite;
    protected $id_utilisateur;
	protected $code_gac_chaine;
	protected $code_source_create;
	protected $code_monde_create;
	protected $code_zone_create;
	protected $id_pays;
	protected $id_region;
	protected $id_prefecture;
	protected $id_canton;
	protected $code_secteur_create;
	protected $code_agence_create;
	protected $code_division;


    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }

    public function getId_acteur() {
        return $this->id_acteur;
    }

    public function setId_acteur($id_acteur) {
        $this->id_acteur = $id_acteur;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getCode_acteur() {
        return $this->code_acteur;
    }

    public function setCode_acteur($code_acteur) {
        $this->code_acteur = $code_acteur;
        return $this;
    }

    public function getType_acteur() {
        return $this->type_acteur;
    }

    public function setType_acteur($type_acteur) {
        $this->type_acteur = $type_acteur;
        return $this;
    }
    
    public function getCode_activite(){
        return $this->code_activite;
    }
    
    public function setCode_activite($code_activite){
        $this->code_activite = $code_activite;
        return $this;
    }
    
    public function getCode_membre(){
        return $this->code_membre;
    }
    
    public function setCode_membre($code_membre){
        $this->code_membre = $code_membre;
        return $this;
    }
	
	public function getCode_gac_chaine(){
        return $this->code_gac_chaine;
    }
    
    public function setCode_gac_chaine($code_gac_chaine) {
        $this->code_gac_chaine = $code_gac_chaine;
        return $this;
    }
	
	public function getCode_source_create(){
        return $this->code_source_create;
    }
    
    public function setCode_source_create($code_source_create) {
        $this->code_source_create = $code_source_create;
        return $this;
    }
	
	public function getCode_monde_create(){
        return $this->code_monde_create;
    }
    
    public function setCode_monde_create($code_monde_create) {
        $this->code_monde_create = $code_monde_create;
        return $this;
    }
	
	public function getCode_zone_create(){
        return $this->code_zone_create;
    }
    
    public function setCode_zone_create($code_zone_create) {
        $this->code_zone_create = $code_zone_create;
        return $this;
    }
	
	public function getId_prefecture(){
        return $this->id_prefecture;
    }
    
    public function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }
	
	
	public function getId_canton(){
        return $this->id_canton;
    }
    
    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	
	
	public function getId_pays(){
        return $this->id_pays;
    }
    
    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	
	
	public function getId_region(){
      return $this->id_region;
    }
    
    public function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }
	
	public function getCode_secteur_create(){
        return $this->code_secteur_create;
    }
    
    public function setCode_secteur_create($code_secteur_create) {
        $this->code_secteur_create = $code_secteur_create;
        return $this;
    }
	
	
	public function getCode_agence_create(){
        return $this->code_agence_create;
    }
    
    public function setCode_agence_create($code_agence_create) {
        $this->code_agence_create = $code_agence_create;
        return $this;
    }
	
	public function getCode_division(){
        return $this->code_division;
    }
    
    public function setCode_division($code_division) {
        $this->code_division = $code_division;
        return $this;
    }
	
	
    public function exchangeArray($data) {
        $this->id_acteur = (isset($data['id_acteur'])) ? $data['id_acteur'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
        $this->type_acteur = (isset($data['type_acteur'])) ? $data['type_acteur'] : NULL;
        $this->code_acteur = (isset($data['code_acteur'])) ? $data['code_acteur'] : NULL;
        $this->code_activite = (isset($data['code_activite'])) ? $data['code_activite'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
		$this->code_gac_chaine = (isset($data['code_gac_chaine'])) ? $data['code_gac_chaine'] : NULL;
		$this->code_source_create = (isset($data['code_source_create'])) ? $data['code_source_create'] : NULL;
		$this->code_monde_create = (isset($data['code_monde_create'])) ? $data['code_monde_create'] : NULL;
		$this->code_zone_create = (isset($data['code_zone_create'])) ? $data['code_zone_create'] : NULL;
		$this->id_pays = (isset($data['id_pays'])) ? $data['id_pays'] : NULL;
		$this->id_region = (isset($data['id_region'])) ? $data['id_region'] : NULL;
		$this->id_prefecture = (isset($data['id_prefecture'])) ? $data['id_prefecture'] : NULL;
		$this->id_canton = (isset($data['id_canton'])) ? $data['id_canton'] : NULL;
		$this->code_secteur_create = (isset($data['code_secteur_create'])) ? $data['code_secteur_create'] : NULL;
		$this->code_division = (isset($data['code_division'])) ? $data['code_division'] : NULL;
    }

    public function toArray() {
        $data = array(
          'id_acteur' => $this->id_acteur,
          'id_utilisateur' => $this->id_utilisateur,
          'date_creation' => $this->date_creation,
          'code_acteur' => $this->code_acteur,
          'type_acteur' => $this->type_acteur,
          'code_activite' => $this->code_activite,
          'code_membre' => $this->code_membre,
		  'code_gac_chaine' => $this->code_gac_chaine,
		  'code_source_create' => $this->code_source_create,
		  'code_monde_create' => $this->code_monde_create,
		  'code_zone_create' => $this->code_zone_create,
		  'id_pays' => $this->id_pays,
		  'id_region' => $this->id_region,
		  'id_prefecture' => $this->id_prefecture,
		  'id_canton' => $this->id_canton,
		  'code_secteur_create' => $this->code_secteur_create,
		  'code_agence_create' => $this->code_agence_create,
		  'code_division' => $this->code_division
        );
        return $data;
    }



////////////////////////////////////////////////////////////////
    public function findByBpf($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_activite = ?', "PBF");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuActeur();
          $entry->setCode_membre($row->code_membre)
                ->setCode_activite($row->code_activite)
                ->setType_acteur($row->type_acteur)
                ->setCode_acteur($row->code_acteur)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_acteur($row->id_acteur)
				->setCode_gac_chaine($row->code_gac_chaine)
				->setCode_source_create($row->code_source_create)
				->setCode_monde_create($row->code_monde_create)
				->setCode_zone_create($row->code_zone_create)
				->setId_pays($row->id_pays)
				->setId_region($row->id_region)
				->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				->setCode_secteur_create($row->code_secteur_create)
				->setCode_agence_create($row->code_agence_create)
				->setCode_division($row->code_division)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findByCmfh($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('type_acteur = ?', "CMFH");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	public function findByKr($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_division = ?', "KR");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findByD($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
          $select->where('code_membre = ?', $code_membre);
          $select->where('code_division = ?', "DETENTRICE");
		  $select->where('code_activite = ?', "FILIERE");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findByDA($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
          $select->where('code_membre = ?', $code_membre);
          $select->where('code_division = ?', "DETENTRICE");
		  $select->where('code_activite = ?', "ACNEV");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	public function findBySur($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_division = ?', "SURVEILLANCE");
		$select->where('code_activite = ?', "FILIERE");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findBySurA($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_division = ?', "SURVEILLANCE");
		$select->where('code_activite = ?', "ACNEV");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	
	public function findByEx($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_division = ?', "EXECUTANTE");
		$select->where('code_activite = ?', "FILIERE");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findByExA($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
        $select->where('code_division = ?', "EXECUTANTE");
		$select->where('code_activite = ?', "ACNEV");
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    public function findByCodeActeur($code_acteur) {
	    $table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_acteur) && $code_acteur !="") {
           $select->where('code_acteur LIKE ?', $code_acteur);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
	
	}

	
	
	
    public function findByActeur($code_membre) {
		$table = new Application_Model_DbTable_EuActeur;
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findAcnevCapitalResi($code_gac_create) {
		$table = new Application_Model_DbTable_EuActeur;
        $select = $tabela->select()->setIntegrityCheck(false);
		$select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_acteur.code_membre');
        $select->where('eu_acteur.code_gac_create LIKE ?',$code_gac_create);
		$select->where('eu_acteur.code_activite LIKE ?','ACNEV')
			   ->where('eu_acteur.type_acteur LIKE ?','KR');
		$result = $table->fetchAll($select); 
		$row = $result->current();
        foreach ($result as $row) {
        $entry = new Application_Model_EuActeur();
        $entry->setCode_membre($row->code_membre)
              ->setCode_activite($row->code_activite)
              ->setType_acteur($row->type_acteur)
              ->setCode_acteur($row->code_acteur)
              ->setDate_creation($row->date_creation)
              ->setId_utilisateur($row->id_utilisateur)
              ->setId_acteur($row->id_acteur)
			  ->setCode_gac_chaine($row->code_gac_chaine)
			  ->setCode_source_create($row->code_source_create)
			  ->setCode_monde_create($row->code_monde_create)
			  ->setCode_zone_create($row->code_zone_create)
			  ->setId_pays($row->id_pays)
			  ->setId_region($row->id_region)
			  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
			  ->setCode_secteur_create($row->code_secteur_create)
			  ->setCode_agence_create($row->code_agence_create)
			  ->setCode_division($row->code_division);  
        }
        return $entry;	   
		
    }
	
	
	public function findByActeurDetentrice($code_membre) {
	   $table = new Application_Model_DbTable_EuActeur;
       $select = $table->select();
       $select->where('code_membre = ?',$code_membre);
	   $select->where('type_acteur LIKE ?','gac_detentrice');
       $resultSet = $table->fetchAll($select);
       if (0 == count($resultSet)) {
            return false;
       }
       $row = $resultSet->current();
       $entries = array();
       foreach ($resultSet as $row) {
        $entry = new Application_Model_EuActeur();
        $entry->setCode_membre($row->code_membre)
              ->setCode_activite($row->code_activite)
              ->setType_acteur($row->type_acteur)
              ->setCode_acteur($row->code_acteur)
              ->setDate_creation($row->date_creation)
              ->setId_utilisateur($row->id_utilisateur)
              ->setId_acteur($row->id_acteur)
			  ->setCode_gac_chaine($row->code_gac_chaine)
			  ->setCode_source_create($row->code_source_create)
			  ->setCode_monde_create($row->code_monde_create)
			  ->setCode_zone_create($row->code_zone_create)
			  ->setId_pays($row->id_pays)
			  ->setId_region($row->id_region)
			  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
			  ->setCode_secteur_create($row->code_secteur_create)
			  ->setCode_agence_create($row->code_agence_create)
			  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	

	
	public function findConuter() {
	   $table = new Application_Model_DbTable_EuActeur;
       $select = $table->select();
       $select->from($table, array('MAX(id_acteur) as count'));
       $result = $table->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }
	
	
	
	
	
    public function fetchAll2() {
		$table = new Application_Model_DbTable_EuActeur;
        $select = $table->select();
        $select->where('type_acteur = ?', "PBF");
        //$select->orwhere('code_activite = ?', "DSMS");
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries[] = $entry;
        }
        return $entries;
    }





    public function find($id_acteur, Application_Model_EuActeur $acteur) {
        $table = new Application_Model_DbTable_EuActeur;
        $select = $table->select();
        $select->where('id_acteur = ?', $id_acteur);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $acteur->setCode_membre($row->code_membre)
               ->setCode_activite($row->code_activite)
               ->setType_acteur($row->type_acteur)
               ->setCode_acteur($row->code_acteur)
               ->setDate_creation($row->date_creation)
               ->setId_utilisateur($row->id_utilisateur)
               ->setId_acteur($row->id_acteur)
			   ->setCode_gac_chaine($row->code_gac_chaine)
			   ->setCode_source_create($row->code_source_create)
			   ->setCode_monde_create($row->code_monde_create)
			   ->setCode_zone_create($row->code_zone_create)
			   ->setId_pays($row->id_pays)
			   ->setId_region($row->id_region)
			   ->setId_prefecture($row->id_prefecture)
				->setId_canton($row->id_canton)
			   ->setCode_secteur_create($row->code_secteur_create)
			   ->setCode_agence_create($row->code_agence_create)
			   ->setCode_division($row->code_division)		
		;
	}







    public function findByActeur2($code_membre) {
		$table = new Application_Model_DbTable_EuActeur;
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries = $entry;
        //}[]
        return $entries;
    }

    public function findByCodeActeur2($code_acteur) {
	    $table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_acteur) && $code_acteur !="") {
           $select->where('code_acteur LIKE ?', $code_acteur);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries = $entry;
        //}[]
        return $entries;
    }
	
    public function findByCodeActeur3($code_membre) {
	    $table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre !="") {
           $select->where('code_membre LIKE ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuActeur();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_acteur($row->id_acteur)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setCode_division($row->code_division);
            $entries = $entry;
        //}[]
        return $entries;
    }
	
	
}



?>
