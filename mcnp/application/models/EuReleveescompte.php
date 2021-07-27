<?php
 
class Application_Model_EuReleveescompte {

    //put your code here
    protected $releveescompte_id;
    protected $releveescompte_releve;
    protected $releveescompte_escompte;
    protected $releveescompte_produit;
    protected $releveescompte_montant;
    protected $publier;
    protected $releveescompte_date;

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

    public function getReleveescompte_id() {
        return $this->releveescompte_id;
    }

    public function setReleveescompte_id($releveescompte_id) {
        $this->releveescompte_id = $releveescompte_id;
        return $this;
    }

    public function getReleveescompte_produit() {
        return $this->releveescompte_produit;
    }

    public function setReleveescompte_produit($releveescompte_produit) {
        $this->releveescompte_produit = $releveescompte_produit;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getReleveescompte_releve() {
        return ($this->releveescompte_releve);
    }

    public function setReleveescompte_releve($releveescompte_releve) {
        $this->releveescompte_releve = ($releveescompte_releve);
        return $this;
    }

    public function getReleveescompte_montant() {
        return $this->releveescompte_montant;
    }

    public function setReleveescompte_montant($releveescompte_montant) {
        $this->releveescompte_montant = $releveescompte_montant;
        return $this;
    }

    public function getReleveescompte_escompte() {
        return ($this->releveescompte_escompte);
    }

    public function setReleveescompte_escompte($releveescompte_escompte) {
        $this->releveescompte_escompte = ($releveescompte_escompte);
        return $this;
    }

    public function getReleveescompte_date() {
        return ($this->releveescompte_date);
    }

    public function setReleveescompte_date($releveescompte_date) {
        $this->releveescompte_date = ($releveescompte_date);
        return $this;
    }


}

?>
