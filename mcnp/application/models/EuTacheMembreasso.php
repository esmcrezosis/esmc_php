<?php

class Application_Model_EuTacheMembreasso {

    //put your asso here
    protected $tache_id;
    protected $tache_libelle;
    protected $tache_url;
    protected $tache_description;
    protected $tache_asso;
    protected $tache_type;
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

    public function getTache_id() {
        return $this->tache_id;
    }

    public function setTache_id($tache_id) {
        $this->tache_id = $tache_id;
        return $this;
    }

    public function getTache_description() {
        return $this->tache_description;
    }

    public function setTache_description($tache_description) {
        $this->tache_description = $tache_description;
        return $this;
    }

    public function getTache_url() {
        return $this->tache_url;
    }

    public function setTache_url($tache_url) {
        $this->tache_url = $tache_url;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getTache_libelle() {
        return ($this->tache_libelle);
    }

    public function setTache_libelle($tache_libelle) {
        $this->tache_libelle = ($tache_libelle);
        return $this;
    }

    public function getTache_asso() {
        return $this->tache_asso;
    }

    public function setTache_asso($tache_asso) {
        $this->tache_asso = $tache_asso;
        return $this;
    }

    public function getTache_type() {
        return ($this->tache_type);
    }

    public function setTache_type($tache_type) {
        $this->tache_type = ($tache_type);
        return $this;
    }


}

?>
