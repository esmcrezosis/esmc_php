<?php

class Application_Model_EuMembreDoublon {

    protected  $membre_doublon_id;
    protected  $membre_doublon_code_membre1;
    protected  $membre_doublon_code_membre2;
    protected  $membre_doublon_etat;
    protected  $membreasso_id;
    protected  $membre_doublon_date;
    
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

    function getMembre_doublon_id() {
        return $this->membre_doublon_id;
    }

    function setMembre_doublon_id($membre_doublon_id) {
        $this->membre_doublon_id = $membre_doublon_id;
        return $this;
    }
    
    function getMembre_doublon_code_membre1() {
        return $this->membre_doublon_code_membre1;
    }

    function setMembre_doublon_code_membre1($membre_doublon_code_membre1) {
        $this->membre_doublon_code_membre1 = $membre_doublon_code_membre1;
        return $this;
    }


	
    function getMembre_doublon_code_membre2() {
        return $this->membre_doublon_code_membre2;
    }

    function setMembre_doublon_code_membre2($membre_doublon_code_membre2) {
        $this->membre_doublon_code_membre2 = $membre_doublon_code_membre2;
        return $this;
    }

    function getMembre_doublon_etat() {
        return $this->membre_doublon_etat;
    }

    function setMembre_doublon_etat($membre_doublon_etat) {
        $this->membre_doublon_etat = $membre_doublon_etat;
        return $this;
    }

    function getMembreasso_id() {
        return $this->membreasso_id;
    }

    function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }
    
    function getMembre_doublon_date() {
        return $this->membre_doublon_date;
    }

    function setMembre_doublon_date($membre_doublon_date) {
        $this->membre_doublon_date = $membre_doublon_date;
        return $this;
    }
    
}

?>
