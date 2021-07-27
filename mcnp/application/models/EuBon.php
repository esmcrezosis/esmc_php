<?php
 
class Application_Model_EuBon {

    //put your code here
    protected $bon_id;
    protected $bon_numero;
    protected $bon_montant;
    protected $bon_montant_salaire;
    protected $bon_type;
    protected $bon_code_membre_emetteur;
    protected $bon_code_membre_distributeur;
    protected $bon_date;
    protected $bon_proposition;
    protected $bon_code_barre;

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

    public function getBon_id() {
        return $this->bon_id;
    }

    public function setBon_id($bon_id) {
        $this->bon_id = $bon_id;
        return $this;
    }

    public function getBon_type() {
        return $this->bon_type;
    }

    public function setBon_type($bon_type) {
        $this->bon_type = $bon_type;
        return $this;
    }

    public function getBon_montant() {
        return $this->bon_montant;
    }

    public function setBon_montant($bon_montant) {
        $this->bon_montant = $bon_montant;
        return $this;
    }

    public function getBon_proposition() {
        return $this->bon_proposition;
    }

    public function setBon_proposition($bon_proposition) {
        $this->bon_proposition = $bon_proposition;
        return $this;
    }

    public function getBon_numero() {
        return ($this->bon_numero);
    }

    public function setBon_numero($bon_numero) {
        $this->bon_numero = ($bon_numero);
        return $this;
    }

    public function getBon_code_membre_emetteur() {
        return $this->bon_code_membre_emetteur;
    }

    public function setBon_code_membre_emetteur($bon_code_membre_emetteur) {
        $this->bon_code_membre_emetteur = $bon_code_membre_emetteur;
        return $this;
    }

    public function getBon_code_membre_distributeur() {
        return $this->bon_code_membre_distributeur;
    }

    public function setBon_code_membre_distributeur($bon_code_membre_distributeur) {
        $this->bon_code_membre_distributeur = $bon_code_membre_distributeur;
        return $this;
    }

    public function getBon_date() {
        return $this->bon_date;
    }

    public function setBon_date($bon_date) {
        $this->bon_date = $bon_date;
        return $this;
    }


    public function getBon_montant_salaire() {
        return $this->bon_montant_salaire;
    }

    public function setBon_montant_salaire($bon_montant_salaire) {
        $this->bon_montant_salaire = $bon_montant_salaire;
        return $this;
    }

    public function getBon_code_barre() {
        return $this->bon_code_barre;
    }

    public function setBon_code_barre($bon_code_barre) {
        $this->bon_code_barre = $bon_code_barre;
        return $this;
    }


}

?>
