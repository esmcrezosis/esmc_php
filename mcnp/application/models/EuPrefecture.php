<?php

class Application_Model_EuPrefecture {
    
    protected $id_prefecture;
    protected $nom_prefecture;
    protected $id_region;
    
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
 
    public function __get($name)
    {
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

    function getId_prefecture() {
        return $this->id_prefecture;
    }

    function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }


    function getNom_prefecture() {
        return $this->nom_prefecture;
    }

	
    function setNom_prefecture($nom_prefecture) {
        $this->nom_prefecture = $nom_prefecture;
        return $this;
    }
	
	
    function getId_region() {
        return $this->id_region;
    }
	
    function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }
      
}