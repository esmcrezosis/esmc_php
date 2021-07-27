<?php

class Application_Model_EuAgence {

    protected $code_agence;
	protected $type_gac;
	protected $date_creation;
    protected $libelle_agence;
    protected $partenaire;
    protected $code_membre;
    protected $code_zone;
	protected $id_pays;
	protected $id_region;
	protected $id_prefecture;
	protected $id_canton;
	protected $code_secteur;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    function getCode_agence() {
        return $this->code_agence;
    }

    function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	
	function setType_gac($type_gac) {
        $this->type_gac = $type_gac;
        return $this;
    }
	
	function getType_gac() {
        return $this->type_gac;
    }
	
	function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }


    function getLibelle_agence() {
        return $this->libelle_agence;
    }

    function setLibelle_agence($libelle_agence) {
        $this->libelle_agence = $libelle_agence;
        return $this;
    }

    function getPartenaire() {
        return $this->partenaire;
    }

    function setPartenaire($partenaire) {
        $this->partenaire = $partenaire;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	function getCode_zone() {
        return $this->code_zone;
    }

    function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        return $this;
    }
	
	function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	function getId_region() {
        return $this->id_region;
    }

    function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }
	
	function getId_prefecture() {
        return $this->id_prefecture;
    }

    function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }
	
	function getId_canton() {
        return $this->id_canton;
    }

    function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }	
	
	function getCode_secteur() {
        return $this->code_secteur;
    }

    function setCode_secteur($code_secteur) {
        $this->code_secteur = $code_secteur;
        return $this;
    }
	

}

