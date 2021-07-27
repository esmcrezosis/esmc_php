<?php

class Application_Model_EuStatutJuridique
{
    protected $code_statut;
    protected $libelle_statut;
    
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

    function getCode_statut() {
        return $this->code_statut;
    }

    function setCode_statut($code_statut) {
        $this->code_statut = $code_statut;
        return $this;
    }

    
    function getLibelle_statut() {
        return $this->libelle_statut;
    }

    
    function setLibelle_statut($libelle_statut) {
        $this->libelle_statut = (string)$libelle_statut;
        return $this;
    }
    
}

