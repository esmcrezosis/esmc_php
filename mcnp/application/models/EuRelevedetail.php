<?php
 
class Application_Model_EuRelevedetail {

    //put your code here
    protected $relevedetail_id;
    protected $relevedetail_releve;
    protected $relevedetail_credit;
    protected $relevedetail_produit;
    protected $relevedetail_montant;
    protected $publier;
    protected $relevedetail_date;

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

    public function getRelevedetail_id() {
        return $this->relevedetail_id;
    }

    public function setRelevedetail_id($relevedetail_id) {
        $this->relevedetail_id = $relevedetail_id;
        return $this;
    }

    public function getRelevedetail_produit() {
        return $this->relevedetail_produit;
    }

    public function setRelevedetail_produit($relevedetail_produit) {
        $this->relevedetail_produit = $relevedetail_produit;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevedetail_releve() {
        return ($this->relevedetail_releve);
    }

    public function setRelevedetail_releve($relevedetail_releve) {
        $this->relevedetail_releve = ($relevedetail_releve);
        return $this;
    }

    public function getRelevedetail_montant() {
        return $this->relevedetail_montant;
    }

    public function setRelevedetail_montant($relevedetail_montant) {
        $this->relevedetail_montant = $relevedetail_montant;
        return $this;
    }

    public function getRelevedetail_credit() {
        return ($this->relevedetail_credit);
    }

    public function setRelevedetail_credit($relevedetail_credit) {
        $this->relevedetail_credit = ($relevedetail_credit);
        return $this;
    }

    public function getRelevedetail_date() {
        return ($this->relevedetail_date);
    }

    public function setRelevedetail_date($relevedetail_date) {
        $this->relevedetail_date = ($relevedetail_date);
        return $this;
    }


}

?>
