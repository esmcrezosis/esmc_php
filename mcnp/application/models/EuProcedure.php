<?php

class Application_Model_EuProcedure {

    //put your asso here
    protected $procedure_id;
    protected $procedure_libelle;
    protected $procedure_url;
    protected $procedure_description;
    protected $procedure_nom;
    protected $procedure_type;
    protected $publier;

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

    public function getProcedure_id() {
        return $this->procedure_id;
    }

    public function setProcedure_id($procedure_id) {
        $this->procedure_id = $procedure_id;
        return $this;
    }

    public function getProcedure_description() {
        return $this->procedure_description;
    }

    public function setProcedure_description($procedure_description) {
        $this->procedure_description = $procedure_description;
        return $this;
    }

    public function getProcedure_url() {
        return $this->procedure_url;
    }

    public function setProcedure_url($procedure_url) {
        $this->procedure_url = $procedure_url;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getProcedure_libelle() {
        return ($this->procedure_libelle);
    }

    public function setProcedure_libelle($procedure_libelle) {
        $this->procedure_libelle = ($procedure_libelle);
        return $this;
    }

    public function getProcedure_nom() {
        return $this->procedure_nom;
    }

    public function setProcedure_nom($procedure_nom) {
        $this->procedure_nom = $procedure_nom;
        return $this;
    }

    public function getProcedure_type() {
        return ($this->procedure_type);
    }

    public function setProcedure_type($procedure_type) {
        $this->procedure_type = ($procedure_type);
        return $this;
    }


}

?>
