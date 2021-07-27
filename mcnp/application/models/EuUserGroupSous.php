<?php

class Application_Model_EuUserGroupSous {

    protected $code_groupe_sous;
    protected $libelle_groupe_sous;
    protected $code_groupe;

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

    function getCode_groupe_sous() {
        return $this->code_groupe_sous;
    }

    function setCode_groupe_sous($code_groupe_sous) {
        $this->code_groupe_sous = $code_groupe_sous;
        return $this;
    }

    function getLibelle_groupe_sous() {
        return $this->libelle_groupe_sous;
    }

    function setLibelle_groupe_sous($libelle_groupe_sous) {
        $this->libelle_groupe_sous = $libelle_groupe_sous;
        return $this;
    }

    function getCode_groupe() {
        return $this->code_groupe;
    }

    function setCode_groupe($code_groupe) {
        $this->code_groupe = $code_groupe;
        return $this;
    }

}

