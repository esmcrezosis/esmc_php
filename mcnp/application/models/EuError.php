<?php

class Application_Model_EuError {
    
    protected $id_error;
    protected $errors;
    protected $type;
    protected $exception;
    protected $message;
    protected $traiter;
	protected $request;

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
	

    function getId_error() {
      return $this->id_error;
    }

    function setId_error($id_error) {
      $this->id_error = $id_error;
      return $this;
    }

    function getErrors() {
        return $this->errors;
    }

    function setErrors($errors) {
        $this->errors = $errors;
        return $this;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
        return $this;
    }

	function getException() {
        return $this->exception;
    }

    function setException($exception) {
        $this->exception = $exception;
        return $this;
    }

    function getMessage() {
      return $this->message;
    }

    function setMessage($message) {
      $this->message = $message;
      return $this;
    }
	
		
    function getTraiter() {
      return $this->traiter;
    }

    function setTraiter($traiter) {
      $this->traiter = $traiter;
      return $this;
    }
		
	function getRequest() {
      return $this->request;
    }

    function setRequest($request) {
      $this->request = $request;
      return $this;
    }
	
	
	
    
}

