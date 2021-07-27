<?php

class Application_Model_EuInformationAdditif {

    //put your code here
    protected $id_information_additif;
    protected $libelle_information_additif;
    protected $reference;
    protected $code_membre;
    protected $membreasso_id;
    protected $etat;

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

    public function getId_information_additif() {
        return $this->id_information_additif;
    }

    public function setId_information_additif($id_information_additif) {
        $this->id_information_additif = $id_information_additif;
        return $this;
    }
    
    public function getLibelle_information_additif() {
        return $this->libelle_information_additif;
    }

    public function setLibelle_information_additif($libelle_information_additif) {
        $this->libelle_information_additif = $libelle_information_additif;
        return $this;
    }


    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }


    public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
	
}

?>
