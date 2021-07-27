<?php

class Application_Model_EuCapaAffecter {

    protected $id_affecter;
    protected $duree_renouvellement;
    protected $reste_duree;
    protected $type_credit;
    protected $id_credit;
    protected $code_domicilier;
    protected $mont_invest;
    protected $code_capa;

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

    function getId_affecter() {
        return $this->id_affecter;
    }

    function setId_affecter($id_affecter) {
        $this->id_affecter = $id_affecter;
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

    function getType_credit() {
        return $this->type_credit;
    }

    function setType_credit($type_credit) {
        $this->type_credit = (string) $type_credit;
        return $this;
    }

    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    function getCode_domicilier() {
        return $this->code_domicilier;
    }

    function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }
    
    function getMont_invest() {
        return $this->mont_invest;
    }

    function setMont_invest($mont_invest) {
        $this->mont_invest = $mont_invest;
        return $this;
    }

    function getCode_capa() {
        return $this->code_capa;
    }

    function setCode_capa($code_capa) {
        $this->code_capa = $code_capa;
        return $this;
    }


}

