<?php

class Application_Model_EuCentrale {

    //put your asso here
    protected $centrale_id;
    protected $centrale_libelle;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
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

    public function getCentrale_id() {
        return $this->centrale_id;
    }

    public function setCentrale_id($centrale_id) {
        $this->centrale_id = $centrale_id;
        return $this;
    }


    public function getCentrale_libelle() {
        return ($this->centrale_libelle);
    }

    public function setCentrale_libelle($centrale_libelle) {
        $this->centrale_libelle = ($centrale_libelle);
        return $this;
    }



}

?>
