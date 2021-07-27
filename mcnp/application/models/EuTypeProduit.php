<?php

class Application_Model_EuTypeProduit {

    protected  $id_type_produit;
    protected  $libelle_type_produit;
    protected  $indice_type_produit;
    
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

    function getId_type_produit() {
        return $this->id_type_produit;
    }

    function setId_type_produit($id_type_produit) {
        $this->id_type_produit = $id_type_produit;
        return $this;
    }

    function getLibelle_type_produit() {
        return $this->libelle_type_produit;
    }

    function setLibelle_type_produit($libelle_type_produit) {
        $this->libelle_type_produit = $libelle_type_produit;
        return $this;
    }

    function getIndice_type_produit() {
        return $this->indice_type_produit;
    }

    function setIndice_type_produit($indice_type_produit) {
        $this->indice_type_produit = $indice_type_produit;
        return $this;
    }


}

?>
