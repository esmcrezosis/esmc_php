<?php

class Application_Model_EuZone {

    protected $code_zone;
    protected $nom_zone;
    protected $date_creation;
    protected $id_utilisateur;
    protected $code_dev;

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

    function getCode_zone() {
        return $this->code_zone;
    }

    function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        $this;
    }

    function getNom_zone() {
        return $this->nom_zone;
    }

    function setNom_zone($nom_zone) {
        $this->nom_zone = $nom_zone;
        $this;
    }

    function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        $this;
    }

    function getCode_dev() {
        return $this->code_dev;
    }

    function setCode_dev($code_dev) {
        $this->code_dev = $code_dev;
        $this;
    }

}

