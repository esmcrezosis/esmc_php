<?php

class Application_Model_EuTypeCompte
{
    protected $code_type_compte;
    protected $lib_type;
    protected $desc_type;
    
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

    function getCode_type_compte(){
        return $this->code_type_compte;
    }
    
    function setCode_type_compte($code_type_compte){
        $this->code_type_compte = $code_type_compte;
        return $this;
    }
    
    function getLib_type(){
        return $this->lib_type;
    }
    function setLib_type($lib_type){
        $this->lib_type = $lib_type;
        return $this;
    }
    
    function getDesc_type(){
        return $this->desc_type;
    }
    function setDesc_type($desc_type){
        $this->desc_type = $desc_type;
        return $this;
    }
   
}
?>
