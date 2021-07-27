<?php

class Application_Model_EuTypeActeur {

    protected $id_type_acteur;
    protected $lib_type_acteur;

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

    function getId_type_acteur() {
        return $this->id_type_acteur;
    }

    function setId_type_acteur($id_type_acteur) {
        $this->id_type_acteur = $id_type_acteur;
        return $this;
    }

    function getLib_type_acteur() {
        return $this->lib_type_acteur;
    }

    function setLib_type_acteur($lib_type_acteur) {
        $this->lib_type_acteur = $lib_type_acteur;
        return $this;
    }

}

