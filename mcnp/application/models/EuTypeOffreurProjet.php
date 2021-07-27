<?php

class Application_Model_EuTypeOffreurProjet {

    protected  $id_type_offreur_projet;
    protected  $libelle_type_offreur_projet;
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

    function getId_type_offreur_projet() {
        return $this->id_type_offreur_projet;
    }

    function setId_type_offreur_projet($id_type_offreur_projet) {
        $this->id_type_offreur_projet = $id_type_offreur_projet;
        return $this;
    }

    function getLibelle_type_offreur_projet() {
        return $this->libelle_type_offreur_projet;
    }

    function setLibelle_type_offreur_projet($libelle_type_offreur_projet) {
        $this->libelle_type_offreur_projet = $libelle_type_offreur_projet;
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
