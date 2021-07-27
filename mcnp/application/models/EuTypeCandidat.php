<?php

class Application_Model_EuTypeCandidat {

    protected  $id_type_candidat;
    protected  $libelle_type_candidat;
    protected  $option_type_candidat;
    
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

    function getId_type_candidat() {
        return $this->id_type_candidat;
    }

    function setId_type_candidat($id_type_candidat) {
        $this->id_type_candidat = $id_type_candidat;
        return $this;
    }

    function getLibelle_type_candidat() {
        return $this->libelle_type_candidat;
    }

    function setLibelle_type_candidat($libelle_type_candidat) {
        $this->libelle_type_candidat = $libelle_type_candidat;
        return $this;
    }

    function getOption_type_candidat() {
        return $this->option_type_candidat;
    }

    function setOption_type_candidat($option_type_candidat) {
        $this->option_type_candidat = $option_type_candidat;
        return $this;
    }
	
	}

?>
