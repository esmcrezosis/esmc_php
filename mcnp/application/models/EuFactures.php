<?php
 
class Application_Model_EuFactures {

    //put your code here
    protected $facture_id;
    protected $facture_numero;
    protected $facture_montant;
    protected $facture_code_membre;
    protected $facture_utilisateur;
    protected $facture_date;
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

    public function getFacture_id() {
        return $this->facture_id;
    }

    public function setFacture_id($facture_id) {
        $this->facture_id = $facture_id;
        return $this;
    }


    public function getFacture_montant() {
        return $this->facture_montant;
    }

    public function setFacture_montant($facture_montant) {
        $this->facture_montant = $facture_montant;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getFacture_numero() {
        return ($this->facture_numero);
    }

    public function setFacture_numero($facture_numero) {
        $this->facture_numero = ($facture_numero);
        return $this;
    }

    public function getFacture_code_membre() {
        return $this->facture_code_membre;
    }

    public function setFacture_code_membre($facture_code_membre) {
        $this->facture_code_membre = $facture_code_membre;
        return $this;
    }

    public function getFacture_utilisateur() {
        return $this->facture_utilisateur;
    }

    public function setFacture_utilisateur($facture_utilisateur) {
        $this->facture_utilisateur = $facture_utilisateur;
        return $this;
    }

    public function getFacture_date() {
        return $this->facture_date;
    }

    public function setFacture_date($facture_date) {
        $this->facture_date = $facture_date;
        return $this;
    }




}

?>
