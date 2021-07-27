<?php

/**
 * Description of EuFn
 *
 * @author user
 */
class Application_Model_EuFgfn {

    //put your code here
    protected $code_fgfn;
    protected $code_membre;
    protected $solde_fgfn;
    
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

    public function getCode_fgfn() {
        return $this->code_fgfn;
    }

    public function setCode_fgfn($code_fgfn) {
        $this->code_fgfn = $code_fgfn;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getSolde_fgfn(){
        return $this->solde_fgfn;
    }
    
    public function setSolde_fgfn($solde_fgfn){
        $this->solde_fgfn = $solde_fgfn;
        return $this;
    }

}

?>
