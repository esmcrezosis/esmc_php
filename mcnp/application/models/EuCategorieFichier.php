<?php

class Application_Model_EuCategorieFichier {

    protected  $id_categorie_fichier;
    protected  $libelle_categorie_fichier;
    
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

    function getId_categorie_fichier() {
        return $this->id_categorie_fichier;
    }

    function setId_categorie_fichier($id_categorie_fichier) {
        $this->id_categorie_fichier = $id_categorie_fichier;
        return $this;
    }

    function getLibelle_categorie_fichier() {
        return $this->libelle_categorie_fichier;
    }

    function setLibelle_categorie_fichier($libelle_categorie_fichier) {
        $this->libelle_categorie_fichier = $libelle_categorie_fichier;
        return $this;
    }

}

?>
