<?php

class Application_Model_EuGcsc {

    protected $id_gcsc;
    protected $code_membre;
    protected $debit;
    protected $credit;
    protected $solde;
    protected $code_smcipn;
    protected $code_smcipnp;
    protected $code_domicilier;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_gcp property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_gcsc property');
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

    function getId_gcsc() {
        return $this->id_gcsc;
    }

    function setId_gcsc($id_gcsc) {
        $this->id_gcsc = $id_gcsc;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getDebit() {
        return $this->debit;
    }

    function setDebit($debit) {
        $this->debit = $debit;
        return $this;
    }

    function getCredit() {
        return $this->credit;
    }

    function setCredit($credit) {
        $this->credit = $credit;
        return $this;
    }

    function getSolde() {
        return $this->solde;
    }

    function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

    function getCode_smcipn() {
        return $this->code_smcipn;
    }

    function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    function getCode_smcipnp() {
        return $this->code_smcipnp;
    }

    function setCode_smcipnp($code_smcipnp) {
        $this->code_smcipnp = $code_smcipnp;
        return $this;
    }

    function getCode_domicilier() {
        return $this->code_domicilier;
    }

    function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }

}

