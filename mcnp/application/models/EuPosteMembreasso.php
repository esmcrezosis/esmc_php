<?php
 
class Application_Model_EuPosteMembreasso {

    //put your code here
    protected $poste_id;
    protected $poste_tache;
    protected $poste_membreasso;

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

    public function getPoste_id() {
        return $this->poste_id;
    }

    public function setPoste_id($poste_id) {
        $this->poste_id = $poste_id;
        return $this;
    }


    public function getPoste_tache() {
        return ($this->poste_tache);
    }

    public function setPoste_tache($poste_tache) {
        $this->poste_tache = ($poste_tache);
        return $this;
    }


    public function getPoste_membreasso() {
        return $this->poste_membreasso;
    }

    public function setPoste_membreasso($poste_membreasso) {
        $this->poste_membreasso = $poste_membreasso;
        return $this;
    }



}

?>
