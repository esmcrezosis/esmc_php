<?php

class Application_Model_EuAncienGcp {

    protected $id_gcp;
    protected $code_tegc;
    protected $id_credit;
    protected $source;
    protected $code_cat;
    protected $mont_gcp;
    protected $date_conso;
    protected $code_membre;
    protected $mont_preleve;
    protected $reste;

	
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
            throw new Exception('Invalid compte_gcp property');
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

    function getId_gcp() {
        return $this->id_gcp;
    }

    function setId_gcp($id_gcp) {
        $this->id_gcp = $id_gcp;
        return $this;
    }
    
    function getCode_tegc() {
        return $this->code_tegc;
    }

    function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }

    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    function getCode_cat() {
        return $this->code_cat;
    }

    function setCode_cat($code_cat) {
        $this->code_cat = $code_cat;
        return $this;
    }

    function getMont_gcp() {
        return $this->mont_gcp;
    }

    function setMont_gcp($mont_gcp) {
        $this->mont_gcp = $mont_gcp;
        return $this;
    }
    
    function getSource(){
        return $this->source;
    }
    
    function setSource($source){
        $this->source = $source;
        return $this;
    }
    
    function getDate_conso(){
        return $this->date_conso;
    }
    
    function  setDate_conso($date_conso){
        $this->date_conso = $date_conso;
        return $this;
    }
    
    function getCode_membre(){
        return $this->code_membre;
    }
    
    function  setCode_membre($code_membre){
        $this->code_membre = $code_membre;
        return $this;
    }
    
    function getMont_preleve(){
        return $this->mont_preleve;
    }
    
    function  setMont_preleve($mont_preleve){
        $this->mont_preleve = $mont_preleve;
        return $this;
    }
    
    function getReste(){
        return $this->reste;
    }
    
    function  setReste($reste) {
        $this->reste = $reste;
        return $this;
    }

}

