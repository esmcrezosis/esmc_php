<?php

class Application_Model_EuQuota
{
    protected $type_quota;
    protected $min_quota;
    protected $max_quota;
    
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

    function getType_quota(){
        return $this->type_quota;
    }
    
    function setType_quota($type_quota){
        $this->type_quota = $type_quota;
        return $this;
    }
    
    function getMin_quota(){
        return $this->min_quota;
    }
    function setMin_quota($min_quota){
        $this->min_quota = $min_quota;
        return $this;
    }
    
    function getMax_quota(){
        return $this->max_quota;
    }
    function setMax_quota($max_quota){
        $this->max_quota = $max_quota;
        return $this;
    }
   
}
?>
