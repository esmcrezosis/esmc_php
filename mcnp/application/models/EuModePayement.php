<?php

class Application_Model_EuModePayement {

    protected  $id_mode_payement;
    protected  $libelle_mode_payement;
    
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

    function getId_mode_payement() {
        return $this->id_mode_payement;
    }

    function setId_mode_payement($id_mode_payement) {
        $this->id_mode_payement = $id_mode_payement;
        return $this;
    }

    function getLibelle_mode_payement() {
        return $this->libelle_mode_payement;
    }

    function setLibelle_mode_payement($libelle_mode_payement) {
        $this->libelle_mode_payement = $libelle_mode_payement;
        return $this;
    }

}

?>
