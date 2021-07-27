<?php
 
class Application_Model_EuRelevecreditnonc {

    //put your code here
    protected $relevecreditnonc_id;
    protected $relevecreditnonc_releve;
    protected $relevecreditnonc_creditnonc;
    protected $relevecreditnonc_produit;
    protected $relevecreditnonc_montant;
    protected $publier;
    protected $relevecreditnonc_date;

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

    public function getRelevecreditnonc_id() {
        return $this->relevecreditnonc_id;
    }

    public function setRelevecreditnonc_id($relevecreditnonc_id) {
        $this->relevecreditnonc_id = $relevecreditnonc_id;
        return $this;
    }

    public function getRelevecreditnonc_produit() {
        return $this->relevecreditnonc_produit;
    }

    public function setRelevecreditnonc_produit($relevecreditnonc_produit) {
        $this->relevecreditnonc_produit = $relevecreditnonc_produit;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevecreditnonc_releve() {
        return ($this->relevecreditnonc_releve);
    }

    public function setRelevecreditnonc_releve($relevecreditnonc_releve) {
        $this->relevecreditnonc_releve = ($relevecreditnonc_releve);
        return $this;
    }

    public function getRelevecreditnonc_montant() {
        return $this->relevecreditnonc_montant;
    }

    public function setRelevecreditnonc_montant($relevecreditnonc_montant) {
        $this->relevecreditnonc_montant = $relevecreditnonc_montant;
        return $this;
    }

    public function getRelevecreditnonc_creditnonc() {
        return ($this->relevecreditnonc_creditnonc);
    }

    public function setRelevecreditnonc_creditnonc($relevecreditnonc_creditnonc) {
        $this->relevecreditnonc_creditnonc = ($relevecreditnonc_creditnonc);
        return $this;
    }

    public function getRelevecreditnonc_date() {
        return ($this->relevecreditnonc_date);
    }

    public function setRelevecreditnonc_date($relevecreditnonc_date) {
        $this->relevecreditnonc_date = ($relevecreditnonc_date);
        return $this;
    }


}

?>
