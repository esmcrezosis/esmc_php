<?php
 
class Application_Model_EuFichier {

    //put your code here
    protected $fichier_id;
    protected $fichier_libelle;
    protected $fichier_categorie;
    protected $fichier_url;
    protected $fichier_type;
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

    public function getFichier_id() {
        return $this->fichier_id;
    }

    public function setFichier_id($fichier_id) {
        $this->fichier_id = $fichier_id;
        return $this;
    }

    public function getFichier_url() {
        return $this->fichier_url;
    }

    public function setFichier_url($fichier_url) {
        $this->fichier_url = $fichier_url;
        return $this;
    }

    public function getFichier_categorie() {
        return $this->fichier_categorie;
    }

    public function setFichier_categorie($fichier_categorie) {
        $this->fichier_categorie = $fichier_categorie;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getFichier_libelle() {
        return ($this->fichier_libelle);
    }

    public function setFichier_libelle($fichier_libelle) {
        $this->fichier_libelle = ($fichier_libelle);
        return $this;
    }

    public function getFichier_type() {
        return $this->fichier_type;
    }

    public function setFichier_type($fichier_type) {
        $this->fichier_type = $fichier_type;
        return $this;
    }


}

?>
