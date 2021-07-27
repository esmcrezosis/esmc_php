<?php
 
class Application_Model_EuActivation {

    //put your code here
    protected $id_activation;
    protected $id_depot;
    protected $date_activation;
    protected $code_activation;
    protected $code_membre;
	protected $membreasso_id;
    
	
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

    
    public function getId_activation() {
        return $this->id_activation;
    }

    public function setId_activation($id_activation) {
        $this->id_activation = $id_activation;
        return $this;
    }

    public function getId_depot() {
        return $this->id_depot;
    }

    public function setId_depot($id_depot) {
        $this->id_depot = $id_depot;
        return $this;
    }
	
    public function getDate_activation() {
        return $this->date_activation;
    }

    public function setDate_activation($date_activation) {
        $this->date_activation = $date_activation;
        return $this;
    }

    public function getCode_activation() {
        return $this->code_activation;
    }

    public function setCode_activation($code_activation) {
        $this->code_activation = $code_activation;
        return $this;
    }
	
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	
	public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }

    

}

?>
