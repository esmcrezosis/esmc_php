<?php

class Application_Model_EuCanton
{
    
    protected $id_canton;
    protected $nom_canton;
    protected $id_ville;
    protected $id_prefecture;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
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

    function getId_canton() {
        return $this->id_canton;
    }

    function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }

	
    function getNom_canton() {
        return $this->nom_canton;
    }

    function setNom_canton($nom_canton) {
        $this->nom_canton = $nom_canton;
        return $this;
    }
	
    function getId_ville() {
        return $this->id_ville;
    }
    function setId_ville($id_ville) {
        $this->id_ville = $id_ville;
        return $this;
    }
    function getId_prefecture() {
        return $this->id_prefecture;
    }

    function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }
    
    
}