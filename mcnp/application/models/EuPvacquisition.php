<?php

class Application_Model_EuPvacquisition {
	
    protected $id_pvacquisition;
    protected $designation_pvacquisition;
	protected $date_pvacquisition;
    protected $document_pv;
    protected $valider;
    protected $rejeter;
	protected $classer;

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
	
	
	

    public function getId_pvacquisition() {
        return $this->id_pvacquisition;
    }

    public function setId_pvacquisition($id_pvacquisition) {
        $this->id_pvacquisition = $id_pvacquisition;
        return $this;
    }
	
	public function getDesignation_pvacquisition() {
        return $this->designation_pvacquisition;
    }

    public function setDesignation_pvacquisition($designation_pvacquisition) {
        $this->designation_pvacquisition = $designation_pvacquisition;
        return $this;
    }
	
	public function getDate_pvacquisition() {
        return $this->date_pvacquisition;
    }

    public function setDate_pvacquisition($date_pvacquisition) {
        $this->date_pvacquisition = $date_pvacquisition;
        return $this;
    }
	
	
	public function getDocument_pv() {
        return $this->document_pv;
    }

    public function setDocument_pv($document_pv) {
        $this->document_pv = $document_pv;
        return $this;
    }
	
	public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
        return $this;
    }
	
	public function getRejeter() {
        return $this->rejeter;
    }

    public function setRejeter($rejeter) {
        $this->rejeter = $rejeter;
        return $this;
    }
	
	public function getClasser() {
        return $this->classer;
    }

    public function setClasser($classer) {
        $this->classer = $classer;
        return $this;
    }
	
	
	

}

