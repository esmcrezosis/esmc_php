<?php
 
class Application_Model_EuFranchise {

     //put your code here
	 protected $id_franchise;
     protected $type_franchise;
     protected $create_date;
     protected $representant;
     protected $code_membre_franchise;
	
	
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
	
     
	
	
	public function getId_franchise() {
        return $this->id_franchise;
    }

    public function setId_franchise($id_franchise) {
        $this->id_franchise = $id_franchise;
        return $this;
    }

    public function getType_franchise() {
        return $this->type_franchise;
    }

    public function setType_franchise($type_franchise) {
        $this->type_franchise = $type_franchise;
        return $this;
    }
        
    public function getCreate_date() {
        return $this->create_date;
    }

    public function setCreate_date($create_date) {
        $this->create_date = $create_date;
        return $this;
    }

	public function getRepresentant() {
        return $this->representant;
    }

    public function setRepresentant($representant) {
        $this->representant = $representant;
        return $this;
    }
    
    public function getCode_membre_franchise() {
        return $this->code_membre_franchise;
    }

    public function setCode_membre_franchise($code_membre_franchise) {
        $this->code_membre_franchise = $code_membre_franchise;
        return $this;
    }
				

}

?>
