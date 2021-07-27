<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuPrk
 *
 * @author Mawuli
 */

 
class Application_Model_EuTypePrk {

    //put your code here
    protected $id_type_prk;
    protected $valeur_prk;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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

    public function getId_type_prk() {
        return $this->id_type_prk;
    }

    public function setId_type_prk($id_type_prk) {
        $this->id_type_prk = $id_type_prk;
        return $this;
    }

    function getValeur_prk() {
        return $this->valeur_prk;
    }

    function setValeur_prk($valeur_prk) {
        $this->valeur_prk = $valeur_prk;
        return $this;
    }

    

}

?>
