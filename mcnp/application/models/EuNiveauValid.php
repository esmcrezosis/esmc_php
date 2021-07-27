<?php

class Application_Model_EuNiveauValid {

    protected  $id_niveau_valid;
    protected  $libelle_niveau_valid;
    
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

    function getId_niveau_valid() {
        return $this->id_niveau_valid;
    }

    function setId_niveau_valid($id_niveau_valid) {
        $this->id_niveau_valid = $id_niveau_valid;
        return $this;
    }

    function getLibelle_niveau_valid() {
        return $this->libelle_niveau_valid;
    }

    function setLibelle_niveau_valid($libelle_niveau_valid) {
        $this->libelle_niveau_valid = $libelle_niveau_valid;
        return $this;
    }

}

?>
