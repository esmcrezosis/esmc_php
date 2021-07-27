<?php
 
class Application_Model_EuRelevebancaire {

    //put your code here
    protected $relevebancaire_id;
    protected $relevebancaire_utilisateur;
    protected $relevebancaire_banque;
    protected $relevebancaire_fichier;
    protected $relevebancaire_date;
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

    public function getRelevebancaire_id() {
        return $this->relevebancaire_id;
    }

    public function setRelevebancaire_id($relevebancaire_id) {
        $this->relevebancaire_id = $relevebancaire_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevebancaire_utilisateur() {
        return ($this->relevebancaire_utilisateur);
    }

    public function setRelevebancaire_utilisateur($relevebancaire_utilisateur) {
        $this->relevebancaire_utilisateur = ($relevebancaire_utilisateur);
        return $this;
    }

    public function getRelevebancaire_banque() {
        return $this->relevebancaire_banque;
    }

    public function setRelevebancaire_banque($relevebancaire_banque) {
        $this->relevebancaire_banque = $relevebancaire_banque;
        return $this;
    }

    public function getRelevebancaire_fichier() {
        return $this->relevebancaire_fichier;
    }

    public function setRelevebancaire_fichier($relevebancaire_fichier) {
        $this->relevebancaire_fichier = $relevebancaire_fichier;
        return $this;
    }

    public function getRelevebancaire_date() {
        return $this->relevebancaire_date;
    }

    public function setRelevebancaire_date($relevebancaire_date) {
        $this->relevebancaire_date = $relevebancaire_date;
        return $this;
    }


}

?>
