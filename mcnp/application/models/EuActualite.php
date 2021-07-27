<?php
 
class Application_Model_EuActualite {

    //put your code here
    protected $actualite_id;
    protected $actualite_libelle;
    protected $actualite_resume;
    protected $actualite_description;
    protected $actualite_type;
    protected $actualite_vignette;
    protected $actualite_date;
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

    public function getActualite_id() {
        return $this->actualite_id;
    }

    public function setActualite_id($actualite_id) {
        $this->actualite_id = $actualite_id;
        return $this;
    }

    public function getActualite_description() {
        return $this->actualite_description;
    }

    public function setActualite_description($actualite_description) {
        $this->actualite_description = $actualite_description;
        return $this;
    }

    public function getActualite_resume() {
        return $this->actualite_resume;
    }

    public function setActualite_resume($actualite_resume) {
        $this->actualite_resume = $actualite_resume;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getActualite_libelle() {
        return ($this->actualite_libelle);
    }

    public function setActualite_libelle($actualite_libelle) {
        $this->actualite_libelle = ($actualite_libelle);
        return $this;
    }

    public function getActualite_type() {
        return $this->actualite_type;
    }

    public function setActualite_type($actualite_type) {
        $this->actualite_type = $actualite_type;
        return $this;
    }

    public function getActualite_vignette() {
        return $this->actualite_vignette;
    }

    public function setActualite_vignette($actualite_vignette) {
        $this->actualite_vignette = $actualite_vignette;
        return $this;
    }

    public function getActualite_date() {
        return $this->actualite_date;
    }

    public function setActualite_date($actualite_date) {
        $this->actualite_date = $actualite_date;
        return $this;
    }


}

?>
