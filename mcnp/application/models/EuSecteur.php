<?php

class Application_Model_EuSecteur {

    protected $code_secteur;
    protected $nom_secteur;
    protected $date_creation;
    protected $id_pays;
    protected $id_region;
	protected $id_prefecture;
	protected $code_membre;

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

    function getCode_secteur() {
        return $this->code_secteur;
    }

    function setCode_secteur($code_secteur) {
        $this->code_secteur = $code_secteur;
        return $this;
    }

    function getNom_secteur() {
        return $this->nom_secteur;
    }

    function setNom_secteur($nom_secteur) {
        $this->nom_secteur = $nom_secteur;
        return $this;
    }

    function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
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
	
	public function getId_prefecture() {
        return $this->id_prefecture;
    }

    public function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }
	
	
	
	
	public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	
	
	
	
	
	

}

