<?php
 
class Application_Model_EuMembretierscode {

    //put your code here
    protected $membretierscode_id;
    protected $membretierscode_membretiers;
    protected $membretierscode_code;
    protected $membretierscode_souscription;
    protected $code_membre;
    protected $publier;
	protected $allocation_cmfh_id;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getMembretierscode_id() {
        return $this->membretierscode_id;
    }

    public function setMembretierscode_id($membretierscode_id) {
        $this->membretierscode_id = $membretierscode_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getMembretierscode_membretiers() {
        return ($this->membretierscode_membretiers);
    }

    public function setMembretierscode_membretiers($membretierscode_membretiers) {
        $this->membretierscode_membretiers = ($membretierscode_membretiers);
        return $this;
    }

    public function getMembretierscode_code() {
        return ($this->membretierscode_code);
    }

    public function setMembretierscode_code($membretierscode_code) {
        $this->membretierscode_code = ($membretierscode_code);
        return $this;
    }

    public function getMembretierscode_souscription() {
        return $this->membretierscode_souscription;
    }

    public function setMembretierscode_souscription($membretierscode_souscription) {
        $this->membretierscode_souscription = $membretierscode_souscription;
        return $this;
    }

    public function getCode_membre() {
        return ($this->code_membre);
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = ($code_membre);
        return $this;
    }
	
	public function getAllocation_cmfh_id() {
      return ($this->allocation_cmfh_id);
    }

    public function setAllocation_cmfh_id($allocation_cmfh_id) {
        $this->allocation_cmfh_id = ($allocation_cmfh_id);
        return $this;
    }
	
	



}

?>
