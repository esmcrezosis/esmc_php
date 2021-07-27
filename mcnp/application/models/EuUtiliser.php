<?php

class Application_Model_EuUtiliser {

    protected $id_utiliser;
    protected $id_smc;
    protected $code_smcipn;
    protected $code_smcipnp;
    protected $date_creation;
    protected $montant_allouer;

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

    function getId_smc() {
        return $this->id_smc;
    }

    function setId_smc($id_smc) {
        $this->id_smc = $id_smc;
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

    function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    function getMontant_allouer() {
        return $this->montant_allouer;
    }

    function setMontant_allouer($montant_allouer) {
        $this->montant_allouer = $montant_allouer;
        return $this;
    }
    
    function getId_utiliser() {
        return $this->id_utiliser;
    }

    function setId_utiliser($id_utiliser) {
        $this->id_utiliser = $id_utiliser;
        return $this;
    }

}