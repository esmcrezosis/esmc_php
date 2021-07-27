<?php
 
class Application_Model_EuQuittance {

    //put your code here
    protected $quittance_id;
    protected $quittance_code;
    protected $quittance_nom;
    protected $quittance_numero;
    protected $quittance_banque;
    protected $quittance_date;
    protected $quittance_type;
    protected $quittance_candidat;
    protected $quittance_cel;
    protected $quittance_code_membre;
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

    public function getQuittance_id() {
        return $this->quittance_id;
    }

    public function setQuittance_id($quittance_id) {
        $this->quittance_id = $quittance_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getQuittance_nom() {
        return $this->quittance_nom;
    }

    public function setQuittance_nom($quittance_nom) {
        $this->quittance_nom = $quittance_nom;
        return $this;
    }

    public function getQuittance_code() {
        return $this->quittance_code;
    }

    public function setQuittance_code($quittance_code) {
        $this->quittance_code = $quittance_code;
        return $this;
    }
	
    public function getQuittance_numero() {
        return $this->quittance_numero;
    }

    public function setQuittance_numero($quittance_numero) {
        $this->quittance_numero = $quittance_numero;
        return $this;
    }

    public function getQuittance_banque() {
        return $this->quittance_banque;
    }

    public function setQuittance_banque($quittance_banque) {
        $this->quittance_banque = $quittance_banque;
        return $this;
    }

    public function getQuittance_date() {
        return $this->quittance_date;
    }

    public function setQuittance_date($quittance_date) {
        $this->quittance_date = $quittance_date;
        return $this;
    }

    public function getQuittance_type() {
        return $this->quittance_type;
    }

    public function setQuittance_type($quittance_type) {
        $this->quittance_type = $quittance_type;
        return $this;
    }

    public function getQuittance_candidat() {
        return $this->quittance_candidat;
    }

    public function setQuittance_candidat($quittance_candidat) {
        $this->quittance_candidat = $quittance_candidat;
        return $this;
    }

    public function getQuittance_cel() {
        return $this->quittance_cel;
    }

    public function setQuittance_cel($quittance_cel) {
        $this->quittance_cel = $quittance_cel;
        return $this;
    }

    public function getQuittance_code_membre() {
        return $this->quittance_code_membre;
    }

    public function setQuittance_code_membre($quittance_code_membre) {
        $this->quittance_code_membre = $quittance_code_membre;
        return $this;
    }


}

?>
