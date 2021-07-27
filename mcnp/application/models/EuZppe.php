<?php
 
class Application_Model_EuZppe {

    //put your code here
    protected $zppe_id;
    protected $zppe_libelle;
    protected $zppe_resume;
    protected $zppe_description;
    protected $zppe_vignette;
    protected $zppe_portable;
    protected $zppe_email;
    protected $zppe_login;
    protected $zppe_password;
    protected $zppe_date_genere;
    protected $publier;
    protected $zppe_code_membre;

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

    public function getZppe_id() {
        return $this->zppe_id;
    }

    public function setZppe_id($zppe_id) {
        $this->zppe_id = $zppe_id;
        return $this;
    }

    public function getZppe_description() {
        return $this->zppe_description;
    }

    public function setZppe_description($zppe_description) {
        $this->zppe_description = $zppe_description;
        return $this;
    }

    public function getZppe_resume() {
        return $this->zppe_resume;
    }

    public function setZppe_resume($zppe_resume) {
        $this->zppe_resume = $zppe_resume;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getZppe_libelle() {
        return ($this->zppe_libelle);
    }

    public function setZppe_libelle($zppe_libelle) {
        $this->zppe_libelle = ($zppe_libelle);
        return $this;
    }


    public function getZppe_vignette() {
        return $this->zppe_vignette;
    }

    public function setZppe_vignette($zppe_vignette) {
        $this->zppe_vignette = $zppe_vignette;
        return $this;
    }

    public function getZppe_login() {
        return $this->zppe_login;
    }

    public function setZppe_login($zppe_login) {
        $this->zppe_login = $zppe_login;
        return $this;
    }

    public function getZppe_password() {
        return $this->zppe_password;
    }

    public function setZppe_password($zppe_password) {
        $this->zppe_password = $zppe_password;
        return $this;
    }

    public function getZppe_date_genere() {
        return $this->zppe_date_genere;
    }

    public function setZppe_date_genere($zppe_date_genere) {
        $this->zppe_date_genere = $zppe_date_genere;
        return $this;
    }


    public function getZppe_portable() {
        return $this->zppe_portable;
    }

    public function setZppe_portable($zppe_portable) {
        $this->zppe_portable = $zppe_portable;
        return $this;
    }


    public function getZppe_email() {
        return $this->zppe_email;
    }

    public function setZppe_email($zppe_email) {
        $this->zppe_email = $zppe_email;
        return $this;
    }

    public function getZppe_code_membre() {
        return $this->zppe_code_membre;
    }

    public function setZppe_code_membre($zppe_code_membre) {
        $this->zppe_code_membre = $zppe_code_membre;
        return $this;
    }



}

?>
