<?php

class Application_Model_EuTelephone {

    protected  $id_telephone;
    protected  $numero_telephone;
    protected  $compagnie_telephone;
    protected  $code_membre;
	protected  $id_mstiers_listecm;
    protected  $principal;
    
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

    function getId_telephone() {
        return $this->id_telephone;
    }

    function setId_telephone($id_telephone) {
        $this->id_telephone = $id_telephone;
        return $this;
    }

    function getNumero_telephone() {
        return $this->numero_telephone;
    }

    function setNumero_telephone($numero_telephone) {
        $this->numero_telephone = $numero_telephone;
        return $this;
    }
	
    function getCompagnie_telephone() {
        return $this->compagnie_telephone;
    }

    function setCompagnie_telephone($compagnie_telephone) {
        $this->compagnie_telephone = $compagnie_telephone;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	function getId_mstiers_listecm() {
        return $this->id_mstiers_listecm;
    }

    function setId_mstiers_listecm($id_mstiers_listecm) {
        $this->id_mstiers_listecm = $id_mstiers_listecm;
        return $this;
    }
	
        
    public function getPrincipal() {
        return $this->principal;
    }

    public function setPrincipal($principal) {
        $this->principal = $principal;
        return $this;
    }
	
	
	
	
	
}

?>
