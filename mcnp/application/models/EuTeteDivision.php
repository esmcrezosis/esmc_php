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
class Application_Model_EuTeteDivision {

      //put your code here
      protected $id_tete_division;
      protected $type_tete_division;
      protected $date_creation;
      protected $code_membre_morale;
	  protected $code_membre;
      protected $code_acteur;
	  protected $id_filiere;
      protected $id_utilisateur;
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
	  protected $code_agence;
	  protected $code_activite;
	


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
      
	
	
	
    public function getId_tete_division() {
        return $this->id_tete_division;
    }

    public function setId_tete_division($id_tete_division) {
        $this->id_tete_division = $id_tete_division;
        return $this;
    }
	
	public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	

    public function getType_tete_division() {
        return $this->type_tete_division;
    }

    public function setType_tete_division($type_tete_division) {
        $this->type_tete_division = $type_tete_division;
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
    
    public function getCode_membre_morale(){
        return $this->code_membre_morale;
    }
    
    public function setCode_membre_morale($code_membre_morale){
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
	
	public function getCode_membre(){
        return $this->code_membre;
    }
    
    public function setCode_membre($code_membre){
        $this->code_membre = $code_membre;
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
	
	public function getId_filiere(){
        return $this->id_filiere;
    }
    
    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }
	
	public function getCode_division(){
        return $this->code_division;
    }
    
    public function setCode_division($code_division) {
        $this->code_division = $code_division;
        return $this;
    }
	
	public function getCode_agence(){
        return $this->code_agence;
    }
    
    public function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	
	
	public function getCode_activite(){
        return $this->code_activite;
    }
	
	public function setCode_activite($code_activite) {
        $this->code_activite = $code_activite;
        return $this;
    }
	
	
	
	
	
    public function exchangeArray($data) {
        $this->id_tete_division = (isset($data['id_tete_division'])) ? $data['id_tete_division'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
        $this->type_tete_division = (isset($data['type_tete_division'])) ? $data['type_tete_division'] : NULL;
        $this->code_acteur = (isset($data['code_acteur'])) ? $data['code_acteur'] : NULL;
        $this->code_membre_morale = (isset($data['code_membre_morale'])) ? $data['code_membre_morale'] : NULL;
		$this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
		$this->id_filiere = (isset($data['id_filiere'])) ? $data['id_filiere'] : NULL;
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
        $this->code_agence = (isset($data['code_agence'])) ? $data['code_agence'] : NULL;
        $this->code_activite = (isset($data['code_activite'])) ? $data['code_activite'] : NULL;			
    }

    public function toArray() {
        $data = array(
          'id_tete_division' => $this->id_tete_division,
          'id_utilisateur' => $this->id_utilisateur,
          'date_creation' => $this->date_creation,
          'code_acteur' => $this->code_acteur,
          'type_tete_division' => $this->type_tete_division,
          'code_membre_morale' => $this->code_membre_morale,
		  'code_membre' => $this->code_membre,
		  'code_source_create' => $this->code_source_create,
		  'code_monde_create' => $this->code_monde_create,
		  'code_zone_create' => $this->code_zone_create,
		  'id_pays' => $this->id_pays,
		  'id_region' => $this->id_region,
		  'id_prefecture' => $this->id_prefecture,
		  'id_canton' => $this->id_canton,
		  'code_secteur_create' => $this->code_secteur_create,
		  'code_agence_create' => $this->code_agence_create,
		  'id_filiere' => $this->id_filiere,
		  'code_division' => $this->code_division,
		  'code_activite' => $this->code_activite,
		  'code_agence' => $this->code_agence
        );
        return $data;
    }
	
	
	
    public function findByActeur($code_membre) {
		$table = new Application_Model_DbTable_EuTeteDivision;
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre_morale = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
           return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTeteDivision();
            $entry->setCode_membre_morale($row->code_membre_morale)
			      ->setCode_membre($row->code_membre)
                  ->setType_tete_division($row->type_tete_division)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_tete_division($row->id_tete_division)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create)
				  ->setId_filiere($row->id_filiere)
				  ->setCode_division($row->code_division)
				  ->setCode_agence($row->code_agence)
				  ->setCode_activite($row->code_activite)
				  ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	

	
	public function findConuter() {
	   $table = new Application_Model_DbTable_EuTeteDivision;
       $select = $table->select();
       $select->from($table, array('MAX(id_tete_division) as count'));
       $result = $table->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }




    public function find($id_tete_division, Application_Model_EuTeteDivision $tetedivision) {
        $table = new Application_Model_DbTable_EuTeteDivision;
        $select = $table->select();
        $select->where('id_tete_division = ?', $id_tete_division);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $tetedivision->setCode_membre_morale($row->code_membre_morale)
		             ->setCode_membre($row->code_membre)
                     ->setType_tete_division($row->type_tete_division)
                     ->setCode_acteur($row->code_acteur)
                     ->setDate_creation($row->date_creation)
                     ->setId_utilisateur($row->id_utilisateur)
                     ->setId_tete_division($row->id_tete_division)
			         ->setCode_source_create($row->code_source_create)
			         ->setCode_monde_create($row->code_monde_create)
			         ->setCode_zone_create($row->code_zone_create)
			         ->setId_pays($row->id_pays)
			         ->setId_region($row->id_region)
					 ->setId_prefecture($row->id_prefecture)
				     ->setId_canton($row->id_canton)
			         ->setCode_secteur_create($row->code_secteur_create)
			         ->setCode_agence_create($row->code_agence_create)
			         ->setId_filiere($row->id_filiere)
					 ->setCode_division($row->code_division)
				     ->setCode_agence($row->code_agence)
				     ->setCode_activite($row->code_activite);
	}







    public function findByActeur2($code_membre) {
		$table = new Application_Model_DbTable_EuActeur();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre_morale = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        //foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTeteDivision();
            $entry->setCode_membre_morale($row->code_membre_morale)
			      ->setCode_membre($row->code_membre)
                  ->setType_tete_division($row->type_tete_division)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_tete_division($row->id_tete_division)
			      ->setCode_source_create($row->code_source_create)
			      ->setCode_monde_create($row->code_monde_create)
			      ->setCode_zone_create($row->code_zone_create)
			      ->setId_pays($row->id_pays)
			      ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
			      ->setCode_secteur_create($row->code_secteur_create)
			      ->setCode_agence_create($row->code_agence_create)
			      ->setId_filiere($row->id_filiere)
				  ->setCode_division($row->code_division)
				  ->setCode_agence($row->code_agence)
				  ->setCode_activite($row->code_activite);
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
            $entry = new Application_Model_EuTeteDivision();
            $entry->setCode_membre_morale($row->code_membre_morale)
			      ->setCode_membre($row->code_membre)
                  ->setType_tete_division($row->type_tete_division)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_tete_division($row->id_tete_division)
			      ->setCode_source_create($row->code_source_create)
			      ->setCode_monde_create($row->code_monde_create)
			      ->setCode_zone_create($row->code_zone_create)
			      ->setId_pays($row->id_pays)
			      ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
			      ->setCode_secteur_create($row->code_secteur_create)
			      ->setCode_agence_create($row->code_agence_create)
			      ->setId_filiere($row->id_filiere)
				  ->setCode_division($row->code_division)
				  ->setCode_agence($row->code_agence)
				  ->setCode_activite($row->code_activite);
            $entries = $entry;
        //}[]
        return $entries;
    }
	
	

    public function findByMembre($code_membre) {
		$table = new Application_Model_DbTable_EuTeteDivision();
        $select = $table->select();
		//if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);
		//}
        $resultSet = $table->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTeteDivision();
            $entry->setCode_membre_morale($row->code_membre_morale)
			      ->setCode_membre($row->code_membre)
                  ->setType_tete_division($row->type_tete_division)
                  ->setCode_acteur($row->code_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_tete_division($row->id_tete_division)
			      ->setCode_source_create($row->code_source_create)
			      ->setCode_monde_create($row->code_monde_create)
			      ->setCode_zone_create($row->code_zone_create)
			      ->setId_pays($row->id_pays)
			      ->setId_region($row->id_region)
				  ->setId_prefecture($row->id_prefecture)
				  ->setId_canton($row->id_canton)
			      ->setCode_secteur_create($row->code_secteur_create)
			      ->setCode_agence_create($row->code_agence_create)
			      ->setId_filiere($row->id_filiere)
				  ->setCode_division($row->code_division)
				  ->setCode_agence($row->code_agence)
				  ->setCode_activite($row->code_activite);
            $entries[] = $entry;
        }
        return $entries;
    }







}



?>
