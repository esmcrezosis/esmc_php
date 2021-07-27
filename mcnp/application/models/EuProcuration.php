<?php

class Application_Model_EuProcuration {
    
    protected $id_procuration;
    protected $code_membre_mandant;
    protected $code_membre_mandataire;
    protected $date_procuration;
    protected $activer;
    
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

    function getId_procuration() {
        return $this->id_procuration;
    }

    function setId_procuration($id_procuration) {
        $this->id_procuration = $id_procuration;
        return $this;
    }


    function getCode_membre_mandant() {
        return $this->code_membre_mandant;
    }

    function setCode_membre_mandant($code_membre_mandant) {
        $this->code_membre_mandant = (string)$code_membre_mandant;
        return $this;
    }
	
    function getCode_membre_mandataire() {
        return $this->code_membre_mandataire;
    }
    function setCode_membre_mandataire($code_membre_mandataire) {
        $this->code_membre_mandataire = $code_membre_mandataire;
        return $this;
    }
    function getDate_procuration() {
        return $this->date_procuration;
    }

    function setDate_procuration($date_procuration) {
        $this->date_procuration = $date_procuration;
        return $this;
    }
    
    function getActiver() {
        return $this->activer;
    }

    function setActiver($activer) {
        $this->activer = $activer;
        return $this;
    }  
}