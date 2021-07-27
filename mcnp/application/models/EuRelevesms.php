<?php
 
class Application_Model_EuRelevesms {

    //put your code here
    protected $relevesms_id;
    protected $relevesms_utilisateur;
    protected $relevesms_banque;
    protected $relevesms_fichier;
    protected $relevesms_date;
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

    public function getRelevesms_id() {
        return $this->relevesms_id;
    }

    public function setRelevesms_id($relevesms_id) {
        $this->relevesms_id = $relevesms_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevesms_utilisateur() {
        return ($this->relevesms_utilisateur);
    }

    public function setRelevesms_utilisateur($relevesms_utilisateur) {
        $this->relevesms_utilisateur = ($relevesms_utilisateur);
        return $this;
    }

    public function getRelevesms_banque() {
        return $this->relevesms_banque;
    }

    public function setRelevesms_banque($relevesms_banque) {
        $this->relevesms_banque = $relevesms_banque;
        return $this;
    }

    public function getRelevesms_fichier() {
        return $this->relevesms_fichier;
    }

    public function setRelevesms_fichier($relevesms_fichier) {
        $this->relevesms_fichier = $relevesms_fichier;
        return $this;
    }

    public function getRelevesms_date() {
        return $this->relevesms_date;
    }

    public function setRelevesms_date($relevesms_date) {
        $this->relevesms_date = $relevesms_date;
        return $this;
    }


}

?>
