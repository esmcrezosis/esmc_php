<?php
 
class Application_Model_EuFichierMstiersListebc {

    //put your code here
    protected $fichier_id;
    protected $fichier_mstiers_listebc;
    protected $fichier_url;
    protected $fichier_banque;
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

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getFichier_mstiers_listebc() {
        return ($this->fichier_mstiers_listebc);
    }

    public function setFichier_mstiers_listebc($fichier_mstiers_listebc) {
        $this->fichier_mstiers_listebc = ($fichier_mstiers_listebc);
        return $this;
    }

    public function getFichier_banque() {
        return $this->fichier_banque;
    }

    public function setFichier_banque($fichier_banque) {
        $this->fichier_banque = $fichier_banque;
        return $this;
    }


}

?>
