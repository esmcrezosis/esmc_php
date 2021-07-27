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
class Application_Model_EuCours {
    //put your code here
    protected $code_cours;
    protected $code_dev_init;
    protected $code_dev_fin;
    protected $val_dev_init;
    protected $val_dev_fin;
    
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
    
    public function getCode_cours(){
        return $this->code_cours;
    }
    
    public function setCode_cours($code_cours){
        $this->code_cours = $code_cours;
        return $this;
    }

    public function getCode_dev_init(){
        return $this->code_dev_init;
    }
    
    public function setCode_dev_init($code_dev_init){
        $this->code_dev_init = $code_dev_init;
        return $this;
    }
    
    public function getCode_dev_fin(){
        return $this->code_dev_fin;
    }
    
    public function setCode_dev_fin($code_dev_fin){
        $this->code_dev_fin = $code_dev_fin;
        return $this;
    }
    
    public function getVal_dev_init(){
        return $this->val_dev_init;
    }
    
    public function setVal_dev_init($val_dev_init){
        $this->val_dev_init = $val_dev_init;
        return $this;
    }
    public function getVal_dev_fin(){
        return $this->val_dev_fin;
    }
    
    public function setVal_dev_fin($val_dev_fin){
        $this->val_dev_fin = $val_dev_fin;
        return $this;
    }
}

?>
