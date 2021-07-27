<?php

class Application_Model_EuRepas {

    protected  $id_repas;
    protected  $libelle_repas;
    protected  $code_membre;
    
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

    function getId_repas() {
        return $this->id_repas;
    }

    function setId_repas($id_repas) {
        $this->id_repas = $id_repas;
        return $this;
    }

    function getLibelle_repas() {
        return $this->libelle_repas;
    }

    function setLibelle_repas($libelle_repas) {
        $this->libelle_repas = $libelle_repas;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }


}

?>
