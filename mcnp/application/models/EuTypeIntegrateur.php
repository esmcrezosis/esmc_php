<?php

class Application_Model_EuTypeIntegrateur {

    protected  $id_type_integrateur;
    protected  $libelle_type_integrateur;
    protected  $type_param_ban;
	protected  $montant_param;
    
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

    function getId_type_integrateur() {
        return $this->id_type_integrateur;
    }

    function setId_type_integrateur($id_type_integrateur) {
        $this->id_type_integrateur = $id_type_integrateur;
        return $this;
    }

    function getLibelle_type_integrateur() {
        return $this->libelle_type_integrateur;
    }

    function setLibelle_type_integrateur($libelle_type_integrateur) {
        $this->libelle_type_integrateur = $libelle_type_integrateur;
        return $this;
    }
	
    function getType_param_ban() {
        return $this->type_param_ban;
    }

    function setType_param_ban($type_param_ban) {
        $this->type_param_ban = $type_param_ban;
        return $this;
    }
	
	function getMontant_param() {
        return $this->montant_param;
    }

    function setMontant_param($montant_param) {
        $this->montant_param = $montant_param;
        return $this;
    }
	
	
	
	

}

?>
