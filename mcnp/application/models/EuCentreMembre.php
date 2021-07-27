<?php

class Application_Model_EuCentreMembre {

    //put your code here
    protected $centre_membre_id;
    protected $centre_id;
    protected $code_membre;

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

    public function getCentre_membre_id() {
        return $this->centre_membre_id;
    }

    public function setCentre_membre_id($centre_membre_id) {
        $this->centre_membre_id = $centre_membre_id;
        return $this;
    }

    public function getCentre_id() {
        return $this->centre_id;
    }

    public function setCentre_id($centre_id) {
        $this->centre_id = $centre_id;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

	
}

?>
