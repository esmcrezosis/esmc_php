<?php

class Application_Model_Categorie {

    protected $code_categorie;
    protected $libelle_categorie;
    protected $description_categorie;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    function getCode_categorie() {
        return $this->code_categorie;
    }

    function setCode_categorie($code_categorie) {
        $this->code_categorie = $code_categorie;
        return $this;
    }

    function getLibelle_categorie() {
        return $this->libelle_categorie;
    }

    function setLibelle_categorie($libelle_categorie) {
        $this->libelle_categorie = (string)$libelle_categorie;
        return $this;
    }

    function getDescription_categorie() {
        return $this->description_categorie;
    }

    function setDescription_categorie($description_categorie) {
        $this->description_categorie = (string)$description_categorie;
        return $this;
    }

}

