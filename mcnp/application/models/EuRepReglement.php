<?php

class Application_Model_EuRepReglement {

    protected $id_reglt_mf;
    protected $id_rep;
    protected $mont_rep_reglt;

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

    function getId_reglt_mf() {
        return $this->id_reglt_mf;
    }

    function setId_reglt_mf($id_reglt_mf) {
        $this->id_reglt_mf = $id_reglt_mf;
        return $this;
    }

    function getId_rep() {
        return $this->id_rep;
    }

    function setId_rep($id_rep) {
        $this->id_rep = $id_rep;
        return $this;
    }

    function getMont_rep_reglt() {
        return $this->mont_rep_reglt;
    }

    function setMont_rep_reglt($mont_rep_reglt) {
        $this->mont_rep_reglt = $mont_rep_reglt;
        return $this;
    }

}