<?php
 
class Application_Model_EuReleveechange {

    //put your code here
    protected $releveechange_id;
    protected $releveechange_releve;
    protected $releveechange_echange;
    protected $releveechange_produit;
    protected $releveechange_montant;
    protected $publier;
    protected $releveechange_date;

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

    public function getReleveechange_id() {
        return $this->releveechange_id;
    }

    public function setReleveechange_id($releveechange_id) {
        $this->releveechange_id = $releveechange_id;
        return $this;
    }

    public function getReleveechange_produit() {
        return $this->releveechange_produit;
    }

    public function setReleveechange_produit($releveechange_produit) {
        $this->releveechange_produit = $releveechange_produit;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getReleveechange_releve() {
        return ($this->releveechange_releve);
    }

    public function setReleveechange_releve($releveechange_releve) {
        $this->releveechange_releve = ($releveechange_releve);
        return $this;
    }

    public function getReleveechange_montant() {
        return $this->releveechange_montant;
    }

    public function setReleveechange_montant($releveechange_montant) {
        $this->releveechange_montant = $releveechange_montant;
        return $this;
    }

    public function getReleveechange_echange() {
        return ($this->releveechange_echange);
    }

    public function setReleveechange_echange($releveechange_echange) {
        $this->releveechange_echange = ($releveechange_echange);
        return $this;
    }

    public function getReleveechange_date() {
        return ($this->releveechange_date);
    }

    public function setReleveechange_date($releveechange_date) {
        $this->releveechange_date = ($releveechange_date);
        return $this;
    }


}

?>
