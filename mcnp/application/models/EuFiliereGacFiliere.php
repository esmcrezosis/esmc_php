<?php

class Application_Model_EuFiliereGacFiliere {

    //put your code here
    protected $code_gac_filiere;
    protected $id_filiere;

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

    public function getCode_gac_filiere() {
        return $this->code_gac_filiere;
    }

    public function setCode_gac_filiere($code_gac_filiere) {
        $this->code_gac_filiere = $code_gac_filiere;
        return $this;
    }

    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

}

?>
