<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDevise
 *
 * @author user
 */
class Application_Model_EuDevise {
    //put your code here
    protected $code_dev;
    protected $lib_dev;
    protected $symbole_dev;
    
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

    public function getCode_dev(){
        return $this->code_dev;
    }
    
    public function setCode_dev($code_dev){
        $this->code_dev = $code_dev;
        return $this;
    }
    
    public function getLib_dev(){
        return $this->lib_dev;
    }
    
    public function setLib_dev($lib_dev){
        $this->lib_dev = $lib_dev;
        return $this;
    }
    
    public function getSymbole_dev(){
        return $this->symbole_dev;
    }
    
    public function setSymbole_dev($symbole_dev){
        $this->symbole_dev = $symbole_dev;
        return $this;
    }
}

?>
