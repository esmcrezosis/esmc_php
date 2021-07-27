<?php

class Application_Model_EuReglementMf {

    protected $id_reglt_mf;
    protected $mont_reglt_mf;
    protected $code_membre;
    protected $date_reglt_mf;
    protected $type_mf;
    protected $type_reglt_mf;
    protected $id_utilisateur;

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

    function getMont_reglt_mf() {
        return $this->mont_reglt_mf;
    }

    function setMont_reglt_mf($mont_reglt_mf) {
        $this->mont_reglt_mf = $mont_reglt_mf;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getDate_reglt_mf() {
        return $this->date_reglt_mf;
    }

    function setDate_reglt_mf($date_reglt_mf) {
        $this->date_reglt_mf = $date_reglt_mf;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    function getType_mf() {
        return $this->type_mf;
    }

    function setType_mf($type_mf) {
        $this->type_mf = $type_mf;
        return $this;
    }

    function getType_reglt_mf() {
        return $this->type_reglt_mf;
    }

    function setType_reglt_mf($type_reglt_mf) {
        $this->type_reglt_mf = $type_reglt_mf;
        return $this;
    }

}

