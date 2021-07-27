<?php

class Application_Model_EuTypeCreneau {

    protected $id_type_creneau;
    protected $libelle_type_creneau;

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

    function getId_type_creneau() {
        return $this->id_type_creneau;
    }

    function setId_type_creneau($id_type_creneau) {
        $this->id_type_creneau = $id_type_creneau;
        return $this;
    }

    function getLibelle_type_creneau() {
        return $this->libelle_type_creneau;
    }

    function setLibelle_type_creneau($libelle_type_creneau) {
        $this->libelle_type_creneau = $libelle_type_creneau;
        return $this;
    }

}

