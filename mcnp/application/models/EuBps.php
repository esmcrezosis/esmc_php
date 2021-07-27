<?php

class Application_Model_EuBps   {

    //put your code here
    protected $id_bps;
    protected $designation;
    protected $type_souscription;
    protected $valeur_parametre;
    
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
	

    public function getId_bps() {
        return $this->id_bps;
    }

    public function setId_bps($id_bps) {
        $this->id_bps = $id_bps;
        return $this;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
        return $this;
    }
	
    public function getType_souscription() {
        return $this->type_souscription;
    }

    public function setType_souscription($type_souscription) {
        $this->type_souscription = $type_souscription;
        return $this;
    }
	
    public function getValeur_parametre() {
        return $this->valeur_parametre;
    }

    public function setValeur_parametre($valeur_parametre) {
        $this->valeur_parametre = $valeur_parametre;
        return $this;
    }


}

?>
