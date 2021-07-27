<?php
 
class Application_Model_EuRecubancaire {

    //put your code here
    protected $recubancaire_id;
    protected $recubancaire_numero;
    protected $recubancaire_date_numero;
    protected $recubancaire_type;
    protected $recubancaire_banque;
    protected $recubancaire_montant;
    protected $recubancaire_vignette;
    protected $recubancaire_souscription;
    protected $publier;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getRecubancaire_id() {
        return $this->recubancaire_id;
    }

    public function setRecubancaire_id($recubancaire_id) {
        $this->recubancaire_id = $recubancaire_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }


    public function getRecubancaire_numero() {
        return $this->recubancaire_numero;
    }

    public function setRecubancaire_numero($recubancaire_numero) {
        $this->recubancaire_numero = $recubancaire_numero;
        return $this;
    }

    public function getRecubancaire_date_numero() {
        return $this->recubancaire_date_numero;
    }

    public function setRecubancaire_date_numero($recubancaire_date_numero) {
        $this->recubancaire_date_numero = $recubancaire_date_numero;
        return $this;
    }

    public function getRecubancaire_type() {
        return $this->recubancaire_type;
    }

    public function setRecubancaire_type($recubancaire_type) {
        $this->recubancaire_type = $recubancaire_type;
        return $this;
    }

    public function getRecubancaire_montant() {
        return $this->recubancaire_montant;
    }

    public function setRecubancaire_montant($recubancaire_montant) {
        $this->recubancaire_montant = $recubancaire_montant;
        return $this;
    }

    public function getRecubancaire_banque() {
        return $this->recubancaire_banque;
    }

    public function setRecubancaire_banque($recubancaire_banque) {
        $this->recubancaire_banque = $recubancaire_banque;
        return $this;
    }

    public function getRecubancaire_vignette() {
        return $this->recubancaire_vignette;
    }

    public function setRecubancaire_vignette($recubancaire_vignette) {
        $this->recubancaire_vignette = $recubancaire_vignette;
        return $this;
    }

    public function getRecubancaire_souscription() {
        return $this->recubancaire_souscription;
    }

    public function setRecubancaire_souscription($recubancaire_souscription) {
        $this->recubancaire_souscription = $recubancaire_souscription;
        return $this;
    }



}

?>
