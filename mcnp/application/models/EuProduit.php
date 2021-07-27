<?php

class Application_Model_EuProduit {

    protected $code_produit;
    protected $libelle_produit;
    protected $description_produit;
    protected $code_categorie;
    protected $type_produit;

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

    function getCode_produit() {
        return $this->code_produit;
    }

    function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

    function getLibelle_produit() {
        return ($this->libelle_produit);
    }

    function setLibelle_produit($libelle_produit) {
        $this->libelle_produit = ($libelle_produit);
        return $this;
    }

    function getDescription_produit() {
        return ($this->description_produit);
    }

    function setDescription_produit($description_produit) {
        $this->description_produit = ($description_produit);
        return $this;
    }

    function getCode_categorie() {
        return $this->code_categorie;
    }

    function setCode_categorie($code_categorie) {
        $this->code_categorie = $code_categorie;
        return $this;
    }
    
    function getType_produit(){
        return $this->type_produit;
    }
    
    function setType_produit($type_produit){
        $this->type_produit = $type_produit;
        return $this;
    }

}

