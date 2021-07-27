<?php

class Application_Model_EuJustifier {

    protected $code_membre;
    protected $code_smcipn;
    protected $salaire;
    protected $affecter;
    protected $solde;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getCode_smcipn() {
        return $this->code_smcipn;
    }

    function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    function getSalaire() {
        return $this->salaire;
    }

    function setSalaire($salaire) {
        $this->salaire = $salaire;
        return $this;
    }

    function getAffecter() {
        return $this->affecter;
    }

    function setAffecter($affecter) {
        $this->affecter = $affecter;
        return $this;
    }

    function getSolde() {
        return $this->solde;
    }

    function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

}