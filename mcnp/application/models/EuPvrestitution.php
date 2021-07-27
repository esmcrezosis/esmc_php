<?php

class Application_Model_EuPvrestitution {
	
    protected $id_pvrestitution;
    protected $designation_pvrestitution;
	protected $date_pvrestitution;
    protected $valider;
    protected $rejeter;
    protected $id_lettre;
	protected $contenu;

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
	
	
	

    public function getId_pvrestitution() {
        return $this->id_pvrestitution;
    }

    public function setId_pvrestitution($id_pvrestitution) {
        $this->id_pvrestitution = $id_pvrestitution;
        return $this;
    }
	
	public function getDesignation_pvrestitution() {
        return $this->designation_pvrestitution;
    }
	
    

    public function setDesignation_pvrestitution($designation_pvrestitution) {
        $this->designation_pvrestitution = $designation_pvrestitution;
        return $this;
    }
	
	public function getDate_pvrestitution() {
        return $this->date_pvrestitution;
    }

    public function setDate_pvrestitution($date_pvrestitution) {
        $this->date_pvrestitution = $date_pvrestitution;
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
	
	
	public function getId_lettre() {
        return $this->id_lettre;
    }

    public function setId_lettre($id_lettre) {
        $this->id_lettre = $id_lettre;
        return $this;
    }
	
	
	public function getContenu() {
        return $this->contenu;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
        return $this;
    }
	
	

}

