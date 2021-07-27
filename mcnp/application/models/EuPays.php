<?php

class Application_Model_EuPays {

    protected $id_pays;
    protected $code_pays;
    protected $libelle_pays;
    protected $nationalite;
    protected $code_telephonique;
    protected $code_zone;

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

    function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }

    function getCode_pays() {
        return $this->code_pays;
    }

    function setCode_pays($code_pays) {
        $this->code_pays = $code_pays;
        return $this;
    }

    function getLibelle_pays() {
        return $this->libelle_pays;
    }

    function setLibelle_pays($libelle_pays) {
        $this->libelle_pays = $libelle_pays;
        return $this;
    }

    function getNationalite() {
        return $this->nationalite;
    }

    function setNationalite($nationalite) {
        $this->nationalite = $nationalite;
        return $this;
    }

    function getCode_telephonique() {
        return $this->code_telephonique;
    }

    function setCode_telephonique($code_telephonique) {
        $this->code_telephonique = $code_telephonique;
        return $this;
    }
    
    public function getCode_zone(){
        return $this->code_zone; 
    }
    
    public function setCode_zone($code_zone){
        $this->code_zone = $code_zone;
        return $this;
    }

}

