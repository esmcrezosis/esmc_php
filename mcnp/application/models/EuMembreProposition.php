<?php

class Application_Model_EuMembreProposition {

    //put your code here
    protected $id_membre_proposition;
    protected $id_proposition;
    protected $code_membre;
   // protected $salaire;

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

    public function getId_membre_proposition() {
        return $this->id_membre_proposition;
    }

    public function setId_membre_proposition($id_membre_proposition) {
        $this->id_membre_proposition = $id_membre_proposition;
        return $this;
    }

    public function getId_proposition() {
        return $this->id_proposition;
    }

    public function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

//    public function getSalaire() {
//        return $this->salaire;
//    }
//
//    public function setSalaire($salaire) {
//        $this->salaire = $salaire;
//        return $this;
//    }
	
}

?>
