<?php

class Application_Model_EuCategorieCompte
{
    protected $code_cat;
    protected $lib_cat;
    protected $desc_cat;
	protected $code_type_compte;
    
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

    function getCode_cat(){
        return $this->code_cat;
    }
    
    function setCode_cat($code_cat){
        $this->code_cat = $code_cat;
        return $this;
    }
	
	function getCode_type_compte(){
        return $this->code_type_compte;
    }
    
    function setCode_type_compte($code_type_compte){
        $this->code_type_compte = $code_type_compte;
        return $this;
    }
    
    function getLib_cat(){
        return ($this->lib_cat);
    }
    function setLib_cat($lib_cat){
        $this->lib_cat = ($lib_cat);
        return $this;
    }
    
    function getDesc_cat(){
        return ($this->desc_cat);
    }
    function setDesc_cat($desc_cat){
        $this->desc_cat = ($desc_cat);
        return $this;
    }
}
?>
