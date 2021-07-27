<?php

class Application_Model_EuFormulaire {

    //put your asso here
    protected $formulaire_id;
    protected $formulaire_libelle;
    protected $formulaire_url;
    protected $formulaire_description;
    protected $formulaire_nom;
    protected $formulaire_procedure;
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

    public function getFormulaire_id() {
        return $this->formulaire_id;
    }

    public function setFormulaire_id($formulaire_id) {
        $this->formulaire_id = $formulaire_id;
        return $this;
    }

    public function getFormulaire_description() {
        return $this->formulaire_description;
    }

    public function setFormulaire_description($formulaire_description) {
        $this->formulaire_description = $formulaire_description;
        return $this;
    }

    public function getFormulaire_url() {
        return $this->formulaire_url;
    }

    public function setFormulaire_url($formulaire_url) {
        $this->formulaire_url = $formulaire_url;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getFormulaire_libelle() {
        return ($this->formulaire_libelle);
    }

    public function setFormulaire_libelle($formulaire_libelle) {
        $this->formulaire_libelle = ($formulaire_libelle);
        return $this;
    }

    public function getFormulaire_nom() {
        return $this->formulaire_nom;
    }

    public function setFormulaire_nom($formulaire_nom) {
        $this->formulaire_nom = $formulaire_nom;
        return $this;
    }

    public function getFormulaire_procedure() {
        return ($this->formulaire_procedure);
    }

    public function setFormulaire_procedure($formulaire_procedure) {
        $this->formulaire_procedure = ($formulaire_procedure);
        return $this;
    }


}

?>
