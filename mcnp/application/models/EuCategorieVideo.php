<?php

class Application_Model_EuCategorieVideo {

    protected  $id_categorie_video;
    protected  $libelle_categorie_video;
    
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

    function getId_categorie_video() {
        return $this->id_categorie_video;
    }

    function setId_categorie_video($id_categorie_video) {
        $this->id_categorie_video = $id_categorie_video;
        return $this;
    }

    function getLibelle_categorie_video() {
        return $this->libelle_categorie_video;
    }

    function setLibelle_categorie_video($libelle_categorie_video) {
        $this->libelle_categorie_video = $libelle_categorie_video;
        return $this;
    }

}

?>
