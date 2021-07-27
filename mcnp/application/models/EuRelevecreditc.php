<?php
 
class Application_Model_EuRelevecreditc {

    //put your code here
    protected $relevecreditc_id;
    protected $relevecreditc_releve;
    protected $relevecreditc_creditc;
    protected $relevecreditc_produit;
    protected $relevecreditc_montant;
    protected $publier;
    protected $relevecreditc_date;

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

    public function getRelevecreditc_id() {
        return $this->relevecreditc_id;
    }

    public function setRelevecreditc_id($relevecreditc_id) {
        $this->relevecreditc_id = $relevecreditc_id;
        return $this;
    }

    public function getRelevecreditc_produit() {
        return $this->relevecreditc_produit;
    }

    public function setRelevecreditc_produit($relevecreditc_produit) {
        $this->relevecreditc_produit = $relevecreditc_produit;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevecreditc_releve() {
        return ($this->relevecreditc_releve);
    }

    public function setRelevecreditc_releve($relevecreditc_releve) {
        $this->relevecreditc_releve = ($relevecreditc_releve);
        return $this;
    }

    public function getRelevecreditc_montant() {
        return $this->relevecreditc_montant;
    }

    public function setRelevecreditc_montant($relevecreditc_montant) {
        $this->relevecreditc_montant = $relevecreditc_montant;
        return $this;
    }

    public function getRelevecreditc_creditc() {
        return ($this->relevecreditc_creditc);
    }

    public function setRelevecreditc_creditc($relevecreditc_creditc) {
        $this->relevecreditc_creditc = ($relevecreditc_creditc);
        return $this;
    }

    public function getRelevecreditc_date() {
        return ($this->relevecreditc_date);
    }

    public function setRelevecreditc_date($relevecreditc_date) {
        $this->relevecreditc_date = ($relevecreditc_date);
        return $this;
    }


}

?>
