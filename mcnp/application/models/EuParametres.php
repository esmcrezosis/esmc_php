<?php

class Application_Model_EuParametres {

    protected $code_param;
    protected $lib_param;
    protected $montant;
    
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

    function getCode_param() {
        return $this->code_param;
    }

    function setCode_param($code_param) {
        $this->code_param = $code_param;
        return $this;
    }

    function getLib_param() {
        return $this->lib_param;
    }

    function setLib_param($lib_param) {
        $this->lib_param = (string) $lib_param;
        return $this;
    }

    function getMontant() {
        return $this->montant;
    }

    function setMontant($montant) {
        $this->montant = (string) $montant;
        return $this;
    }

}

