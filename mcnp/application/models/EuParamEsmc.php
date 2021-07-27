<?php

class Application_Model_EuParamEsmc {

    protected $id_param;
    protected $libelle_param;
    protected $valeur_param;
    
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

    function getId_param() {
        return $this->id_param;
    }

    function setId_param($id_param) {
        $this->id_param = $id_param;
        return $this;
    }

    function getLibelle_param() {
        return $this->libelle_param;
    }

    function setLibelle_param($libelle_param) {
        $this->libelle_param = $libelle_param;
        return $this;
    }

    function getValeur_param() {
        return $this->valeur_param;
    }

    function setValeur_param($valeur_param) {
        $this->valeur_param = $valeur_param;
        return $this;
    }

}

