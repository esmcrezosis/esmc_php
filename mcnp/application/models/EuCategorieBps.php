<?php

class Application_Model_EuCategorieBps {

    protected  $id_categorie;
    protected  $libelle_categorie;
    
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

    function getId_categorie() {
        return $this->id_categorie;
    }

    function setId_categorie($id_categorie) {
        $this->id_categorie = $id_categorie;
        return $this;
    }

    function getLibelle_categorie() {
        return $this->libelle_categorie;
    }

    function setLibelle_categorie($libelle_categorie) {
        $this->libelle_categorie = $libelle_categorie;
        return $this;
    }

}

?>
