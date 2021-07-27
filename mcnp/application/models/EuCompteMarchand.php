<?php

class Application_Model_EuCompteMarchand {

    protected $membre;
    protected $produit;
    protected $montant_compte;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_marchand property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_marchand property');
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

    function getMembre() {
        return $this->membre;
    }

    function setMembre($membre) {
        $this->membre = $membre;
        return $this;
    }

    function getProduit() {
        return $this->produit;
    }

    function setProduit($produit) {
        $this->produit = (string) $produit;
        return $this;
    }

    function getMontant_compte() {
        return $this->montant_compte;
    }

    function setMontant_compte($montant_compte) {
        $this->montant_compte = (string) $montant_compte;
        return $this;
    }

}

