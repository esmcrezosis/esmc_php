<?php

class Application_Model_EuGac {

    protected $code_gac;
    protected $code_membre;
    protected $nom_gac;
    protected $code_zone;
    protected $code_membre_gestionnaire;
    protected $date_creation;
    protected $id_utilisateur;
    protected $groupe;
    protected $code_type_gac;
    protected $zone;
    protected $code_gac_create;
    protected $code_gac_chaine;
	protected $type_gac;
	protected $id_pays;
	protected $id_region;
	protected $code_secteur;
	protected $code_agence;
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
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getCode_gac() {
        return $this->code_gac;
    }

    public function setCode_gac($code_gac) {
        $this->code_gac = $code_gac;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getNom_gac() {
        return $this->nom_gac;
    }

    public function setNom_gac($nom_gac) {
        $this->nom_gac = $nom_gac;
        return $this;
    }

    public function getCode_zone() {
        return $this->code_zone;
    }

    public function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        return $this;
    }

    public function getCode_membre_gestionnaire() {
        return $this->code_membre_gestionnaire;
    }

    public function setCode_membre_gestionnaire($code_membre_gestionnaire) {
        $this->code_membre_gestionnaire = $code_membre_gestionnaire;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	public function getType_gac() {
        return $this->type_gac;
    }

    public function setType_gac($type_gac) {
        $this->type_gac = $type_gac;
        return $this;
    }

    public function getGroupe() {
        return $this->groupe;
    }

    public function setGroupe($groupe) {
        $this->groupe = $groupe;
        return $this;
    }

    public function getCode_type_gac() {
        return $this->code_type_gac;
    }

    public function setCode_type_gac($code_type_gac) {
        $this->code_type_gac = $code_type_gac;
        return $this;
    }

    public function getZone() {
        return $this->zone;
    }

    public function setZone($zone) {
        $this->zone = $zone;
        return $this;
    }

    public function getCode_gac_create() {
        return $this->code_gac_create;
    }

    public function setCode_gac_create($code_gac_create) {
        $this->code_gac_create = $code_gac_create;
        return $this;
    }
    
    public function getCode_gac_chaine() {
        return $this->code_gac_chaine;
    }

    public function setCode_gac_chaine($code_gac_chaine) {
        $this->code_gac_chaine = $code_gac_chaine;
        return $this;
    }
	
	public function getId_pays() {
        return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	public function getId_region() {
        return $this->id_region;
    }

    public function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }
	
	public function getCode_secteur() {
        return $this->code_secteur;
    }

    public function setCode_secteur($code_secteur) {
        $this->code_secteur = $code_secteur;
        return $this;
    }
	
	public function getCode_agence() {
        return $this->code_agence;
    }

    public function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	
	public function getId_prefecture() {
        return $this->id_prefecture;
    }

    public function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }
	
	public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	
	
	
}

?>
