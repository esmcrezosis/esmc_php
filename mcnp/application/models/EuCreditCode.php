<?php

class Application_Model_EuCreditCode {

    protected $code_compte;
    protected $credit_code;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid credit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid credit property');
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

    function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    function getCredit_code() {
        return $this->credit_code;
    }

    function setCredit_code($credit_code) {
        $this->credit_code = $credit_code;
        return $this;
    }


}

