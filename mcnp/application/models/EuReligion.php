<?php

class Application_Model_EuReligion {

    protected $id_religion_membre;
    protected $libelle_religion;

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

    function getId_religion_membre() {
        return $this->id_religion_membre;
    }

    function setId_religion_membre($id_religion_membre) {
        $this->id_religion_membre = $id_religion_membre;
        return $this;
    }

    function getLibelle_religion() {
        return $this->libelle_religion;
    }

    function setLibelle_religion($libelle_religion) {
        $this->libelle_religion = (string) $libelle_religion;
        return $this;
    }

}
