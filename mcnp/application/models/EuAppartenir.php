<?php
class Application_Model_EuAppartenir
{

    protected $code_rayon;
    protected $code_gamme;
    protected $creer_par;
    
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

    function getCode_rayon(){
        return $this->code_rayon;
    }
    
    function setCode_rayon($code_rayon){
        $this->code_rayon = $code_rayon;
        return $this;
    }
    
    function getCode_gamme(){
        return $this->code_gamme;
    }
    
    function setCode_gamme($code_gamme){
        $this->code_gamme = $code_gamme;
        return $this;
    }
    
    function getCreer_par(){
        return $this->creer_par;
    }
    function setCreer_par($creer_par){
        $this->creer_par = $creer_par;
        return $this;
    }
}