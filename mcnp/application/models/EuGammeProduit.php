<?php
class Application_Model_EuGammeProduit
{
    protected $code_gamme;
    protected $design_gamme;
    protected $membre;
   
    
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
    function getCode_gamme(){
        return $this->code_gamme;
    }
    function setCode_gamme($code_gamme){
        $this->code_gamme = $code_gamme;
        return $this;
    }
    function getDesign_gamme(){
        return $this->design_gamme;
    }
    function setDesign_gamme($design_gamme){
        $this->design_gamme = $design_gamme;
        return $this;
    }
    
    function getCode_membre(){
        return $this->membre;
    }
    
    function setMembre($membre){
        $this->membre = $membre;
        return $this;
    }
    
}