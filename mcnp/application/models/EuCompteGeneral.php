<?php

class Application_Model_EuCompteGeneral {

    protected $code_compte;
    protected $intitule;
    protected $service;
    protected $solde;
    protected $code_type_compte;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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

    function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    function getIntitule() {
        return $this->intitule;
    }

    function setIntitule($intitule) {
        $this->intitule = (string) $intitule;
        return $this;
    }
    
    function getService() {
        return $this->service;
    }

    function setService($service) {
        $this->service =  $service;
        return $this;
    }
    
    function getSolde() {
        return $this->solde;
    }

    function setSolde($solde) {
        $this->solde =  $solde;
        return $this;
    }
    
    function getCode_type_compte() {
        return $this->code_type_compte;
    }

    function setCode_type_compte($code_type_compte) {
        $this->code_type_compte =  $code_type_compte;
        return $this;
    }

}

