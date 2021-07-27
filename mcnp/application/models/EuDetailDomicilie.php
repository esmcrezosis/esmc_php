<?php

class Application_Model_EuDetailDomicilie {

    protected $code_domicilier;
    protected $id_credit;
    protected $code_membre;
    protected $montant_credit;
    protected $utiliser;
    protected $duree_renouvellement;
    protected $reste_duree;
    
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

    function getCode_domicilier() {
        return $this->code_domicilier;
    }

    function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }

    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getMontant_credit() {
        return $this->montant_credit;
    }

    function setMontant_credit($montant_credit) {
        $this->montant_credit = $montant_credit;
        return $this;
    }
    
    function getUtiliser() {
        return $this->utiliser;
    }

    function setUtiliser($utiliser) {
        $this->utiliser = $utiliser;
        return $this;
    }
    
    function getDuree_renouvellement() {
        return $this->duree_renouvellement;
    }

    function setDuree_renouvellement($duree_renouvellement) {
        $this->duree_renouvellement = $duree_renouvellement;
        return $this;
    }
    
    function getReste_duree() {
        return $this->reste_duree;
    }

    function setReste_duree($reste_duree) {
        $this->reste_duree = $reste_duree;
        return $this;
    }

}