<?php

class Application_Model_EuDetailFicheBesoin {
	
	protected $id_detail_fiche_besoin;
	protected $id_fiche_besoin;
    protected $code_identification;

  
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
	
	function getId_detail_fiche_besoin() {
      return $this->id_detail_fiche_besoin;
    }
    
    function setId_detail_fiche_besoin($id_detail_fiche_besoin) {
      $this->id_detail_fiche_besoin = $id_detail_fiche_besoin;
      return $this;
    }
	
	function getId_fiche_besoin() {
      return $this->id_fiche_besoin;
    }
    
    function setId_fiche_besoin($id_fiche_besoin) {
      $this->id_fiche_besoin = $id_fiche_besoin;
      return $this;
    }
	
	function getCode_identification() {
      return $this->code_identification;
    }
    
    function setCode_identification($code_identification) {
      $this->code_identification = $code_identification;
      return $this;
    }
	
}


