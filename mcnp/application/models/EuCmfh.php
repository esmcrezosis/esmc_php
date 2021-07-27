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
class Application_Model_EuCmfh {

    //put your code here
    protected $id_cmfh;
    protected $date_creation;
    protected $code_membre;
    protected $id_type_candidat;
	protected $code_zone_create;
	protected $id_pays;
	protected $id_region;
	protected $id_prefecture;
	protected $id_canton;


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

    public function getId_cmfh() {
        return $this->id_cmfh;
    }

    public function setId_cmfh($id_cmfh) {
      $this->id_cmfh = $id_cmfh;
      return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }
	
	

    public function getId_type_candidat() {
      return $this->id_type_candidat;
    }

    public function setId_type_candidat($id_type_candidat) {
        $this->id_type_candidat = $id_type_candidat;
        return $this;
    }
    
    
    public function getCode_membre(){
        return $this->code_membre;
    }
    
    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
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
	
	public function getId_prefecture() {
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
	
	
	
	/*
    public function exchangeArray($data) {
       $this->id_cmfh = (isset($data['id_cmfh'])) ? $data['id_cmfh'] : NULL;
       $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
       $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
       $this->type_acteur = (isset($data['type_acteur'])) ? $data['type_acteur'] : NULL;
       $this->code_activite = (isset($data['code_activite'])) ? $data['code_activite'] : NULL;
       $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
	   $this->code_gac_chaine = (isset($data['code_gac_chaine'])) ? $data['code_gac_chaine'] : NULL;
	   $this->code_source_create = (isset($data['code_source_create'])) ? $data['code_source_create'] : NULL;
	   $this->code_monde_create = (isset($data['code_monde_create'])) ? $data['code_monde_create'] : NULL;
	   $this->code_zone_create = (isset($data['code_zone_create'])) ? $data['code_zone_create'] : NULL;
	   $this->id_pays = (isset($data['id_pays'])) ? $data['id_pays'] : NULL;
	   $this->id_region = (isset($data['id_region'])) ? $data['id_region'] : NULL;
	   $this->code_secteur_create = (isset($data['code_secteur_create'])) ? $data['code_secteur_create'] : NULL;
    }

    public function toArray() {
        $data = array(
          'id_cmfh' => $this->id_cmfh,
          'id_utilisateur' => $this->id_utilisateur,
          'date_creation' => $this->date_creation,
          'type_acteur' => $this->type_acteur,
          'code_activite' => $this->code_activite,
          'code_membre' => $this->code_membre,
		  'code_gac_chaine' => $this->code_gac_chaine,
		  'code_source_create' => $this->code_source_create,
		  'code_monde_create' => $this->code_monde_create,
		  'code_zone_create' => $this->code_zone_create,
		  'id_pays' => $this->id_pays,
		  'id_region' => $this->id_region,
		  'code_secteur_create' => $this->code_secteur_create,
		  'code_agence_create' => $this->code_agence_create
        );
        return $data;
    }



    ////////////////////////////////////////////////////////////////
	public function findByCmfh($code_membre) {
		$table = new Application_Model_DbTable_EuCmfh();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!="") {
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
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_cmfh($row->id_cmfh)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create);
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
            $entry = new Application_Model_EuCmfh();
            $entry->setCode_membre($row->code_membre)
                  ->setCode_activite($row->code_activite)
                  ->setType_acteur($row->type_acteur)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setId_cmfh($row->id_cmfh)
				  ->setCode_gac_chaine($row->code_gac_chaine)
				  ->setCode_source_create($row->code_source_create)
				  ->setCode_monde_create($row->code_monde_create)
				  ->setCode_zone_create($row->code_zone_create)
				  ->setId_pays($row->id_pays)
				  ->setId_region($row->id_region)
				  ->setCode_secteur_create($row->code_secteur_create)
				  ->setCode_agence_create($row->code_agence_create);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findConuter() {
	   $table = new Application_Model_DbTable_EuCmfh;
       $select = $table->select();
       $select->from($table, array('MAX(id_cmfh) as count'));
       $result = $table->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }


    public function find($id_cmfh, Application_Model_EuCmfh $acteur) {
        $table = new Application_Model_DbTable_EuCmfh;
        $select = $table->select();
        $select->where('id_cmfh = ?', $id_cmfh);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $acteur->setCode_membre($row->code_membre)
               ->setCode_activite($row->code_activite)
               ->setType_acteur($row->type_acteur)
               ->setDate_creation($row->date_creation)
               ->setId_utilisateur($row->id_utilisateur)
               ->setId_cmfh($row->id_cmfh)
			   ->setCode_gac_chaine($row->code_gac_chaine)
			   ->setCode_source_create($row->code_source_create)
			   ->setCode_monde_create($row->code_monde_create)
			   ->setCode_zone_create($row->code_zone_create)
			   ->setId_pays($row->id_pays)
			   ->setId_region($row->id_region)
			   ->setCode_secteur_create($row->code_secteur_create)
			   ->setCode_agence_create($row->code_agence_create);
	}
	*/
	
	
  }



?>
