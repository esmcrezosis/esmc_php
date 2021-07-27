<?php

class Application_Model_EuTypePropo {

    protected  $id_type_propo;
    protected  $libelle_type_propo;
    
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

    function getId_type_propo() {
        return $this->id_type_propo;
    }

    function setId_type_propo($id_type_propo) {
        $this->id_type_propo = $id_type_propo;
        return $this;
    }

    function getLibelle_type_propo() {
        return $this->libelle_type_propo;
    }

    function setLibelle_type_propo($libelle_type_propo) {
        $this->libelle_type_propo = $libelle_type_propo;
        return $this;
    }

}

?>
