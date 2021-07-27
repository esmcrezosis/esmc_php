<?php

class Application_Model_EuCompteCreditCapa {

    protected $id_credit;
    protected $code_capa;
    protected $montant;
    protected $code_produit;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid credit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid credit property');
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

    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    function getCode_capa() {
        return $this->code_capa;
    }

    function setCode_capa($code_capa) {
        $this->code_capa = $code_capa;
        return $this;
    }

    function getMontant() {
        return $this->montant;
    }

    function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    function getCode_produit() {
        return $this->code_produit;
    }

    function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

}

